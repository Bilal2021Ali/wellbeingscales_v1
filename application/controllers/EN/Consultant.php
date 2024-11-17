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
            redirect('EN/Users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick System | Registration School ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Consultant/index');
        $this->load->view('EN/inc/footer');
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
            redirect('EN/Users');
        }
        $keys = ['schools' => 'S', 'departments' => 'D', 'ministries' => 'M', 'companies' => "C"];
        if ($data['parent-data']->Type == "Ministry") {
            $supportedtypes = ['schools', 'ministries'];
            $links = [
                array(
                    'name' => "Schools", "link" => base_url('EN/Consultant/systemes/Schools'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "Ministries", "link" => base_url('EN/Consultant/systemes/Ministries'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
            ];
        } else if ($data['parent-data']->Type == "Company") {
            $supportedtypes = ['companies', 'departments'];
            $links = [
                array(
                    'name' => "Companies", "link" => base_url('EN/Consultant/systemes/Companies'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "Departments", "link" => base_url('EN/Consultant/systemes/Departments'),
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
                        $this->response->json(["status" => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]); // error
                    }
                } else { // static loading
                    $data['hasparent'] = false;
                    switch ($data['type']) { // getting the data based on the type
                        case 'schools':
                            $systemes = $this->db->select("School_Name_EN AS title , l0_organization.EN_Title as ParentName , l1_school.Id , l1_school.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_school.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_school`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_school")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'departments':
                            $systemes = $this->db->select("Dept_Name_EN AS title , l0_organization.EN_Title as ParentName , l1_co_department.Id , l1_co_department.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_co_department.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_co_department`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_co_department")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'ministries':
                            $systemes = $this->db->select("EN_Title AS title , Id , TimeStamp")
                                ->where("Type", "Ministry")
                                ->where("Id", $data['parent-data']->Id)
                                ->get('l0_organization')->result_array();
                            break;
                        case 'companies':
                            $systemes = $this->db->select("EN_Title AS title , Id , TimeStamp")
                                ->where("Id", $data['parent-data']->Id)
                                ->where("Type", "Company")
                                ->get('l0_organization')->result_array();
                            break;
                        default:
                            exit("Error !!");
                            break;
                    }
                    $data['systemes'] = $systemes;
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/Consultant/systemes');
                    $this->load->view('EN/inc/footer');
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
                            $this->response->json(["status" => "error", "message" => "Sorry !! we have unexpected error , Please refresh the page and try again later"]);
                        }
                    }
                    if ($singleId !== null ? $this->db->insert('l1_consultant_reports', $data) : $this->db->insert_batch('l1_consultant_reports', $data)) {
                        $this->response->json(["status" => "ok", "accounts" => ($singleId !== null ? [$singleId] : $ids)]); // return success and array of success ids
                    } else {
                        $this->response->json(["status" => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]);
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
                    $this->response->json(["status" => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]);
                }
            } else {
                $this->response->json(["status" => "error", "message" => "unsupported request"]);
            }
        } else {
            if ($this->input->method() !== "get") {
                $this->response->json(["status" => "error", "message" => "unexpected error refresh the page please "]);
            } else {
                $routes[]  = array(
                    "title" => "Consultant PDF Dashboard",
                    "links" => $links
                );
                $data['links'] = $routes;
                $data['page_title'] = "QlickSystems | List all ";
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Global/Links/Lists', $data);
                $this->load->view('EN/inc/footer');
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
                    return redirect("EN/Consultant/systemes"); // stop the script if the file Doesn't exist
                }
                $data['fullreportdata'] = $data['fullreportdata'][0];
                switch ($data['fullreportdata']['AccountType']) { // getting the data based on the type
                    case 'S':
                        $systeme = $this->db->select("School_Name_EN AS title , l1_school.Id ")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get("l1_school")->result_array();
                        break;
                    case 'D':
                        $systeme = $this->db->select("Dept_Name_EN AS title , l1_co_department.Id ")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get("l1_co_department")->result_array();
                        break;
                    case 'M':
                        $systeme = $this->db->select("EN_Title AS title , Id , TimeStamp")->where("Type", "Ministry")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get('l0_organization')->result_array();
                        break;
                    case 'C':
                        $systeme = $this->db->select("EN_Title AS title , Id , TimeStamp")->where("Type", "Company")
                            ->where("Id", $data['fullreportdata']['AccountId'])
                            ->get('l0_organization')->result_array();
                        break;
                    default:
                        exit("Error !!");
                        break;
                }
                if (empty($systeme)) {
                    return redirect("EN/Consultant/systemes"); // stop the script if the systeme Doesn't exist
                }
                $systeme = $systeme[0];
                $types = ['s' => "school", "M" => "Ministry", "C" => "Company", "D" => "department_Company"];
                $data['targetedAccount'] = ["Id" => $systeme['Id'], "Type" => $types[strtolower($data['fullreportdata']['AccountType'])], "Name" => $systeme['title']];
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Component/Consultant/chat', $data);
                $this->load->view('EN/inc/footer');
            } else {
                redirect('EN/Consultant/systemes');
            }
        }
        $this->load->view('EN/inc/footer');
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
        AND receiver_id = '" . $sessiondata['admin_id'] . "' AND receiver_usertype = '" . $sessiondata['type'] . "'
        AND read_at IS NULL)";
        $data['chats'] = $this->db->query("SELECT l1_consultant_reports.Id AS Report_Id , l1_consultant_reports.AccountType, 
        concat('" . base_url('uploads/consultants/') . "',l1_consultant_reports.FileName) as link ,
        $subquery AS unreadCounter ,
        CASE
            WHEN l1_consultant_reports.AccountType = 'S' THEN (SELECT School_Name_EN FROM `l1_school` WHERE `l1_school`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'M' THEN (SELECT EN_Title FROM `l0_organization` WHERE `l0_organization`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'D' THEN (SELECT Dept_Name_EN FROM `l1_co_department` WHERE `l1_co_department`.`Id` = `l1_consultant_reports`.`AccountId` )
            WHEN l1_consultant_reports.AccountType = 'C' THEN (SELECT EN_Title FROM `l0_organization` WHERE `l0_organization`.`Id` = `l1_consultant_reports`.`AccountId` )
            ELSE 'We cant find this user !'
        END AS U_Name 
        FROM l1_consultant_reports 
        WHERE EXISTS (SELECT l0_consultant_chat.Id FROM  l0_consultant_chat 
        WHERE l0_consultant_chat.about = l1_consultant_reports.Id
        AND receiver_id = '" . $sessiondata['admin_id'] . "' AND receiver_usertype = '" . $sessiondata['type'] . "'
        AND read_at IS NULL)")->result_array();
        // $this->response->dd($data);
        $data['keys'] = ['S' => 'school', 'D' => 'department', 'M' => 'ministrie', "C" => 'companie'];
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Consultant/ureadchats', $data);
        $this->load->view('EN/inc/footer');
    }

    public function Reports()
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
            redirect('EN/Users');
        }
        $keys = ['schools' => 'S', 'departments' => 'D', 'ministries' => 'M', 'companies' => "C"];
        if ($data['parent-data']->Type == "Ministry") {
            $supportedtypes = ['schools', 'ministries'];
            $links = [
                array(
                    'name' => "Schools", "link" => base_url('EN/Consultant/Reports/Schools'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "Ministries", "link" => base_url('EN/Consultant/Reports/Ministries'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
            ];
        } else if ($data['parent-data']->Type == "Company") {
            $supportedtypes = ['companies', 'departments'];
            $links = [
                array(
                    'name' => "Companies", "link" => base_url('EN/Consultant/Reports/Companies'),
                    "desc" => "", "icon" => "fav_icon.png"
                ),
                array(
                    'name' => "Departments", "link" => base_url('EN/Consultant/Reports/Departments'),
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
                    } catch (\Throwable $th) {
                    }
                } else {  // static loading
                    $data['hasparent'] = false;
                    switch ($data['type']) { // getting the data based on the type
                        case 'schools':
                            $systemes = $this->db->select("School_Name_EN AS title , l0_organization.EN_Title as ParentName , l1_school.Id , l1_school.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_school.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_school`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_school")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'departments':
                            $systemes = $this->db->select("Dept_Name_EN AS title , l0_organization.EN_Title as ParentName , l1_co_department.Id , l1_co_department.TimeStamp")
                                ->join('l0_organization', 'l0_organization.Id = l1_co_department.Added_By')
                                ->where("EXISTS (SELECT Id FROM `l1_consultants_children` WHERE `account_id` = `l1_co_department`.`Id` AND `l1_consultants_children`.`consultant_id` = '" . $sessiondata['admin_id'] . "' ) ")
                                ->get("l1_co_department")->result_array();
                            $data['hasparent'] = true;
                            break;
                        case 'ministries':
                            $systemes = $this->db->select("EN_Title AS title , Id , TimeStamp")
                                ->where("Type", "Ministry")
                                ->where("Id", $data['parent-data']->Id)
                                ->get('l0_organization')->result_array();
                            break;
                        case 'companies':
                            $systemes = $this->db->select("EN_Title AS title , Id , TimeStamp")
                                ->where("Id", $data['parent-data']->Id)
                                ->where("Type", "Company")
                                ->get('l0_organization')->result_array();
                            break;
                        default:
                            exit("Error !!");
                            break;
                    }
                    $data['systemes'] = $systemes;
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/Consultant/Reports');
                    $this->load->view('EN/inc/footer');
                }
            }
        } else {
            if ($this->input->method() !== "get") {
                $this->response->json(["status" => "error", "message" => "unexpected error refresh the page please "]);
            } else {
                $routes[]  = array(
                    "title" => "Consultant PDF Dashboard",
                    "links" => $links
                );
                $data['links'] = $routes;
                $data['page_title'] = "QlickSystems | List all ";
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/Global/Links/Lists', $data);
                $this->load->view('EN/inc/footer');
            }
        }
    }

    public function Upload_Category_resources()
    {
        // upload function 
        if (!empty($_FILES['file']['name'])) {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => []);
            if ($this->input->post("AccountId") && $this->input->post("file_type") && $this->input->post("language") && in_array($this->input->post("language"), ["AR", "EN"])) {
                $file_type = $this->input->post("file_type");
                $language = $this->input->post("language");
                if ($file_type == "1") {
                    $folderlik = './uploads/Category_resources/' . $language . "/";
                } elseif ($file_type == "2") {
                    $folderlik = './uploads/Reports_resources/' . $language . "/";
                }
                $config['upload_path']    = $folderlik;
                $config['allowed_types']  = 'gif|jpg|png|pdf|psd|mp4|mp3|html|pptx|ppt|7z|zip|doc|docx|csv|XLK|3gp|avi|m4v|mpeg'; // accepted types
                $config['encrypt_name']     = true;
                $this->load->library('upload', $config);
                // respons array
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $respons['messages'] = $error;
                    $respons['error'] = "we can't upload the file now , please try later";
                    http_response_code(500);
                } else {
                    $data = $this->upload->data();
                    $AccountId = $this->input->post('AccountId');
                    $AccountType = $this->input->post('AccountType');
                    $data = [
                        "file_type"     => $file_type,
                        "file_url"      => $data['file_name'],
                        "file_language" => $language,
                        "AccountId"     => $AccountId,
                        "AccountType"   => $AccountType,
                    ];
                    if ($this->db->insert('l1_category_resources', $data)) {
                        $respons['status'] = "ok";
                    } else {
                        $respons['messages'] = ["error" => "we cant update this url now , please try later"];
                    }
                }
            } else {
                $respons['messages'] = ["error" => "We have error in this request please refresh page and try again "];
            }
            echo json_encode($respons);
        } else {
            if ($this->input->method() == "put" && $this->input->input_stream("id")) {
                $id = $this->input->input_stream("id");
                if ($this->db->query("UPDATE `l1_category_resources` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                    echo "ok";
                } else {
                    echo "error";
                }
            } else {
                header("Content-Type: application/json; charset=UTF-8");
                $respons = array('status' => "error", "messages" => []);
                if ($this->input->post('AccountId') && $this->input->post('language') && $this->input->post('file_type') && $this->input->post('AccountType')) {
                    $condetions = array(
                        "AccountId"     => $this->input->post('AccountId'),
                        "AccountType"   => $this->input->post('AccountType'),
                        "file_language" => $this->input->post('language'),
                        "file_type"     => $this->input->post('file_type')
                    );
                    if ($query = $this->db->get_where('l1_category_resources', $condetions)) {
                        $respons['list'] = $query->result_array();
                        $respons['status'] = "ok";
                    }
                } else {
                    // $respons['messages'] = ["error" => "We have error in this request please refresh page and try again "];
                    $respons['messages'] = $this->input->post();
                }
                echo json_encode($respons);
            }
        }
    }

    public function update_Category_resource_title()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => []);
            if ($this->input->post('file_id') && $this->input->post('new_title') && $this->input->post('language')) {
                if ($this->input->post('language') == "EN") {
                    $this->db->set('file_name_en', $this->input->post('new_title'));
                } else {
                    $this->db->set('file_name_ar', $this->input->post('new_title'));
                }
                $this->db->where('Id', $this->input->post('file_id'));
                if ($this->db->update('l1_category_resources')) {
                    $respons['status'] = "ok";
                }
            }
            echo json_encode($respons);
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => []);
            if ($this->input->input_stream('file_id')) {
                $id = $this->input->input_stream('file_id');
                if ($this->db->delete('l1_category_resources', array('id' => $id))) {
                    $respons['status'] = "ok";
                } else {
                    $respons['status'] = "error";
                }
            }
            echo json_encode($respons);
        }
    }


    public function upload_Resources()
    {
        if (!empty($_FILES['file']['name']) && $this->input->post("AccountId") && $this->input->post("AccountType") && is_numeric($this->input->post("AccountId"))) {
            // Set preference
            $config['upload_path']   = './uploads/Category_resources/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|psd';
            $config['max_size']      = '51200'; // max_size in kb
            $config['encrypt_name']  = true;
            //Load upload library
            $this->load->library('upload', $config);
            // File upload
            if ($this->upload->do_upload('file')) {
                // insert the file data
                $language = $this->input->post('files_language');
                $uploadData = $this->upload->data();
                $data = [
                    "file_name"         => $uploadData['file_name'],
                    "AccountId"         => $this->input->post("AccountId"),
                    "AccountType"       => $this->input->post("AccountType"),
                    "language_resource" => $language
                ];
                $this->db->insert("st_sv_categorys_resources", $data);
            } else {
                $this->response->json(["status" => "error", "message" => $this->upload->display_errors()]);
            }
        }
    }

    public function getResorceFilesList()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post('AccountId') && $this->input->post("language")) {
            // when post means return list as json
            $AccountId = $this->input->post('AccountId');
            $language = $this->input->post('language');
            header('Content-Type: application/json');
            $list = $this->db->query("SELECT `st_sv_categorys_resources`.`Id` AS FileKey , `st_sv_categorys_resources`.`status` AS status,
            `st_sv_categorys_resources`.`file_name` , `st_sv_categorys_resources`.`TimeStamp` AS At_dt 
            FROM `st_sv_categorys_resources` 
            WHERE `st_sv_categorys_resources`.`AccountId`  = '" . $AccountId . "' AND `st_sv_categorys_resources`.`language_resource` = '" . $language . "' ")->result_array();
            foreach ($list as $key => $cat) {
                $list[$key]['FileType'] = pathinfo($cat['file_name'], PATHINFO_EXTENSION);
            }
            echo json_encode($list);
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE" && $this->input->input_stream('files_ids')) {
            //$cat_id = $this->input->input_stream('files_ids');
            header('Content-Type: application/json');
            $response = array('status' => "error", "message" => "we have unexpected error ");
            if (sizeof($this->input->input_stream('files_ids')) > 0) {
                $ids = implode(',', $this->input->input_stream('files_ids'));
                if ($this->db->query("DELETE FROM `st_sv_categorys_resources` WHERE Id IN (" . $ids . ")")) {
                    $filesList = $this->db->query("SELECT `file_name` FROM `st_sv_categorys_resources` WHERE Id IN (" . $ids . ")")->result_array();
                    $deleted = 0;
                    $filed = array();
                    foreach ($filesList as $key => $file) {
                        if (unlink("./uploads/Category_resources/" . basename($file['file_name']))) {
                            $deleted++;
                        } else {
                            $filed[] = "./uploads/Category_resources/" . $file['file_name'];
                        }
                    }
                    $response = array('status' => "ok", "message" => "Deleted successfully ", "Deleted" => $deleted, "Failed" => $filed);
                } else {
                    $response = array('status' => "error", $this->db->last_query());
                }
            }
            echo json_encode($response);
        } elseif ($this->input->method() == "put") {
            $id = $this->input->input_stream("id");
            if ($this->db->query("UPDATE `st_sv_categorys_resources` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function articles_controle()
    {
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('articles', 'Article ', 'trim|required|min_length[3]|max_length[65535]');
        $this->form_validation->set_rules('accountid', ' ', 'trim|required|min_length[1]|numeric');
        if ($this->form_validation->run()) {
            $article = $this->input->post('articles');
            $AccountId = $this->input->post('accountid');
            $AccountType = $this->input->post('accounttype');
            $title = $this->input->post('title');
            // upload image 
            $config['upload_path']   = './uploads/articles_files/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = '51200'; // max_size in kb = 50mb
            $config['encrypt_name']  = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('art_image')) {
                $uploadData = $this->upload->data();
                $data = [
                    "Article"      => $article,
                    "img_url"     => $uploadData['file_name'],
                    "AccountId"   => $AccountId,
                    "AccountType" => $AccountType,
                    "title"       => $title,
                    "language"    => $this->input->post('articles_language')
                ];
                if ($this->db->insert("st_sv_categorys_articles", $data)) {
                    $response = array("status" => "ok", "message" => "Unexpected error", "inputs" => $this->input->post());
                }
            } else {
                $response = array("status" => "error", "message" => $this->upload->display_errors());
            }
        } else {
            //echo validation_errors();
            $response = array("status" => "error", "message" => validation_errors(), "inputs" => $this->input->post());
        }
        // show respons     
        echo json_encode($response);
    }

    public function getCategoriesList()
    {
        if ($this->input->method() == "post") {
            header('Content-Type: application/json');
            $respons = array('status' => "error");
            // echo json_encode(['hi' => "dfgdf"]);
            if ($this->input->post('accountid') && $this->input->post('accounttype') && $this->input->post('language')) {
                $accountid = $this->input->post('accountid');
                $accounttype = $this->input->post('accounttype');
                $language = $this->input->post('language');
                $data = array();
                $data = $this->db->query(" SELECT `st_sv_categorys_articles`.`img_url` , `st_sv_categorys_articles`.`title` , `st_sv_categorys_articles`.`status` , 
                `st_sv_categorys_articles`.`Id` AS art_id, `st_sv_categorys_articles`.`Article` AS art_text
                FROM `st_sv_categorys_articles` 
                WHERE `st_sv_categorys_articles`.`AccountId` = '" . $accountid . "' AND `st_sv_categorys_articles`.`AccountType` = '" . $accounttype . "'
                AND `st_sv_categorys_articles`.`language` = '" . $language . "' ")->result_array();
                // echo $this->db->last_query();
                // changig the texts format 
                foreach ($data as $key => $article) {
                    $text = $article['art_text'];
                    $data[$key]['art_text'] = trim($text);
                }
                // print_r($data);
                // echo json_encode();
                $respons = array('status' => "ok", "list" => $data);
            }
            echo json_encode($respons);
        } elseif ($this->input->method() == "delete") {
            if ($this->input->input_stream('key')) {
                $article = $this->input->input_stream('key');
                if ($this->db->delete('st_sv_categorys_articles', array('Id' => $article))) {  // Delete the article FRom st_sv_categorys_articles
                    $this->response->json(["status" => "ok"]);
                }
            } else {
                $this->response->json(["status" => "error"]);
            }
        } elseif ($this->input->method() == "put") {
            $id = $this->input->input_stream("id");
            if ($this->db->query("UPDATE `st_sv_categorys_articles` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function Upload_media_link()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
        if (
            $this->input->post("media_link") && $this->input->post("category_id") && $this->input->post("language")
            && in_array($this->input->post("language"), ["AR", "EN"])
        ) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('language', 'language', 'trim|required');
            $this->form_validation->set_rules('category_id', 'category_id', 'trim|required');
            if ($this->form_validation->run()) {
                if (!empty($this->input->post("media_link"))) { // validation the link
                    $language = $this->input->post('language');
                    $category_id = $this->input->post('category_id');
                    // making array
                    $data = array();
                    $links = $this->input->post("media_link");
                    // freach link
                    foreach ($links as $link) {
                        if (!empty($link['link_title'])) {
                            $title = $link['link_title'];
                        } else {
                            $linkparts = explode("?", trim($link['media_link']));
                            if (sizeof($linkparts) == 2) {
                                $videoid = str_replace("v=", "", $linkparts[1]);
                                $apikey = 'AIzaSyAU4Pg_I5BGHHIrJ5WBF8neXPYfYut9A-8'; // api key
                                $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $videoid . '&key=' . $apikey . '&part=snippet');
                                $videoDetails = json_decode($json, true);
                                if (!empty($videoDetails['items'][0]['snippet']['title'])) {
                                    $title = $videoDetails['items'][0]['snippet']['title'];
                                } else {
                                    $title = "No title";
                                }
                            } else {
                                $title = "No title";
                            }
                        }
                        // making array of data
                        $data[] = array(
                            "link"        => trim($link['media_link']),
                            "langauge"    => $language,
                            "category_id" => $category_id,
                            "AccountId"   => $category_id,
                            "title"       => $title,
                            "AccountType" => strtolower($this->uri->segment(4) ?? ""),
                            "status" => 1
                        );
                    }
                    // insert data
                    try {
                        $this->db->insert_batch('sv_st_consultant_media_links',  $data);
                        $respons['status'] = "ok";
                    } catch (\Throwable $th) {
                        $respons['status'] = "error";
                        $respons['messages'] = ["error" => "we cant update this url now , please try later"];
                    }
                } else {
                    $respons['messages'] = ["error" => "Please add a link "];
                }
            } else {
                $respons['messages'] = ["error" => validation_errors()];
            }
        } else {
            $respons['messages'] = ["error" => "We have error in this request please refresh page and try again "];
        }
        echo json_encode($respons);
    }

    public function medialinks()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
            if ($this->input->post('language') && $this->input->post('category')) {
                $AccountId = $this->input->post('category');
                $langauge = $this->input->post('language');
                $list = $this->db->get_where('sv_st_consultant_media_links', [
                    'AccountId' => $AccountId,
                    "langauge" => $langauge,
                    "AccountType" => strtolower($this->uri->segment(4) ?? ""),
                ])->result_array();
                $respons = array('status' => "ok", "list" => $list);
            }
            echo json_encode($respons);
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
            if ($this->input->input_stream('linkId')) {
                $linkId = $this->input->input_stream('linkId');
                if ($this->db->delete('sv_st_consultant_media_links', array('Id' => $linkId))) {
                    $respons['status'] = "ok";
                } else {
                    $respons['status'] = "error";
                }
            }
            echo json_encode($respons);
        } elseif ($this->input->method() == "put" && $this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            if ($this->db->query("UPDATE `sv_st_consultant_media_links` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }
}
