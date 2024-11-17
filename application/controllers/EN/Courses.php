<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends CI_Controller
{
    // public array $sessiondata = [];
    public $sessiondata = array();


    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 0) {
            redirect('EN/users');
            exit();
        }
        $this->sessiondata = $sessiondata;
    }

    private function load($view, $extraData = [])
    {
        $data['page_title'] = "Qlick Health | Courses ";
        $data['sessiondata'] = $this->sessiondata;
        $this->load->view('EN/inc/header', array_merge($data, $extraData));
        $this->load->view($view);
        $this->load->view('EN/inc/footer');
    }


    public function list()
    {
        $data['categories'] = $this->db->query("SELECT scou_st0_main_courses.Courses_Title AS courseTitle,
                sv_st_category.Cat_en as category_title,
                sv_st_category.Id as category_id,
                (SELECT COUNT(*) FROM scou_st0_main_courses WHERE scou_st0_main_courses.Category_Id = sv_st_category.Id) AS coursesCount,
                   COUNT(scou_st0_courses_topics.Id) AS topicsCount,
                   (SELECT COUNT(scou_st0_courses_resource.Id) FROM scou_st0_courses_resource WHERE scou_st0_courses_resource.Courses_Topic_Id = scou_st0_courses_topics.Id) AS resourcesCount,
                   sv_st_category.Cat_en AS categoryTitle
            FROM sv_st_category
            LEFT JOIN scou_st0_main_courses ON scou_st0_main_courses.Category_Id = sv_st_category.Id
            LEFT JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id
            GROUP BY sv_st_category.Id")->result_array();
        $this->load("EN/Courses/lists/all", $data);
    }

    public function courses_list()
    {
        if ($this->input->method() === "delete") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                $this->db->where("Id", $id)->delete("scou_st0_main_courses");
                $this->response->json(["status" => "ok"]);
                return;
            } else {
                $this->response->json(["status" => "error", "message" => "invalid request"]);
                return;
            }
        }
        if ($this->input->method() === "post") {
            $id = $this->input->post("id");
            $this->db->query("UPDATE scou_st0_main_courses SET Status = IF(Status=1, 0, 1) WHERE Id = '" . $id . "'");
            return;
        }
        $data['category'] = $this->getCategoryFromUrl();
        $data['courses'] = $this->db
            ->query("SELECT scou_st0_main_courses.Courses_Title AS courseTitle,
                   scou_st0_main_courses.Id AS courseId,
                   COUNT(scou_st0_courses_topics.Id) AS topicsCount,
                   (SELECT COUNT(scou_st0_courses_resource.Id) FROM scou_st0_courses_resource WHERE scou_st0_courses_resource.Courses_Topic_Id = scou_st0_courses_topics.Id) AS resourcesCount,
                   sv_st_category.Cat_en AS categoryTitle
            FROM scou_st0_main_courses
            JOIN sv_st_category ON sv_st_category.Id = scou_st0_main_courses.Category_Id
            LEFT JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id
            WHERE scou_st0_main_courses.Category_Id =  " . $data['category']['Id'] . "
            GROUP BY scou_st0_main_courses.Id")
            ->result_array();
        // 
        //        echo $this->db->last_query();
        //        die();
        $data['full_courses'] = $this->db
            ->select("scou_st0_main_courses.* , r_resources.Resources_Type_EN as ResourceTitle , r_language.Language as LanguageName")
            ->join("r_resources", "r_resources.Id = scou_st0_main_courses.Resources_Type_Id")
            ->join("r_language", "r_language.Id = scou_st0_main_courses.Language_Id")
            ->where("scou_st0_main_courses.Category_Id", $data['category']['Id'])
            ->get("scou_st0_main_courses")
            ->result_array();
        $this->load("EN/Courses/lists/courses", $data);
    }

    public function topics_list()
    {
        if (!$this->uri->segment(4) && !is_numeric($this->uri->segment(4))) {
            $this->output->set_status_header('404');
            die();
        }
        $courseId = $this->uri->segment(4);
        $course = $this->db->select("Id , Courses_Title , Category_Id")->where("Id", $courseId)->get("scou_st0_main_courses")->result_array()[0] ?? null;
        if (empty($course)) {
            $this->output->set_status_header('404');
            die();
        }

        $this->load->model("CoursesModel");
        if ($this->input->method() === "delete") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                $this->db->where("Id", $id)->delete("scou_st0_courses_topics");
                $this->response->json(["status" => "ok"]);
            } else {
                $this->response->json(["status" => "error", "message" => "invalid request"]);
            }
            return;
        }
        if ($this->input->method() === "post") {
            $id = $this->input->post("id");
            $this->db->query("UPDATE scou_st0_courses_topics SET Status = IF(Status=1, 0, 1) WHERE Id = '" . $id . "'");
            return;
        }

        $data['topics'] = $this->CoursesModel->topics($courseId);
        //$courseId
        $data['courseId'] = $courseId;
        $data['course'] = $course;
        $this->load("EN/Courses/lists/topics", $data);
    }

    public function resources_list()
    {
        if (!$this->uri->segment(4) && !is_numeric($this->uri->segment(4))) {
            $this->output->set_status_header('404');
            die();
        }
        $topicId = $this->uri->segment(4);
        $topic = $this->db->select("Id , Courses_Topic_Title , Main_Courses_Id")->where("Id", $topicId)->get("scou_st0_courses_topics")->result_array();

        if (empty($topic)) {
            $this->output->set_status_header('404');
            die();
        }
        $data['topic'] = $topic[0];
        $this->load->model("CoursesModel");

        if ($this->input->method() === "delete") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                $this->db->where("Id", $id)->delete("scou_st0_courses_resource");
                $this->response->json(["status" => "ok"]);
            } else {
                $this->response->json(["status" => "error", "message" => "invalid request"]);
            }
            return;
        }
        if ($this->input->method() === "post") {
            $id = $this->input->post("id");
            $this->db->query("UPDATE scou_st0_courses_resource SET Status = IF(Status=1, 0, 1) WHERE Id = '" . $id . "'");
            return;
        }

        $data['resources'] = $this->CoursesModel->resourses($topicId);
        // $this->response->json($data);
        $this->load("EN/Courses/lists/resources", $data);
    }

    private function getCategoryFromUrl()
    {
        if (!$this->uri->segment(4) && !is_numeric($this->uri->segment(4))) {
            $this->output->set_status_header('404');
            die();
        }
        $categoryId = $this->uri->segment(4);
        $category = $this->db->select("Id , Cat_en")->where("Id", $categoryId)->get("sv_st_category")->result_array();
        if (empty($category)) {
            $this->output->set_status_header('404');
            die();
        }
        return $category[0];
    }

    public function course()
    {
        $data['category'] = $this->getCategoryFromUrl();
        $id = $this->uri->segment(5);
        $data['course'] = [
            "Category_Id" => null,
            "Language_Id" => null,
            "Courses_Title" => "",
            "Description" => "",
            "Resources_Type_Id" => "",
            "Guidance_Notes" => "",
            "Tags" => ""
        ];
        if ($id) {
            $course = $this->db->where("Id", $this->uri->segment(5))->limit(1)->get("scou_st0_main_courses")->result_array()[0] ?? null;
            if (empty($course)) {
                $this->output->set_status_header('404');
                die();
            }
            $data['course'] = $course;
        }
        if ($this->input->method() === "post") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('resource', 'Resource Type', 'required|numeric');
            $this->form_validation->set_rules('language', 'Language', 'required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('description', 'Description', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('guidance-notes', 'Guidance Description', 'required');
            if ($this->form_validation->run()) {
                $options = [
                    "Category_Id" => $data['category']['Id'],
                    "Language_Id" => $this->input->post("language"),
                    "Courses_Title" => $this->input->post("title"),
                    "Description" => $this->input->post("description"),
                    "Resources_Type_Id" => $this->input->post("resource"),
                    "Guidance_Notes" => $this->input->post("guidance-notes"),
                    "Tags" => $this->input->post("tags") ?? "",
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s")
                ];
                if (($id && isset($_FILES['cover-file']['name']) && !empty($_FILES['cover-file']['name'])) || empty($id)) {
                    $config['upload_path'] = './uploads/courses';
					$config['allowed_types'] = 'gif|jpg|png|pdf'; // Add pdf to the allowed file types
					$config['max_size'] = 10000; // 10 MB
					$config['encrypt_name'] = true;
					$this->load->library('upload', $config);
                    if (!$this->upload->do_upload('cover-file')) {
                        $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
                    }
                    $uploadData = $this->upload->data();
                    $options["Cover_URL"] = base_url("uploads/courses/" . $uploadData['file_name']);
                }
                if ($id) {
                    $this->db->where("Id", $id)->set($options)->update("scou_st0_main_courses",);
                } else {
                    $this->db->insert("scou_st0_main_courses", $options);
                }
                $this->response->json(['status' => "ok", "message" => "Course Added Successfully"]);
            } else {
                $this->response->json(['status' => "error", "message" => validation_errors()]);
            }
            return;
        }
        $data['resources'] = $this->db->select("Id , Resources_Type_EN")->order_by("Resources_Type_EN", "ASC")->get("r_resources")->result_array();
        $data['languages'] = $this->db->select("Id , Language")->order_by("Language", "ASC")->get("r_language")->result_array();
        $this->load("EN/Courses/course", $data);
    }

    public function topic()
    {
        if (!$this->uri->segment(4)) {
            $this->output->set_status_header('404');
            die();
        }
        $courseId = $this->uri->segment(4);
        $data['course'] = $this->db->where("Id", $courseId)->limit(1)->get("scou_st0_main_courses")->result_array()[0] ?? null;
        if (empty($data['course'])) {
            $this->output->set_status_header('404');
            die();
        }
        $id = $this->uri->segment(5);
        $data['topic'] = [
            'Courses_Topic_Title' => '',
            'File_URL_Type_Id' => null,
            'Description' => '',
        ];
        if ($id) {
            $topic = $this->db->where("Id", $id)->limit(1)->get("scou_st0_courses_topics")->result_array()[0] ?? null;
            if (empty($topic)) {
                $this->output->set_status_header('404');
                die();
            }
            $data['topic'] = $topic;
        }
        if ($this->input->method() === "post") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('topic-title', 'Topic Title', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('file-type', 'File Type', 'required|numeric');
            $this->form_validation->set_rules('topic-description', 'Topic Description', 'required|min_length[3]|max_length[200]');
            if (!$this->form_validation->run()) {
                $this->response->json(['status' => "error", "message" => validation_errors()]);
            }
            $options = [
                'Main_Courses_Id' => $courseId,
                'Courses_Topic_Title' => $this->input->post("topic-title"),
                'File_URL_Type_Id' => $this->input->post("file-type"),
                'Description' => $this->input->post("topic-description"),
            ];
            if ($id) {
                $this->db->where("Id", $id)->set($options)->update("scou_st0_courses_topics",);
            } else {
                $this->db->insert("scou_st0_courses_topics", $options);
            }
        }
        $data['resources'] = $this->db->select("Id , Resources_Type_EN")->order_by("Resources_Type_EN", "ASC")->get("r_resources")->result_array();
        $data['languages'] = $this->db->select("Id , Language")->order_by("Language", "ASC")->get("r_language")->result_array();
        $data['urlTypes'] = $this->db->select("*")->order_by("File_URL_Type", "ASC")->get("r_file_URL_type")->result_array();
        $this->load("EN/Courses/topic", $data);
    }

    public function resource()
    {
        if (!$this->uri->segment(4)) {
            $this->output->set_status_header('404');
            die();
        }

        $id = $this->uri->segment(5);
        $topicId = $this->uri->segment(4);
        $data['topicId'] = $topicId;
        $data['resource'] = ['Courses_Resource_Tile' => ''];
        if (!empty($id) && is_numeric($id)) {
            $resource = $this->db->select("Courses_Resource_Tile")->where("Id", $id)->limit(1)->get("scou_st0_courses_resource")->result_array()[0] ?? null;
            if (empty($resource)) {
                $this->output->set_status_header('404');
                die();
            }
            $data['resource'] = ['Courses_Resource_Tile' => $resource['Courses_Resource_Tile']];
        }
        $data['topic'] = $this->db
            ->select("Courses_Topic_Title as topicTitle , r_file_URL_type.File_URL_Type as type")
            ->join("r_file_URL_type", "r_file_URL_type.Id = scou_st0_courses_topics.File_URL_Type_Id")
            ->where("scou_st0_courses_topics.Id", $topicId)
            ->get("scou_st0_courses_topics")
            ->result_array()[0] ?? null;
        if (empty($data['topic'])) {
            $this->output->set_status_header('404');
            die();
        }
        if ($this->input->method() === "post") {
            $isNew = empty($id);
            $options = [];
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Recourse Title', 'required|min_length[3]|max_length[200]');
            if (!$this->form_validation->run()) {
                $this->response->json(['status' => "error", "message" => validation_errors()]);
            }
            $options['Courses_Resource_Tile'] = $this->input->post("title");
            $options['Courses_Topic_Id'] = $topicId;
            if (($id && isset($_FILES['cover-file']['name']) && !empty($_FILES['cover-file']['name'])) || $isNew) {
                $config['upload_path'] = './uploads/courses-covers';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = 50000; // 5 MB
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('cover')) {
                    $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
                }
                $uploadData = $this->upload->data();
                $options["Cover_URL"] = base_url("uploads/courses-covers/" . $uploadData['file_name']);
            }

            if (is_string($this->input->post("file"))) {
                $options["File_URL"] = $this->input->post("file");
            } else if (($id && isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) || $isNew) {
                $config['upload_path'] = './uploads/resources';
                $config['allowed_types'] = 'gif|jpg|png|pdf|mp4|url';
                $config['max_size'] = 250000; // 5 MB
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
                }
                $uploadData = $this->upload->data();
                $options["File_URL"] = base_url("uploads/courses-covers/" . $uploadData['file_name']);
            }

            if ($id) {
                $this->db->where("Id", $id)->set($options)->update("scou_st0_courses_resource");
            } else {
                $this->db->insert("scou_st0_courses_resource", $options);
            }

            $this->response->json(['status' => "ok"]);
        }
        $this->load("EN/Courses/resource", $data);
    }

    public function targeted_accounts()
    {
        $courseId = $this->uri->segment(4);
        // getting the data
        if ($this->input->method() == "get") { // getting the data
            $data['TargetedAccountsList'] = $this->db->select("l0_organization.EN_Title AS name , l0_organization.Id AS Id , scou_st0__main_courses_targeted_accounts.Status AS status ,scou_st0__main_courses_targeted_accounts.Id AS connectionId ,scou_st0__main_courses_targeted_accounts.TimeStamp AS AddedAt ")
                ->from("scou_st0__main_courses_targeted_accounts")->join("l0_organization", "l0_organization.Id = scou_st0__main_courses_targeted_accounts.Organization_Id")
                ->where('Main_Courses_Id', $courseId)
                ->get()
                ->result_array();
            if (!empty($data["TargetedAccountsList"])) {
                $this->db->where_not_in("Id", array_column($data["TargetedAccountsList"], "Id"));
            }
            // Return The List Based On The TargetedType Type
            $data['accounts'] = $this->db->get('l0_organization')->result_array();
            $data['courseId'] = $courseId;
            $this->load->view("EN/Courses/targeted-accounts", $data);
        } else if ($this->input->method() == "post") { // adding an account
            if (!empty($this->input->post('account'))) {
                $data = array();
                foreach ($this->input->post('account') as $key => $account) {
                    $data[] = array(
                        "Status" => 1,
                        "Main_Courses_Id" => $courseId,
                        "Organization_Id" => $account,
                        "Organization_Type_Id" => 1,
                    );
                }
                try {
                    $this->db->insert_batch("scou_st0__main_courses_targeted_accounts", $data);
                    $this->response->json(["status" => "ok"]);
                } catch (\Throwable $th) {
                    $this->response->json(["status" => "error", "message" => "Sorry we have unexpected error , Please try again later", "msg" => $this->uri->segment_array()]);
                }
            }
        } else if ($this->input->method() == "delete") { // updating the status
            try {
                $id = $this->input->input_stream('id');
                $this->db->query("UPDATE scou_st0__main_courses_targeted_accounts SET `Status` = IF(`Status`=1, 0, 1) WHERE `Id` = '" . $id . "' ");
                $this->response->json(["status" => "ok"]);
            } catch (\Throwable $th) {
                $this->response->json(["status" => "error", "message" => "Sorry we have unexpected error , Please try again later"]);
            }
        }
    }
}