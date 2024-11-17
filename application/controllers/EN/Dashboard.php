<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 */
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 0) {
            redirect('users');
            exit();
        }
    }

    public function index()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
            if ($sessiondata['type'] == 1) {
                $adminData = $this->db->query("SELECT * FROM l0_organization WHERE Id = '" . $sessiondata['admin_id'] . "'")->result_array();
                $complet['adminData'] = $this->db->query("SELECT * FROM l0_organization WHERE Id = '" . $sessiondata['admin_id'] . "'")->result_array();
                foreach ($adminData as $admindata) {
                    if (empty($admindata['Manager']) || empty($admindata['Tel'])) {
                        $data['hasntnav'] = true;
                        $this->load->view('EN/inc/header', $data);
                        $this->load->view('EN/Global/Complete_registration', $complet);
                        $this->load->view('EN/inc/footer', $data);
                    } else {
                        $this->load->view('EN/inc/header', $data);
                        $this->load->view('EN/SuperAdmin/dash');
                        $this->load->view('EN/inc/footer');
                    }
                }
            } else {
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/dash');
                $this->load->view('EN/inc/footer');
            }
        } else {
            redirect('users');
        }
    }

    public function addSystem()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Registration System ";
        $data['sessiondata'] = $sessiondata;
        $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` DESC LIMIT 10')->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/add_level1_system', $listofadmins);
        $this->load->view('EN/inc/footer');
    }

    public function GrantSystemTest()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Registration System ";
        $data['sessiondata'] = $sessiondata;
        $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` DESC LIMIT 10')->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/grantSystemTest', $listofadmins);
        $this->load->view('EN/inc/footer');
    }

    public function ManageSets()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Manage Sets ";
        $data['sessiondata'] = $sessiondata;
        $listofadmins['sets'] = $this->db->query('SELECT * FROM `sv_sets`')->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/AddSurveyTemplate', $listofadmins);
        $this->load->view('EN/inc/footer');
    }

    public function Category()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $data['page_title'] = "Qlick Health | Manage Sets ";
            $data['sessiondata'] = $sessiondata;
            $data['Categorys'] = $this->db->query(' SELECT * FROM `sv_st_category` ')->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Category_managment');
            $this->load->view('EN/inc/footer');
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $cat_id = $this->input->input_stream('category_id');
            if ($this->db->delete('sv_st_category', array('Id' => $cat_id))) {
                echo "ok";
            } else {
                echo "error";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !$this->input->post("for_get") && $this->input->post("RequestFor") == "Add") {
            header('Content-Type: application/json');
            $respons = array("status" => "error", "message" => "unexpexted error");
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Title_EN', 'Title EN', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Action_EN', 'Action EN', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Report_EN', 'Report EN', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Media_EN', 'Media EN', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Title_AR', 'Title AR', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Action_AR', 'Action AR', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Report_AR', 'Report AR', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('Media_AR', 'Media AR', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('code', 'code', 'trim|required|exact_length[7]');
            if ($this->form_validation->run()) {
                $data = [
                    "Cat_en" => $this->input->post('Title_EN'),
                    "Cat_ar" => $this->input->post('Title_AR'),
                    "action_name_en" => $this->input->post('Action_EN'),
                    "action_name_ar" => $this->input->post('Action_AR'),
                    "report_name_en" => $this->input->post('Report_EN'),
                    "report_name_ar" => $this->input->post('Report_AR'),
                    "media_name_en" => $this->input->post('Media_EN'),
                    "media_name_ar" => $this->input->post('Media_AR'),
                    "Code" => $this->input->post('code')
                ];
                if ($this->db->insert('sv_st_category', $data)) {
                    $respons = array("status" => "ok", "message" => "Data Added Successfully ");
                } else {
                    $respons = array("status" => "error", "message" => "unexpexted error");
                }
            } else {
                $respons = array("status" => "error", "message" => validation_errors());
            }
            echo json_encode($respons);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for_get")) {
            header('Content-Type: application/json');
            $respons = array('status' => "error", "category_data" => []);
            $cat_id = $this->input->post('cat_id');
            if ($category_data = $this->db->get_where('sv_st_category', array('Id' => $cat_id), 1)->result_array()) {
                $respons = array('status' => "ok", "category_data" => $category_data);
            } else {
                $respons = array('status' => "error", "category_data" => $this->db->last_query());
            }
            echo json_encode($respons);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("RequestFor") == "Update") { // Update category data 
            header('Content-Type: application/json');
            $respons = array("status" => "error", "message" => "unexpexted error");
            if ($this->input->post("cat_id") && is_numeric($this->input->post("cat_id"))) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('Title_EN', 'Title EN', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Action_EN', 'Action EN', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Report_EN', 'Report EN', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Media_EN', 'Media EN', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Title_AR', 'Title AR', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Action_AR', 'Action AR', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Report_AR', 'Report AR', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('Media_AR', 'Media AR', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('code', 'code', 'trim|required|exact_length[7]');
                if ($this->form_validation->run()) {
                    // start update
                    $this->db->set('Cat_en', $this->input->post('Title_EN'));
                    $this->db->set('Cat_ar', $this->input->post('Title_AR'));
                    $this->db->set('action_name_en', $this->input->post('Action_EN'));
                    $this->db->set('action_name_ar', $this->input->post('Action_AR'));
                    $this->db->set('report_name_en', $this->input->post('Report_EN'));
                    $this->db->set('report_name_ar', $this->input->post('Report_AR'));
                    $this->db->set('media_name_en', $this->input->post('Media_EN'));
                    $this->db->set('media_name_ar', $this->input->post('Media_AR'));
                    $this->db->where('Id', $this->input->post('cat_id'));
                    if ($this->db->update('sv_st_category')) { // the only case return ok 
                        $respons = array("status" => "ok", "message" => "Data Updated Successfully");
                    }
                } else {
                    $respons = array("status" => "error", "message" => validation_errors());
                }
            } else {
                $respons = array("status" => "error", "message" => "unexpexted error , Pleas refresh The page ");
            }
            echo json_encode($respons);
        } elseif (
            !empty($_FILES['icon']) && $this->input->post("activeCategory") && is_numeric($this->input->post("activeCategory"))
            && $this->input->post("activeLanguage") && in_array($this->input->post('activeLanguage'), ['ar', 'en'])
        ) {
            $config['upload_path'] = './uploads/category_choices_icons/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '51200'; // max_size in kb
            $config['encrypt_name'] = true;
            $lang = $this->input->post('activeLanguage');
            //Load upload library
            $this->load->library('upload', $config);
            // File upload
            if ($this->upload->do_upload('icon')) {
                // insert the file data
                $uploadData = $this->upload->data();
                if ($this->db->where("id", $this->input->post("activeCategory"))->set('icon_' . $lang, $uploadData['file_name'])->update('sv_st_category')) {
                    $this->response->json(['status' => 'ok']);
                } else {
                    $this->response->json(['status' => 'error', 'message' => "Sorry we have unexpected error , Please refresh the page and try again."]);
                }
            } else {
                $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors()]);
            }
        }
    }

    public function Addsurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Manage Sets ";
        $data['sessiondata'] = $sessiondata;
        $data['sets'] = $this->db->query('SELECT * FROM `sv_sets` ')->result_array();
        $data['ctegories'] = $this->db->query('SELECT * FROM `sv_st_category` ')->result_array();
        $data['Ministries'] = $this->db->where('Type', 'Ministry')->get('l0_organization')->result_array();
        $data['Companies'] = $this->db->where('Type', 'Company')->get('l0_organization')->result_array();
        $data['styles'] = $this->db->get('scl_st0_climate_styles')->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/Creat_new_Survey');
        $this->load->view('EN/inc/footer');
    }

    public function CreatClimateSurvey()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = "Qlick Health | Manage Sets ";
            $data['sessiondata'] = $sessiondata;
            $data['sets'] = $this->db->query('SELECT * FROM `sv_sets` ')->result_array();
            $data['ctegories'] = $this->db->query('SELECT * FROM `sv_st_category` ')->result_array();
            $data['Ministries'] = $this->db->where('Type', 'Ministry')->get('l0_organization')->result_array();
            $data['Companies'] = $this->db->where('Type', 'Company')->get('l0_organization')->result_array();
            $data['styles'] = $this->db->get('scl_st0_climate_styles')->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/CreatClimateSurvey'); //Type
            $this->load->view('EN/inc/footer');
        } else {
            if ($this->input->post("set") && $this->input->post("questions") && $this->input->post("category") && $this->input->post("answer_group") && $this->input->post("targetedaccounts") && $this->input->post('style')) {
                $questions = $this->input->post('questions');
                $target = $this->input->post('targetedtypes');
                $style = $this->input->post('style');

                $config['upload_path'] = './uploads/climates-surveys-images';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 10000; // 10 MB
                $config['encrypt_name'] = true;
                $avatar = "";
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('climateImage')) {
                    $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
                } else {
                    $uploadData = $this->upload->data();
                    $avatar = base_url("uploads/climates-surveys/" . $uploadData['file_name']);
                }

                if (in_array($target, ['M', 'C'])) {
                    $data = [
                        "set_id" => $this->input->post("set"),
                        "category" => $this->input->post("category"),
                        "answer_group" => $this->input->post("answer_group"),
                        "question_id" => $questions,
                        "targeted_type" => $target,
                        "style" => $style,
                        "Published_to" => (!empty($this->input->post('targetedaccounts')) ? $this->input->post('targetedaccounts')[0] : 0), // for mobile app only
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s'),
                        "Company_Type" => $target == "M" ? 1 : 2,
                        "climate_image" => $avatar
                    ];
                    if ($this->db->insert('scl_st0_climate', $data)) {
                        $survId = $this->db->insert_id();
                        $choicesData = $this->db->get_where('sv_set_template_answers_choices', ['group_id' => $this->input->post("answer_group")])->result_array();
                        $choices = array();
                        $targetedaccounts = array();
                        foreach ($this->input->post("targetedaccounts") as $key => $targetedaccount) {
                            $targetedaccounts[] = [
                                'account_id' => $targetedaccount,
                                'survey_id' => $survId,
                            ];
                        }
                        $this->db->insert_batch('scl_st0_climate_targeted_accounts', $targetedaccounts);
                        foreach ($choicesData as $key => $choice) {
                            $choices[] = [
                                "servey_id" => $survId,
                                "choice_id" => $choice['Id'],
                                "position" => $key,
                                "mark" => 1
                            ];
                        }
                        if ($this->db->insert_batch('scl_st_choices', $choices)) {
                            $actions = array();
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/ClimateSurveys"),
                                "title" => "Survey List",
                                "description" => "Find your surveys",
                                "icon" => "uil-list-ul",
                            ];
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/CreatClimateSurvey"),
                                "title" => "Create another one",
                                "description" => "Add another survey",
                                "icon" => "uil-plus",
                            ];
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/climateChoices/" . $survId),
                                "title" => "Choices",
                                "description" => "Add Icons to your choices and delete it",
                                "icon" => "uil-create-dashboard",
                            ];
                            $this->response->json(['status' => 'ok', "actions" => $actions]);
                        } else {
                            $this->response->json(['status' => 'error']);
                        }
                    } else {
                        $this->response->json(['status' => 'error']);
                    }
                }
            } else {
                $this->response->json(['status' => 'error']);
            }
        }
    }

    public function climateChoices()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            if ($this->input->method() == 'get') {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['page_title'] = "Qlick Health | Manage Choices ";
                $data['sessiondata'] = $sessiondata;
                $data['choices'] = $this->db
                    ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
                    sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
                    ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
                    ->from('scl_st_choices')
                    ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
                    ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
                    ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
                    ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
                    ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
                    ->where('servey_id', $this->uri->segment(4))
                    ->order_by('position', 'ASC')
                    ->get()->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/climateChoices');
                $this->load->view('EN/inc/footer');
            } else {
                if ($this->input->post('type')) {
                    if ($this->input->post('type') == "sorting") {
                        foreach ($this->input->post("newsorting") as $key => $sort) {
                            $this->db->set('position', $key);
                            $this->db->where('id', $sort);
                            $this->db->where('servey_id', $this->uri->segment(4));
                            $this->db->update("scl_st_choices");
                        }
                        $this->response->json(['status' => "ok"]);
                    }
                } else if ($this->input->post('Mark') && $this->input->post('activeChoice')) {
                    $this->db->set('mark', $this->input->post('Mark'));
                    $this->db->where('id', $this->input->post('activeChoice'));
                    $this->db->where('servey_id', $this->uri->segment(4));
                    if ($this->db->update("scl_st_choices")) {
                        $this->response->json(['status' => "ok"]);
                    } else {
                        $this->response->json(['status' => "error", "message" => "we have unexpected error , Please refresh the page and try again."]);
                    }
                } else {
                    if (
                        !empty($_FILES['icon']) && $this->input->post("activeChoice") && is_numeric($this->input->post("activeChoice"))
                        && $this->input->post('activeLanguage') && in_array($this->input->post('activeLanguage'), ['ar', 'en'])
                    ) {
                        $config['upload_path'] = './uploads/climate_choices_icons/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '51200'; // max_size in kb
                        $config['encrypt_name'] = true;
                        //Load upload library
                        $this->load->library('upload', $config);
                        // File upload
                        if ($this->upload->do_upload('icon')) {
                            // insert the file data
                            $uploadData = $this->upload->data();
                            if ($this->db->where("id", $this->input->post("activeChoice"))->set('icon_' . $this->input->post('activeLanguage'), $uploadData['file_name'])->update('scl_st_choices')) {
                                $this->response->json(['status' => 'ok']);
                            } else {
                                $this->response->json(['status' => 'error', 'message' => "Sorry we have unexpected error , Please refresh the page and try again."]);
                            }
                        } else {
                            $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors()]);
                        }
                    } else {
                        $this->response->json(['status' => 'error', 'message' => "Sorry you have to choose an file"]);
                    }
                }
            }
        } else {
            echo "Error...";
        }
    }

    public function ClimateSurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "Qlick Health | List ";
        if ($this->input->method() == "get") {
            $data['surveys'] = $this->db->query(" SELECT
            `scl_st0_climate`.`TimeStamp` AS created_at ,
            `scl_st0_climate`.`Id` AS survey_id,
            `scl_st0_climate`.`status` AS status,
            (SELECT COUNT(`scl_climate_answers`.`Id`) FROM `scl_climate_answers` WHERE `climate_id` = `scl_published_claimate`.`Id` ) AS completed,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
            `scl_st0_climate`.`answer_group` AS group_id,
            `scl_st0_climate`.`targeted_type` AS targeted,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_title ,
            (SELECT COUNT(`scl_published_claimate`.`Id`) 
            FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id` ) AS isUsed ,
            `sv_questions_library`.`en_title` AS question 
            FROM `scl_st0_climate`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
            JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
            LEFT JOIN `scl_st_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
            LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
            GROUP BY `scl_st0_climate`.`Id` ORDER BY `scl_st0_climate`.`Id` ASC ")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/ClaimateSurveys');
            $this->load->view('EN/inc/footer');
        } elseif ($this->input->method() == "delete") {
            if ($this->input->input_stream('serv_id')) {
                $serv_id = $this->input->input_stream('serv_id');
                if ($this->db->delete('scl_st0_climate', array('Id' => $serv_id))) {
                    echo "ok";
                }
            } else {
                echo "error";
            }
        } elseif ($this->input->method() == "put") {
            if ($this->input->input_stream('surveyId')) {
                $serv_id = $this->input->input_stream('surveyId');
                if ($this->db->query("UPDATE `scl_st0_climate` SET status = IF(status=1, 0, 1) WHERE Id = '" . $serv_id . "'")) {
                    echo "ok";
                }
            } else {
                echo "error";
            }
        }
    }

    public function manage_answers()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | template answers";
        // $data['isUsed'] = $this->db->get_where('sv_st_surveys' , ['answer_group_en' => $id])->result_array();
        $data['choices'] = $this->db->query("SELECT `sv_set_template_answers`.* , `sv_st_surveys`.`Id` AS UsedInSurvey
        FROM `sv_set_template_answers` 
        LEFT JOIN `sv_st_surveys` ON `sv_st_surveys`.`answer_group_en` = `sv_set_template_answers`.`Id`
        ORDER BY sv_set_template_answers.Id DESC ")->result_array();
        // $this->response->dd($data['choices']);
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/temp_answers');
        $this->load->view('EN/inc/footer');
    }

    public function manage_choices()
    {
        if ($this->uri->segment(4)) {
            $id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | template answers";
            $data['parent_data'] = $this->db->query("SELECT * FROM `sv_set_template_answers` WHERE `Id` = '" . $id . "' ORDER BY Id DESC  ")->result_array();
            if (!empty($data['parent_data'])) {
                $data['choices'] = $this->db->query(" SELECT * FROM `sv_set_template_answers_choices` WHERE `group_id` = '" . $id . "'
                ORDER BY Id DESC ")->result_array();
                $data['isUsed'] = $this->db->get_where('sv_st_surveys', ['answer_group_en' => $id])->result_array();
                $data['sessiondata'] = $sessiondata;
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/answer_choices_managment');
                $this->load->view('EN/inc/footer');
            } else {
                redirect('EN/Dashboard/manage_answers');
            }
        }
    }
    // the new  Survey manage page 
    // sv_st_questions 
    public function Manage_surveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Manage Surveys";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/Manage_Surveys');
        $this->load->view('EN/inc/footer');
    }

    public function surveys_list()
    {
        $status = intval($this->input->get('status') ?? 1);
        $data['surveys'] = $this->db->query(" SELECT
            `sv_st_surveys`.`TimeStamp` AS created_at ,
            `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_surveys`.`targeted_type` AS targeted_type,
            (SELECT COUNT(`sv_st1_answers`.`Id`) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) AS completed,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_title ,
            `sv_st_questions`.`survey_id` AS connId ,
            COUNT(`sv_st_questions`.`Id`) AS questions_count ,
            COUNT(`sv_school_published_surveys`.`Id`) AS isUsed 
            FROM `sv_st_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            LEFT JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            LEFT JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            WHERE `sv_st_surveys`.`status` = " . $status . "
            GROUP BY `sv_st_questions`.`survey_id` ORDER BY `sv_st_surveys`.`Id` ASC")->result_array();
        $data['fillablesurveys'] = $this->db->query(" SELECT
            `sv_st_fillable_surveys`.`TimeStamp` AS created_at ,
            `sv_st_fillable_surveys`.`Id` AS survey_id,
            `sv_st_fillable_surveys`.`status` AS status,
            (SELECT COUNT(`sv_st1_answers`.`Id`) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) AS completed,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
            `sv_st_fillable_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_st_fillable_questions`.`survey_id` AS connId ,
            COUNT(`sv_st_fillable_questions`.`survey_id`) AS questions_count ,
            COUNT(`sv_school_published_surveys`.`Id`) AS isUsed 
            FROM `sv_st_fillable_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
            INNER JOIN `sv_st_fillable_questions` ON `sv_st_fillable_questions`.`survey_id` = `sv_st_fillable_surveys`.`Id`
            LEFT JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
            LEFT JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_fillable_surveys`.`category`
            WHERE `sv_st_fillable_surveys`.`status` = " . $status . "
            GROUP BY `sv_st_fillable_questions`.`survey_id` ORDER BY `sv_st_fillable_surveys`.`Id` ASC")->result_array();
        $this->load->view('EN/SuperAdmin/inc/surveys-lists', $data);
    }

    public function change_serv_status()
    {
        if ($this->input->post('sv_type') == "fillable" || $this->input->input_stream('sv_type') == "fillable") {
            $tableName = "sv_st_fillable_surveys";
            $q_tableName = "sv_st_fillable_questions";
        } else {
            $tableName = "sv_st_surveys";
            $q_tableName = "sv_st_questions";
        }
        if ($this->input->post("serv_id") && $this->input->post("type") && $this->input->post('sv_type')) {
            $id = $this->input->post("serv_id");
            if ($this->input->post("type") == "change") {
                if ($this->db->query("UPDATE `" . $tableName . "` SET status = IF(status=1, 0, 1) WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            } elseif ($this->input->post("type") == "delete") {
                if ($this->db->query("DELETE FROM `" . $tableName . "` WHERE Id = '" . $id . "' ")) {
                    $this->db->query("DELETE FROM `" . $q_tableName . "` WHERE survey_id = '" . $id . "' ");
                    echo 'ok';
                } else {
                    echo "error";
                }
            }
        } elseif ($this->input->post("requestFor") && $this->input->post("requestFor") == "All_questions" && $this->input->post("group_id")) {
            $group = $this->input->post("group_id");
            $quastins = $this->db->query("SELECT *,`" . $q_tableName . "`.`Id` AS q_id
			FROM `" . $q_tableName . "`
			INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_tableName . "`.`question_id`
			WHERE `survey_id` = '" . $group . "' ")->result_array();
            if (!empty($quastins)) {
                foreach ($quastins as $key => $question) { ?>
                    <div id="question_<?php echo $question['q_id'] ?>" class="animate__animated">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none notStatic">
                                <a href="#quas_<?php echo $question['q_id'] ?>" class="text-dark" data-toggle="collapse"
                                   aria-expanded="false" aria-controls="quas_<?php echo $question['q_id'] ?>">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            <?php echo ($key + 1) . ". " . $question['en_title']; ?>
                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="quas_<?php echo $question['q_id'] ?>" class="collapse"
                                     aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <h6><?php echo $question['code']; ?>
                                            | <?php echo $question['TimeStamp']; ?></h6>
                                        <p><?php echo $question['en_desc'] ?></p>
                                        <div class="col-12">
                                            <i class="uil uil-trash delete_question"
                                               data-surv-type="<?= $this->input->post('sv_type') ?>"
                                               for="<?php echo $question['q_id'] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <script>
                    $('.delete_question').each(function () {
                        $(this).click(function () {
                            const Id = $(this).attr('for');
                            const type = $(this).attr('data-surv-type');
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, cancel!',
                                confirmButtonClass: 'btn btn-success mt-2',
                                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                                buttonsStyling: false
                            }).then(function (result) {
                                if (result.value) {
                                    //DELETE 	
                                    $.ajax({
                                        type: 'DELETE',
                                        url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
                                        data: {
                                            question_id: Id,
                                            sv_type: type
                                        },
                                        success: function (data) {
                                            if (data === "ok") {
                                                Swal.fire({
                                                    title: 'Deleted!',
                                                    text: 'Your question has been deleted.',
                                                    icon: 'success'
                                                }).then(function (result) {
                                                    $('#question_' + Id).addClass('animate__flipOutX');
                                                    setTimeout(function () {
                                                        $('#question_' + Id).remove();
                                                    }, 800);
                                                });
                                            } else {
                                                Swal.fire(
                                                    'error',
                                                    'Oops! We have an unexpected error.',
                                                    'error'
                                                );
                                            }
                                        },
                                        ajaxError: function () {
                                            Swal.fire(
                                                'error',
                                                'oops!! we have a error',
                                                'error'
                                            );
                                        }
                                    });
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    Swal.fire({
                                        title: 'Cancelled',
                                        text: 'this question is safe !',
                                        icon: 'error'
                                    });
                                }
                            });
                        });
                    });
                </script>
            <?php } else { ?>
                <img src="<?php echo base_url() ?>assets/images/404-error.png" alt="" class="w-100">
                <h3 class="text-center">No data found !!</h3>
                <?php
            }
        } elseif ($this->input->post("requestFor") && $this->input->post("requestFor") == "av_questions" && $this->input->post("group_id")) {
            $av_questions = array();
            $group = $this->input->post("group_id");
            $av_questions = $this->db->query("SELECT `en_title`,`Id`
            FROM `sv_questions_library`
            WHERE NOT EXISTS (SELECT Id FROM `" . $q_tableName . "` 
            WHERE `" . $q_tableName . "`.`question_id` =  `sv_questions_library`.`Id` AND `survey_id` = '" . $group . "' ) ")->result_array();
            $survtype = $this->input->post("sv_type");
            $this->load->view('EN/SuperAdmin/add_quastion_to_serv', [
                'av_questions' => $av_questions,
                'suerv_id' => $group,
                "survey_type" => $survtype
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == "DELETE" && $this->input->input_stream("question_id")) {
            $question_id = $this->input->input_stream("question_id");
            if ($this->db->query("DELETE FROM `" . $q_tableName . "` WHERE `Id` = '" . $question_id . "' ")) {
                $survId = $this->input->input_stream('sv_id');
                $this->db->delete('sv_st_answers_mark', ["survey_id" => $survId, "question_id" => $question_id]);
                echo "ok";
            }
        }
    }

    public function push_new_questions()
    {
        if ($this->input->post('new_questions') && $this->input->post('__surv_') && $this->input->post('__survtype__')) {
            $serv_id = $this->input->post('__surv_');
            $questions = $this->input->post('new_questions');
            if ($this->input->post('__survtype__') == "fillable") {
                $table_name = "sv_st_fillable_questions";
            } else {
                $table_name = "sv_st_questions";
            }
            foreach ($questions as $key => $question) {
                $questions_arr[] = array(
                    "survey_id" => $serv_id,
                    "question_id" => $question,
                    "position" => $key,
                    "created" => date('Y-m-d'),
                    "time" => date('H:i:s'),
                );
            }
            if ($this->db->insert_batch($table_name, $questions_arr)) {
                echo "ok";
            }
        }
    }

    public function Managequestions()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add question";
        $data['sessiondata'] = $sessiondata;
        $this->load->library('pagination');
        $config['base_url'] = base_url("EN/Dashboard/Managequestions");
        $config['total_rows'] = $this->db->get("sv_questions_library")->num_rows();
        $config['per_page'] = 15;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination navigation mt-2" style="justify-content: center;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item page-link">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item page-link">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item page-link">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="bg-primary active text-white page-item page-link"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item page-link">';
        $config['num_tag_close'] = '</li>';
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data['set_id'] = $this->uri->segment(4);
        $list['questions'] = $this->db->query("SELECT * FROM `sv_questions_library` LIMIT $page," . $config['per_page'] . " ")->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/Managequestions', $list);
        $this->load->view('EN/inc/footer');
    }

    public function questions_grouping()
    {
        if ($this->uri->segment(5)) {
            $g_table = "sv_st_fillable_groups";
            $q_tableName = "sv_st_fillable_questions";
        } else {
            $g_table = "sv_st_groups";
            $q_tableName = "sv_st_questions";
        }
        if ($this->input->get('survtype')) {
            if ($this->input->get('survtype') == "fillable") {
                $g_table = "sv_st_fillable_groups";
                $q_tableName = "sv_st_fillable_questions";
            } else {
                $g_table = "sv_st_groups";
                $q_tableName = "sv_st_questions";
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if ($this->uri->segment(4)) {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['page_title'] = "Qlick Health | Add question";
                $data['sessiondata'] = $sessiondata;
                $group_id = $this->uri->segment(4);
                $data['group_id'] = $group_id;
                $data['surv_type'] = $this->uri->segment(5) ? "fillable" : "notfillable";
                $data['used_groups'] = $this->db->query(" SELECT * FROM `" . $g_table . "` WHERE `serv_id` = '" . $group_id . "'")->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/questions_grouping');
                $this->load->view('EN/inc/footer');
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("group_id")) {
            if ($this->input->post('group_id') && $this->input->post('serv_id')) {
                $av_questions = array();
                $serv_id = $this->input->post("serv_id");
                $group = $this->input->post("group_id");
                $av_questions = $this->db->query("SELECT `en_title`,`" . $q_tableName . "`.`Id`
                    FROM `sv_questions_library`
                    JOIN `" . $q_tableName . "` ON `" . $q_tableName . "`.`question_id` = `sv_questions_library`.`Id` AND `" . $q_tableName . "`.`survey_id` = '" . $serv_id . "'
                    WHERE EXISTS ( SELECT Id FROM `" . $q_tableName . "` 
                    WHERE `" . $q_tableName . "`.`question_id` =  `sv_questions_library`.`Id` AND `survey_id` = '" . $serv_id . "' AND `Group_id` = '0' )  ")->result_array();
                $this->load->view('EN/SuperAdmin/add_quastion_to_serv', [
                    'av_questions' => $av_questions,
                    'suerv_id' => $serv_id,
                    "survey_type" => $this->uri->segment(5) ? "fillable" : "notfillable",
                ]);
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("question_id")) {
            $av_questions = array();
            $serv_id = $this->input->post("serv_id");
            $group = $this->input->post("group_key");
            $av_groups = $this->db->query("SELECT * FROM `" . $g_table . "` WHERE `Id` !=  '" . $group . "' AND `serv_id` = '" . $serv_id . "' ")->result_array();
            ?>
            <label for="av_groups">Avalaible groups :</label>
            <select name="av_groups" class="form-control" id="av_groups">
                <?php foreach ($av_groups as $group) { ?>
                    <option value="<?php echo $group['Id'] ?>"><?php echo $group['title_en'] ?></option>
                <?php } ?>
            </select>
            <?php
        }
    }

    public function add_questions_to_group()
    {
        if ($this->input->get('survtype') == "fillable") {
            $g_table = "sv_st_fillable_groups";
            $q_tableName = "sv_st_fillable_questions";
        } else {
            $g_table = "sv_st_groups";
            $q_tableName = "sv_st_questions";
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "ADD_to") {
            $serv_id = $this->input->post('__surv_');
            $questions = $this->input->post('new_questions');
            $group_id = $this->input->post('group_id');
            $in = implode(',', $questions);
            if (!empty($in)) {
                if ($this->db->query("UPDATE `" . $q_tableName . "` SET `Group_id` = '" . $group_id . "' WHERE Id in (" . $in . ") ")) {
                    echo "ok";
                }
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "trans") {
            $serv_id = $this->input->post('__serv__');
            $q_id = $this->input->post('quastion_id');
            $new_g = $this->input->post('av_groups');
            if ($this->db->query("UPDATE `" . $q_tableName . "` SET `Group_id` = '" . $new_g . "' WHERE Id = '" . $q_id . "' ")) {
                echo "ok";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "new") {
            if ($this->input->post("title_en") && $this->input->post("title_ar") && $this->input->post("__serv__")) {
                $serv_id = $this->input->post("__serv__");
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $data = array(
                    'title_en' => $title_en,
                    'title_ar' => $title_ar,
                    'serv_id' => $serv_id
                );
                if ($this->db->insert($g_table, $data)) {
                    echo "ok";
                }
            } else {
                echo "not_valid";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "titles_get") {
            if ($this->input->post("group_id")) {
                header('Content-Type: application/json');
                $id = $this->input->post("group_id");
                $response = array('status' => "error", "title_en" => "", "title_ar" => "");
                $titles = $this->db->get_where($g_table, array('Id' => $id), 1)->result_array();
                if (!empty($titles)) {
                    $response = array(
                        'status' => 'ok',
                        'title_en' => $titles[0]['title_en'],
                        'title_ar' => $titles[0]['title_ar'],
                    );
                }
            }
            echo json_encode($response);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "update_g_title") {
            if ($this->input->post("group_upg_id") && $this->input->post("group_title_en") && $this->input->post("group_title_ar")) {
                $id = $this->input->post("group_upg_id");
                $title_en = $this->input->post("group_title_en");
                $title_ar = $this->input->post("group_title_ar");
                $this->db->set('title_en', $title_en);
                $this->db->set('title_ar', $title_ar);
                $this->db->where('Id', $id);
                if ($this->db->update($g_table)) {
                    echo "ok";
                }
            } else {
                print_r($this->input->post());
            }
        } elseif ($this->input->post("for") == "delete") {
            $id = $this->input->post("group_id");
            $inthisgroup = $this->db->get_where($g_table, array('Id' => $id))->result_array();
            $hasthisgroup = implode(',', array_column($inthisgroup, 'Id'));
            if (!empty($hasthisgroup)) {
                if ($this->db->query("UPDATE `" . $q_tableName . "` SET `Group_id` = '0' WHERE Id In (" . $hasthisgroup . ") ")) {
                    if ($this->db->delete($g_table, array('Id' => $id))) {
                        echo "ok";
                    }
                }
            } else {
                if ($this->db->delete($g_table, array('Id' => $id))) {
                    echo "ok";
                }
            }
        }
    }

    public function ManageChoices()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add question";
        $data['sessiondata'] = $sessiondata;
        $data['set_id'] = $this->uri->segment(4);
        $list['choices'] = $this->db->query("SELECT * FROM `sv_choices_libaray` ")->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/ManageChoices', $list);
        $this->load->view('EN/inc/footer');
    }

    public function Refrigerator_management()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add question";
        $data['sessiondata'] = $sessiondata;
        //`refrigerator_area`.`source_id`
        if (!$this->uri->segment(4) || $this->uri->segment(4) !== "connect_dept") {
            $Refrigerators = $this->db->query(" SELECT * ,
            `refrigerator_levels`.`TimeStamp` AS Added_in , 
            `refrigerator_area`.`Description` AS  The_Site_Name ,
            `refrigerator_area`.`Id` AS  ref_id ,
            `l1_co_department`.`Dept_Name_EN` AS  Dept_name ,
            `l0_organization`.`EN_Title` AS  Comp_name
            FROM `refrigerator_area` 
            JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
            JOIN `r_sites` ON `r_sites`.`Id` = `refrigerator_area`.`Site_Id` 
            JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
            JOIN `l0_organization` ON `l1_co_department`.`Added_By` = `l0_organization`.`Id`
            WHERE `refrigerator_area`.`user_type` = 'company_department'
            ORDER BY `refrigerator_area`.`Id` DESC ")->result_array();
            $list['Refrigerators'] = $Refrigerators;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Refrigerator_management', $list);
            $this->load->view('EN/inc/footer');
        }
    }

    public function Refrigerator_connect_management()
    {
        if ($this->uri->segment(4) && $this->uri->segment(5)) {
            $type = $this->uri->segment(4);
            $id = $this->uri->segment(5);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Add question";
            $data['sessiondata'] = $sessiondata;
            //`refrigerator_area`.`source_id`
            if ($type == "comp_dept") {
                $Refrigerators = $this->db->query(" SELECT * ,
                `refrigerator_levels`.`TimeStamp` AS Added_in , 
                `refrigerator_area`.`Description` AS  The_Site_Name ,
                `refrigerator_area`.`Id` AS  ref_id ,
                `l1_co_department`.`Dept_Name_EN` AS  Dept_name ,
                `l2_avatars`.`Link` AS  Dept_puc
                FROM `refrigerator_area` 
                JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
                JOIN `r_sites` ON `r_sites`.`Id` = `refrigerator_area`.`Site_Id` 
                JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
                LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_co_department`.`Id`
                AND `l2_avatars`.`Type_Of_User` = 'department_Company'
                WHERE `refrigerator_area`.`user_type` = 'company_department' AND `refrigerator_area`.`Id` = '" . $id . "'
                ORDER BY `refrigerator_area`.`Id` DESC ")->result_array();
                if (!empty($Refrigerators)) {
                    $list['Refrigerator_infos'] = $Refrigerators;
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/SuperAdmin/Refrigerator_connect_management', $list);
                    $this->load->view('EN/inc/footer');
                }
            } elseif ($type == "dept_to_dept") {
                $Refrigerators = $this->db->query(" SELECT * ,
                `refrigerator_levels`.`TimeStamp` AS Added_in , 
                `refrigerator_area`.`Description` AS  The_Site_Name ,
                `refrigerator_area`.`Id` AS  ref_id ,
                `l1_co_department`.`Dept_Name_EN` AS  Dept_name ,
                `l1_co_department`.`Id` AS  Dept_id ,
                `l2_avatars`.`Link` AS  Dept_puc
                FROM `refrigerator_area` 
                JOIN `refrigerator_levels` ON `refrigerator_levels`.`Id` = `refrigerator_area`.`type` 
                JOIN `r_sites` ON `r_sites`.`Id` = `refrigerator_area`.`Site_Id` 
                JOIN `l1_co_department` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
                LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_co_department`.`Id`
                AND `l2_avatars`.`Type_Of_User` = 'department_Company'
                WHERE `refrigerator_area`.`user_type` = 'company_department' AND `refrigerator_area`.`Id` = '" . $id . "'
                ORDER BY `refrigerator_area`.`Id` DESC ")->result_array();
                if (!empty($Refrigerators)) {
                    $list['Refrigerator_infos'] = $Refrigerators;
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/SuperAdmin/Refrigerator_connect_management_forDepts', $list);
                    $this->load->view('EN/inc/footer');
                }
            }
        }
    }

    public function Manage_depts_Refrigerators()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $sys_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Add question";
            $data['sessiondata'] = $sessiondata;
            $connects = $this->db->query(" SELECT `other`.`Dept_Name_EN` AS `Title` ,
            `v0_area_depts_devices_permissions`.`Id` AS `conn_id` ,
            `v0_area_depts_devices_permissions`.`TimeStamp` AS `In`
            FROM `v0_area_depts_devices_permissions`
            JOIN `l1_co_department` other ON `other`.`Id` = `v0_area_depts_devices_permissions`.`to_dept` 
            JOIN `l1_co_department` me ON `me`.`Id` = `v0_area_depts_devices_permissions`.`by_dept` 
            WHERE `by_dept` = '" . $sys_id . "'  ")->result_array();
            $list['new_to_connect'] = $this->db->query("SELECT `other`.`Id` , `other`.`Dept_Name_EN` AS  Dept_name
            FROM `v0_area_depts_devices_permissions`
            RIGHT JOIN `l1_co_department` other ON `other`.`Id` != `v0_area_depts_devices_permissions`.`to_dept`
            WHERE `other`.`Id` != '" . $sys_id . "' ")->result_array();
            $list['connects'] = $connects;
            $list['thisId'] = $sys_id;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Depts_Refrigerators_connect', $list);
            $this->load->view('EN/inc/footer');
        } else {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Add question";
            $data['sessiondata'] = $sessiondata;
            $depts = $this->db->query(" SELECT DISTINCT
            `l1_co_department`.`Dept_Name_EN` AS  Dept_name ,
            `l1_co_department`.`Id` AS  Dept_id ,
            `l1_co_department`.`email` AS  dept_email ,
            `l2_avatars`.`Link` AS  Dept_puc ,
            COUNT(`refrigerator_area`.`Id`) AS refs_counter
            FROM `l1_co_department`
            JOIN `refrigerator_area` ON `l1_co_department`.`Id` = `refrigerator_area`.`source_id`
            LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l1_co_department`.`Id`
            AND `l2_avatars`.`Type_Of_User` = 'department_Company' 
            WHERE `refrigerator_area`.`user_type` = 'company_department'")->result_array();
            $data['depts'] = $depts;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Depts_Refrigerators_management');
            $this->load->view('EN/inc/footer');
        }
    }

    public function add_new_connect_ref()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                if ($this->db->query("DELETE FROM `v0_area_device_permission` WHERE Id = '" . $id . "' ")) {
                    echo 'ok';
                }
            }
        } else {
            if ($this->input->post("system") && $this->input->post("for")) {
                $system = $this->input->post("system");
                $for = $this->input->post("for");
                $type = $this->input->post("type");
                $data = array(
                    "system_id" => $system,
                    "area_id" => $for,
                    "relation_type" => $type,
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s"),
                );
                if ($this->db->insert('v0_area_device_permission', $data)) {
                    echo "ok";
                }
            }
        }
    }

    public function manage_dept_connect_ref()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                if ($this->db->query("DELETE FROM `v0_area_depts_devices_permissions` WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                }
            }
        } else {
            if ($this->input->post("for") && $this->input->post("from")) {
                $to = $this->input->post("for");
                $from = $this->input->post("from");
                $data = array(
                    "by_dept" => $from,
                    "to_dept" => $to,
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s"),
                );
                if ($this->db->insert('v0_area_depts_devices_permissions', $data)) {
                    echo "ok";
                }
            }
        }
    }

    public function changeset()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('set_id')) {
                $id = $this->input->input_stream('set_id');
                if ($this->db->query("DELETE FROM `sv_sets` WHERE Id = '" . $id . "'")) {
                    echo "ok";
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
            $id = $this->input->input_stream("set_id");
            $title_type = $this->input->input_stream("title_type");
            $new_val = $this->input->input_stream("val");
            if ($title_type == "en") {
                if ($this->db->query("UPDATE `sv_sets` SET `title_en` = '" . $new_val . "' WHERE Id = '" . $id . "' ")) {
                    echo "ok";
                }
            } elseif ($title_type == "ar") {
                if ($this->db->query("UPDATE `sv_sets` SET `title_ar` = '" . $new_val . "' WHERE Id = '" . $id . "' ")) {
                    echo "ok";
                }
            }
        } else {
            if ($this->input->post("set_id")) {
                $id = $this->input->post("set_id");
                if ($this->db->query("UPDATE sv_sets SET status = IF(status=1, 0, 1) WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            }
        }
    }

    public function changequestion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('question_id')) {
                $id = $this->input->input_stream('question_id');
                if ($this->db->query("DELETE FROM `sv_questions_library` WHERE id = '" . $id . "'")) {
                    echo "ok";
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
            $id = $this->input->input_stream("quastuion_id");
            $type = $this->input->input_stream("type");
            $lang = $this->input->input_stream("lang");
            $new_val = $this->input->input_stream("val");
            if ($lang == 'en') {
                if ($type == "title") {
                    if ($this->db->query("UPDATE `sv_questions_library` SET `en_title` = '" . $new_val . "' WHERE Id = '" . $id . "' ")) {
                        echo "ok";
                    }
                } elseif ($type == "desc") {
                    if ($this->db->query("UPDATE `sv_questions_library` SET `en_desc` = '" . $new_val . "'  WHERE Id = '" . $id . "' ")) {
                        echo "ok";
                    }
                }
            } elseif ($lang == 'ar') {
                if ($type == "title") {
                    if ($this->db->query("UPDATE `sv_questions_library` SET `ar_title` = '" . $new_val . "'  WHERE Id = '" . $id . "' ")) {
                        echo "ok";
                    }
                } elseif ($type == "desc") {
                    if ($this->db->query("UPDATE `sv_questions_library` SET `ar_desc` = '" . $new_val . "'  WHERE Id = '" . $id . "' ")) {
                        echo "ok";
                    }
                }
            }
        } else {
            if ($this->input->post("question_id")) {
                $id = $this->input->post("question_id");
                if ($this->db->query("UPDATE sv_questions_library SET status = IF(status=1, 0, 1) WHERE Id = '" . $id . "'")) {
                    echo 'ok';
                } else {
                    echo "error";
                }
            }
        }
    }

    public function changechoice()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('choice_id')) {
                $id = $this->input->input_stream('choice_id');
                if ($this->db->query("DELETE FROM `sv_choices_libaray` WHERE id = '" . $id . "'")) {
                    echo "ok";
                }
            }
        }
    }

    private function sendNewUserEmail($email, $pass, $username)
    {
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.track.qlickhealth.com',
            'smtp_port' => 465,
            'smtp_user' => 'no_reply@track.qlickhealth.com',
            'smtp_pass' => 'Bd}{kKW]eTfH',
            'smtp_crypto' => 'ssl',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $messg = '<center>
        <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
        <h2> Hi there <h2> 
        <h3>Your User name is : ' . $username . ' </h3>
        <h3>Your password is : ' . $pass . ' </h3>
        <a href=""' . base_url() . '"EN/Users" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
        </center>';
        $this->email->initialize($config);
        $this->email->set_newline('\r\n');
        $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
        $this->email->bcc('emails@qlicksystems.com');
        $this->email->to($email);
        $this->email->subject(' Your User Name And Password ');
        $this->email->message($messg);
        if (!$this->email->send()) {
            echo $this->email->print_debugger();
            echo 'We have an error in sending the email . Please try again later. ';
        } else {
            echo "The Email is Sended !";
        }
        return ('traryradet');
    }

    public function questionsprovider() // returns json list of questions by the datatable parameters
    {
        // $this->response->dd($this->input->post());
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        // query building
        foreach (['en_title', 'ar_title', 'en_desc'] as $matchKey) {
            $this->db->or_like($matchKey, $this->input->post("search")['value']);
        }
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $this->db->order_by(str_replace([0, 1, 2, 3], ['Id', 'en_title', 'ar_title', 'en_desc'], $this->input->post('order')[0]['column']), strtoupper($this->input->post('order')[0]['dir']));
        $actualdata = $this->db->get("sv_questions_library");
        // echo $this->db->last_query();
        $this->db->reset_query();
        if (!empty($this->input->post("search")['value'])) {
            foreach (['en_title', 'ar_title', 'en_desc'] as $matchKey) {
                $this->db->or_like($matchKey, $this->input->post("search")['value']);
            }
        }
        $query = $this->db->get("sv_questions_library");
        $data = [];
        foreach ($actualdata->result() as $sn => $r) {
            $isselected = '';
            if ($this->input->post('selectType') == "multiple") {
                if (!empty($this->input->post('selectedQuestions'))) {
                    if (in_array($r->Id, $this->input->post('selectedQuestions'))) {
                        $isselected = 'checked';
                    }
                }
                $checkElem = '<div class="custom-control custom-checkbox mb-2 mr-sm-3"><input ' . $isselected . ' type="checkbox" class="custom-control-input chkbox" id="question_' . $r->Id . '" value="' . $r->Id . '"><label class="custom-control-label" for="question_' . $r->Id . '"></label></div>';
            } else {
                if (!empty($this->input->post('selectedQuestions'))) {
                    if ($r->Id == $this->input->post('selectedQuestions')) {
                        $isselected = 'checked';
                    }
                }
                $checkElem = '<div class="form-check mb-3 text-center"><input class="form-check-input btn" type="radio" name="formRadios" value="' . $r->Id . '" id="formRadios_' . $sn . '" ' . $isselected . '><label class="form-check-label" for="formRadios1"></label></div>';
            }
            $data[] = array(
                "id" => $checkElem,
                "questionEn" => $r->en_title,
                "questionAr" => $r->ar_title,
                "survey_description" => $r->en_desc,
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $query->num_rows(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function start_creat_servey()
    {
        if ($this->input->post("set") && $this->input->post("questions") && $this->input->post("category") && $this->input->post('style') && $this->input->post("answer_group")) {
            $questions_arr = array();
            $actions = array();
            $intable = $this->input->post('TypeOfSurvey') == "with" ? "sv_st_surveys" : "sv_st_fillable_surveys";
            $last = $this->db->query("SELECT Id FROM `" . $intable . "` ORDER BY Id DESC")->result_array();
            $number = (empty($last) ? 0 : $last[0]['Id']) + 1;
            $code = ($this->input->post('TypeOfSurvey') == "with" ? "Survey-" : "Interview-") . ($number > 9 ? $number : "0" . $number);
            $set = $this->input->post("set");
            $style = $this->input->post("style");
            $questions = array();
            foreach (explode(',', $this->input->post("questions")) as $question) {
                $questions[] = $question;
            }
            $answer_group = $this->input->post("answer_group");
            if (!empty($this->input->post("reference_en")) && !empty($this->input->post("reference_ar")) && !empty($this->input->post("disclaimer_en")) && !empty($this->input->post("disclaimer_ar")) && !empty($this->input->post("targetedaccounts"))) {
                $target = $this->input->post('targetedtypes');
                if (in_array($target, ['M', 'C'])) {
                    if ($this->input->post('TypeOfSurvey') == "with") {
                        $data = array(
                            "set_id" => $set, // survey name here
                            "category" => $this->input->post("category"),
                            "answer_group_en" => $answer_group,
                            "reference_en" => $this->input->post("reference_en"),
                            "reference_ar" => $this->input->post("reference_ar"),
                            "disclaimer_en" => $this->input->post("disclaimer_en"),
                            "disclaimer_ar" => $this->input->post("disclaimer_ar"),
                            "Message_en" => $this->input->post("message_en"),
                            "Message_ar" => $this->input->post("message_ar"),
                            "created" => date('Y-m-d'),
                            "time" => date('H:i:s'),
                            "code" => $code,
                            "generation" => rand(10000, 99999),
                            "targeted_type" => $target,
                            "style" => $style,
                            "Company_Type" => $target == 'M' ? 1 : 2,
                        );
                        $intable = "sv_st_surveys";
                        $q_surveyTable = "sv_st_questions";
                    } else {
                        $data = array(
                            "set_id" => $set, // survey name here
                            "category" => $this->input->post("category"),
                            "reference_en" => $this->input->post("reference_en"),
                            "reference_ar" => $this->input->post("reference_ar"),
                            "disclaimer_en" => $this->input->post("disclaimer_en"),
                            "disclaimer_ar" => $this->input->post("disclaimer_ar"),
                            "Message_en" => $this->input->post("message_en"),
                            "Message_ar" => $this->input->post("message_ar"),
                            "created" => date('Y-m-d'),
                            "time" => date('H:i:s'),
                            "code" => $code,
                            "generation" => rand(10000, 99999),
                            "targeted_type" => $target,
                            "style" => $style,
                            "Company_Type" => $target == 'M' ? 1 : 2,
                        );
                        $intable = "sv_st_fillable_surveys";
                        $q_surveyTable = "sv_st_fillable_questions";
                    }
                    //sv_st_questions
                    if ($this->db->insert($intable, $data)) {
                        $serv_id = $this->db->insert_id();
                        $last = $this->db->query("SELECT Id FROM `" . $intable . "` ORDER BY Id DESC")->result_array();
                        $number = empty($last) ? 1 : $last[0]['Id'];
                        foreach ($questions as $key => $question) {
                            $questions_arr[] = array(
                                "survey_id" => $serv_id,
                                "question_id" => $question,
                                "position" => $key,
                                "created" => date('Y-m-d'),
                                "time" => date('H:i:s'),
                            );
                        }
                        if ($this->db->insert_batch($q_surveyTable, $questions_arr)) {
                            $targetedaccounts = array();
                            foreach ($this->input->post("targetedaccounts") as $key => $targetedaccount) {
                                $targetedaccounts[] = [
                                    'account_id' => $targetedaccount,
                                    'survey_id' => $serv_id,
                                ];
                            }
                            $this->db->insert_batch('sv_st_targeted_accounts', $targetedaccounts);
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/Manage_surveys"),
                                "title" => "Survey List",
                                "description" => "Find your surveys",
                                "icon" => "uil-list-ul",
                            ];
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/questions-manage/") . $serv_id . "/" . ($this->input->post('TypeOfSurvey') ? "choices" : "fillable"),
                                "title" => "Survey Managment",
                                "description" => "questions order , change messages text , groups orders , add question or delete..",
                                "icon" => "uil-window-grid",
                            ];
                            $actions[] = [
                                "link" => base_url("EN/Dashboard/Addsurveys"),
                                "title" => "Creat Another one",
                                "description" => "Add another survey !!",
                                "icon" => "uil-plus",
                            ];
                            if ($this->input->post('TypeOfSurvey') == "with") {
                                $choices = $this->db->query("SELECT `sv_set_template_answers_choices`.`Id` as Id 
                                FROM `sv_set_template_answers` 
                                JOIN `sv_set_template_answers_choices` ON `sv_set_template_answers_choices`.`group_id` = `sv_set_template_answers`.`Id`
                                WHERE `sv_set_template_answers`.`Id` = '" . $answer_group . "' ")->result_array();
                                $marks = array();
                                $questions = $this->db->query("SELECT *,`sv_st_questions`.`Id` AS q_id
                                FROM `sv_st_questions`
                                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                                WHERE `sv_st_questions`.`survey_id` = '" . $serv_id . "' 
                                AND `sv_st_questions`.`group_id` = '0'  ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                                if (!empty($choices)) {
                                    foreach ($questions as $key => $question) {
                                        foreach ($choices as $c_mark => $choice) {
                                            $marks[] = array(
                                                "question_id" => $question['q_id'],
                                                "choice_id" => $choice['Id'],
                                                "survey_id" => $serv_id,
                                                "mark" => ($c_mark + 1)
                                            );
                                        }
                                    }
                                    $this->db->insert_batch("sv_st_answers_mark", $marks);
                                    $this->response->json([
                                        "status" => 'ok',
                                        "actions" => $actions,
                                    ]);
                                } else {
                                    $this->response->json([
                                        "status" => 'ok',
                                        "actions" => $actions,
                                    ]);
                                }
                            } else {
                                $this->response->json([
                                    "status" => 'ok',
                                    "actions" => $actions,
                                ]);
                            }
                        }
                    }
                }
            } else {
                echo "error";
            }
        }
    }

    public function startAddingSystem()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            //$this->form_validation->set_rules( 'Client_Department', 'Client Department', 'trim|required|alpha' );
            $this->form_validation->set_rules('cousntrie', 'countrie', 'trim|required|numeric');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('style_id', 'style_id', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                $style = $this->db->where("Id", $this->input->post("style_id"))->get("r_style");
                if ($style->num_rows() <= 0) {
                    echo "unsupported type";
                    die();
                }
                $style = $style->row();
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Client_type = $style->type == "C" ? "Company" : "Ministry";
                $username = $this->input->post('Username');
                $countrie = $this->input->post('cousntrie');
                $email = $this->input->post('Email');
                $style_id = "";
                $style_id = $this->input->post('style_id');
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $Client_Department = "";
                $VX = $this->input->post('VX');
                if ($VX == 1) {
                    $Client_Department = "School";
                } elseif ($VX == 2) {
                    $Client_Department = "Ministry Department";
                } else {
                    $Client_Department = "Company";
                }
                $ClientCode = (strtolower($Client_type) == "ministry" ? '1' : '2');
                $iscorrent = $this->db->query("SELECT * FROM `v_login` WHERE username = '" . $username . "' ")->result_array();
                if (empty($iscorrent)) {
                    $this->load->library('session');
                    $sessiondata = $this->session->userdata('admin_details');
                    $region = $this->db->query("SELECT * FROM `region` ORDER BY `Id` DESC")->result_array();
                    $RG = $region[0]['region'];
                    $regionId = str_pad($RG, 4, '0', STR_PAD_LEFT);
                    $s_id = str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
                    $rand = rand(1000, 9999);
                    $genrationcode = $regionId . $s_id . $rand;
                    $data = [
                        'Username' => $username,
                        'password' => $hash_pass,
                        'AR_Title' => $Arabic_Title,
                        'Type' => $Client_type,
                        'Created' => date('Y-m-d'),
                        'EN_Title' => $English_Title,
                        'Department' => $Client_Department,
                        'CountryID' => $countrie,
                        'Email' => $email,
                        'VX' => $VX,
                        'generation' => $genrationcode,
                        'Style_type_id' => $style_id,
                        'Company_Type' => $ClientCode,
                    ];
                    if ($this->db->insert('l0_organization', $data)) {
                        $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`, `Company_Type` ,`Created`,`generation`) 
                        VALUES ('" . $username . "','" . $hash_pass . "','admin' , '" . $ClientCode . "' ,'" . date('Y-m-d') . "','" . $genrationcode . "')");
                        //    $this->sendNewUserEmail($email, $password, $username); 
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'The data were inserted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#5b8ce8',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        </script>
                        <?php
                    }
                } else {
                    echo 'The user name ' . '"' . $username . '"' . ' is already exist';
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function codetest()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $region = $this->db->query("SELECT * FROM `region` ORDER BY `Id` DESC")->result_array();
        $regionId = str_pad($region[0]['region'], 4, '0', STR_PAD_LEFT);
        $s_id = str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
        $genrationcode = $regionId . $s_id;
        echo $genrationcode;
    }

    public function SendInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedpassword') && $this->input->post('getedusername')) {
            if (
                !empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedpassword'))
                && !empty($this->input->post('getedusername'))
            ) {
                $username = $this->input->post('getedusername');
                $password = $this->input->post('getedpassword');
                $email = $this->input->post('sendToEmail');
                $this->load->library('email');
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mail.track.qlickhealth.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'no_reply@track.qlickhealth.com',
                    'smtp_pass' => 'Bd}{kKW]eTfH',
                    'smtp_crypto' => 'ssl',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = '<center>
          <img src="https://qlickhealth.com/admin/assets/img/qlick-health-logo.png" >
          <h2> Hi there <h2> 
          <h3>Your User name is : ' . $username . ' </h3>
          <h3>Your password is : ' . $password . ' </h3>
          <a href="https://track.qlickhealth.com" style="width:140px;padding:10px;background:#5b73e8;border-radius:5px;display: block;color: #fff;margin: auto;text-align: center;text-decoration: navajowhite;">Go To LogIn Page !</a>
          </center>';
                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
                $this->email->to($email);
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);
                if (!$this->email->send()) {
                    echo $this->email->print_debugger();
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "The Email is Sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/Dashboard/addSystem';
          </script>
          ";
                }
            }
        }
    }

    public function SendUpdatedInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedusername')) {
            if (!empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedusername'))) {
                $username = $this->input->post('getedusername');
                $email = $this->input->post('sendToEmail');
                $this->load->library('email');
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mail.track.qlickhealth.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'no_reply@track.qlickhealth.com',
                    'smtp_pass' => 'Bd}{kKW]eTfH',
                    'smtp_crypto' => 'ssl',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = "<center>
          <img src='https://qlickhealth.com/admin/assets/img/qlick-health-logo.png' >
          <h3> Hi there <h3> 
          <h2>Your User name is Updeted To : $username <h2>
          </center>";
                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('sender@track.qlickhealth.com', 'qlickhealth');
                $this->email->to($email);
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);
                if (!$this->email->send()) {
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "the email is sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/Dashboard/UpdateSystem';
          </script>
          ";
                }
            }
        }
    }

    public function UpdateSystem()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadmins'] = $this->db->query('SELECT * FROM l0_organization ORDER BY `Id` ASC')->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/Upadate_System');
        $this->load->view('EN/inc/footer');
    }

    public function changestatus()
    {
        $id = $this->input->post('adminid');
        $adminstatus = $this->db->query("SELECT * FROM `l0_organization` WHERE  Id = '" . $id . "' LIMIT 1")->result_array();
        foreach ($adminstatus as $adminstat) {
            if ($adminstat['status'] == 1) {
                $enable = true;
                $text = 'disabled';
            } else {
                $enable = false;
                $text = 'enabled';
            }
            $name = $adminstat['Username'];
        }
        if ($enable) {
            $this->db->query("UPDATE l0_organization SET `status` = '0' WHERE Id = '" . $id . "' ");
        } else {
            $this->db->query("UPDATE l0_organization SET `status` = '1' WHERE Id = '" . $id . "' ");
        }
        echo $name . "  is now " . $text;
    }

    public function listofadmins()
    {
        $id = $this->uri->segment(3);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $adminInfos['theadminData'] = $this->db->query("SELECT * FROM l0_organization 
          WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('EN/SuperAdmin/UpadateSystemData', $adminInfos);
            $this->load->view('EN/inc/footer');
        }
    }

    public function UpdateSystemData()
    {
        $id = $this->uri->segment(4);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $data['olddata'] = $this->db->where("Id", $id)->order_by("Id", "DESC")->get("l0_organization");
            if ($data['olddata']->num_rows() <= 0) {
                echo "No data Found....";
                die();
            }
            $data['olddata'] = $data['olddata']->row();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/UpadateSystemData');
            $this->load->view('EN/inc/footer');
        }
    }

    public function UpdateSchoolData()
    {
        $id = $this->uri->segment(4);
        if (is_numeric($id)) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $adminInfos['theadminData'] = $this->db->query("SELECT * FROM l1_school 
            WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('EN/SuperAdmin/UpadateSchoolData', $adminInfos);
            $this->load->view('EN/inc/footer');
        }
    }

    public function Add_Position()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add New Position ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/gatesCreatClimateSurvey');
        $this->load->view('EN/inc/footer');
    }

    public function Add_Position_gm()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add New Position ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/add_position_gm');
        $this->load->view('EN/inc/footer');
    }

    public function add_material_study()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = "Qlick Health | Add New Position ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/add_material_study');
            $this->load->view('EN/inc/footer');
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name_en', 'English name', 'trim|required|min_length[3]|max_length[200]|is_unique[r_positions_tech.Position]');
            $this->form_validation->set_rules('name_ar', 'Arabic name', 'trim|required|min_length[3]|max_length[200]|is_unique[r_positions_tech.AR_Position]');
            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('name_ar');
                $English_Title = $this->input->post('name_en');
                $data = [
                    "AR_Position" => $Arabic_Title,
                    "Position" => $English_Title
                ];
                if ($this->db->insert("r_positions_tech", $data)) {
                    $this->response->json(["status" => "success", "message" => "added successfully...."]);
                }
            } else {
                $this->response->json(["status" => "error", "message" => validation_errors('<span>', '</span><br>')]);
            }
        }
    }

    public function startUpdatingSystem()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title') && $this->input->post('id')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            //$this->form_validation->set_rules( 'Client_Department', 'Client Department', 'trim|required|alpha' );
            $this->form_validation->set_rules('cousntrie', 'countrie', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('style_id', 'style_id', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                $style = $this->db->where("Id", $this->input->post("style_id"))->get("r_style");
                if ($style->num_rows() <= 0) {
                    echo "unsupported type";
                    die();
                }
                $style = $style->row();
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Client_type = $style->type == "C" ? "Company" : "Ministry";
                $countrie = $this->input->post('cousntrie');
                $email = $this->input->post('Email');
                $style_id = "";
                $style_id = $this->input->post('style_id');
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $Client_Department = "";
                $VX = $this->input->post('VX');
                if ($VX == 1) {
                    $Client_Department = "School";
                } elseif ($VX == 2) {
                    $Client_Department = "Ministry Department";
                } else {
                    $Client_Department = "Company";
                }
                $ClientCode = (strtolower($Client_type) == "ministry" ? '1' : '2');
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $region = $this->db->query("SELECT * FROM `region` ORDER BY `Id` DESC")->result_array();
                $RG = $region[0]['region'];
                $regionId = str_pad($RG, 4, '0', STR_PAD_LEFT);
                $s_id = str_pad($sessiondata['admin_id'], 4, '0', STR_PAD_LEFT);
                $rand = rand(1000, 9999);
                $genrationcode = $regionId . $s_id . $rand;
                $data = [
                    'password' => $hash_pass,
                    'AR_Title' => $Arabic_Title,
                    'Type' => $Client_type,
                    'Created' => date('Y-m-d'),
                    'EN_Title' => $English_Title,
                    'Department' => $Client_Department,
                    'CountryID' => $countrie,
                    'Email' => $email,
                    'VX' => $VX,
                    'generation' => $genrationcode,
                    'Style_type_id' => $style_id,
                    'Company_Type' => $ClientCode,
                ];
                if ($this->db->set($data)->where("Id", $this->input->post('id'))->update('l0_organization', $data)) { ?>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'The data were inserted successfully.',
                            icon: 'success',
                            confirmButtonColor: '#5b8ce8',
                        });
                        setTimeout(function () {
                            location.href = "<?= base_url() . "EN/Dashboard/UpdateSystem/"; ?>";
                        }, 1500);
                    </script>
                    <?php
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function addSchool()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 1) {
            $data['page_title'] = "Qlick System | Registration School ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/add_school2');
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    public function startAddingSchool()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('Clases', 'Clases', 'trim|required');
            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $username = $this->input->post('Username');
                $clases = $this->input->post('Clases');
                // Selects
                $School_Gender = $this->input->post('School_Gender');
                $city = $this->input->post('city');
                $isselected = 0;
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $My_Id = $sessiondata['admin_id'];
                if ($School_Gender == "Male" || $School_Gender == "Female" || $School_Gender == "mix") {
                    $isselected++;
                } else {
                    echo 'Please Select The Gender Of School';
                }
                if (is_numeric($city)) {
                    $isselected++;
                } else {
                    echo 'Please Select The city';
                }
                if ($isselected == 2) {
                    $iscorrent = $this->db->query("SELECT * FROM `l1_school` WHERE Username = '" . $username . "' ")->result_array();
                    if (empty($iscorrent)) {
                        if ($this->db->query("INSERT INTO `l1_school` (
          `Username`,`password`,
          `School_Name_AR`, `School_Name_EN`,
          `Created`, `Manager_EN`, `Manager_AR`,
          `Phone`,`Email`,
          `Citys`,`Gender`,`Type_Of_School`,
          `Added_By`)
          
          VALUES (
          '" . $username . "','" . $hash_pass . "',
          '" . $Arabic_Title . "','" . $English_Title . "'
          ,'" . date('Y-m-d') . "','" . $Manager_EN . "','" . $Manager_AR . "',
          '" . $Phone . "','" . $Email . "'
          ,'" . $city . "','" . $School_Gender . "',
          '" . $clases . "',$My_Id)")) {
                            echo '
               <script>
               $("#getedusername").attr("value","' . $username . '");
               $("#getedpassword").attr("value","' . $password . '");
               </script>';
                            echo "<script>$('.card .InputForm').html('');</script>";
                            echo '<script>
               $("#Toast").addClass("inserted_suc");
               </script>';
                            echo "<h3>The System is Created successfuly </h3><h5>USERNAME : " . $username . " <h5>
               <h5>PASSWORD : " . $password . " <h5>";
                            echo '
               <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal"> Send By Email </button>';
                            echo '<button type="button" onClick="back();" id="back" class="btn btn-dark waves-effect waves-light" style="margin: auto 10px;"> Back To Main Dashboard </button>';
                            echo '
               <script>
               $("#getedusername").attr("value","' . $username . '");
               $("#getedpassword").attr("value","' . $password . '");
               </script>';
                        } else {
                            $this->db->_error_message();
                        }
                    } else {
                        echo 'The user name ' . '"' . $username . '"' . ' is already exist';
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function UpdateSchool()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Update System ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l1_school WHERE Added_By = "' . $sessiondata['admin_id'] . '" ORDER BY `Id` ASC')->result_array();
        $this->load->view('EN/SuperAdmin/Upadate_School', $listofadmins);
        $this->load->view('EN/inc/footer');
    }

    public function SendSchoolInfosEmail()
    {
        $this->load->library('session');
        if ($this->input->post('sendToEmail') && $this->input->post('getedpassword') && $this->input->post('getedusername')) {
            if (
                !empty($this->input->post('sendToEmail')) && !empty($this->input->post('getedpassword'))
                && !empty($this->input->post('getedusername'))
            ) {
                $username = $this->input->post('getedusername');
                $password = $this->input->post('getedpassword');
                $email = $this->input->post('sendToEmail');
                $this->load->library('email');
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mail.track.qlickhealth.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'no_reply@track.qlickhealth.com',
                    'smtp_pass' => 'Bd}{kKW]eTfH',
                    'smtp_crypto' => 'ssl',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                //$link = base_url()."EN/Users/Updatepassword?email='".$email."'&hash='".$password."'&as='".$loged_as."'";
                $messg = "<center>
          <img src='https://qlickhealth.com/admin/assets/img/qlick-health-logo.png' >
          <h2> Hi there <h2> 
          <h3>Your User name is : $username <h3>
          <h3>Your password is : $password <h3>
          </center>";
                $this->email->initialize($config);
                $this->email->set_newline('\r\n');
                $this->email->from('sender@track.qlickhealth.com', 'track.qlickhealth.com');
                $this->email->to($email);
                $this->email->subject(' You User Name And Password ');
                $this->email->message($messg);
                if (!$this->email->send()) {
                    echo 'We have an error in sending the email . Please try again later.';
                } else {
                    echo "the email is sended";
                    $this->session->set_flashdata('email_sended', 'true');
                    echo "
          <script>
          location.href = '" . base_url() . "EN/Dashboard/addSchool';
          </script>
          ";
                }
            }
        }
    }

    public function changeSchoolstatus()
    {
        $id = $this->input->post('adminid');
        $adminstatus = $this->db->query("SELECT * FROM `l1_school` WHERE  Id = '" . $id . "' LIMIT 1")->result_array();
        foreach ($adminstatus as $adminstat) {
            if ($adminstat['status'] == 1) {
                $enable = true;
                $text = 'disabled';
            } else {
                $enable = false;
                $text = 'enabled';
            }
            $name = $adminstat['Username'];
        }
        if ($enable) {
            $this->db->query("UPDATE l1_school SET `status` = '0' WHERE Id = '" . $id . "' ");
        } else {
            $this->db->query("UPDATE l1_school SET `status` = '1' WHERE Id = '" . $id . "' ");
        }
        echo $name . "  is now " . $text;
    }

    public function startAddNewPosition()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('userposition') && $this->input->post('code')) {
            $this->form_validation->set_rules('userposition', 'User Position', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('position_ar', 'User Position AR', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('code', 'Code', 'trim|required|exact_length[9]');
            if ($this->form_validation->run()) {
                $position = $this->input->post('userposition');
                $code = $this->input->post('code');
                $corrent = $this->db->query("SELECT * FROM  `r_positions` WHERE `Position` = '" . $position . "' 
			    OR `Code` = '" . $code . "' ")->result_array();
                if (empty($corrent)) {
                    $data = [
                        "Position" => $position,
                        "Code" => $code,
                        "Created" => date("Y-m-d"),
                        "Added_By" => $sessiondata['admin_id'],
                        "AR_Position" => $this->input->post("position_ar"),
                    ];
                    if ($this->db->insert("r_positions", $data)) {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'The data was inserted. Successfuly !!',
                                icon: 'success'
                            });
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Error !!',
                                text: 'Sorry, there is an error. Please try again later.',
                                icon: 'error'
                            });
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'Error !!',
                            text: 'This Position "<?php echo $position; ?>" Alredy Exist !!',
                            icon: 'error'
                        });
                    </script>
                    <?php
                }
            } else { ?>
                <script>
                    Swal.fire({
                        title: 'warning !!',
                        text: 'You have entered incorrect data. Kindly check it and try again.',
                        icon: 'warning'
                    });
                </script>
            <?php }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'Sorry.',
                    text: 'Please Enter Some Data ): ',
                    icon: 'error'
                });
            </script>
            <?php
        }
    }

    public function startAddNewPosition_gm()
    {
        $this->load->library('form_validation');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('userposition') && $this->input->post('code')) {
            $this->form_validation->set_rules('userposition', 'User Position', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('UserType_ar', 'User Position AR', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('code', 'Code', 'trim|required|exact_length[9]');
            if ($this->form_validation->run()) {
                $position = $this->input->post('userposition');
                $code = $this->input->post('code');
                $corrent = $this->db->query("SELECT * FROM  `r_positions_gm` WHERE `Position` = '" . $position . "' 
			    OR `Code` = '" . $code . "' ")->result_array();
                if (empty($corrent)) {
                    $data = [
                        "Position" => $position,
                        "Code" => $code,
                        "Created" => date("Y-m-d"),
                        "Added_By" => $sessiondata['admin_id'],
                        "AR_Position" => $this->input->post("UserType_ar"),
                    ];
                    if ($this->db->insert("r_positions_gm", $data)) {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'The data was inserted. Successfuly !!',
                                icon: 'success'
                            });
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Error !!',
                                text: 'Sorry, there is an error. Please try again later.',
                                icon: 'error'
                            });
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'Error !!',
                            text: 'This Position "<?php echo $position; ?>" Alredy Exist !!',
                            icon: 'error'
                        });
                    </script>
                    <?php
                }
            } else { ?>
                <script>
                    Swal.fire({
                        title: 'warning !!',
                        text: 'You have entered incorrect data. Kindly check it and try again.',
                        icon: 'warning'
                    });
                </script>
            <?php }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'Sorry.',
                    text: 'Please Enter Some Data ): ',
                    icon: 'error'
                });
            </script>
            <?php
        }
    }

    public function startUpdatingSchool()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Name In Arabic', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager Name In English', 'trim|required');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $id = $this->input->post('ID');
            if ($this->form_validation->run()) {
                if (is_numeric($id)) {
                    $Arabic_Title = $this->input->post('Arabic_Title');
                    $English_Title = $this->input->post('English_Title');
                    $Manager_AR = $this->input->post('Manager_AR');
                    $Manager_EN = $this->input->post('Manager_EN');
                    $Phone = $this->input->post('Phone');
                    $Email = $this->input->post('Email');
                    $username = $this->input->post('Username');
                    $iscorrent = $this->db->query("SELECT *
          FROM `l0_organization` WHERE username = '" . $username . "' AND Id != '" . $id . "' ")->result_array();
                    if (empty($iscorrent)) {
                        if ($this->db->query("UPDATE l1_school
          SET School_Name_AR = '" . $Arabic_Title . "', School_Name_AR = '" . $English_Title . "', 
          Manager_EN = '" . $Manager_EN . "', Manager_AR = '" . $Manager_AR . "' , Email = '" . $Email . "', Phone = '" . $Phone . "' 
          WHERE id = '" . $id . "' ")) {
                            echo "<script>$('.card form').html('');</script>";
                            echo '<script>
          $("#Toast").addClass("inserted_suc");
          </script>';
                            echo '<script>
          $("#Toast").css("background","#0eacd8");
          $("#Toast").css("margin-bottom","0px");
          </script>';
                            echo "<h3>The data is updated. successfuly </h3><h5>USERNAME : " . $username . " <h5>";
                            echo '<button _ngcontent-gvm-c151="" mat-raised-button="" color="primary" class="mat-focus-indicator mr-3 mat-raised-button mat-button-base mat-primary" onclick="sendbyemail()" id="sendbyemail">
     <span class="mat-button-wrapper">Send It By Email</span>
     <span matripple="" class="mat-ripple mat-button-ripple"></span>
     <span class="mat-button-focus-overlay"></span>
     </button>';
                            echo '<button _ngcontent-gvm-c151="" mat-raised-button="" color="primary" class="mat-focus-indicator mr-3 mat-raised-button mat-button-base mat-primary" onclick="back()" id="sendbyemail">
     <span class="mat-button-wrapper"> Back To Schools List </span>
     <span matripple="" class="mat-ripple mat-button-ripple"></span>
     <span class="mat-button-focus-overlay"></span>
     </button>';
                            echo '
               <script>
               $("#getedusername").attr("value","' . $username . '");
               </script>';
                        }
                    } else {
                        echo 'This User Name Is Already Used';
                    }
                } else {
                    echo "<script>
                    location.reload();
                    </script>";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function AddNewTest()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |  Add New Test ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/AddTest');
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    public function StartAddNewTest()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('TestCode', 'Test Code', 'trim|required');
            // The Units
            $UnitType = $this->input->post('UnitType');
            if ($UnitType == 1) {
                $this->form_validation->set_rules('Min', 'Min', 'trim|numeric|required');
                $this->form_validation->set_rules('Max', 'Max', 'trim|numeric|required');
            } else {
                $this->form_validation->set_rules('Positive', 'Max Unit', 'trim|required|required');
                $this->form_validation->set_rules('Negative', 'Max Unit', 'trim|required|required');
            }
            // type 1     
            $this->form_validation->set_rules('MinUnit', 'Min Unit', 'trim');
            $this->form_validation->set_rules('MaxUnit', 'Max Unit', 'trim');
            // type 2     
            $this->form_validation->set_rules('UnitePositive', 'Unite Positive', 'trim');
            $this->form_validation->set_rules('UniteNegative', 'Unite Negative', 'trim');
            if ($this->form_validation->run()) {
                $MinUnit = $this->input->post('MinUnit');
                $MaxUnit = $this->input->post('MaxUnit');
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $TestCode = $this->input->post('TestCode');
                $UnitePositive = $this->input->post('UnitePositive');
                $UniteNegative = $this->input->post('UniteNegative');
                $iscorrentCode = $this->db->query("SELECT * FROM l0_tests WHERE TestCode ='" . $TestCode . "'")->result_array();
                if (empty($iscorrentCode)) {
                    if ($UnitType == 1) {
                        $Min = $this->input->post('Min');
                        $Max = $this->input->post('Max');
                        if ($this->input->post('MaxUnit')) {
                            $MaxUnit = $this->input->post('MaxUnit');
                        } else {
                            $MaxUnit = '';
                        }
                        if ($this->input->post('MinUnit')) {
                            $MinUnit = $this->input->post('MinUnit');
                        } else {
                            $MinUnit = '';
                        }
                        if ($this->db->query("INSERT INTO `l0_tests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES
           ('" . $Arabic_Title . "', '" . $English_Title . "', '" . $TestCode . "', 
           '" . $Min . "', '" . $Max . "','" . date('Y-m-d') . "', '" . $MaxUnit . "', '" . $MinUnit . "', '1'); ")) {
                            $sended = true;
                        }
                    } else {
                        $Positive = $this->input->post('Positive');
                        $Negative = $this->input->post('Negative');
                        if ($this->input->post('UnitePositive')) {
                            $UnitePositive = $this->input->post('UnitePositive');
                        } else {
                            $UnitePositive = '';
                        }
                        if ($this->input->post('UniteNegative')) {
                            $UniteNegative = $this->input->post('UniteNegative');
                        } else {
                            $UniteNegative = '';
                        }
                        if ($this->db->query("INSERT INTO `l0_tests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES ('" . $Arabic_Title . "', '" . $English_Title . "', '" . $TestCode . "', 
           '" . $Negative . "', '" . $Positive . "','" . date('Y-m-d') . "', '" . $UnitePositive . "', '" . $UniteNegative . "', '0'); ")) {
                            $sended = true;
                        }
                    }
                    if ($sended) {
                        echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b8ce8',
        cancelButtonColor: '#f46a6a'
          });
        </script>   
          ";
                        /* echo "   
        <script>   
    $('#sa-warning').click(function () {
      Swal.fire({
        title:'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b73e8',
        cancelButtonColor: '#21307A' ,
        confirmButtonText: 'Add New One'
        cancelButtonText: 'Back To Dashboard'
      }).then(function (result) {
        if (result.value) {
        Location.reload();
        }else{ 
        location.href =  '".base_url()."EN/Dashboard'
 
         }
          }
          )}; //Parameter
       
 
        </script>   
          ";*/
                    }
                } else {
                    echo "This Test is Already Added";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function TestsList()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |  Add New Test ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l0_tests ORDER BY `Id` DESC ')->result_array();
            $this->load->view('EN/inc/header');
            $this->load->view('EN/TestsList', $listofadmins);
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    public function ConnectedTests()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick System |   Manage Connecting  ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $listofadmins['listofadmins'] = $this->db->query('SELECT * FROM l0_systemtwithtest
          ORDER BY `Id` DESC ')->result_array();
            $this->load->view('EN/inc/header');
            $this->load->view('EN/SuperAdmin/ConnectedTests', $listofadmins);
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    public function UpdateTestData()
    {
        $this->load->library('session');
        $id = $this->uri->segment(3);
        $sessiondata = $this->session->userdata('admin_details');
        if (is_numeric($id) && $sessiondata['level'] == 0) {
            $data['page_title'] = "Qlick Health | Update System ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $adminInfos['TestData'] = $this->db->query("SELECT * FROM l0_tests 
          WHERE id = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            $this->load->view('EN/SuperAdmin/UpdateTestData', $adminInfos);
            $this->load->view('EN/inc/footer');
        } else {
            redirect('users');
        }
    }

    public function StartUpdateTestData()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('TestCode', 'Test Code', 'trim|required');
            // The Units
            $UnitType = $this->input->post('UnitType');
            if ($UnitType == 1) {
                $this->form_validation->set_rules('Min', 'Min', 'trim|numeric|required');
                $this->form_validation->set_rules('Max', 'Max', 'trim|numeric|required');
            } else {
                $this->form_validation->set_rules('Positive', 'Max Unit', 'trim|required|required');
                $this->form_validation->set_rules('Negative', 'Max Unit', 'trim|required|required');
            }
            // type 1     
            $this->form_validation->set_rules('MinUnit', 'Min Unit', 'trim');
            $this->form_validation->set_rules('MaxUnit', 'Max Unit', 'trim');
            // type 2     
            $this->form_validation->set_rules('UnitePositive', 'Unite Positive', 'trim');
            $this->form_validation->set_rules('UniteNegative', 'Unite Negative', 'trim');
            if ($this->form_validation->run()) {
                $MinUnit = $this->input->post('MinUnit');
                $MaxUnit = $this->input->post('MaxUnit');
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $TestCode = $this->input->post('TestCode');
                $id = $this->input->post('ID');
                $UnitePositive = $this->input->post('UnitePositive');
                $UniteNegative = $this->input->post('UniteNegative');
                $iscorrentCode = $this->db->query("SELECT * FROM l0_tests WHERE TestCode ='" . $TestCode . "' AND Id != '" . $id . "' ")->result_array();
                if (empty($iscorrentCode)) {
                    if ($UnitType == 1) {
                        $Min = $this->input->post('Min');
                        $Max = $this->input->post('Max');
                        if ($this->input->post('MaxUnit')) {
                            $MaxUnit = $this->input->post('MaxUnit');
                        } else {
                            $MaxUnit = '';
                        }
                        if ($this->input->post('MinUnit')) {
                            $MinUnit = $this->input->post('MinUnit');
                        } else {
                            $MinUnit = '';
                        }
                        /* if($this->db->query("INSERT INTO `tbltests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES
           ('".$Arabic_Title."', '".$English_Title."', '".$TestCode."', 
           '".$Min."', '".$Max."','".date('Y-m-d')."', '".$MaxUnit."', '".$MinUnit."', '1'); ")){ */
                        if ($this->db->query(" UPDATE `l0_tests` SET TestName_AR = '" . $Arabic_Title . "' ,
     TestName_EN = '" . $English_Title . "', TestCode = '" . $TestCode . "' , TestMin = '" . $Min . "', TestMax = '" . $Max . "', 
     Created = '" . date('Y-m-d') . "' ,MaxUnit = '" . $MaxUnit . "', MinUnit = '" . $MinUnit . "' ,Ch= '1'  WHERE Id = '" . $id . "' ")) {
                            $sended = true;
                        }
                    } else {
                        $Positive = $this->input->post('Positive');
                        $Negative = $this->input->post('Negative');
                        if ($this->input->post('UnitePositive')) {
                            $UnitePositive = $this->input->post('UnitePositive');
                        } else {
                            $UnitePositive = '';
                        }
                        if ($this->input->post('UniteNegative')) {
                            $UniteNegative = $this->input->post('UniteNegative');
                        } else {
                            $UniteNegative = '';
                        }
                        /*if($this->db->query("INSERT INTO `tbltests` (`TestName_AR`, `TestName_EN`, `TestCode`,
           `TestMin`, `TestMax`, `Created`, `MaxUnit`, `MinUnit`, `Ch`) VALUES ('".$Arabic_Title."', '".$English_Title."', '".$TestCode."', 
           '".$Negative."', '".$Positive."','".date('Y-m-d')."', '".$UnitePositive."', '".$UniteNegative."', '0'); ")){*/
                        if ($this->db->query(" UPDATE `l0_tests` SET TestName_AR = '" . $Arabic_Title . "' ,
     TestName_EN = '" . $English_Title . "', TestCode = '" . $TestCode . "' , TestMin = '" . $Negative . "', TestMax = '" . $Positive . "', 
     Created = '" . date('Y-m-d') . "' ,MaxUnit = '" . $UnitePositive . "', MinUnit = '" . $UniteNegative . "', Ch= '0' WHERE Id = '" . $id . "' ")) {
                            $sended = true;
                        }
                    }
                    if ($sended) {
                        echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b8ce8',
        cancelButtonColor: '#f46a6a'
          });
        </script>   
          ";
                        /* echo "   
        <script>   
    $('#sa-warning').click(function () {
      Swal.fire({
        title:'Success',
        text: 'The Data Is Inserted.',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#5b73e8',
        cancelButtonColor: '#21307A' ,
        confirmButtonText: 'Add New One'
        cancelButtonText: 'Back To Dashboard'
      }).then(function (result) {
        if (result.value) {
        Location.reload();
        }else{ 
        location.href =  '".base_url()."EN/Dashboard'
 
         }
          }
          )}; //Parameter
       
 
        </script>   
          ";*/
                    } else {
                        echo "error";
                    }
                } else {
                    echo "This Test is Already Added";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function StartLink()
    {
        $this->load->library('form_validation');
        if ($this->input->post('System') && $this->input->post('Test')) {
            $this->form_validation->set_rules('System', 'System', 'trim|required');
            $this->form_validation->set_rules('Test', 'Test', 'trim|required');
            if ($this->form_validation->run()) {
                $system = $this->input->post('System');
                $Test = $this->input->post('Test');
                if (is_numeric($system) && is_numeric($Test)) {
                    $isexist = $this->db->query("SELECT * FROM l0_systemtwithtest WHERE SystemId = '" . $system . "' AND TestId = '" . $Test . "' ")->num_rows();
                    if ($isexist == 0) {
                        if ($this->db->query("INSERT INTO `l0_systemtwithtest` (`SystemId`, `TestId` ,`Created`)
       VALUES ('" . $system . "', '" . $Test . "','" . date('Y-m-d') . "');")) {
                            echo "The Test Was Added";
                            echo "   
        <script>   
        Swal.fire({
        title: 'Success',
        text: 'The Test Was Added !',
        icon: 'success',
        confirmButtonColor: '#5b8ce8',
          });
        </script>   
          ";
                        } else {
                            echo "oops!! We Have A Error ";
                        }
                    } else {
                        echo "   
        <script>   
        Swal.fire({
        title: 'error',
        text: 'The Test Already Added !',
        icon: 'error',
        confirmButtonColor: '#5b8ce8',
          });
        </script>   
          ";
                    }
                } else {
                    echo "You Have a Error In The data $Test";
                }
            } else {
                echo "Oops We Have a Error";
            }
        } else {
            echo
            '<script>
          location.reload();
          </script>';
        }
    }

    public function getTests()
    {
        $id = $this->input->post('id');
        $tests = $this->db->query("SELECT * FROM  l0_tests ")->result_array();
        $corent = $this->db->query("SELECT * FROM l0_systemtwithtest WHERE 
          SystemId = '" . $id . "' AND Test ")->result_array();
        $options = 0;
        echo '<Select Class="custom-select" name="Test">';
        if (empty($corent)) {
            foreach ($corent as $ses) {
                $idTest = $ses['TestId'];
                foreach ($tests as $data) {
                    $getcode = $this->db->query("SELECT * FROM r_testcode
                              WHERE Id = '" . $data['TestCode'] . "' LIMIT 1 ")->result_array();
                    foreach ($getcode as $code) {
                        echo '<option value="' . $idTest . '" class="option" >' . $code['CPT_Code'] . '</option>';
                    }
                    $options++;
                }
            }
        }
        if ($options <= 0) {
            echo '<option value="no Data Found" class="option" >No Data Found</option>';
        }
        echo '</select>';
    }

    public function startAddNewSet()
    {
        $this->load->library('form_validation');
        if ($this->input->post('en_title') && $this->input->post('ar_title')) {
            $this->form_validation->set_rules('en_title', 'En title', 'trim|required');
            $this->form_validation->set_rules('ar_title', 'Ar Title', 'trim|required');
            if ($this->form_validation->run()) {
                $en_title = $this->input->post("en_title");
                $ar_title = $this->input->post("ar_title");
                $count = $this->db->query("SELECT id FROM `sv_sets` ")->num_rows();
                $code = "Survey-Titles-" . ((100 + $count) + 1);
                $data = array(
                    "title_en" => $en_title,
                    "title_ar" => $ar_title,
                    "created" => date('Y-m-d'),
                    "time" => date('H:i:s'),
                    "code" => $code,
                    "generation" => rand(10000, 99999),
                );
                if ($this->db->insert('sv_sets', $data)) {
                    ?>
                    <script>
                        location.reload();
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="uil uil-check mr-2"></i>
                        sorry we have error right now !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="uil uil-exclamation-octagon mr-2"></i>
                    <?php echo validation_errors(); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="uil uil-exclamation-octagon mr-2"></i>
                Please enter some data
            </div>
            <?php
        }
    }

    public function startAddNewchoice()
    {
        $this->load->library('form_validation');
        if ($this->input->post('en_title') && $this->input->post('ar_title')) {
            $this->form_validation->set_rules('en_title', 'En title', 'trim|required');
            $this->form_validation->set_rules('ar_title', 'Ar Title', 'trim|required');
            if ($this->form_validation->run()) {
                $en_title = $this->input->post("en_title");
                $ar_title = $this->input->post("ar_title");
                $count = $this->db->query("SELECT id FROM `sv_sets` ")->num_rows();
                $code = "Survey-Titles-" . ((100 + $count) + 1);
                $data = array(
                    "title_en" => $en_title,
                    "title_ar" => $ar_title,
                    "code" => $code,
                    "generation" => rand(10000, 99999),
                );
                if ($this->db->insert('sv_choices_libaray', $data)) {
                    ?>
                    <script>
                        location.reload();
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="uil uil-check mr-2"></i>
                        sorry we have error right now !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="uil uil-exclamation-octagon mr-2"></i>
                    <?php echo validation_errors(); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="uil uil-exclamation-octagon mr-2"></i>
                Please enter some data
            </div>
            <?php
        }
    }

    public function startAddNewquestion()
    {
        $this->load->library('form_validation');
        if ($this->input->post('en_title') && $this->input->post('ar_title')) {
            $this->form_validation->set_rules('en_title', 'En title', 'trim|required');
            $this->form_validation->set_rules('ar_title', 'Ar Title', 'trim|required');
            $this->form_validation->set_rules('Desc_En', 'Desc in EN', 'trim|required');
            //$this->form_validation->set_rules( 'Desc_Ar', 'Desc in AR', 'trim|required' );
            if ($this->form_validation->run()) {
                $en_title = $this->input->post("en_title");
                $ar_title = $this->input->post("ar_title");
                $Desc_En = $this->input->post("Desc_En");
                //$Desc_Ar  = $this->input->post("Desc_Ar");
                $count = $this->db->query("SELECT Id FROM `sv_questions_library` ORDER BY id DESC LIMIT 1")->result_array();
                if (!empty($count)) {
                    $f_count = $count[0]['Id'];
                    settype($f_count, 'integer');
                    $handr = 100 + $f_count;
                    $code = "Question-" . ($handr + 1);
                } else {
                    $code = "Question-101";
                }
                $data = array(
                    "en_title" => $en_title,
                    "ar_title" => $ar_title,
                    //"ar_desc"   =>   $Desc_Ar  , 
                    "en_desc" => $Desc_En,
                    "created" => date('Y-m-d'),
                    "time" => date('H:i:s'),
                    "code" => $code,
                    "generation" => rand(10000, 99999),
                );
                if ($this->db->insert('sv_questions_library', $data)) {
                    ?>
                    <script>
                        location.reload();
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="uil uil-check mr-2"></i>
                        sorry we have error right now !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="uil uil-exclamation-octagon mr-2"></i>
                    <?php echo validation_errors(); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="uil uil-exclamation-octagon mr-2"></i>
                Please enter some data
            </div>
            <?php
        }
    }

    public function DeletConnect()
    {
        $id = $this->input->post('Conid');
        if ($this->db->query(" DELETE FROM l0_systemtwithtest WHERE Id = '" . $id . "'  ")) {
            echo "The Connect Deleted";
        } else {
            echo "oops We have A error Please Try Again Later";
        }
    }

    public function DeletTest()
    {
        $id = $this->input->post('ID');
        if ($this->db->query(" DELETE FROM l0_tests WHERE Id = '" . $id . "'  ")) {
            echo "The Test Was Deleted";
        }
    }

    public function permissions()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $User_id = $this->uri->segment(4);
            $data['page_title'] = "Qlick Health | Update System ";
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['User_id'] = $User_id;
            $this->load->view('EN/inc/header', $data);
            $data['user_data'] = $this->db->query(" SELECT l0_organization.* , v0_permissions.*,
            IFNULL(l2_avatars.Link,'default_avatar.jpg')  AS Link 
            FROM `l0_organization`
            LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l0_organization`.`Id` 
            AND `l2_avatars`.`Type_Of_User` = `l0_organization`.`Type`
            LEFT JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`Id`
            WHERE `l0_organization`.`Id` = '" . $User_id . "' 
            ORDER BY `l0_organization`.`Id` DESC LIMIT 1")->result_array();
            $this->load->view('EN/SuperAdmin/permissions', $data);
            $this->load->view('EN/inc/footer');
        }
    }

    public function Permissions_edite()
    {
        if ($this->input->post('permType') && $this->input->post('User')) {
            $permType = $this->input->post('permType');
            $User = $this->input->post('User');
            $user_type = $this->input->post('user_type');
            $today = date("Y-m-d");
            $time = date("h:i:s");
            $is_in_permissions = $this->db->query("SELECT `Id`,`$permType` FROM `v0_permissions`
			WHERE `user_id` = '" . $User . "' AND `user_type` = '" . $user_type . "' LIMIT 1 ")->result_array();
            if (!empty($is_in_permissions)) {
                $perm_id = $is_in_permissions[0]['Id'];
                $perm_status = $is_in_permissions[0]["$permType"];
                if ($perm_status == 0) {
                    $new_status = 1;
                } else {
                    $new_status = 0;
                }
                $this->db->query(" UPDATE `v0_permissions`
				SET `$permType` = '" . $new_status . "',
				`Created` = '" . $today . "' , `Time` = '" . $time . "'
				WHERE `Id` = '" . $perm_id . "' ");
                if ($new_status == 0) {
                    echo "This permission is now disabled for this organization";
                } else {
                    echo "This permission is now enabled for this organization";
                }
            } else {
                $this->db->query("INSERT INTO `v0_permissions`
				( `user_id`, `user_type`, `$permType`, `Company_Type` , `Created`, `Time` ) 
				VALUES ('" . $User . "','" . $user_type . "' , '" . ($user_type == "Ministry" ? 1 : 2) . "' ,'1','" . $today . "','" . $time . "')");
                echo "This permission is now enabled for this user";
            }
        }
    }

    public function question()
    {
        //print_r($this->input->post());
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            $rand = $this->input->post("rand");
            if ($for == "new") {
                $forset = $this->input->post("for_set");
                if ($this->db->query("INSERT INTO `sv_set_groups`
				( `set_id`, `title_en`, `title_ar`, `place`, `code`, `generation`)
				VALUES 
				('" . $forset . "','No Title','بدون عنوان','1','" . $rand . "','" . time() . "')")) {
                    $lastadded = $this->db->query("SELECT Id FROM `sv_set_questions`  ORDER BY Id DESC LIMIT 1")->result_array();
                    $respons = array('Type' => "new", 'status' => "ok", "Id" => $lastadded[0]['Id']);
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update_Title") {
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $id = $this->input->post("id");
                $this->db->query("UPDATE `sv_set_questions` SET `title_en` = '" . $title_en . "' , `title_ar` = '" . $title_ar . "' 
				WHERE Id = '" . $id . "' ");
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_questions` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "All_questions") {
                $respons = array();
                $id = $this->input->post("set_id");
                $questions = $this->db->query("SELECT `sv_set_questions`.`title_en` AS Title ,
				`sv_set_questions`.`Id` 
				FROM `sv_set_questions`
				WHERE `sv_set_questions`.`set_id` = '" . $id . "' ")->result_array();
                //print_r($questions);
                $count = 1;
                foreach ($questions as $question) {
                    $h1id = $count++;
                    $rand_id = rand(1000, 9999);
                    $realId = $question['Id'];
                    $newquestion = "";
                    $newquestion .= '<div class="col-lg-6 section_question Ready" Key="' . $rand_id . '" realKey="' . $realId . '"> ';
                    $newquestion .= '<h3 contenteditable="true" id="Title' . $h1id . '">' . $question['Title'] . '</h3>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light choiceBtn"><i class="uil uil-plus"></i></button>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light delete"><i class="uil uil-trash"></i></button>';
                    $newquestion .= '<hr>';
                    ///// sv_set_choices
                    $choices = $this->db->query("SELECT * FROM `sv_set_choices` 
					WHERE question_id = '" . $question['Id'] . "'")->result_array();
                    $newquestion .= '<div class="choices">';
                    if (!empty($choices)) {
                        $h = 0;
                        foreach ($choices as $choice) {
                            $h++;
                            //"choice" + i + "_" + h
                            $newquestion .= '<div class="custom-control custom-radio mb-3">';
                            $newquestion .= '<input type="radio" id="choiceLa_' . $h1id . '_' . $h . '" name="choice' . $realId . '" class="custom-control-input" >';
                            $newquestion .= '<label class="custom-control-label" for="choiceLa_' . $h1id . '_' . $h . '" id="choice_' . $h1id . '_' . $h . '" contenteditable="true" realKey="' . $choice['Id'] . '">' . $choice['title_en'];
                            $newquestion .= '</label>';
                            $newquestion .= '<button class="addchoices waves-effect waves-light delete_choise"  choice_index="' . $h . '" realkey="' . $choice['Id'] . '"><i class="uil uil-trash"></i></button></div>';
                        }
                    } else {
                        $newquestion .= '<h3>No choices Yet !</h3>';
                    }
                    $newquestion .= '</div>';
                    $respons[] = array('Key' => $rand_id, 'html' => $newquestion, "choices" => $choices);
                }
                //header("Content-Type: application/json; charset=UTF-8");
                echo json_encode($respons);
            }
        }
    }

    public function template_answers()
    {
        //print_r($this->input->post());
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            $rand = $this->input->post("rand");
            $title_en = $this->input->post("title_en");
            $title_ar = $this->input->post("title_ar");
            if ($for == "new") {
                $data = array(
                    "title_en" => $title_en,
                    "title_ar" => $title_ar,
                );
                if ($this->db->insert("sv_set_template_answers", $data)) {
                    $lastadded = $this->db->query("SELECT Id FROM `sv_set_template_answers`  ORDER BY Id DESC LIMIT 1")->result_array();
                    $respons = array('Type' => "new", 'status' => "ok", "Id" => $lastadded[0]['Id']);
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update_Title") {
                $title = $this->input->post("title");
                $language = $this->input->post("language");
                $id = $this->input->post("id");
                if ($language == "en") {
                    $this->db->set('title_en', $title);
                } else {
                    $this->db->set('title_ar', $title);
                }
                $this->db->where('Id', $id);
                $this->db->update('sv_set_template_answers');
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_template_answers` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "All_questions") {
                $respons = array();
                $questions = $this->db->query("SELECT `sv_set_template_answers`.`title_en` AS Title ,
				`sv_set_template_answers`.`Id` 
				FROM `sv_set_template_answers`")->result_array();
                //print_r($questions);
                $count = 1;
                foreach ($questions as $question) {
                    $h1id = $count++;
                    $rand_id = rand(1000, 9999);
                    $realId = $question['Id'];
                    $newquestion = "";
                    $newquestion .= '<div class="col-lg-6 section_question Ready" Key="' . $rand_id . '" realKey="' . $realId . '"> ';
                    $newquestion .= '<h3 contenteditable="true" id="Title' . $h1id . '">' . $question['Title'] . '</h3>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light choiceBtn"><i class="uil uil-plus"></i></button>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light delete"><i class="uil uil-trash"></i></button>';
                    $newquestion .= '<hr>';
                    ///// sv_set_choices
                    $choices = $this->db->query("SELECT * FROM `sv_set_template_answers_choices` 
					WHERE group_id = '" . $question['Id'] . "'")->result_array();
                    $newquestion .= '<div class="choices">';
                    if (!empty($choices)) {
                        $h = 0;
                        foreach ($choices as $choice) {
                            $h++;
                            //"choice" + i + "_" + h
                            $newquestion .= '<div class="custom-control custom-radio mb-3">';
                            $newquestion .= '<input type="radio" id="choiceLa_' . $h1id . '_' . $h . '" name="choice' . $realId . '" class="custom-control-input" >';
                            $newquestion .= '<label class="custom-control-label" for="choiceLa_' . $h1id . '_' . $h . '" id="choice_' . $h1id . '_' . $h . '" contenteditable="true" realKey="' . $choice['Id'] . '">' . $choice['title_en'];
                            $newquestion .= '</label>';
                            $newquestion .= '<button class="addchoices waves-effect waves-light delete_choise"  choice_index="' . $h . '" realkey="' . $choice['Id'] . '"><i class="uil uil-trash"></i></button></div>';
                        }
                    } else {
                        $newquestion .= '<h3>No choices Yet !</h3>';
                    }
                    $newquestion .= '</div>';
                    $respons[] = array('Key' => $rand_id, 'html' => $newquestion, "choices" => $choices);
                }
                //header("Content-Type: application/json; charset=UTF-8");
                echo json_encode($respons);
            }
        }
    }

    public function addChoice()
    {
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            $rand = $this->input->post("rand");
            if ($for == "new") {
                $q_id = $this->input->post("q_id");
                if ($this->db->query("INSERT INTO 
				`sv_set_choices`(`question_id`, `title_en`, `title_ar`, `code`) 
				VALUES ('" . $q_id . "','Not defined','غير معرف','" . time() . "')")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update") {
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $id = $this->input->post("id");
                $this->db->query("UPDATE `sv_set_choices`
				SET`title_en`= '" . $title_en . "' ,`title_ar`= '" . $title_ar . "' WHERE Id = '" . $id . "'");
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_choices` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            }
        }
    }

    public function addChoice_library()
    {
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            if ($for == "new") {
                $q_id = $this->input->post("q_id");
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $data = [
                    "group_id" => $q_id,
                    "title_en" => $title_en,
                    "title_ar" => $title_ar,
                ];
                if ($this->db->insert('sv_set_template_answers_choices', $data)) {
                    $respons = array('Type' => "add", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update") {
                $title = $this->input->post("title");
                $language = $this->input->post("language");
                $id = $this->input->post("id");
                if ($language == "en") {
                    $this->db->set('title_en', $title);
                } else {
                    $this->db->set('title_ar', $title);
                }
                $this->db->where('Id', $id);
                $this->db->update('sv_set_template_answers_choices');
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_template_answers_choices` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            }
        }
    }

    public function Gallery_manage()
    {
        $this->load->helper('directory');
        $data['gallery_files'] = directory_map('./assets/images/gallery');
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Gallery manage";
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/Gallery_manage', $data);
        $this->load->view('EN/inc/footer');
    }

    public function deleteGalleryFile()
    {
        $status = "error";
        if ($this->input->post("filename")) {
            $filename = './assets/images/gallery/' . $this->input->post("filename");
            $this->load->helper('file');
            if (unlink($filename)) {
                $status = "ok";
            } else {
                echo $filename;
            }
        }
        echo $status;
    }

    public function GalleryfileUpload()
    {
        if (!empty($_FILES['file']['name'])) {
            // Set preference
            $config['upload_path'] = './assets/images/gallery/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '1024'; // max_size in kb
            $config['file_name'] = md5(time()) . ".png";
            //Load upload library
            $this->load->library('upload', $config);
            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
            }
        }
    }

    public function categorys_reports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | survey report ";
        $data['categorys'] = $this->db->query("SELECT * ,
        ( SELECT COUNT(`sv_st_surveys`.`Id`) FROM `sv_st_surveys` WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` ) AS counter_of_using ,
        ( SELECT COUNT(`sv_school_published_surveys`.`Id`)
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`  
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = `sv_st_category`.`Id`
        GROUP BY `sv_school_published_surveys`.`Id` LIMIT 1 ) AS counter_of_publish
        FROM `sv_st_category` ORDER BY Id ASC")->result_array();
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/survey_report', $data);
        $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
    } //category

    public function return_surveys_of_category()
    {
        $respons = array("status" => "error", "cat" => "", "data" => []);
        if ($this->input->post('cat_id') && is_numeric($this->input->post('cat_id'))) {
            $id = $this->input->post('cat_id');
            $data = $this->db->query("SELECT
            `sv_st1_surveys`.`TimeStamp` AS creating_date ,
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
            (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter ,
            (SELECT COUNT(Id) FROM `sv_school_published_surveys` WHERE `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` ) AS counter_of_publish
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            WHERE `sv_st_surveys`.`category` = '" . $id . "'
            GROUP BY `sv_st1_surveys`.`Id`")->result_array();
            $respons = array("status" => "ok", "cat" => $data[0]['Cat_en'] ?? "No data Found", "data" => $data);
        }
        echo json_encode($respons);
    }

    public function Upload_Category_resources()
    {
        // upload function 
        if (!empty($_FILES['file']['name'])) {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => []);
            if ($this->input->post("ca_t_id") && $this->input->post("file_type") && $this->input->post("language") && in_array($this->input->post("language"), ["AR", "EN"])) {
                $file_type = $this->input->post("file_type");
                $language = $this->input->post("language");
                if ($file_type == "1") {
                    $folderlik = './uploads/Category_resources/' . $language . "/";
                } elseif ($file_type == "2") {
                    $folderlik = './uploads/Reports_resources/' . $language . "/";
                }
                $config['upload_path'] = $folderlik;
                $config['allowed_types'] = 'gif|jpg|png|pdf|psd|mp4|mp3|html|pptx|ppt|7z|zip|doc|docx|csv|XLK|3gp|avi|m4v|mpeg'; // accepted types
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                // respons array
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    $respons['messages'] = $error;
                    $respons['error'] = "we can't upload the file now , please try later";
                    http_response_code(500);
                } else {
                    $data = $this->upload->data();
                    $cat_id = $this->input->post('ca_t_id');
                    $data = [
                        "file_type" => $file_type,
                        "file_url" => $data['file_name'],
                        "file_language" => $language,
                        "category_id" => $cat_id,
                        "AccountId" => $cat_id
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
                if ($this->input->post('category_id') && $this->input->post('language') && $this->input->post('file_type')) {
                    $condetions = array(
                        "AccountId" => $this->input->post('category_id'),
                        "file_language" => $this->input->post('language'),
                        "file_type" => $this->input->post('file_type')
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
                                    $title = "no title";
                                }
                            } else {
                                $title = "no title";
                            }
                        }
                        // making array of data
                        $data[] = array(
                            "link" => trim($link['media_link']),
                            "langauge" => $language,
                            "category_id" => $category_id,
                            "title" => $title,
                        );
                    }
                    // insert data
                    if ($this->db->insert_batch('sv_st_category_media_links', $data)) {
                        $respons['status'] = "ok";
                    } else {
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
                $category_id = $this->input->post('category');
                $langauge = $this->input->post('language');
                $list = $this->db->get_where('sv_st_category_media_links', array('category_id' => $category_id, "langauge" => $langauge))->result_array();
                $respons = array('status' => "ok", "list" => $list);
            }
            echo json_encode($respons);
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
            if ($this->input->input_stream('linkId')) {
                $linkId = $this->input->input_stream('linkId');
                if ($this->db->delete('sv_st_category_media_links', array('Id' => $linkId))) {
                    $respons['status'] = "ok";
                } else {
                    $respons['status'] = "error";
                }
            }
            echo json_encode($respons);
        } elseif ($this->input->method() == "put" && $this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            if ($this->db->query("UPDATE `sv_st_category_media_links` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function Resources()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Gallery manage";
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $data['page_title'] = "Qlick Health | Category Resources ";
            $data['sessiondata'] = $sessiondata;
            $data['Categorys'] = $this->db->query(' SELECT * FROM `sv_st_category` ')->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/CG_Resources', $data);
            $this->load->view('EN/inc/footer');
        } else {
            print_r($this->input->post());
        }
    }

    public function upload_Resources()
    {
        if (!empty($_FILES['file']['name']) && $this->input->post("cat_id") && is_numeric($this->input->post("cat_id"))) {
            // Set preference
            $config['upload_path'] = './uploads/Category_resources/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|psd';
            $config['max_size'] = '51200'; // max_size in kb
            $config['encrypt_name'] = true;
            //Load upload library
            $this->load->library('upload', $config);
            // File upload
            if ($this->upload->do_upload('file')) {
                // insert the file data
                $language = $this->input->post('files_language');
                $uploadData = $this->upload->data();
                $data = [
                    "file_name" => $uploadData['file_name'],
                    "cat_id" => $this->input->post("cat_id"),
                    "language_resource" => $language
                ];
                $this->db->insert("st_sv_categorys_resources", $data);
            } else {
                print_r($this->upload->display_errors());
            }
        }
    }

    public function getResorceFilesList()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post('cat_id') && $this->input->post("language")) {
            // when post means return list as json
            $cat_id = $this->input->post('cat_id');
            $language = $this->input->post('language');
            header('Content-Type: application/json');
            $list = $this->db->query("SELECT `st_sv_categorys_resources`.`Id` AS FileKey , `st_sv_categorys_resources`.`status` AS status,
            `st_sv_categorys_resources`.`file_name`, `sv_st_category`.`Cat_en` , `st_sv_categorys_resources`.`TimeStamp` AS At_dt 
            FROM `sv_st_category` 
            JOIN `st_sv_categorys_resources` ON `st_sv_categorys_resources`.`cat_id` = `sv_st_category`.`Id` 
            WHERE `sv_st_category`.`Id`  = '" . $cat_id . "' AND `st_sv_categorys_resources`.`language_resource` = '" . $language . "' ")->result_array();
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
                        if (unlink("./uploads/Category_resources/" . $file['file_name'])) {
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
        $this->form_validation->set_rules('cat_id', ' ', 'trim|required|min_length[1]|numeric');
        if ($this->form_validation->run()) {
            $article = $this->input->post('articles');
            $cat_id = $this->input->post('cat_id');
            $title = $this->input->post('title');
            // upload image 
            $config['upload_path'] = './uploads/articles_files/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '51200'; // max_size in kb = 50mb
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('art_image')) {
                $uploadData = $this->upload->data();
                $data = [
                    "Article" => $article,
                    "img_url" => $uploadData['file_name'],
                    "cat_id" => $cat_id,
                    "title" => $title,
                    "language" => $this->input->post('articles_language')
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
            if ($this->input->post('cat_id') && $this->input->post('language')) {
                $cat_id = $this->input->post('cat_id');
                $language = $this->input->post('language');
                $data = array();
                $data = $this->db->query(" SELECT `st_sv_categorys_articles`.`img_url` , `st_sv_categorys_articles`.`title` , `st_sv_categorys_articles`.`status` , 
                `st_sv_categorys_articles`.`Id` AS art_id ,
                `sv_st_category`.`Cat_en` AS Category_name , `st_sv_categorys_articles`.`Article` AS art_text , `sv_st_category`.`Id` AS cat_id
                FROM `st_sv_categorys_articles` 
                JOIN `sv_st_category` ON `st_sv_categorys_articles`.`cat_id` = `sv_st_category`.`Id` 
                WHERE `sv_st_category`.`Id` = '" . $cat_id . "' AND `st_sv_categorys_articles`.`language` = '" . $language . "' ")->result_array();
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
            if ($this->input->input_stream('cat_id')) {
                $cat_id = $this->input->input_stream('cat_id');
                if ($this->db->delete('st_sv_categorys_articles', array('Id' => $cat_id))) {  // Delete the article FRom st_sv_categorys_articles
                    echo "ok";
                }
            } else {
                print_r($this->input->input_stream());
                echo "error";
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

    public function article()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $category_id = $this->uri->segment(4);
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $data['page_title'] = "Qlick Health | Category Resources ";
                $data['sessiondata'] = $sessiondata;
                $data['article'] = $this->db->query(" SELECT * FROM `st_sv_categorys_articles` WHERE `Id` = '" . $category_id . "' ")->result_array();
                if (!empty($data['article'])) {
                    $data['article'] = $data['article'][0];
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/SuperAdmin/Resources_Article', $data);
                    $this->load->view('EN/inc/footer');
                } else {
                    redirect("EN/Dashboard/Resources");
                }
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                header('Content-Type: application/json');
                $respons = array('status' => "error");
                $this->load->library('form_validation');
                $this->form_validation->set_rules('articles', 'Article ', 'trim|required|min_length[3]|max_length[65535]');
                $this->form_validation->set_rules('title', 'title ', 'trim|required|min_length[3]|max_length[200]');
                if ($this->form_validation->run()) {
                    $article = $this->input->post('articles');
                    $title = $this->input->post('title');
                    // upload image 
                    $config['upload_path'] = './uploads/articles_files/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = '51200'; // max_size in kb = 50mb
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('art_image')) {
                        $uploadData = $this->upload->data();
                        $data['img_url'] = $uploadData['file_name'];
                    } else {
                        $data = [
                            "Article" => $article,
                            "title" => $title
                        ];
                    }
                    $this->db->set($data);
                    $this->db->where('Id', $category_id);
                    if ($this->db->update("st_sv_categorys_articles", $data)) {
                        $respons = array("status" => "ok", "message" => "Unexpected error", "inputs" => $this->input->post());
                    }
                } else {
                    $respons = array('status' => "error", "messages" => validation_errors());
                }
                echo json_encode($respons);
            }
        }
    }

    public function settings()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $category_id = $this->uri->segment(4);
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->load->helper('directory');
            $data['logos'] = directory_map('./assets/images/settings/logos');
            $data['settings'] = $this->db->get('l0_global_settings', 1)->result_array()[0];
            $data['page_title'] = "Qlick Health | Category Resources ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/settings', $data);
            $this->load->view('EN/inc/footer');
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json');
            $respons = array("status" => "errror", "messages" => "");
            $config['upload_path'] = "./assets/images/settings/logos/";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['encrypt_name'] = true;
            //  start upload
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("newlogo")) {
                $upload_data = $this->upload->data();
                $data = array(
                    'logo_url' => $upload_data['file_name'],
                );
                if ($this->db->update('l0_global_settings', $data)) {
                    $respons = array("status" => "ok");
                } else {
                    $respons = array("status" => "ok", "messages" => "unexpected error");
                }
            } else {
                $respons = array("status" => "error", "messages" => $this->upload->display_errors("", ""));
            }
            echo json_encode($respons);
        }
    }

    public function updatelogo()
    {
        // receive name of file as "url_name" ; post request
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $this->input->post("url_name");
            $data = array(
                'logo_url' => $name,
            );
            if ($this->db->update('l0_global_settings', $data)) {
                echo "ok";
            } else {
                echo "error";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $file = $this->input->input_stream("url_name");
            if (file_exists("./assets/images/settings/logos/" . $file)) {
                unlink("./assets/images/settings/logos/" . $file);
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function apicopying()
    {
        if ($this->input->method() == "post" && $this->input->post('status') !== null) {
            $this->db->set('api_copy', ($this->input->post('status') == ('1' || '0') ? $this->input->post('status') : '0'));
            if ($this->db->update("l0_global_settings")) {
                echo "Status updated successfully";
            }
        }
    }

    public function Departments_tests_permission()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            $data['thisId'] = $id;
            $data['page_title'] = "Qlick Health | Connect ";
            $data["connects"] = $this->db->query(" SELECT `other`.`Dept_Name_EN` AS `Title` ,
            `v0_departments_results_permissions`.`Id` AS `conn_id` ,
            `v0_departments_results_permissions`.`TimeStamp` AS `In` ,
            `v0_departments_results_permissions`.`adding` , `v0_departments_results_permissions`.`list`
            FROM `v0_departments_results_permissions`
            JOIN `l1_co_department` other ON `other`.`Id` = `v0_departments_results_permissions`.`to_dept` 
            JOIN `l1_co_department` me ON `me`.`Id` = `v0_departments_results_permissions`.`by_dept` 
            WHERE `by_dept` = '" . $id . "'  ")->result_array();
            $data['departments'] = $this->db->query("SELECT *
            FROM l1_co_department 
            WHERE l1_co_department.Id != '" . $id . "' ")->result_array();
            $data['new_to_connect'] = $this->db->query(" SELECT * FROM l1_co_department
            WHERE NOT EXISTS (SELECT Id 
            FROM v0_departments_results_permissions 
            WHERE `l1_co_department`.`Id` = `v0_departments_results_permissions`.`to_dept` 
            AND `v0_departments_results_permissions`.`by_dept` = '" . $id . "' ) AND l1_co_department.Id != '" . $id . "' ")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/company_tests_permission');
            $this->load->view('EN/inc/footer');
        } else {
            $data['page_title'] = "Qlick Health | Campanys";
            $data['campanys'] = $this->db->query("SELECT `l1_co_department`.* , `l2_avatars`.`Link` AS pic   
            FROM `l1_co_department`
            LEFT JOIN `l2_avatars` ON `l2_avatars`.`Type_Of_User` = 'department_Company' 
            AND `l2_avatars`.`For_User` = `l1_co_department`.`Id`  ")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Companys_tests_permission');
            $this->load->view('EN/inc/footer');
        }
    }

    public function schools_tests_permission()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            $data['thisId'] = $id;
            $data['page_title'] = "Qlick Health | Connect ";
            $data["connects"] = $this->db->query(" SELECT `other`.`School_Name_EN` AS `Title` ,
            `v0_schools_results_permissions`.`Id` AS `conn_id` ,
            `v0_schools_results_permissions`.`TimeStamp` AS `In` ,
            `v0_schools_results_permissions`.`adding` , `v0_schools_results_permissions`.`list`
            FROM `v0_schools_results_permissions`
            JOIN `l1_school` other ON `other`.`Id` = `v0_schools_results_permissions`.`to_school` 
            JOIN `l1_school` me ON `me`.`Id` = `v0_schools_results_permissions`.`by_school` 
            WHERE `by_school` = '" . $id . "'  ")->result_array();
            $data['departments'] = $this->db->query("SELECT *
            FROM l1_school 
            WHERE l1_school.Id != '" . $id . "' ")->result_array();
            $data['new_to_connect'] = $this->db->query(" SELECT * FROM l1_school
            WHERE NOT EXISTS (SELECT Id 
            FROM v0_schools_results_permissions 
            WHERE `l1_school`.`Id` = `v0_schools_results_permissions`.`to_school` 
            AND `v0_schools_results_permissions`.`by_school` = '" . $id . "' ) AND l1_school.Id != '" . $id . "' ")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/school_tests_permission');
            $this->load->view('EN/inc/footer');
        } else {
            $data['page_title'] = "Qlick Health | Campanys";
            $data['campanys'] = $this->db->query("SELECT `l1_co_department`.* , `l2_avatars`.`Link` AS pic   
            FROM `l1_co_department`
            LEFT JOIN `l2_avatars` ON `l2_avatars`.`Type_Of_User` = 'department_Company' 
            AND `l2_avatars`.`For_User` = `l1_co_department`.`Id`  ")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/schools_tests_permission');
            $this->load->view('EN/inc/footer');
        }
    }

    public function manage_dept_results_connect_ref()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                if ($this->db->query("DELETE FROM `v0_departments_results_permissions` WHERE Id = '" . $id . "' ")) {
                    echo 'ok';
                }
            }
        } elseif ($this->input->method() == "post") {
            if ($this->input->post("for") && $this->input->post("from")) {
                $to = $this->input->post("for");
                $from = $this->input->post("from");
                $data = array(
                    "by_dept" => $from,
                    "to_dept" => $to,
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s"),
                );
                if ($this->db->insert('v0_departments_results_permissions', $data)) {
                    echo "ok";
                }
            } elseif ($this->input->post("connect_id") && $this->input->post("perm_name")) {
                $name = $this->input->post("perm_name");
                $connId = $this->input->post("connect_id");
                if ($this->db->query("UPDATE `v0_departments_results_permissions` SET `" . $name . "` = IF(" . $name . "=1, 0, 1) WHERE Id = '" . $connId . "' ")) {
                    echo "ok";
                } else {
                    echo "error";
                }
            }
        }
    }

    public function manage_school_results_connect_ref()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                if ($this->db->query("DELETE FROM `v0_schools_results_permissions` WHERE Id = '" . $id . "' ")) {
                    echo 'ok';
                }
            }
        } elseif ($this->input->method() == "post") {
            if ($this->input->post("for") && $this->input->post("from")) {
                $to = $this->input->post("for");
                $from = $this->input->post("from");
                $data = array(
                    "by_school" => $from,
                    "to_school" => $to,
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s"),
                );
                if ($this->db->insert('v0_schools_results_permissions', $data)) {
                    echo "ok";
                }
            } elseif ($this->input->post("connect_id") && $this->input->post("perm_name")) {
                $name = $this->input->post("perm_name");
                $connId = $this->input->post("connect_id");
                if ($this->db->query("UPDATE `v0_schools_results_permissions` SET `" . $name . "` = IF(" . $name . "=1, 0, 1) WHERE Id = '" . $connId . "' ")) {
                    echo "ok";
                } else {
                    echo "error";
                }
            }
        }
    }

    public function welcome()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Add Position ";
        $datalink = "./assets/data/links.json";
        $data['links'] = json_decode(file_get_contents($datalink), true);
        // $this->response->dd($data['links']);
        if ($this->input->method() == "get") {
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/welcomeSettings');
            $this->load->view('EN/inc/footer');
        } else if ($this->input->method() == "post") {
            $config['upload_path'] = './assets/images';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '4024'; // max_size in kb
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('img')) {
                $this->load->helper('string');
                $uploadData = $this->upload->data();
                $new = [
                    "id" => random_string('alnum', 16),
                    "img" => $uploadData["file_name"],
                    "title" => $this->input->post("title"),
                    "link" => $this->input->post("language"),
                    "action" => $this->input->post("action"),
                ];
                $inp = file_get_contents($datalink);
                $tempArray = json_decode($inp);
                array_push($tempArray, $new);
                $jsonData = json_encode($tempArray);
                file_put_contents($datalink, $jsonData);
                $this->response->json(["status" => "ok"]);
            } else {
                $this->response->json(["status" => "error", "data" => $this->upload->display_errors("", "")]);
            }
        } elseif ($this->input->method() == "delete") {
            if ($this->uri->segment(4)) {
                $id = $this->uri->segment(4);
                foreach ($data['links'] as $key => $link) {
                    if ($link['id'] == $id) {
                        unset($data['links'][$key]);
                    }
                }
                $jsonData = json_encode($data['links']);
                file_put_contents($datalink, $jsonData);
                $this->response->json(["status" => "ok"]);
            } else {
                $this->response->json(["status" => "error"]);
            }
        } else {
            echo $this->input->method();
        }
    }

    public function Add_Position_staff()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Add Position ";
        $data['type'] = "staff";
        if ($this->input->method() == "get") {
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/addposition_st', $data);
            $this->load->view('EN/inc/footer');
        } else if ($this->input->method() == "post") {
            $this->load->library('form_validation');
            if ($this->input->post('userposition') && $this->input->post('code')) {
                $this->form_validation->set_rules('userposition', 'User Position', 'trim|required|min_length[3]|max_length[30]');
                $this->form_validation->set_rules('UserType_ar', 'User Position AR', 'trim|required|min_length[3]|max_length[30]');
                $this->form_validation->set_rules('code', 'Code', 'trim|required|exact_length[9]');
                if ($this->form_validation->run()) {
                    // You Have Entred incorrect Data , Please Checke It and Try Again !!
                    $position = $this->input->post('userposition');
                    $code = $this->input->post('code');
                    $corrent = $this->db->query("SELECT * FROM  `r_positions_sch` WHERE `Position` = '" . $position . "' OR `Code` = '" . $code . "' ")->result_array();
                    if (empty($corrent)) {
                        $data = [
                            "Position" => $position,
                            "Code" => $code,
                            "Created" => date("Y-m-d"),
                            "Added_By" => $sessiondata['admin_id'],
                            "AR_Position" => $this->input->post("UserType_ar"),
                        ];
                        if ($this->db->insert("r_positions_sch", $data)) { ?>
                            <script>
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'The data was inserted. Successfuly !!',
                                    icon: 'success'
                                });
                            </script>
                            <?php
                        } else {
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Error !!',
                                    text: 'Sorry, there is an error. Please try again later.',
                                    icon: 'error'
                                });
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Error !!',
                                text: 'This Position "<?php echo $position; ?>" Alredy Exist !!',
                                icon: 'error'
                            });
                        </script>
                        <?php
                    }
                } else { ?>
                    <script>
                        Swal.fire({
                            title: 'warning !!',
                            text: `<?= validation_errors("- ", " -") ?>`,
                            icon: 'warning'
                        });
                    </script>
                <?php }
            } else {
                ?>
                <script>
                    Swal.fire({
                        title: 'Sorry.',
                        text: 'Please Enter Some Data ): ',
                        icon: 'error'
                    });
                </script>
                <?php
            }
        }
    }

    public function gates()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        if ($this->uri->segment(4)) {
            $accepted = ['all', 'gm', 'staff', 'teacher'];
            if (in_array($this->uri->segment(4), $accepted)) {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['type'] = $this->uri->segment(4);
                $table = "";
                switch ($data['type']) {
                    case 'all':
                        $table = "	r_positions";
                        break;
                    case 'gm':
                        $table = "	r_positions_gm";
                        break;
                    case 'staff':
                        $table = "r_positions_sch";
                        break;
                    case 'teacher':
                        $table = "r_positions_tech";
                        break;
                    default:
                        redirect("EN/Dashboard/Resources");
                        break;
                }
                if ($this->input->method() == "get") {
                    $data['page_title'] = "Qlick Health | Add New Position ";
                    $data['sessiondata'] = $sessiondata;
                    $data['positions'] = $this->db->get($table)->result_array();
                    $this->load->view('EN/inc/header', $data);
                    $this->load->view('EN/SuperAdmin/gates');
                    $this->load->view('EN/inc/footer');
                } else if ($this->input->method() == "post") {
                    $this->load->library('form_validation');
                    $this->load->library('session');
                    $sessiondata = $this->session->userdata('admin_details');
                    if ($this->input->post('userposition') && $this->input->post('code')) {
                        $this->form_validation->set_rules('userposition', 'User Position', 'trim|required|min_length[3]|max_length[30]');
                        $this->form_validation->set_rules('UserType_ar', 'User Position AR', 'trim|required|min_length[3]|max_length[30]');
                        $this->form_validation->set_rules('code', 'Code', 'trim|required|exact_length[9]');
                        if ($this->form_validation->run()) {
                            $position = $this->input->post('userposition');
                            $code = $this->input->post('code');
                            $corrent = $this->db->get_where($table, ['Position' => $position])->result_array();
                            if (empty($corrent)) {
                                $data = [
                                    "Position" => $position,
                                    "Code" => $code,
                                    "Created" => date("Y-m-d"),
                                    "Added_By" => $sessiondata['admin_id'],
                                    "AR_Position" => $this->input->post("UserType_ar"),
                                ];
                                if ($this->db->insert($table, $data)) {
                                    $this->response->json(['status' => "ok"]);
                                } else {
                                    $this->response->json(['status' => "error", "message" => "sorry we have unexpected error ,please refresh tha page and try again."]);
                                }
                            } else {
                                $this->response->json(['status' => "error", "message" => "This Position Already Exists !"]);
                            }
                        } else {
                            $this->response->json(['status' => "error", "message" => validation_errors('', '')]);
                        }
                    } else {
                        $this->response->json(['status' => "error", "message" => "Fill the Form Please !"]);
                    }
                } else if ($this->input->method() == "put") {
                    $this->load->library('form_validation');
                    $this->load->library('session');
                    $sessiondata = $this->session->userdata('admin_details');
                    if ($this->input->input_stream('userposition') && $this->input->input_stream('key')) {
                        // setting up for validation
                        $inputs = [
                            "userposition" => $this->input->input_stream("userposition"),
                            "UserType_ar" => $this->input->input_stream("UserType_ar"),
                            "key" => $this->input->input_stream("key"),
                        ];
                        $this->form_validation->set_data($inputs);
                        // validation
                        $this->form_validation->set_rules('userposition', 'User Position', 'trim|required|min_length[3]|max_length[30]');
                        $this->form_validation->set_rules('UserType_ar', 'User Position AR', 'trim|required|min_length[3]|max_length[30]');
                        $this->form_validation->set_rules('key', 'key', 'trim|required|numeric');
                        if ($this->form_validation->run()) {
                            $position = $this->input->input_stream('userposition');
                            $corrent = $this->db->get_where($table, ['Position' => $position])->result_array();
                            if (empty($corrent)) {
                                $data = [
                                    "Position" => $position,
                                    "Created" => date("Y-m-d"),
                                    "Added_By" => $sessiondata['admin_id'],
                                    "AR_Position" => $this->input->input_stream("UserType_ar"),
                                ];
                                if ($this->db->where("Id", $this->input->input_stream("key"))->update($table, $data)) {
                                    $this->response->json(['status' => "ok"]);
                                } else {
                                    $this->response->json(['status' => "error", "message" => "sorry we have unexpected error ,please refresh tha page and try again."]);
                                }
                            } else {
                                $this->response->json(['status' => "error", "message" => "This Position Already Exists !"]);
                            }
                        } else {
                            $this->response->json(['status' => "error", "message" => validation_errors('', '')]);
                        }
                    } else {
                        $this->response->json(['status' => "error", "message" => "Fill the Form Please !"]);
                    }
                } else if ($this->input->method() == "delete") {
                    if ($this->input->input_stream('id') && is_numeric($this->input->input_stream('id'))) {
                        $id = $this->input->input_stream('id');
                        try {
                            $this->db->where('Id', $id)->delete($table);
                        } catch (Throwable $th) {
                            $this->response->json(['status' => "error", "message" => "sorry we have unexpected error ,please refresh tha page and try again."]);
                        }
                    } else {
                        $this->response->json(['status' => "error", "message" => "sorry we have unexpected error ,please refresh tha page and try again."]);
                    }
                }
            }
        } else {
            $links = array();
            $links[] = array('name' => "Courses", "link" => base_url('EN/Courses/list'), "desc" => "", "icon" => "courses.png");
            $links[] = array('name' => "Speak Out", "link" => base_url('EN/Dashboard/lifereports'), "desc" => "", "icon" => "speakout.png");
            $links[] = array('name' => "Refrigerator Management", "link" => base_url('EN/Dashboard/Refrigerator_management'), "desc" => "", "icon" => "controlrrefrigerator.png");
            $links[] = array('name' => "Control Permissions", "link" => base_url('EN/Dashboard/permissions_routes'), "desc" => "", "icon" => "permissions.png");
            $links[] = array('name' => "Resources", "link" => base_url('EN/Dashboard/Resources-Managment'), "desc" => "", "icon" => "resources.png");
            $links[] = array('name' => "Message", "link" => base_url('EN/Dashboard/Message'), "desc" => "", "icon" => "message.png");
            $links[] = array('name' => "Mobile Library", "link" => base_url('EN/Dashboard/Resports-Routes'), "desc" => "", "icon" => "mobilelibrary.png");

            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | Positions ";
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/Global/Links/Lists', $data);
            $this->load->view('EN/inc/footer');
        }
    }

    public function permissions_routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links = array();
        $links[] = array(
            "title" => "Control Permissions",
            "links" => [
                array('name' => "Schools Permissions", "link" => base_url('EN/Dashboard/schools_tests_permission'), "desc" => "", "icon" => "schoolpermission.png"),
                array('name' => "Departments Permissions", "link" => base_url('EN/Dashboard/Departments_tests_permission'), "desc" => "", "icon" => "departmentpermission.png"),
            ]
        );
        $data['links'] = $links;

        $data['page_title'] = "QlickSystems";
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Global/Links/Lists', $data);
        $this->load->view('EN/inc/footer');
    }

    public function standards()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Positions ";
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $data['survey_id'] = $this->uri->segment(4);
            $data['standars'] = $this->db->get("r_standards")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/standards');
            $this->load->view('EN/inc/footer');
        } else {
            redirect("EN/Dashboard/Manage_surveys");
        }
    }

    public function standarsGrouping()
    {
        $g_table = "sv_st_standars_groups";
        $q_tableName = "sv_st_questions";
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if ($this->uri->segment(4) && $this->uri->segment(5) && is_numeric($this->uri->segment(4)) && is_numeric($this->uri->segment(5)) && !empty($this->db->get_where("r_standards", ['Id' => $this->uri->segment(4)])->result_array())) {
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['page_title'] = "Qlick Health | Add question";
                $data['sessiondata'] = $sessiondata;
                $group_id = $this->uri->segment(4);
                $serv_id = $this->uri->segment(5);
                $data['standars'] = $this->db->get_where("r_standards", ['Id' => $this->uri->segment(4)])->result_array();
                $data['group_id'] = $group_id;
                $data['serv_id'] = $serv_id;
                $data['surv_type'] = "notfillable";
                $data['used_groups'] = $this->db->query(" SELECT * FROM `" . $g_table . "` WHERE `serv_id` = '" . $serv_id . "'")->result_array();
                $data['standard'] = true;
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/standard_results_grouping');
                $this->load->view('EN/inc/footer');
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("group_id")) {
            if ($this->input->post('group_id') && $this->input->post('serv_id')) {
                $av_questions = array();
                $serv_id = $this->input->post("serv_id");
                $group = $this->input->post("group_id");
                $av_questions = $this->db->query("SELECT `en_title`,`" . $q_tableName . "`.`Id`
                    FROM `sv_questions_library`
                    JOIN `" . $q_tableName . "` ON `" . $q_tableName . "`.`question_id` = `sv_questions_library`.`Id` AND `" . $q_tableName . "`.`survey_id` = '" . $serv_id . "'
                    WHERE EXISTS ( SELECT Id FROM `" . $q_tableName . "` 
                    WHERE `" . $q_tableName . "`.`question_id` =  `sv_questions_library`.`Id` AND `survey_id` = '" . $serv_id . "' GROUP BY `" . $q_tableName . "`.`Id` ) 
                    AND NOT EXISTS (SELECT Id FROM `sv_standard_questions_groups` WHERE `Question_id` = `" . $q_tableName . "`.`question_id` AND `results_standard_group` = '" . $group . "')")->result_array();
                $this->load->view('EN/SuperAdmin/add_quastion_to_serv', [
                    'av_questions' => $av_questions,
                    'suerv_id' => $serv_id,
                    "survey_type" => "notfillable",
                ]);
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("question_id")) {
            $av_questions = array();
            $serv_id = $this->input->post("serv_id");
            $group = $this->input->post("group_key");
            $av_groups = $this->db->query("SELECT * FROM `" . $g_table . "` WHERE `Id` !=  '" . $group . "' AND `serv_id` = '" . $serv_id . "' ")->result_array();
            ?>
            <label for="av_groups">Avalaible groups :</label>
            <select name="av_groups" class="form-control" id="av_groups">
                <?php foreach ($av_groups as $group) { ?>
                    <option value="<?php echo $group['Id'] ?>"><?php echo $group['title_en'] ?></option>
                <?php } ?>
            </select>
            <?php
        }
    }

    public function add_questions_to_standar_group()
    {
        $g_table = "sv_st_standars_groups";
        $q_tableName = "sv_st_questions";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "ADD_to") {
            $serv_id = $this->input->post('__surv_');
            $questions = $this->input->post('new_questions');
            $group_id = $this->input->post('group_id');
            $in = implode(',', $questions);
            if (!empty($in)) {
                $data = array();
                foreach ($questions as $q_id) {
                    $data[] = array(
                        "Question_id" => $q_id,
                        "results_standard_group" => $group_id,
                    );
                }
                if ($this->db->insert_batch("sv_standard_questions_groups", $data)) {
                    echo "ok";
                }
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "trans") {
            $serv_id = $this->input->post('__serv__');
            $connectId = $this->input->post('quastion_id');
            $new_g = $this->input->post('av_groups');
            //quastion_id = Id in sv_standard_questions_groups
            $this->db->set('results_standard_group', $new_g);
            $this->db->where('Id', $connectId);
            if ($this->db->update("sv_standard_questions_groups")) {
                echo "ok";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "new") {
            if ($this->input->post("title_en") && $this->input->post("title_ar") && $this->input->post("__serv__")) {
                $serv_id = $this->input->post("__serv__");
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $standard_id = $this->input->get('standard_id') ?? 0;
                $data = array(
                    'title_en' => $title_en,
                    'title_ar' => $title_ar,
                    'serv_id' => $serv_id,
                    'Standard_Id' => $standard_id
                );
                if ($this->db->insert($g_table, $data)) {
                    echo "ok";
                }
            } else {
                echo "not_valid";
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "titles_get") {
            if ($this->input->post("group_id")) {
                header('Content-Type: application/json');
                $id = $this->input->post("group_id");
                $response = array('status' => "error", "title_en" => "", "title_ar" => "");
                $titles = $this->db->get_where($g_table, array('Id' => $id), 1)->result_array();
                if (!empty($titles)) {
                    $response = array(
                        'status' => 'ok',
                        'title_en' => $titles[0]['title_en'],
                        'title_ar' => $titles[0]['title_ar'],
                    );
                }
            }
            echo json_encode($response);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $this->input->post("for") == "update_g_title") {
            if ($this->input->post("group_upg_id") && $this->input->post("group_title_en") && $this->input->post("group_title_ar")) {
                $id = $this->input->post("group_upg_id");
                $title_en = $this->input->post("group_title_en");
                $title_ar = $this->input->post("group_title_ar");
                $this->db->set('title_en', $title_en);
                $this->db->set('title_ar', $title_ar);
                $this->db->where('Id', $id);
                if ($this->db->update($g_table)) {
                    echo "ok";
                }
            } else {
                // error
            }
        } elseif ($this->input->post("for") == "delete") {
            $id = $this->input->post("group_id");
            $inthisgroup = $this->db->get_where($g_table, array('Id' => $id))->result_array();
            $hasthisgroup = implode(',', array_column($inthisgroup, 'Id'));
            if (!empty($hasthisgroup)) {
                if ($this->db->query("UPDATE `" . $q_tableName . "` SET `results_standard_group` = '0' WHERE Id In (" . $hasthisgroup . ") ")) {
                    if ($this->db->delete($g_table, array('Id' => $id))) {
                        echo "ok";
                    }
                }
            } else {
                if ($this->db->delete($g_table, array('Id' => $id))) {
                    echo "ok";
                }
            }
        }
    }

    public function dialosticbp()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | dialosticbp';
        $data['dialosticbps'] = $this->db->get("r_dialosticbp")->result_array();
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/dialosticbp');
            $this->load->view('EN/inc/footer');
        } else {
            if ($this->input->post('col_id') && $this->input->post('new_val') && $this->input->post('col')) {
                $this->db->set($this->input->post('col'), str_replace('#', '', $this->input->post('new_val')));
                $this->db->where('id', $this->input->post('col_id'));
                if ($this->db->update('r_dialosticbp')) {
                    echo "ok";
                } else {
                    echo "error";
                }
            }
        }
    }

    public function lifereports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | template answers";
        $data['choices'] = $this->db->query("SELECT * FROM `sv_set_template_lifereports` ORDER BY Id DESC ")->result_array();
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/SuperAdmin/temp_lifereports_answers');
        $this->load->view('EN/inc/footer');
    }

    public function lifereports_choices()
    {
        if ($this->uri->segment(4)) {
            $id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | template answers";
            $data['parent_data'] = $this->db->query("SELECT * FROM `sv_set_template_lifereports` WHERE `Id` = '" . $id . "' ORDER BY Id DESC  ")->result_array();
            if (!empty($data['parent_data'])) {
                $data['choices'] = $this->db->query(" SELECT * FROM `sv_set_template_lifereports_choices` WHERE `group_id` = '" . $id . "'
                ORDER BY Id DESC ")->result_array();
                $data['sessiondata'] = $sessiondata;
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/answer_lifereports_managment');
                $this->load->view('EN/inc/footer');
            } else {
                redirect('EN/Dashboard/');
            }
        }
    }

    public function addlifereports_library()
    {
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            if ($for == "new") {
                $q_id = $this->input->post("q_id");
                $title_en = $this->input->post("title_en");
                $title_ar = $this->input->post("title_ar");
                $data = [
                    "group_id" => $q_id,
                    "title_en" => $title_en,
                    "title_ar" => $title_ar,
                ];
                if ($this->db->insert('sv_set_template_lifereports_choices', $data)) {
                    $respons = array('Type' => "add", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update") {
                $title = $this->input->post("title");
                $language = $this->input->post("language");
                $id = $this->input->post("id");
                if ($language == "en") {
                    $this->db->set('title_en', $title);
                } else {
                    $this->db->set('title_ar', $title);
                }
                $this->db->where('Id', $id);
                $this->db->update('sv_set_template_lifereports_choices');
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_template_lifereports_choices` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            }
        }
    }

    public function template_lifereports()
    {
        //print_r($this->input->post());
        if ($this->input->post("requestFor")) {
            $for = $this->input->post("requestFor");
            $rand = $this->input->post("rand");
            $title_en = $this->input->post("title_en");
            $title_ar = $this->input->post("title_ar");
            if ($for == "new") {
                $data = array(
                    "title_en" => $title_en,
                    "title_ar" => $title_ar,
                );
                if ($this->db->insert("sv_set_template_lifereports", $data)) {
                    $lastadded = $this->db->query("SELECT Id FROM `sv_set_template_lifereports`  ORDER BY Id DESC LIMIT 1")->result_array();
                    $respons = array('Type' => "new", 'status' => "ok", "Id" => $lastadded[0]['Id']);
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "Update_Title") {
                $title = $this->input->post("title");
                $language = $this->input->post("language");
                $id = $this->input->post("id");
                if ($language == "en") {
                    $this->db->set('title_en', $title);
                } else {
                    $this->db->set('title_ar', $title);
                }
                $this->db->where('Id', $id);
                $this->db->update('sv_set_template_lifereports');
                echo 'Updated';
            } elseif ($for == "Delete") {
                $id = $this->input->post("id");
                if ($this->db->query("DELETE FROM `sv_set_template_lifereports` WHERE Id = '" . $id . "' ")) {
                    $respons = array('Type' => "Delete", 'status' => "ok");
                    header("Content-Type: application/json; charset=UTF-8");
                    echo json_encode($respons);
                }
            } elseif ($for == "All_questions") {
                $respons = array();
                $questions = $this->db->query("SELECT `sv_set_template_lifereports`.`title_en` AS Title ,
				`sv_set_template_lifereports`.`Id` 
				FROM `sv_set_template_lifereports`")->result_array();
                //print_r($questions);
                $count = 1;
                foreach ($questions as $question) {
                    $h1id = $count++;
                    $rand_id = rand(1000, 9999);
                    $realId = $question['Id'];
                    $newquestion = "";
                    $newquestion .= '<div class="col-lg-6 section_question Ready" Key="' . $rand_id . '" realKey="' . $realId . '"> ';
                    $newquestion .= '<h3 contenteditable="true" id="Title' . $h1id . '">' . $question['Title'] . '</h3>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light choiceBtn"><i class="uil uil-plus"></i></button>';
                    $newquestion .= '<button class="addchoices waves-effect waves-light delete"><i class="uil uil-trash"></i></button>';
                    $newquestion .= '<hr>';
                    ///// sv_set_choices
                    $choices = $this->db->query("SELECT * FROM `sv_set_template_lifereports_choices` 
					WHERE group_id = '" . $question['Id'] . "'")->result_array();
                    $newquestion .= '<div class="choices">';
                    if (!empty($choices)) {
                        $h = 0;
                        foreach ($choices as $choice) {
                            $h++;
                            //"choice" + i + "_" + h
                            $newquestion .= '<div class="custom-control custom-radio mb-3">';
                            $newquestion .= '<input type="radio" id="choiceLa_' . $h1id . '_' . $h . '" name="choice' . $realId . '" class="custom-control-input" >';
                            $newquestion .= '<label class="custom-control-label" for="choiceLa_' . $h1id . '_' . $h . '" id="choice_' . $h1id . '_' . $h . '" contenteditable="true" realKey="' . $choice['Id'] . '">' . $choice['title_en'];
                            $newquestion .= '</label>';
                            $newquestion .= '<button class="addchoices waves-effect waves-light delete_choise"  choice_index="' . $h . '" realkey="' . $choice['Id'] . '"><i class="uil uil-trash"></i></button></div>';
                        }
                    } else {
                        $newquestion .= '<h3>No choices Yet !</h3>';
                    }
                    $newquestion .= '</div>';
                    $respons[] = array('Key' => $rand_id, 'html' => $newquestion, "choices" => $choices);
                }
                //header("Content-Type: application/json; charset=UTF-8");
                echo json_encode($respons);
            }
        }
    }

    public function StudentsCards()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                if ($data = $this->db->get_where("l3_student_dashboard_standards", ['Id' => $this->uri->segment(4)])->row()) {
                    $this->response->json(["status" => "ok", "data" => $data]);
                } else {
                    $this->response->json(["status" => "error", "messages" => "sorry no data found !!"]);
                }
            } else {
                $data['page_title'] = 'Qlick Health | Students Cards';
                $data['sessiondata'] = $sessiondata;
                $data['cards'] = $this->db->get("l3_student_dashboard_standards")->result_array();
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/StudentsCardsControle');
                $this->load->view('EN/inc/footer');
            }
        } else if ($this->input->method() == "post") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('goal', 'Goal', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                if ($this->input->post('id')) {
                    if (!empty($_FILES['icon']['name'])) {
                        $config['upload_path'] = './uploads/Dashboard_icons';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '4024'; // max_size in kb
                        $config['encrypt_name'] = true;
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('icon')) {
                            $uploadData = $this->upload->data();
                            $data = [
                                "title" => $this->input->post('title'),
                                "goal" => $this->input->post('goal'),
                                "icon" => $uploadData['file_name'],
                            ];
                            $this->db->set($data);
                            $this->db->where("Id", $this->input->post('id'));
                            if ($this->db->update("l3_student_dashboard_standards", $data)) {
                                $this->response->json(["status" => "ok"]);
                            } else {
                                $this->response->json(["status" => "error", "messages" => "Sorry, we have unexpected error , Please try again later !!"]);
                            }
                        } else {
                            $this->response->json(["status" => "error", "messages" => $this->upload->display_errors()]);
                        }
                    } else {
                        $data = [
                            "title" => $this->input->post('title'),
                            "goal" => $this->input->post('goal'),
                        ];
                        $this->db->set($data);
                        $this->db->where("Id", $this->input->post('id'));
                        if ($this->db->update("l3_student_dashboard_standards", $data)) {
                            $this->response->json(["status" => "ok", "updated" => "yes"]);
                        } else {
                            $this->response->json(["status" => "error", "messages" => "Sorry, we have unexpected error , Please try again later !!"]);
                        }
                    }
                } else {
                    $config['upload_path'] = './uploads/Dashboard_icons';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = '4024'; // max_size in kb
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('icon')) {
                        $uploadData = $this->upload->data();
                        $data = [
                            "title" => $this->input->post('title'),
                            "goal" => $this->input->post('goal'),
                            "icon" => $uploadData['file_name'],
                        ];
                        if ($this->db->insert("l3_student_dashboard_standards", $data)) {
                            $this->response->json(["status" => "ok"]);
                        } else {
                            $this->response->json(["status" => "error", "messages" => "Sorry, we have unexpected error , Please try again later !!"]);
                        }
                    } else {
                        $this->response->json(["status" => "error", "messages" => $this->upload->display_errors()]);
                    }
                }
            } else {
                $this->response->json(["status" => "error", "messages" => validation_errors()]);
            }
        } else if ($this->input->method() == "delete") {
            if ($this->input->input_stream('id')) {
                if ($this->db->delete('l3_student_dashboard_standards', array('Id' => $this->input->input_stream('id')))) {
                    $this->response->json(["status" => "ok"]);
                } else {
                    $this->response->json(["status" => "error"]);
                }
            } else {
                $this->response->json(["status" => "error"]);
            }
        }
    }

    public function Classes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = 'Qlick Health | Classes';
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/classes');
            $this->load->view('EN/inc/footer');
        } else if ($this->input->method() == "post") {
            if ($this->uri->segment(4)) {
                $id = $this->uri->segment(4);
                $this->db->set('Class', $this->input->post('newname'));
                $this->db->where('Id', $id);
                if ($this->db->update('r_levels')) {
                    $this->response->json(["status" => "ok"]);
                } else {
                    $this->response->json(["status" => "error"]);
                }
            } else {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name_en', 'Name EN', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('name_ar', 'Name AR', 'trim|required|min_length[3]|max_length[200]');
                if ($this->form_validation->run()) {
                    $data = [
                        "Class" => $this->input->post('name_en'),
                        "Class_ar" => $this->input->post('name_ar'),
                    ];
                    if ($this->db->insert("r_levels", $data)) {
                        $this->response->json(["status" => "ok"]);
                    } else {
                        $this->response->json(["status" => "error", "messages" => "unexpected error , Please try again later"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "messages" => validation_errors()]);
                }
            }
        } else if ($this->input->method() == "delete") {
            $id = $this->uri->segment(4);
            if ($this->db->delete('r_levels', ['Id' => $id])) {
                $this->response->json(["status" => "ok"]);
            } else {
                $this->response->json(["status" => "error"]);
            }
        }
    }

    public function Resports_Routes()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $links = array();
        $links[] = array(
            "title" => "Mobile Library",
            "links" => [
                array(
                    'name' => "CATEGORIES PDF", "link" => base_url('EN/Dashboard/Categories'),
                    "desc" => "", "icon" => "categoriespdfl.png"
                ),
                array(
                    'name' => "ARCHITECTURES PDF", "link" => base_url('EN/Dashboard/mobile-architecture'),
                    "desc" => "", "icon" => "mobile-architecture.png"
                ),
            ]
        );
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Global/Links/Lists', $data);
        $this->load->view('EN/inc/footer'); //`sv_st_category`.`Id`
    }

    private function categoriesFilesManagment($table = "sv_st_categories_reports_files")
    {
        // will be used to all actions
        $config["table"] = $table;
        $data["isMobile"] = $table !== "sv_st_categories_reports_files" ? true : false;
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Categories';
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            //show old files
            if ($this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6) && is_numeric($this->uri->segment(4)) && in_array(strtolower($this->uri->segment(5)), ["staff", "student", "teacher", "parent"]) && in_array(strtolower($this->uri->segment(6)), ["ar", "en"])) {
                $id = $this->uri->segment(4);
                $type = strtolower($this->uri->segment(5));
                $language = strtolower($this->uri->segment(6));
                // get the old files
                $files = $this->db->where("Category_id", $id)->where("language", $language)->where("usertype", $type)->get($config["table"])->result_array();
                // return the response HTML
                if (empty($files)) {
                    echo "No files yet...";
                } else {
                    foreach ($files as $key => $file) {
                        $this->load->view('EN/SuperAdmin/inc/category-pdf', ["file" => $file]);
                    }
                }
                // Force the CI engine to render the content generated until now    
                $this->CI = &get_instance();
                $this->CI->output->_display();
                die();
            }
            $data['categories'] = $this->db->query("SELECT sv_st_category.* , ( SELECT COUNT(`sv_st_surveys`.`Id`) FROM `sv_st_surveys` WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` ) AS counter_of_using 
            FROM `sv_st_category` 
            ORDER BY Id ASC")->result_array();
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/SuperAdmin/Categories');
            $this->load->view('EN/inc/footer');
        } else {
            if ($this->input->post("cat_id") && $this->input->post("userType") && $this->input->post("lang")) {
                $config['upload_path'] = './uploads/categories_reports/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '5000';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('newFile')) {
                    $fileName = $this->upload->data()['file_name'];
                    $newfile = [
                        "Category_id" => $this->input->post("cat_id"),
                        "language" => $this->input->post("lang"),
                        "usertype" => $this->input->post("userType"),
                        "file" => $fileName
                    ];
                    if ($this->db->insert($config["table"], $newfile)) {
                        $this->response->json(["status" => "ok"]);
                    } else {
                        $this->response->json(["status" => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "message" => $this->upload->display_errors()]);
                }
            } else {
            }
        }
    }

    public function Categories()
    {
        $this->categoriesFilesManagment();
    }

    public function mobile_architecture()
    {
        $this->categoriesFilesManagment("sv_st_categories_mobile_architecture");
    }

    private function filesActions($table = "sv_st_categories_reports_files")
    {
        try {
            // status update
            if ($this->input->method() == "post" && $this->input->post("file") && is_numeric($this->input->post("file"))) {
                $file = $this->input->post("file");
                $this->db->query("UPDATE " . $table . " SET status = IF(status=1, 0, 1) WHERE Id = '" . $file . "'");
                $this->response->json(["status" => "ok"]);
                die();
            }
            // delete
            if ($this->input->method() == "delete" && $this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $this->db->delete($table, ["Id" => $this->uri->segment(4)]);
                $this->response->json(["status" => "ok"]);
                die();
            }
        } catch (Throwable $th) {
            $this->response->json(["status" => "error", "message" => "sorry we have an unexpected error..."]);
        }
    }

    public function categories_files()
    {
        $this->filesActions();
    }

    public function mobile_architecture_files()
    {
        $this->filesActions("sv_st_categories_mobile_architecture");
    }

    public function questions_manage()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && in_array($this->uri->segment(5), ['fillable', "choices"])) {
            $data['serv_id'] = $this->uri->segment(4);
            $data['serv_type'] = $this->uri->segment(5);
            if ($this->uri->segment(5) == "fillable") {
                $g_tableName = "sv_st_fillable_groups";
                $q_tableName = "sv_st_fillable_questions";
            } else {
                $g_tableName = "sv_st_groups";
                $q_tableName = "sv_st_questions";
            }
            if ($this->input->method() == "get") {
                $data['survey'] = $this->db->query(" SELECT
                `sv_st_surveys`.`TimeStamp` AS created_at ,
                `sv_st_surveys`.`Id` AS survey_id,
                `sv_st_surveys`.`status` AS status,
                `sv_st_surveys`.`Message_en` ,`sv_st_surveys`.`Message_ar` ,
                `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
                `sv_st_category`.`Cat_en`,
                `sv_st_category`.`Cat_ar`,
                `sv_st_surveys`.`answer_group_en` AS group_id,
                `sv_st_surveys`.`code` AS serv_code,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_set_template_answers`.`title_en` AS choices_title ,
                `" . $q_tableName . "`.`survey_id` AS connId ,
                COUNT(`sv_school_published_surveys`.`Id`) AS isUsed ,
                COUNT(`" . $q_tableName . "`.`survey_id`) AS questions_count
                FROM `sv_st_surveys`
                INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                INNER JOIN `" . $q_tableName . "` ON `" . $q_tableName . "`.`survey_id` = `sv_st_surveys`.`Id`
                INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                LEFT JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                LEFT JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id`
                JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
                WHERE `sv_st_surveys`.`Id` = '" . $data['serv_id'] . "'
                GROUP BY `" . $q_tableName . "`.`survey_id` ORDER BY `sv_st_surveys`.`Id` ASC")->result_array();
                if (empty($data['survey'])) {
                    // exit if the survey is empty
                    redirect('EN/Dashboard/Manage_surveys');
                    return false;
                }
                $data['survey'] = $data['survey'][0];
                $data['questions'] = $this->db->query("SELECT *,`" . $q_tableName . "`.`Id` AS q_id
                FROM `" . $q_tableName . "`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_tableName . "`.`question_id`
                WHERE `survey_id` = '" . $data['serv_id'] . "' ")->result_array();
                $data['used_groups'] = $this->db->query(" SELECT * FROM `" . $g_tableName . "` WHERE `serv_id` = '" . $data['serv_id'] . "' 
                ORDER BY `" . $g_tableName . "`.`position` ASC")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`" . $q_tableName . "`.`Id` AS q_id
                FROM `" . $q_tableName . "`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_tableName . "`.`question_id`
                WHERE `" . $q_tableName . "`.`survey_id` = '" . $data['serv_id'] . "' 
                AND `" . $q_tableName . "`.`group_id` = '0'  ORDER BY `" . $q_tableName . "`.`position` ASC")->result_array();
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $data['survey']['group_id'] . "' ")->result_array();
                $data['questions_counter'] = 0;
                // page loading
                $this->load->library('session');
                $sessiondata = $this->session->userdata('admin_details');
                $data['sessiondata'] = $sessiondata;
                $data['page_title'] = "QlickSystems | List all ";
                $this->load->view('EN/inc/header', $data);
                $this->load->view('EN/SuperAdmin/survey_questions_managment');
                $this->load->view('EN/inc/footer');
            } else if ($this->input->method() == "post") {
                if ($this->input->post('newsorting') && $this->input->post('type')) {
                    if ($this->input->post('type') == "questions") {
                        foreach ($this->input->post("newsorting") as $key => $sort) {
                            $this->db->set('position', $key);
                            $this->db->where('Id', $sort);
                            $this->db->where('survey_id', $data['serv_id']);
                            $this->db->update($q_tableName);
                        }
                    } else if ($this->input->post('type') == "groups") {
                        foreach ($this->input->post("newsorting") as $key => $sort) {
                            $this->db->set('position', $key);
                            $this->db->where('Id', $sort);
                            $this->db->where('serv_id', $data['serv_id']);
                            $this->db->update($g_tableName);
                        }
                    } else {
                        $this->response->json([
                            "status" => "error"
                        ]);
                        return false;
                    }
                    $this->response->json([
                        "status" => "ok"
                    ]);
                } else {
                    $this->response->json([
                        "status" => "error"
                    ]);
                }
            }
        } else {
            redirect('EN/Dashboard/Manage_surveys');
        }
    }

    public function survey_preview()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && in_array($this->uri->segment(5), ['choices', 'fillable'])) {
            $serv_id = $this->uri->segment(4);
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['type'] = $this->uri->segment(5);
            $data['activeLanguage'] = "en";
            if ($this->uri->segment(6) && in_array(strtolower($this->uri->segment(6)), ['ar', 'en'])) {
                $data['activeLanguage'] = strtolower($this->uri->segment(6));
            }
            if ($this->uri->segment(5) == "choices") {
                $data['serv_data'] = $this->db->query(" SELECT 
                `sv_st1_surveys`.`title_en` AS Title_en,
                `sv_st1_surveys`.`title_ar` AS Title_ar,
                `sv_st_surveys`.`Id` as mainId ,
                `sv_st_surveys`.`Message_en` AS Message,
                `sv_st_surveys`.`answer_group_en` AS group_id ,
                `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
                `sv_st_surveys`.`Id` AS main_survey_id ,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar 
                FROM `sv_st_surveys` 
                LEFT JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                WHERE `sv_st_surveys`.`Id` = '" . $data['serv_id'] . "' ")->result_array();
                if (empty($data['serv_data'])) {
                    echo "no data found";
                    exit();
                }
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
            } else {
                $data['serv_data'] = $this->db->query(" SELECT 
                `sv_st1_surveys`.`title_en` AS Title_en,
                `sv_st1_surveys`.`title_ar` AS Title_ar,
                `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
                `sv_st_fillable_surveys`.`Message_en` AS Message,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_st_fillable_surveys`.`Id` AS main_survey_id 
                FROM `sv_st1_surveys` 
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
                WHERE `sv_st_surveys`.`Id` = '" . $data['serv_id'] . "' ")->result_array();
                // $this->response->json($data['serv_data']);
            }
            if (!empty($data['serv_data'])) {
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "' 
                ORDER BY `sv_st_groups`.`position` ASC")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' 
                ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                $data['hasntnav'] = true;
                $this->load->view(strtoupper($data['activeLanguage']) . "/inc/header", $data);
                $this->load->view("EN/SuperAdmin/survey-preview");
                $this->load->view(strtoupper($data['activeLanguage']) . "/inc/footer");
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('EN/schools/wellness');
        }
    }

    public function ChoicesValues()
    {
        if ($this->input->method() == "get") {
            $choice = $this->uri->segment(4);
            $question = $this->uri->segment(5);
            $survey_id = $this->uri->segment(6);
            $q = $this->db->get_where("sv_st_answers_mark", ["choice_id" => $choice, "question_id" => $question, "survey_id" => $survey_id])->result_array();
            if (!empty($q)) {
                $this->response->json([
                    "status" => "ok",
                    "activeMark" => $q[0]['mark'],
                    "activeId" => $q[0]['Id']
                ]);
            } else {
                $this->response->json([
                    "status" => "error"
                ]);
            }
        } else if ($this->input->method() == "post") {
            $surveyId = $this->uri->segment(4);
            $data = [
                "survey_id" => $surveyId,
                "question_id" => $this->input->post('question'),
                "choice_id" => $this->input->post('choice'),
                "mark" => $this->input->post('mark'),
            ];
            if ($this->input->post('activeId') == 0) {
                if ($this->db->insert('sv_st_answers_mark', $data)) {
                    $this->response->json([
                        "status" => "ok"
                    ]);
                } else {
                    $this->response->json([
                        "status" => "error"
                    ]);
                }
            } else {
                $this->db->set($data);
                $this->db->where("Id", $this->input->post('activeId'));
                if ($this->db->update('sv_st_answers_mark')) {
                    $this->response->json([
                        "status" => "ok"
                    ]);
                } else {
                    $this->response->json([
                        "status" => "error"
                    ]);
                }
            }
        }
    }

    public function tipsManagment()
    {
        // $this->response->dd($this->input->post());
        if ($this->input->post('value') && $this->input->post("language") && $this->input->post("name") && $this->input->post("surveKey")) {
            $this->db->set($this->input->post("name") . "_" . $this->input->post("language"), $this->input->post('value'));
            $this->db->where('Id', $this->input->post("surveKey"));
            if ($this->db->update('sv_st_surveys')) {
                $this->response->json([
                    "status" => "ok"
                ]);
            } else {
                $this->response->json([
                    "status" => "error"
                ]);
            }
        }
    }

    public function Message()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/Component/Message');
        $this->load->view('EN/inc/footer');
    }

    public function TargetedAccounts()
    {
        // function to control the targeted accounts of the normal surveys and climate
        // this link will be called from ClimateSurveys and Manage_surveys pages 
        // supported methods : post & delete 
        if ($this->uri->segment(4) && in_array($this->uri->segment(4), ["Climate", "Survey"]) && is_numeric($this->uri->segment(5))) { // checking the data 
            $SurveyType = $this->uri->segment(4);
            $SurveyId = $this->uri->segment(5);
            $only = "";
            switch ($SurveyType) { // returning the table name based on the survey type
                case 'Climate':
                    $table = "scl_st0_climate_targeted_accounts";
                    $stable = "scl_st0_climate";
                    break;
                case 'courses':
                    $table = "scou_st0__main_courses_targeted_accounts";
                    $stable = "scou_st0_main_courses";
                    break;
                default:
                    $table = "sv_st_targeted_accounts";
                    $stable = "sv_st_surveys";
                    break;
            }
            // getting the survey data
            $surveydata = $this->db->select('*')->where('id', $SurveyId)->get($stable)->row();
            if (!isset($surveydata)) { // stop the script if this survey doesn't exist
                die($this->response->json(["status" => "error", "message" => "Sorry. The Survey You Are Looking For Doesn't Exist !"]));
            }
            $only = $surveydata->targeted_type == "M" ? "Ministry" : "Company";
            // getting the data
            if ($this->input->method() == "get") { // getting the data
                $data['TargetedAccountsList'] = $this->db->select("l0_organization.EN_Title AS name , l0_organization.Id AS Id , " . $table . ".Status AS status , `$table`.Id AS connectionId , `$table`.TimeStamp AS AddedAt ")
                    ->from($table)->join("l0_organization", "l0_organization.Id = `$table`.account_id")
                    ->where('survey_id', $SurveyId)
                    ->get()
                    ->result_array();
                $data['SurveyType'] = $SurveyType;
                $data['SurveyId'] = $SurveyId;
                if (!empty($data["TargetedAccountsList"])) {
                    $this->db->where_not_in("Id", array_column($data["TargetedAccountsList"], "Id"));
                }
                // Return The List Based On The TargetedType Type
                if ($only !== "") {
                    $data['accounts'] = $this->db->where("Type", $only)->get('l0_organization')->result_array();
                } else {
                    $data['accounts'] = $this->db->get('l0_organization')->result_array();
                }
                $this->load->view("EN/SuperAdmin/component/TargetedAccountsList", $data);
            } else if ($this->input->method() == "post") { // adding an account
                if (!empty($this->input->post('account'))) {
                    $data = array();
                    foreach ($this->input->post('account') as $key => $account) {
                        $data[] = array(
                            "survey_id" => $SurveyId,
                            "account_id" => $account,
                        );
                    }
                    try {
                        $this->db->insert_batch($table, $data);
                        $this->response->json(["status" => "ok"]);
                    } catch (Throwable $th) {
                        $this->response->json(["status" => "error", "message" => "Sorry we have unexpected error , Please try again later"]);
                    }
                }
            } else if ($this->input->method() == "delete") { // updating the status
                try {
                    $id = $this->input->input_stream('id');
                    $this->db->query("UPDATE `" . $table . "` SET `Status` = IF(`Status`=1, 0, 1) WHERE `Id` = '" . $id . "' ");
                    $this->response->json(["status" => "ok"]);
                } catch (Throwable $th) {
                    $this->response->json(["status" => "error", "message" => "Sorry we have unexpected error , Please try again later"]);
                }
            }
        } else {
            $this->response->json(["status" => "error", "message" => "Sorry we have unexpected error"]);
        }
    }

    public function Resources_Managment()
    { // accessible link Resources-Managment
        $this->load->library('session');
        $this->load->library('Resources');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Resources Managment ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        if ($this->uri->segment(4)) {
            // settingup the data 
            $type = $this->uri->segment(4);
            if (!$this->resources->valid($type)) { // stop the script when the type isn't supported
                redirect("EN/Dashboard/Resources-Managment");
                exit();
            }
            $body['backndData'] = $this->resources->get($type);
            if ($this->input->method() == "get") {
                if ($this->input->is_ajax_request()) {
                    if ($this->uri->segment(5) && is_numeric($this->uri->segment(5))) {
                        $data = $this->db->where('Id', $this->uri->segment(5))->get($body['backndData']->table)->result_array();
                        if (empty($data)) {
                            $this->response->json(["status" => "error", "message" => "Sorry We Can't Find The Data"]);
                        }
                        $this->response->json(["status" => "ok", "data" => $data[0]]);
                    } else {
                        $this->response->json(["status" => "error", "message" => "Sorry We Have An unexpected error"]);
                    }
                } else { // Showing The Browser Page
                    $body['results'] = $this->db->get($body['backndData']->table)->result_array();
                    $this->load->view('EN/SuperAdmin/Resources-Managment', $body);
                }
            } else if ($this->input->method() == "post") {
                // Creating New Data
                $this->load->library('form_validation');
                foreach ($body['backndData']->inputs as $column) {
                    $this->form_validation->set_rules($column->input, $column->validation[0], $column->validation[1]);
                }
                if ($this->form_validation->run()) {
                    // settingup the data
                    $inputs = [];
                    foreach ($body['backndData']->inputs as $column) {
                        $inputs[$column->input] = $this->input->post($column->input);
                    }
                    // inserting The Data
                    try {
                        // check if update or insert request
                        if ($this->input->post('activeKey') && is_numeric($this->input->post('activeKey'))) { // update
                            $this->db->where('Id', $this->input->post('activeKey'))->set($inputs)->update($body['backndData']->table);
                        } else { // insert
                            $this->db->insert($body['backndData']->table, $inputs);
                        }
                        $this->response->json(["status" => "ok"]);
                    } catch (Throwable $th) {
                        $this->response->json(["status" => "error", "message" => "Sorry We Have An unexpected error"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "message" => validation_errors()]);
                }
            } else if ($this->input->method() == "delete") { // Deleting 
                try {
                    if ($this->input->input_stream('key') && is_numeric($this->input->input_stream('key'))) { // single Delete
                        $this->db->where('Id', $this->input->input_stream('key'))->delete($body['backndData']->table);
                        $this->response->json(["status" => "ok"]);
                    } else if ($this->input->input_stream('keys') && gettype($this->input->input_stream('keys')) == "array") { // Multiple Delete
                        $this->db->where_in('Id', $this->input->input_stream('keys'))->delete($body['backndData']->table);
                        $this->response->json(["status" => "ok"]);
                    } else {
                        $this->response->json(["status" => "error", "message" => "Sorry We Have An unexpected error"]);
                    }
                } catch (Throwable $th) {
                    $this->response->json(["status" => "error", "message" => "Sorry We Have An unexpected error"]);
                }
            }
        } else { // show links
            $data['links'] = $this->resources->links();
            $data['EnableSearch'] = true;
            $this->load->view('EN/Global/Links/Lists', $data);
        }
        $this->load->view('EN/inc/footer');
    }
} //end extand     