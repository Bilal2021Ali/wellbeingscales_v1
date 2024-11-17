<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Consultant extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 0 || $sessiondata['type'] !== "consultant") {
            redirect('AR/Users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Registration School ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Consultant/index');
        $this->load->view('AR/inc/footer');
    }

    public function systemes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | systemes ";
        $data['sessiondata'] = $sessiondata;
        $data['parent-data'] = $this->db->select("l0_organization.*")
            ->from('l0_organization')
            ->join('l1_consultants', 'l1_consultants.Added_By = l0_organization.Id')
            ->where("l1_consultants.Id", $sessiondata['admin_id'])
            ->get()->row();
        if (empty($data['parent-data'])) { // when the company or ministry is deleted log the user out
            session_destroy();
            redirect('AR/Users');
        }
        $keys = ['schools' => 'S', 'departments' => 'D', 'ministries' => 'M', 'companies' => "C"];
        if ($data['parent-data']->Type == "Ministry") {
            $supportedtypes = ['schools', 'ministries'];
            $links = [
                array(
                    'name' => "المدارس", "link" => base_url('AR/Consultant/systemes/Schools'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "الوزارة", "link" => base_url('AR/Consultant/systemes/Ministries'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
            ];
        } else if ($data['parent-data']->Type == "Company") {
            $supportedtypes = ['companies', 'departments'];
            $links = [
                array(
                    'name' => "الشركات", "link" => base_url('AR/Consultant/systemes/Companies'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "الفروع", "link" => base_url('AR/Consultant/systemes/Departments'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
            ];
        }
        if ($this->uri->segment(4) && in_array(strtolower($this->uri->segment(4)), $supportedtypes)) {
            $data['type'] = strtolower($this->uri->segment(4));
            if ($this->input->method() == "get") {
                $data['links'] = $links;
                if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->input->is_ajax_request()) { // request for files
                    try {
                        $accountid = $this->uri->segment(5);
                        $files = $this->db->select("concat('" . base_url('uploads/consultants/') . "',FileName) as link , Comments , Id")
                            ->select("(SELECT COUNT(Id) FROM l0_consultant_chat WHERE l0_consultant_chat.about = l1_consultant_reports.Id) AS ChatMessages")
                            ->select('(SELECT COUNT(Id) 
                            FROM l0_consultant_chat 
                            WHERE l0_consultant_chat.about = l1_consultant_reports.Id
                            AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                            AND read_at IS NULL) AS UnreadMessages')
                            ->where("AccountType", $keys[$data['type']])
                            ->where("AccountId", $accountid)
                            ->get('l1_consultant_reports')
                            ->result_array();
                        $this->response->json(["status" => "ok", "files" => $files]); // return success
                    } catch (\Throwable $th) {
                        $this->response->json(["status" => "error", "message" => "معذرة !! لدينا خطأ غير متوقع ، يرجى المحاولة مرة أخرى في وقت لاحق"]); // error
                    }
                } else { // static loading
                    $data['hasparent'] = false;
                    switch ($data['type']) { // getting the data based on the type
                        case 'schools':
                            $systemes = $this->db->select("School_Name_AR AS title , l0_organization.AR_Title as ParentName , l1_school.Id , l1_school.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_school.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_school`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_school")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'departments':
                            $systemes = $this->db->select("Dept_Name_EN AS title , l0_organization.AR_Title as ParentName , l1_co_department.Id , l1_co_department.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_co_department.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_co_department`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_co_department")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'ministries':
                            $systemes = $this->db->select("AR_Title AS title , Id , TimeStamp")
                                ->where("Type", "Ministry")
                                ->where("Id", $data['parent-data']->Id)
                                ->get('l0_organization')->result_array();
                            break;
                        case 'companies':
                            $systemes = $this->db->select("AR_Title AS title , Id , TimeStamp")
                                ->where("Id", $data['parent-data']->Id)
                                ->where("Type", "Company")
                                ->get('l0_organization')->result_array();
                            break;
                        default:
                            exit("Error !!");
                            break;
                    }
                    $data['systemes'] = $systemes;
                    $this->load->view('AR/inc/header', $data);
                    $this->load->view('AR/Consultant/systemes');
                    $this->load->view('AR/inc/footer');
                }
            } else if ($this->input->method() == "post" && ($this->input->post("ids") || $this->input->post("id"))) {
                $type = $data['type'];
                $this->load->library('form_validation');
                $this->form_validation->set_rules('comments', 'comments', 'trim|max_length[200]');
                if (!$this->form_validation->run()) { // stop the script if the user inputs isn't valid
                    return $this->response->json(["status" => "error", "message" => validation_errors()]); // return the error message
                }
                // start uploading the file if the other inputs is ok
                $config['upload_path'] = './uploads/consultants/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '50000';
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('newFile')) {
                    $data = array();
                    $singleId = null; // null by default
                    $fileName = $this->upload->data()['file_name'];
                    if ($this->input->post('id')) {
                        $singleId = $this->input->post('id');
                        $data = [
                            "FileName"    => $fileName,
                            "AccountId"   => $singleId,
                            "AccountType" => $keys[$type],
                            "UploadedBy"  => $sessiondata["admin_id"],
                            "Comments"    => $this->input->post('comments')
                        ];
                    } else {
                        if (!empty(explode(',', $this->input->post("ids")))) { // check if the array isn't empty    
                            $ids = explode(',', $this->input->post("ids"));
                            foreach ($ids as $key => $id) {
                                $data[] = [
                                    "FileName"    => $fileName,
                                    "AccountId"   => $id,
                                    "AccountType" => $keys[$type],
                                    "UploadedBy"  => $sessiondata["admin_id"],
                                    "Comments"    => $this->input->post('comments')
                                ];
                            }
                        } else { // show error message 
                            $this->response->json(["status" => "error", "message" => "معذرة !! لدينا خطأ غير متوقع ، يرجى تحديث الصفحة والمحاولة مرة أخرى لاحقًا"]);
                        }
                    }
                    if ($singleId !== null ? $this->db->insert('l1_consultant_reports', $data) : $this->db->insert_batch('l1_consultant_reports', $data)) {
                        $this->response->json(["status" => "ok", "accounts" => ($singleId !== null ? [$singleId] : $ids)]); // return success and array of success ids
                    } else {
                        $this->response->json(["status" => "error", "message" => "معذرة !! لدينا خطأ غير متوقع ، يرجى المحاولة مرة أخرى في وقت لاحق"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "message" => $this->upload->display_errors()]);
                }
            } else if ($this->input->method() == "delete" && $this->input->input_stream("id")) {
                try {
                    $id = $this->input->input_stream("id");
                    $this->db->delete('l1_consultant_reports', ['Id' => $id]);
                    $this->response->json(["status" => "ok"]);
                } catch (\Throwable $th) {
                    $this->response->json(["status" => "error", "message" => "معذرة !! لدينا خطأ غير متوقع ، يرجى المحاولة مرة أخرى في وقت لاحق"]);
                }
            } else {
                $this->response->json(["status" => "error", "message" => "unsupported request"]);
            }
        } else {
            if ($this->input->method() !== "get") {
                $this->response->json(["status" => "error", "message" => "خطأ غير متوقع قم بتحديث الصفحة من فضلك"]);
            } else {
                $routes[]  = array(
                    "title" => "Consultant PDF Dashboard",
                    "links" => $links
                );
                $data['links'] = $routes;
                $data['page_title'] = "QlickSystems | اللائحة ";
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Global/Links/Lists', $data);
                $this->load->view('AR/inc/footer');
            }
        }
    }

    public function Chat()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            if (is_numeric($this->uri->segment(4))) {
                // for chat
                $data['fileid'] = $this->uri->segment(4);
                $data['fullreportdata'] = $this->db->get_where('l1_consultant_reports', ['Id' => $data['fileid']])->result_array();
                if (empty($data['fullreportdata'])) {
                    return redirect("AR/Consultant/systemes"); // stop the script if the file Doesn't exist
                }
                $data['fullreportdata'] = $data['fullreportdata'][0];
                switch ($data['fullreportdata']['AccountType']) { // getting the data based on the type
                    case 'S':
                        $systeme = $this->db->select("School_Name_AR AS title , l1_school.Id ")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get("l1_school")->result_array();
                        break;
                    case 'D':
                        $systeme = $this->db->select("Dept_Name_AR AS title , l1_co_department.Id ")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get("l1_co_department")->result_array();
                        break;
                    case 'M':
                        $systeme = $this->db->select("AR_Title AS title , Id , TimeStamp")->where("Type", "Ministry")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get('l0_organization')->result_array();
                        break;
                    case 'C':
                        $systeme = $this->db->select("AR_Title AS title , Id , TimeStamp")->where("Type", "Company")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get('l0_organization')->result_array();
                        break;
                    default:
                        exit("Error !!");
                        break;
                }
                if (empty($systeme)) {
                    return redirect("AR/Consultant/systemes"); // stop the script if the systeme Doesn't exist
                }
                $systeme = $systeme[0];
                $types = ['s' => "school", "M" => "Ministry", "C" => "Company", "d" => "department_Company"];
                $data['targetedAccount'] = ["Id" => $systeme['Id'], "Type" => $types[strtolower($data['fullreportdata']['AccountType'])], "Name" => $systeme['title']];
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/Component/Consultant/chat', $data);
                $this->load->view('AR/inc/footer');
            } else {
                redirect('AR/Consultant/systemes');
            }
        }
        $this->load->view('AR/inc/footer');
    }

    public function chats()
    {
        // page that show all of the reports that has unred messages
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Uread Chat ";
        $data['sessiondata'] = $sessiondata;
        $subquery = "(SELECT COUNT(l0_consultant_chat.Id) FROM  l0_consultant_chat 
        WHERE l0_consultant_chat.about = l1_consultant_reports.Id
        AND receiver_id = '0' AND receiver_usertype = '" . $sessiondata['type'] . "'
        AND read_at IS NULL)";
        $data['chats'] = $this->db->query("SELECT l1_consultant_reports.Id AS Report_Id , l1_consultant_reports.AccountType, 
        concat('" . base_url('uploads/consultants/') . "',l1_consultant_reports.FileName) as link ,
        $subquery AS unreadCounter ,
        CASE
            WHEN l1_consultant_reports.AccountType = 'S' THEN (SELECT School_Name_AR FROM `l1_school` WHERE `l1_school`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'M' THEN (SELECT AR_Title FROM `l0_organization` WHERE `l0_organization`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'D' THEN (SELECT Dept_Name_AR FROM `l1_co_department` WHERE `l1_co_department`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'C' THEN (SELECT AR_Title FROM `l0_organization` WHERE `l0_organization`.`Id` = `l1_consultant_reports`.`AccountId` )
            ELSE 'We cant find this user !'
        END AS U_Name 
        FROM l1_consultant_reports 
        WHERE EXISTS (SELECT l0_consultant_chat.Id FROM  l0_consultant_chat 
        WHERE l0_consultant_chat.about = l1_consultant_reports.Id
        AND receiver_id = '0' AND receiver_usertype = '" . $sessiondata['type'] . "'
        AND read_at IS NULL)")->result_array();
        // $this->response->dd($data);
        $data['keys'] = ['S' => 'school', 'D' => 'department', 'M' => 'ministrie', "C" => 'companie'];
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/Consultant/ureadchats', $data);
        $this->load->view('AR/inc/footer');
    }
}
