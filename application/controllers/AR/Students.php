<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Students extends CI_Controller
{
    public $schoolid = 0;
    public $userdata = 0;
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || empty($sessiondata) || $sessiondata['level'] !== 3 || $sessiondata['type'] !== "Student") {
            redirect('AR/users');
            exit();
        } else {
            $userdata = $this->db->get_where('l2_student', ['Id' => $sessiondata['admin_id']])->result_array();
            if (!empty($userdata)) {
                $this->userdata = $userdata;
                $this->schoolid = $userdata[0]['Added_By'];
            } else {
                redirect('AR/users');
                exit();
            }
        }
    }

    public function Home()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Dashboard';
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/students/Home');
        $this->load->view('AR/inc/footer');
    }

    public function Mylifereports()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Dashboard';
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == 'get') {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && !$this->uri->segment(5)) {
                $data['show'] = 2;
                $data['id'] = $this->uri->segment(4);
                $data['groups'] = $this->db->get_where('sv_set_template_lifereports_choices', ['group_id' => $data['id']])->result_array();
            } elseif ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5))) {
                $data["show"] = 3;
                $data['group'] = $this->uri->segment(4);
                $data['choice'] = $this->uri->segment(5);
            } else {
                $data['show'] = 1;
                $data['groups'] = $this->db->get('sv_set_template_lifereports')->result_array();
            }
            $this->load->view('AR/inc/header', $data);
            $this->load->view('AR/students/Mylifereports');
            $this->load->view('AR/inc/footer');
        } elseif ($this->input->method() == "post") {
            //Mylifereports
            $this->load->library('form_validation');
            $this->form_validation->set_rules('description_en', 'description en', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('description_ar', 'description ar', 'trim|required|min_length[10]');
            if ($this->form_validation->run()) {
                $data = [
                    "group_id" => $this->input->post('groupid'),
                    "type_id" => $this->input->post('choiceid'),
                    "user_id" => $sessiondata['admin_id'],
                    "description_en" => $this->input->post('description_en'),
                    "description_ar" => $this->input->post('description_ar'),
                ];
                if ($this->db->insert('l3_mylifereports', $data)) {
                    $this->response->json(["status" => "ok", "id" => $this->db->insert_id()]);
                } else {
                    $this->response->json(["status" => "error"]);
                }
            } else {
                $this->response->json(["status" => "error", "errors" => validation_errors()]);
            }
        }
    }

    public function Mylifereportsmedia()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "post") {
            if (!empty($_FILES['file']['name'])) {
                // Set preference
                $config['upload_path'] = './uploads/Mylifereportsmedia/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|mp3';
                $config['max_size']    = '30000'; // max_size in kb
                $config['encrypt_name']  = true;
                //Load upload library
                $this->load->library('upload', $config);
                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $data = [
                        "report_id" => $this->uri->segment(4),
                        "file" => $uploadData['file_name']
                    ];
                    $this->db->insert('l3_mylifereportsmedia', $data);
                } else {
                    http_response_code(500);
                    foreach ($this->upload->display_errors() as $key => $error) {
                        echo $error;
                    }
                }
            }
        } elseif ($this->input->method() == "get") {
            $data['page_title'] = 'Qlick Health | Dashboard';
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $data['sessiondata'] = $sessiondata;
                $data['id'] = $this->uri->segment(4);
                $this->load->view('AR/inc/header', $data);
                $this->load->view('AR/students/Mylifereportsmedia');
                $this->load->view('AR/inc/footer');
            } else {
                redirect('/AR/Students/Home');
            }
        }
    }

    public function aboutus()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Dashboard';
        $data['sessiondata'] = $sessiondata;
        $this->load->view('AR/inc/header', $data);
        $this->load->view('AR/students/aboutus');
        $this->load->view('AR/inc/footer');
    }

    public function Profile()
    {
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && $this->uri->segment(4) == "edite") {
                // load edite pages
                echo "هل أنت متأكد من التعديل؟";
            } else {
                $sessiondata = $this->session->userdata('admin_details');
                $data['sessiondata'] = $sessiondata;
                $data['page_title'] = " Qlick Health | My Profile ";
                $user_data = $this->db->query(" SELECT `l2_student`.* , Link , `l1_school`.`School_Name_AR` AS Schoolname
                FROM `l2_student` 
                LEFt JOIN `l2_avatars` ON `l2_avatars`.`For_User` = '" . $sessiondata['admin_id'] . "' AND `l2_avatars`.`Type_Of_User` = 'Student'
                JOIN `l1_school` ON `l1_school`.`Id` = `l2_student`.`Added_by` 
                WHERE `l2_student`.Id = '" . $sessiondata['admin_id'] . "' LIMIT 1 ")->result_array();
                if (!empty($user_data)) {
                    $data['all_user_data'] = $user_data[0];
                    $data['user_gender'] = $user_data[0]['Gender'] == '1' ? '1' : '2';
                    $data['school_id'] = $user_data[0]['Added_By'];
                    $data['Class'] = $user_data[0]['Class'];
                    $data['school_name'] = $user_data[0]['Schoolname'];
                    $data['student_name'] = $user_data[0]['F_name_AR'] . ' ' . $user_data[0]['L_name_AR'];
                    $data['img_url'] = $user_data[0]['Link'] == "" ? "default_avatar.jpg" : $user_data[0]['Link'];
                } else {
                    $this->load->library('session');
                    session_destroy();
                    redirect('AR/users');
                }
                $data['contriesarray'] = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();
                $data['rerquest_type'] = "view";
                $this->load->view("AR/inc/header", $data);
                $this->load->view("AR/students/Profile");
                $this->load->view("AR/inc/footer");
            }
        } else {
            $this->load->library('form_validation');
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            // setting the conditions
            $this->form_validation->set_rules('f_n_e', 'First Name EN', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('f_n_a', 'First Name AR', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('m_n_e', 'Middle Name EN', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('m_n_a', 'Middle Name AR', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('l_n_e', 'Last Name EN', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('l_n_a', 'Last Name AR', 'trim|required|min_length[3]|max_length[200]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|max_length[15]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required|in_list[1,2]|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required|prep_for_form|encode_php_tags');
            $this->form_validation->set_rules('DOP', 'Date Of bearth', 'trim|required|exact_length[10]|prep_for_form|encode_php_tags');
            if ($this->form_validation->run()) {
                // setteng data
                $this->db->set('F_name_EN', $this->input->post('f_n_e'));
                $this->db->set('F_name_AR', $this->input->post('f_n_a'));
                $this->db->set('M_name_EN', $this->input->post('m_n_e'));
                $this->db->set('M_name_AR', $this->input->post('m_n_a'));
                $this->db->set('L_name_EN', $this->input->post('l_n_e'));
                $this->db->set('L_name_AR', $this->input->post('l_n_a'));
                $this->db->set('Phone', $this->input->post('phone'));
                $this->db->set('Gender', $this->input->post('Gender'));
                $this->db->set('Email', $this->input->post('email'));
                $this->db->set('Nationality', $this->input->post('Nationality'));
                $this->db->set('DOP', $this->input->post('DOP'));
                $this->db->where('Id', $sessiondata['admin_id']);
                //  UPDATE data
                if ($this->db->update('l2_student')) {
                    echo "ok";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function Dashboard()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dashboard ";
        $data['records'] = $this->db->query("SELECT * , l3_student_dashboard.Id as id FROM `l3_student_dashboard`
        JOIN `l3_student_dashboard_standards` ON `l3_student_dashboard_standards`.`Id` = `l3_student_dashboard`.`value_type`
        WHERE student_id = '" . $sessiondata['admin_id']."' ")->result_array();
        $this->load->view("AR/inc/header", $data);
        $this->load->view("AR/students/Dashboard");
        $this->load->view("AR/inc/footer");
    }

    public function Videos()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Videos ";
        $data['videos'] = $this->db->get_where('l3_videos', ['by_school' => $this->schoolid])->result_array();
        $this->load->view("AR/inc/header", $data);
        $this->load->view("AR/Global/l3_school/Videos");
        $this->load->view("AR/inc/footer");
    }

    public function Show_surveys()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_student', array('Id' => $sessiondata['admin_id']), 1)->result_array();
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['Gender'] == '1' ? '1' : '2';
            $school_id = $user_data[0]['Added_By'];
            $Class = $user_data[0]['Class'];
        } else {
            $this->load->library('session');
            print_r($user_data);
            session_destroy();
            redirect('AR/users');
        }
        $today = date('Y-m-d');
        $data['fillable_surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_fillable_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_ar` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_fillable_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_st_themes`.`image_name` AS image_link
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' 
        AND `sv_st1_surveys`.`Status` = '1' 
        AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '2' AND `survey_type` = 'fillable' ) 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Student' AND `sv_school_published_surveys`.`status` = '1'  
        AND `sv_school_published_fillable_surveys_targetedusers`.`user_id` = '" . $sessiondata['admin_id'] . "' 
        AND `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        $data['surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_ar` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st_themes`.`image_name` AS image_link
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '2'
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN `sv_school_published_surveys_levels` ON `sv_school_published_surveys_levels`.`Survey_id` = `sv_school_published_surveys`.`Id` AND `sv_school_published_surveys_levels`.`Level_code` = '" . $Class . "'
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_school_published_surveys`.`status` = '1' AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '2' ) 
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        $this->load->view("AR/inc/header", $data);
        $this->load->view("AR/Global/l3_school/Show_avalaible_surveys");
        $this->load->view("AR/inc/footer");
    }

    public function start_private_survey()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $serv_id = $this->uri->segment(4);
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`Message_ar` AS Message,
            `sv_st_fillable_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
            JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' ")->result_array();
            if (!empty($data['serv_data'])) {
                $data['serv_theme'] = $data['serv_data'][0]['serv_theme'];
                $data['serv_img'] = $data['serv_data'][0]['image_name'];
                $data['serv_id'] = $serv_id;
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['page_title'] = " Qlick Health | start survey ";
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_fillable_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_fillable_questions`.`Id` AS q_id
                FROM `sv_st_fillable_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_fillable_questions`.`question_id`
                WHERE `survey_id` = '" . $group . "' AND  `sv_st_fillable_questions`.`Group_id` = '0' ")->result_array();
                $data['questions_counter'] = 0;
                $this->load->view("AR/inc/header", $data);
                $this->load->view("AR/Global/l3_school/start_private_survey");
                $this->load->view("AR/inc/footer");
            }
        } elseif ($this->input->method() == "post") {
            $errors = array(); // errors of validation
            if (sizeof($this->input->post("answers")) == $this->input->post('questions')) {
                $answers = $this->input->post('answers');
                // validaton each answer
                foreach ($answers as $q_id => $answer) {
                    $answers[$q_id] = urldecode(htmlspecialchars(trim($answer)));
                    if (empty($answer)) {
                        $errors[$q_id] = "Please answer this question";
                    } elseif (strlen($answer) < 3) {
                        $errors[$q_id] = "Your answer is very short";
                    } elseif (strlen($answer) > 1000) {
                        $errors[$q_id] = "Your answer is very Long";
                    }
                }
                if (!empty($errors)) {
                    $this->response->json(["status" => "validation_error", "errors" => $errors]);
                } else {
                    // when the answers accepted
                    $started_at = new DateTime($this->input->get('time'));
                    $now = new DateTime(date('H:i:s'));
                    $timediff = $started_at->diff($now);
                    $finished_at_s = $timediff->h . ':' . $timediff->i . ':' . $timediff->s;
                    $finished_at = date("H:i:s", strtotime($finished_at_s));
                    $answers_data = array(
                        'user_id'         => $sessiondata['admin_id'],
                        'user_type'       => '2', // mean parent
                        'finishing_time'  => $finished_at,
                        'serv_id'         => $this->input->get('serv'),
                        "survey_type"     => "fillable"
                    );
                    if ($this->db->insert('sv_st1_answers', $answers_data)) {
                        $answers_id = $this->db->insert_id();
                        $savinganswers = array();
                        foreach ($answers as $q_id => $theanswer) {
                            $savinganswers[] = array(
                                "QuestionId"     => $q_id,
                                "answer_Value"   => $theanswer,
                                "answer_data_id" => $answers_id
                            );
                        }
                        if ($this->db->insert_batch('sv_st1_fillable_answers_values', $savinganswers)) {
                            $this->response->json(["status" => "ok"]);
                        } else {
                            $this->response->json(["status" => "error", "message" => "we have unexpected error !"]);
                        }
                    } else {
                        $this->response->json(["status" => "error", "message" => "we have unexpected error !"]);
                    }
                }
            }
        }
    }

    public function start_survey()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $serv_id = $this->uri->segment(4);
                $data['serv_id'] = $serv_id;
                $data['page_title'] = " Qlick Health | start survey ";
                $data['serv_data'] = $this->db->query(" SELECT 
                `sv_st1_surveys`.`title_ar` AS Title_ar,
                `sv_st_surveys`.`Message_ar` AS Message,
                `sv_st_surveys`.`answer_group_en` AS group_id ,
                `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
                `sv_st_surveys`.`Id` AS main_survey_id ,
                `sv_st_themes`.`file_name` AS serv_theme ,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_st_themes`.`image_name` AS image_name 
                FROM `sv_st1_surveys` 
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
                JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
                WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' ")->result_array();
                if (!empty($data['serv_data'])) {
                    $data['serv_theme'] = $data['serv_data'][0]['serv_theme'];
                    $data['serv_img'] = $data['serv_data'][0]['image_name'];
                    $group = $data['serv_data'][0]['main_survey_id'];
                    $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                    $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                    FROM `sv_st_questions`
                    INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                    WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' ")->result_array();
                    $group_coices = $data['serv_data'][0]['group_id'];
                    $data['choices'] = $this->db->query("SELECT `title_ar` AS title,`Id` FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                    $this->load->view("AR/inc/header", $data);
                    $this->load->view("AR/Global/l3_school/start_survey");
                    $this->load->view("AR/inc/footer");
                } else {
                    $this->load->view('AR/Global/accessForbidden');
                }
            } else {
                redirect('AR/Students/Show_surveys');
            }
        } elseif ($this->input->method() == "post") {
            $counter_questions = $this->input->post("choices") - 1;
            $answers_counter = sizeof($this->input->post()) - 2;
            if ($counter_questions == $answers_counter) {
                $started_at = new DateTime($this->input->get('time'));
                $now = new DateTime(date('H:i:s'));
                $timediff = $started_at->diff($now);
                $finished_at_s = $timediff->h . ':' . $timediff->i . ':' . $timediff->s;
                $finished_at = date("H:i:s", strtotime($finished_at_s));
                $answers_data = array(
                    'user_id'         => $sessiondata['admin_id'],
                    'user_type'       => '2', // mean parent
                    'finishing_time'  => $finished_at,
                    'serv_id'         => $this->input->get('serv'),
                );
                if ($this->db->insert('sv_st1_answers', $answers_data)) {
                    $this->db->select('Id');
                    $this->db->where('user_id', $sessiondata['admin_id']);
                    $this->db->where('serv_id', $this->input->get('serv'));
                    $this->db->order_by('Id', 'DESC');
                    $this->db->limit(1);
                    $answer_data_id = $this->db->get('sv_st1_answers')->result_array();
                    $answers_id = $answer_data_id[0]['Id'];
                    $all_questions = $this->input->post();
                    unset($all_questions['choices']);
                    unset($all_questions['showname']);
                    $answers = array();
                    foreach ($all_questions as $question) {
                        $__question = explode('_', $question);
                        $choice_id   = $__question[0];
                        $question_id = $__question[1];
                        $answers[] = array(
                            "choice_id"       => $choice_id,
                            "question_id"     => $question_id,
                            "answers_data_id" => $answers_id,
                        );
                    }
                    if ($this->db->insert_batch('sv_st1_answers_values', $answers)) {
                        echo "ok";
                    }
                }
            } else {
                echo "Please be Sure to Answer all Questions";
            }
        }
    }


    public function Surveys_history()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_student', array('Id' => $sessiondata['admin_id']))->result_array();
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['Gender'] == '1' ? '1' : '2';
            $school_id = $user_data[0]['Added_By'];
        } else {
            $this->load->library('session');
            print_r($user_data);
            session_destroy();
            redirect('AR/users');
        }
        $data['surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_ar` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '2'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '2') 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC LIMIT 20 ")->result_array();
        $data['private_surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_fillable_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_ar` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_fillable_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_st_themes`.`image_name` AS image_link ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' AND `sv_st1_surveys`.`Status` = '1' 
        AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '2' AND `survey_type` = 'fillable' ) 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Student'  
        AND `sv_school_published_fillable_surveys_targetedusers`.`user_id` = '" . $sessiondata['admin_id'] . "' 
        AND `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        $this->load->view("AR/inc/header", $data);
        $this->load->view("AR/Global/l3_school/Show_surveys_history");
        $this->load->view("AR/inc/footer");
    }
    
    public function About_us()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | About us ';
        $data['sessiondata'] = $sessiondata;
        $user_data = $this->db->get_where('l2_student', array('Id' => $sessiondata['admin_id']))->result_array();
        if (!empty($user_data)) {
            $school_id = $user_data[0]['Added_By'];
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('AR/users');
        }
        $data['data'] = $this->db->query("SELECT `Ar_title` AS Title , `Ar_article` AS text , `ar_image` AS img
        FROM l3_about_us WHERE `school_id` = '" . $school_id . "' AND `targeted_users` = 'students' ")->result_array();
        $this->load->view('AR/inc/header', $data);
        $this->load->view("AR/Global/l3_school/about_us");
        $this->load->view('AR/inc/footer');
    }
}