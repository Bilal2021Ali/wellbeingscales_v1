<?php

namespace BaseControllers\Ministry;

use CI_Controller;
use Throwable;

require_once __DIR__ . "/../../../system/core/Controller.php";


class SubAccountsManager
{
    private const PASSWORD = "123456789";

    public CI_Controller $controller;
    public mixed $response;
    public mixed $db;
    public mixed $input;
    public mixed $load;
    public mixed $uri;
    public mixed $form_validation;
    public mixed $upload;

    public array $sessionData;
    public string $mainTable;
    public string $childrenTable;
    public string $type;
    public string $uploadPath;

    public function __construct(CI_Controller $controller, string $mainTable, string $childrenTable, string $type)
    {
        // copy instances
        $this->controller = $controller;
        $this->response = $controller->response;
        $this->db = $controller->db;
        $this->input = $controller->input;
        $this->load = $controller->load;
        $this->uri = $controller->uri;
        $this->sessionData = $controller->sessionData;
        $this->form_validation = $controller->form_validation;

        // set variables
        $this->mainTable = $mainTable;
        $this->childrenTable = $childrenTable;
        $this->type = $type;
        $this->uploadPath = './uploads/' . $this->type . 's';
    }

    public function crud(): void
    {
        if ($this->input->method() == "get") {
            if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->input->is_ajax_request()) { // request for account details
                $this->showConsultantAccount($this->uri->segment(5));
                return;
            }
            $this->showConsultantManagementList();
            return;
        }

        if ($this->input->method() == "post") {
            if ($this->input->post("_activeid")) { // update request
                $this->updateConsultantAccount();
                return;
            }

            $this->newConsultantAccount();
            return;
        }

        if ($this->input->method() == "delete") {
            $this->deleteConsultantAccount();
            return;
        }

        $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
    }


    private function showConsultantAccount($id): void
    {
        try {
            $account = $this->db->select($this->mainTable . '.name , ' . $this->mainTable . '.Id , v_login.Username')
                ->from($this->mainTable)
                ->join("v_login", "v_login.Id = $this->mainTable.loginkey")
                ->where("$this->mainTable.Added_By", $this->sessionData['admin_id'])
                ->where("$this->mainTable.Id", $id)
                ->get()->result_array();
            if (!empty($account)) {
                $account = $account[0];
                $children = array_column($this->db->select('account_id')->from($this->childrenTable)->where($this->type . '_id', $id)->get()->result_array(), "account_id");
                $this->response->json(['status' => 'ok', 'details' => $account, "children" => $children]);
            } else {
                $this->response->json(['status' => 'error', 'message' => "Sorry we Can't Find This User"]);
            }
        } catch (Throwable $th) {
            $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later"]);
        }
    }

    private function showConsultantManagementList(): void
    {
        $data['page_title'] = "Qlick Health |  " . $this->type;
        $data['children'] = $this->db->select("l1_school.Id AS id , l1_school.School_Name_EN AS text ")->from('l1_school')->where('l1_school.Added_By', $this->sessionData['admin_id'])->get()->result_array();
        $data['accounts'] = $this->db->select($this->mainTable . '.name , ' . $this->mainTable . '.Id ,' . $this->mainTable . '.avatar, v_login.Username')
            ->select('(SELECT COUNT(Id) FROM `' . $this->childrenTable . '` WHERE `' . $this->type . '_id` = `' . $this->mainTable . '`.`Id` ) AS ChildrenCounter')
            ->from($this->mainTable)
            ->join("v_login", "v_login.Id = " . $this->mainTable . ".loginkey")
            ->where($this->mainTable . ".Added_By", $this->sessionData['admin_id'])
            ->get()->result_array();
        $data['name'] = $this->type . "s";
        $data['defaultPassword'] = self::PASSWORD;
        $this->controller->_showPage('EN/Component/Consultant/Managment', $data);
    }

    private function updateConsultantAccount(): void
    {
        $activeId = $this->input->post("_activeid");
        $CI =& get_instance();

        // validation start
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('children[]', 'children', 'trim|required', array('required' => 'Select one School at least.'));
        if (!$this->form_validation->run()) {
            $this->response->json(['status' => 'error', 'message' => validation_errors('', '')]);
        }

        try {
            $updateData = ["name" => $this->input->post('name')];

            if (!empty($_FILES['avatar']['name'])) {
                $updateData = $this->getUploadedAvatar($CI, $updateData);
            }

            $this->db->where("Id", $activeId)->set($updateData)->update($this->mainTable);
            // deleting the old children
            $this->db->where($this->type . '_id', $activeId)->delete($this->childrenTable);
            // inserting the new ones
            $children = array();
            foreach ($this->input->post("children") as $key => $school) {
                $children[] = [
                    $this->type . '_id' => $activeId,
                    'account_id' => $school,
                ];
            }
            $this->db->insert_batch($this->childrenTable, $children);
            // returning the status success
            $this->response->json(['status' => "ok"]);
        } catch (Throwable $th) {
            $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later", "s" => $th]);
        }
    }

    /**
     * @param CI_Controller $CI
     * @param array $updateData
     * @return array
     */
    private function getUploadedAvatar(CI_Controller $CI, array $updateData): array
    {
        $config['upload_path'] = $this->uploadPath;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000; // 10 MB
        $config['encrypt_name'] = true;
        $CI->load->library('upload', $config);

        if (!$CI->upload->do_upload('avatar')) {
            $this->response->json(['status' => 'error', 'message' => $CI->upload->display_errors() ?? "avatar upload error"]);
        } else {
            $uploadData = $CI->upload->data();
            $updateData['avatar'] = base_url("uploads/" . $this->type . "s/" . $uploadData['file_name']);
        }
        return $updateData;
    }

    private function newConsultantAccount(): void
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[v_login.Username]|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('children[]', 'children', 'trim|required', array('required' => 'Select one School at least.'));
        if (!$this->form_validation->run()) {
            $this->response->json(['status' => 'error', 'message' => validation_errors('', '')]);
        }


        try {
            $consultants = [];
            $CI =& get_instance();

            if (!empty($_FILES['avatar']['name'])) {
                $consultants = $this->getUploadedAvatar($CI, $consultants);
            } else {
                $this->response->json(['status' => 'error', 'message' => "avatsar upload error"]);
            }

            $login = [
                "username" => $this->input->post('username'),
                "password" => password_hash(self::PASSWORD, PASSWORD_DEFAULT),
                "Type" => $this->type,
            ];
            $this->db->insert('v_login', $login); // login data
            $loginKey = $this->db->insert_id();
            $consultants += [
                "name" => $this->input->post('name'),
                "Added_By" => $this->sessionData['admin_id'],
                "loginkey" => $loginKey,
            ];

            $this->db->insert($this->mainTable, $consultants); // user data
            $consultantKey = $this->db->insert_id();
            $children = array();
            foreach ($this->input->post("children") as $key => $school) { // preparing the children data
                $children[] = [
                    $this->type . '_id' => $consultantKey,
                    'account_id' => $school,
                ];
            }
            $this->db->insert_batch($this->childrenTable, $children);
            $this->response->json(['status' => "ok"]);
        } catch (Throwable $th) {
            $this->response->json(['status' => 'error', 'message' => "We Have unexpected error please try again later", "th" => $th->getMessage()]);
        }
    }

    private function deleteConsultantAccount(): void
    {
        if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->input->is_ajax_request()) { // deleting
            $this->db->where('Id', $this->uri->segment(5))->delete($this->mainTable);
            $this->response->json(['status' => "ok"]);
        }
    }
}