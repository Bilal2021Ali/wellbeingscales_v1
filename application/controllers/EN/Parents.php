<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Parents extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || empty($sessiondata) || $sessiondata['level'] !== 2 || $sessiondata['type'] !== "Parent") {
            redirect('EN/users');
            exit();
        } else {
            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https:/" : "http:/";
            $CurPageURL = $protocol . "/" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $link = str_replace(base_url(), "", $CurPageURL);
            if (!$sessiondata['regestred'] && $sessiondata['level'] == 2 && $sessiondata['type'] == "Parent" && $link !== "EN/Parents/Register") {
                redirect('EN/Parents/Register');
            }
        }
    }

    public function Dashboard()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dashboard ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Parent/Dashboard");
        $this->load->view("EN/inc/footer");
    }

    public function Select_Child()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Enter Result ";
        $data['hasntnav'] = true;
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Parent/Select_Child");
        $this->load->view("EN/inc/footer");
    }

    public function Register()
    {
        if ($this->input->method() == "get") {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Register ";
            $data['hasntnav'] = true;
            $this->load->view("EN/inc/header", $data);
            $this->load->view("EN/Parent/Register");
            $this->load->view("EN/inc/footer");
        } elseif ($this->input->method() == "post") {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name_en', 'en name', 'trim|required|max_length[200]|min_length[3]');
            $this->form_validation->set_rules('name_ar', 'ar name', 'trim|required|max_length[200]|min_length[3]');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('gender', 'gender', 'trim|required|in_list[male,female]');
            if ($this->form_validation->run()) {
                $gender = $this->input->post('gender') == "male" ? 1 : 2;
                $data = array(
                    'login_key' => $sessiondata['login_id'],
                    'name_en'   => $this->input->post('name_en'),
                    'name_ar'   => $this->input->post('name_ar'),
                    'DOP'       => $this->input->post('DOP'),
                    'gender'    => $gender,
                );
                if ($this->db->insert('l2_parents', $data)) {
                    $this->db->select_max('Id');
                    $last_user = $this->db->get('l2_parents')->result_array();
                    $last_id = $last_user[0]['Id'];
                    $sess_array  = array(
                        'username'  => $sessiondata['username'],
                        'login_id'  => $sessiondata['login_id'],
                        'admin_id'  => $last_id,
                        'type'      => 'Parent',
                        'regestred' =>  true,
                        'level'     => 2,
                    );
                    $this->session->set_userdata('admin_details', $sess_array);
                    $new_sessiondata = $this->session->userdata('admin_details');
                    echo "ok";
                } else {
                    echo "Sorry we have error , please try again !";
                }
            } else {
                echo validation_errors();
            }
        }
    }


    public function Show_surveys()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_parents', array('Id' => $sessiondata['admin_id']))->result_array();
        $students_arr = $this->db->query(" SELECT Added_By FROM `l2_student`
        WHERE Parent_NID = '" . $sessiondata['username'] . "' ")->result_array();
        $students_schools = implode(',', array_column($students_arr, 'Added_By'));
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['gender'];
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('EN/Users');
        }
        $today = date('Y-m-d');
        if (!empty($students_schools)) {
            $data['fillable_surveys'] = $this->db->query(" SELECT
            `sv_school_published_surveys`.`Id` AS survey_id,
            `sv_school_published_surveys`.`Created` AS Created_date,
            `sv_st_fillable_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st_fillable_surveys`.`Message_en` AS Message,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_fillable_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_st_themes`.`image_name` AS image_link
            FROM `sv_st1_surveys`
            JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
            JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND `sv_school_published_surveys`.`By_school` in (" . $students_schools . ")
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link` 
            AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '4' AND `survey_type` = 'fillable' ) 
            AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
            WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Parent' AND `sv_school_published_surveys`.`status` = '1'
            AND `sv_school_published_fillable_surveys_targetedusers`.`user_id` = '" . $sessiondata['admin_id'] . "' 
            AND `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_school_published_surveys`.`survey_type` = 'fillable' 
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();

            $data['surveys'] = $this->db->query(" SELECT
            `sv_school_published_surveys`.`Id` AS survey_id,
            `sv_school_published_surveys`.`Created` AS Created_date,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` in (" . $students_schools . ")
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '4'
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_school_published_surveys`.`status` = '1' AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '4' )
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC ")->result_array();
        } else {
            $data['fillable_surveys'] = array();
            $data['surveys'] = array();
        }
        //echo $this->db->last_query();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Show_avalaible_surveys");
        $this->load->view("EN/inc/footer");
    }


    public function start_private_survey()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $serv_id = $this->uri->segment(4);
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_fillable_surveys`.`Message_en` AS Message,
            `sv_st_fillable_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_surveys` 
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
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_fillable_groups` WHERE `serv_id` = '" . $group . "'
                ORDER BY `sv_st_fillable_groups`.`position` ASC")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_fillable_questions`.`Id` AS q_id
                FROM `sv_st_fillable_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_fillable_questions`.`question_id`
                WHERE `survey_id` = '" . $group . "' AND  `sv_st_fillable_questions`.`Group_id` = '0' 
                ORDER BY `sv_st_fillable_questions`.`position` ASC")->result_array();
                $data['questions_counter'] = 0;
                $this->load->view("EN/inc/header", $data);
                $this->load->view("EN/Global/l3_school/start_private_survey");
                $this->load->view("EN/inc/footer");
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
                        'user_type'       => '4', // mean parent
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
                `sv_st1_surveys`.`title_en` AS Title_en,
                `sv_st_surveys`.`Message_en` AS Message,
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
                    $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "' 
                    ORDER BY `sv_st_groups`.`position` ASC")->result_array();
                    $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                    FROM `sv_st_questions`
                    INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                    WHERE `survey_id` = '" . $group . "' AND  `sv_st_questions`.`Group_id` = '0'
                    ORDER BY `sv_st_questions`.`position` ASC ")->result_array();
                    $group_coices = $data['serv_data'][0]['group_id'];
                    $data['choices'] = $this->db->query("SELECT `title_en` AS title,`Id` FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                    $this->load->view("EN/inc/header", $data);
                    $this->load->view("EN/Global/l3_school/start_survey");
                    $this->load->view("EN/inc/footer");
                }
            } else {
                echo $this->uri->segment(4);
                redirect('EN/Parents/Show_surveys');
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
                    'user_type'       => '4', // mean parent
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
                echo "counter_questions : " . $counter_questions;
                echo "answers_counter : " . $answers_counter;

                echo "please be sure to answer all the questions";
            }
        }
    }


    public function Surveys_history()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_parents', array('Id' => $sessiondata['admin_id']), 1)->result_array();
        $students_arr = $this->db->query(" SELECT Added_By FROM `l2_student`
        WHERE Parent_NID = '" . $sessiondata['username'] . "' ")->result_array();
        $students_schools = implode(',', array_column($students_arr, 'Added_By'));
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['gender'];
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('EN/Users');
        }
        $data['surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` in (" . $students_schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '4'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '4' )
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC LIMIT 20  ")->result_array();
        $data['private_surveys'] = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_fillable_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_fillable_surveys`.`Message_en` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_fillable_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_st_themes`.`image_name` AS image_link ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` in (" . $students_schools . ")
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' AND `sv_st1_surveys`.`Status` = '1' 
        AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '4' AND `survey_type` = 'fillable' ) 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Parent'  
        AND `sv_school_published_fillable_surveys_targetedusers`.`user_id` = '" . $sessiondata['admin_id'] . "' 
        AND `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Show_surveys_history");
        $this->load->view("EN/inc/footer");
    }

    public function Profile()
    {
        if ($this->input->method() == "get") {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['page_title'] = " Qlick Health | Register ";
            $data['hasntnav'] = true;
            $data['request_for'] = 'update';
            $data['user_data'] = $this->db->get_where('l2_parents', array('Id' => $sessiondata['admin_id']), 1)->result_array()[0];
            $this->load->view("EN/inc/header", $data);
            $this->load->view("EN/Parent/Register");
            $this->load->view("EN/inc/footer");
        } elseif ($this->input->method() == "post") {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name_en', 'en name', 'trim|required|max_length[200]|min_length[3]');
            $this->form_validation->set_rules('name_ar', 'ar name', 'trim|required|max_length[200]|min_length[3]');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('gender', 'gender', 'trim|required|in_list[male,female]');
            if ($this->form_validation->run()) {
                $gender = $this->input->post('gender') == "male" ? 1 : 2;
                $data = array(
                    'login_key' => $sessiondata['login_id'],
                    'name_en'   => $this->input->post('name_en'),
                    'name_ar'   => $this->input->post('name_ar'),
                    'DOP'       => $this->input->post('DOP'),
                    'gender'    => $gender,
                );
                $this->db->set('name_en', $this->input->post('name_en'));
                $this->db->set('name_ar', $this->input->post('name_ar'));
                $this->db->set('DOP', $this->input->post('DOP'));
                $this->db->set('gender', $gender);
                $this->db->where('Id', $sessiondata['admin_id']);
                if ($this->db->update('l2_parents')) {
                    echo "ok";
                } else {
                    echo "Sorry we have error , please try again !";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    // old code 
    public function StartAddResults()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $symptoms = $this->input->post("symptoms");
        $Templatur = $this->input->post("Temp");
        $time_HS = date('H:i:s');
        if (is_array($symptoms)) {
            $symptomsVal = "";
            foreach ($symptoms as $symptom) {
                $symptomsVal .= $symptom . ";";
            }
        } else {
            $symptomsVal = $symptoms;
        }
        $User_Id = $sessiondata['admin_id'];
        $type = $sessiondata['type'];
        $today =  date("Y-m-d");
        $time =  date("Y-m-d");
        if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Symptoms`, `Created`,`Time`) VALUES ('" . $User_Id . "', '" . $type . "', '" . $Templatur . "', '" . $symptomsVal . "', '".date('Y-m-d')."','" . $time_HS . "');")) { ?>
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: ' Successfuly Inserted !! ',
                    icon: 'success',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php }
    }


    public function StartAddResultsForstudent()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $symptoms = $this->input->post("symptoms");
        $Templatur = $this->input->post("Temp");
        $time_HS = date('H:i:s');
        if (is_array($symptoms)) {
            $symptomsVal = "";
            foreach ($symptoms as $symptom) {
                $symptomsVal .= $symptom . ";";
            }
        } else {
            $symptomsVal = $symptoms;
        }
        $User_Id = $this->input->post("Stud_Id");
        $type = "Student";
        print_r($sessiondata);
        $today =  date("Y-m-d");
        if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Added_By`, `Result`, `Symptoms`, `Created`, `Time`) VALUES ('" . $User_Id . "', '" . $type . "','" . $sessiondata['username'] . "' , '" . $Templatur . "', 
          '" . $symptomsVal . "', '".date('Y-m-d')."','" . $time_HS . "');")) { ?>
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: ' Successfuly Inserted !! ',
                    icon: 'success',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php }
    }


    public function AddResultForStaff()
    {
        $id = $this->input->post("UserId");
        $testtype = $this->input->post("Test_type");
        $Templatur = $this->input->post("Temp");
        $time_HS = date('H:i:s');
        if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test` ,`Created`,`Time`) 
          VALUES ( '" . $id . "', 'Staff' , '" . $Templatur . "', '" . $testtype . "' ,'".date('Y-m-d')."','" . $time_HS . "');")) {
            //$this->db2_first_action($id,'Staff');
        ?>
            <script>
                $("#TrStafffId<?php echo $id; ?>").addClass("AddedSuccess");
                $("#TrStafffId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
                setTimeout(function() {
                    $("#TrStafffId<?php echo $id; ?>").slideUp();
                }, 1000);
            </script>
        <?php } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
            <?php }
    }

    /*public function db2_first_action(){
		  $this->load->model('Test_db2');	   
		  $this->Test_db2->sync_two_databases();	   
}*/

    public function AddCovidResult()
    {
        $id = $this->input->post("UserId");
        $Usertype = $this->input->post("Test_type");
        $Templatur = $this->input->post("Temp");
        $Device_Id = $this->input->post("Device");
        $Device_batch = $this->input->post("Batch");
        $test = $this->input->post("Test");
        //$Test_Description = $Device_array['2'];

        //print_r($Device_array);
        $time_HS = date('H:i:s');
        if (!empty($Device_Id)) {
            if ($this->db->query("INSERT INTO `l2_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
		  `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
          VALUES ( '" . $id . "', '" . $Usertype . "' , '" . $Templatur . "' , '" . $Device_Id . "' , '" . $Device_batch . "' , 
		  '" . $test . "' ,'".date('Y-m-d')."','" . $time_HS . "');")) { ?>
                <script>
                    $("#<?php echo $Usertype . '_' . $id; ?>").addClass("AddedSuccess");
                    $("#<?php echo $Usertype . '_' . $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
                    setTimeout(function() {
                        $("#<?php echo $Usertype . '_' . $id; ?>").slideUp();
                    }, 1000);
                </script>
            <?php } else { ?>
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ooops! An error was encountered.',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                </script>
            <?php }
        } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
            <?php
        }
    }

    public function AddCovidResult_Co()
    {
        $id = $this->input->post("UserId");
        $Usertype = $this->input->post("Test_type");
        $Templatur = $this->input->post("Temp");
        $Device_Id = $this->input->post("Device");
        $Device_batch = $this->input->post("Batch");
        $test = $this->input->post("Test");
        //$Test_Description = $Device_array['2'];
        //print_r($Device_array);

        $time_HS = date('H:i:s');
        if (!empty($Device_Id)) {
            if ($this->db->query("INSERT INTO `l2_co_labtests` (`UserId`, `UserType`, `Result`, `Device_Test` , 
		  `Device_Batch` , `Test_Description` ,`Created`,`Time`) 
          VALUES ( '" . $id . "', '" . $Usertype . "' , '" . $Templatur . "' , '" . $Device_Id . "' , '" . $Device_batch . "' , 
		  '" . $test . "' ,'".date('Y-m-d')."','" . $time_HS . "');")) { ?>
                <script>
                    $("#<?php echo $Usertype . '_' . $id; ?>").addClass("AddedSuccess");
                    $("#<?php echo $Usertype . '_' . $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
                    setTimeout(function() {
                        $("#<?php echo $Usertype . '_' . $id; ?>").slideUp();
                    }, 1000);
                </script>
            <?php } else { ?>
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ooops! An error was encountered.',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                </script>
            <?php }
        } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php
        }
    }


    public function AddResultForTeacher()
    {
        $id = $this->input->post("UserId");
        $Templatur = $this->input->post("Temp");
        $time_HS = date('H:i:s');
        $dev_type = $this->input->post("Test_type");
        if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test` , `Created`,`Time`) 
          VALUES ( '" . $id . "', 'Teacher' , '" . $Templatur . "', '" . $dev_type . "' ,'".date('Y-m-d')."','" . $time_HS . "');")) { ?>
            <script>
                $("#TrTeacherId<?php echo $id; ?>").addClass("AddedSuccess");
                $("#TrTeacherId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
                setTimeout(function() {
                    $("#TrTeacherId<?php echo $id; ?>").slideUp();
                }, 1000);
            </script>
        <?php } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
        <?php }
    }

    public function AddResultForStudent()
    {
        $id = $this->input->post("UserId");
        $Templatur = $this->input->post("Temp");
        $DevType = $this->input->post("ST_Type");
        $time_HS = date('H:i:s');
        if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Device_Test`,`Created`,`Time`) 
          VALUES ( '" . $id . "', 'Student' , '" . $Templatur . "', '" . $DevType . "' ,'".date('Y-m-d')."','" . $time_HS . "');")) { ?>
            <script>
                $("#TrStudId<?php echo $id; ?>").addClass("AddedSuccess");
                $("#TrStudId<?php echo $id; ?>").html("<th></th><th>Added Successfully!</th><th></th><th></th>");
                setTimeout(function() {
                    $("#TrStudId<?php echo $id; ?>").slideUp();
                }, 1000);
            </script>
        <?php } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Ooops! An error was encountered.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
            <?php }
    }

    public function AddResultForPatients()
    {
        if ($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")) {
            $id = $this->input->post("UserId");
            $Templatur = $this->input->post("Temp");
            $prefx = $this->input->post("prefix");
            $time = date('H:i:s');
            if ($this->db->query("INSERT INTO `l2_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
          VALUES ( '" . $id . "', '" . $prefx . "' , '" . $Templatur . "', '".date('Y-m-d')."','" . $time . "');")) { ?>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: ' Successfuly Inserted !! ',
                        icon: 'success',
                        confirmButtonColor: '#5b8ce8',
                        timer: 1000,
                    });

                    $('#TrId<?php echo $id; ?>').remove();
                </script>
            <?php } else { ?>
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ooops! An error was encountered.',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                </script>
            <?php }
        } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Kindly enter data.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
            <?php    }
    }
    public function AddResultForCoPatients()
    {
        if ($this->input->post("UserId") && $this->input->post("Temp") && $this->input->post("prefix")) {
            $id = $this->input->post("UserId");
            $Templatur = $this->input->post("Temp");
            $prefx = $this->input->post("prefix");
            $time = date('H:i:s');
            if ($this->db->query("INSERT INTO `l2_co_gateway_result` (`UserId`, `UserType`, `Result`, `Created`,`Time`) 
            VALUES ( '" . $id . "', '" . $prefx . "' , '" . $Templatur . "', '".date('Y-m-d')."','" . $time . "');")) { ?>
                <script>
                    $('#TrId<?php echo $id; ?>').remove();
                </script>
            <?php } else { ?>
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ooops! An error was encountered.',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8',
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                </script>
            <?php }
        } else { ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Kindly enter data.',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8',
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            </script>
            <?php    }
    }

    public function SelectByPrefix_co()
    {
        if ($this->input->post("Pref")) {
            $sessiondata = $this->session->userdata('admin_details');
            $pef = $this->input->post("Pref");
            $Added_By = $sessiondata['admin_id'];
            if ($pef == "ref") {
                //co_machine
                $list = $this->db->query(" SELECT * FROM `co_machine`
			  JOIN 
			  WHERE `Added_By` = '" . $Added_By . "' ")->result_array();
                if (empty($list)) {
            ?>
                    <div class="card-body">
                        <div class="card-title text-center"> sorry we don't have any data !! </div>
                    </div>
                <?php  } else { ?>
                    <div class="card-body">
                        <div class="card-title text-center"> users list
                            <hr>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> img</th>
                                    <th> name </th>
                                    <th> user type </th>
                                    <th> input </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 0;
                                foreach ($list as $refg) {
                                    $sn++;
                                ?>
                                    <tr id="TrId<?php echo $refg['Id']; ?>">
                                        <th scope="row">
                                            <?php echo $sn; ?>
                                        </th>
                                        <td>
                                            <?php echo $refg['name'] ?>
                                        </td>
                                        <td><?php echo $refg['type']; ?></td>
                                        <td>
                                            <form class="AddResultPatient">
                                                <input type="number" class="form-control form-control-sm" placeholder=" result " name="Temp" value="37">
                                                <input type="hidden" value="<?php echo $refg['Id']; ?>" name="UserId">
                                                <input type="hidden" value="<?php echo $pef; ?>" name="prefix">
                                            </form>
                                        </td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                        <script>
                            $(".AddResultPatient").on('focusout', function(e) {
                                e.preventDefault();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>EN/Results/AddResultForCoPatients',
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(data) {
                                        $('.JHZLNS').html(data);
                                    },
                                    ajaxError: function() {
                                        Swal.fire(
                                            'error',
                                            'oops!! we have a error',
                                            'error'
                                        )
                                    }
                                });
                            });
                        </script>
                    </div>
                <?php  }
            } else {
                $list = $this->db->query("SELECT * FROM `l2_co_patient` WHERE `UserType` = '" . $pef . "'
          AND Added_By = '" . $Added_By . "' ")->result_array();
                if (empty($list)) { ?>
                    <div class="card-body">
                        <div class="card-title text-center"> sorry we don't have any data !! </div>
                    </div>
                <?php } else { ?>
                    <div class="card-body">
                        <div class="card-title text-center"> users list
                            <hr>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> img </th>
                                    <th> name </th>
                                    <th> Natoinal id </th>
                                    <th> user type </th>
                                    <th> input </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 0;
                                foreach ($list as $admin) {
                                    $sn++;
                                ?>
                                    <tr id="TrId<?php echo $admin['Id']; ?>">
                                        <td style="width: 20px;">
                                            <?php
                                            $avatar = $this->db->query("SELECT * FROM `l2_co_avatars`
							 WHERE `For_User` = '" . $admin['Id'] . "' AND `Type_Of_User` = '" . $admin["UserType"] . "' LIMIT 1 ")->result_array();
                                            ?>
                                            <?php if (empty($avatar)) {  ?>
                                                <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>uploads/co_avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo $admin['F_name_EN'] . ' ' . $admin['M_name_EN'] . ' ' . $admin['L_name_EN']; ?>
                                        </td>
                                        <td><?php echo $admin['National_Id']; ?></td>
                                        <td><?php echo $admin['UserType']; ?></td>
                                        <td>
                                            <form class="AddResultPatient">
                                                <input type="number" class="form-control form-control-sm" placeholder=" result " name="Temp" value="37">
                                                <input type="hidden" value="<?php echo $admin['Id']; ?>" name="UserId">
                                                <input type="hidden" value="<?php echo $pef; ?>" name="prefix">
                                            </form>
                                        </td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                        <script>
                            $(".AddResultPatient").on('focusout', function(e) {
                                e.preventDefault();
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>EN/Results/AddResultForCoPatients',
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(data) {
                                        $('.JHZLNS').html(data);
                                    },
                                    ajaxError: function() {
                                        Swal.fire(
                                            'error',
                                            'oops!! we have a error',
                                            'error'
                                        )
                                    }
                                });
                            });
                            $("table").DataTable();
                        </script>
                    </div>
        <?php }
            }
        }
    }




    public function Batch_Counter()
    {
        $devicedata = $this->input->post("Device");
        $Device_array = explode('@', $devicedata);
        $Device_batch = $Device_array['1'];
        $count = $this->db->query("SELECT * FROM `l2_labtests` WHERE Device_Batch = '" . $Device_batch . "' ")->num_rows();
        echo $count;
    }


    public function GetResultsCounterFor()
    {
        $type = $this->input->post('TeatsType');
        ?>
        <div class="col-xl-12">
            <div class="card-body" style="border-radius: 5px;border: 3px solid #0eacd8;padding: 9px;">
                <h4 class="card-title"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Lab_Counter.png" style="width: 25px;margin: auto 5px;"> <?php echo $type; ?></h4>
            </div>
        </div>
        <div class="col-md-4 col-xl-4 text-center">
            <div class="card notStatic">
                <div class="card-body" style="padding: 5px;">
                    <div class="card-body badge-soft-danger" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #f57d6a;">
                        <div>
                            <div class="row">
                                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                    <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/positive.png" alt="Temperature" style="width: 70px;margin-top: 5px;">
                                </div>
                                <div class="col-xl-8">
                                    <p class="mb-0 badge badge-danger font-size-12" style="width: 103px;">Positive (+)</p>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?php echo $this->GetTotal('1', $type, 'Home') ?></span>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;">Quarantine <?php echo $this->GetTotal('1', $type, 'Quarantine') ?></span>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;">No Action <?php echo $this->GetTotal('1', $type, 'School') ?></span>
                                </div>
                                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                    <h4 class="mb-1 mt-1">
                                        <span data-plugin="counterup"><?php echo $this->GetTotal('1', $type) ?></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-4 text-center">
            <div class="card notStatic">
                <div class="card-body" style="padding: 5px;box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);">
                    <div class="card-body badge-soft-success" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #34ccc7;">
                        <div>
                            <div class="row">
                                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                    <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/negative.png" alt="Temperature" style="width: 70px;margin-top: 5px;">
                                </div>
                                <div class="col-xl-8">
                                    <p class="mb-0 badge badge-success font-size-12" style="width: 103px;">Negative (-)</p>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #172b88;color: #fff;margin: 5px auto;display: block;">Stay Home <?php echo $this->GetTotal('0', $type, 'Home') ?></span>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #ff0000;color: #fff;margin: 5px auto;display: block;">Quarantine <?php echo $this->GetTotal('0', $type, 'Quarantine') ?></span>
                                    <span class="badge font-size-12" style="width: 104px;background-color: #34c38f;color: #fff;margin: 5px auto;display: block;">No Action <?php echo $this->GetTotal('0', $type, 'School') ?></span>
                                </div>
                                <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                    <h4 class="mb-1 mt-1">
                                        <span data-plugin="counterup"><?php echo $this->GetTotal('0', $type) ?></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-4 text-center">
            <div class="card notStatic">
                <div class="card-body" style="padding: 5px">
                    <div class="card-body badge-soft-info" style="height: 130px;display: grid;align-items: center;border-radius: 5px;border: 3px solid #50a5f1;">
                        <div class="row">
                            <div class="col-xl-2" style="text-align: center;align-items: center;display: grid;">
                                <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/pandemic-128.png" alt="Temperature" style="width: 50px;margin-top: 5px;">
                            </div>
                            <div class="col-xl-8">
                                <h4 class="mb-1 mt-1">
                                    <span data-plugin="counterup"><?php echo $this->GetTotal_Not($type); ?></span>
                                </h4>
                                <p class="mb-0 badge badge-info font-size-12" style="width: 103px;">No Tests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        //print_r($this->input->post());
    }



    private function GetTotal($where, $type, $action = "")
    {
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();

        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];

            if (!empty($action)) {
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }

            foreach ($getResults as $results) {
                $counter++;
            }
        }

        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
            $T_ID = $Teacher['Id'];
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            foreach ($getResultsT as $results) {
                $counter++;
            }
        }

        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurStudents as $Student) {
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Result` = '" . $where . "' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            foreach ($getResultsT as $results) {
                $counter++;
            }
        }

        return ($counter);
    }

    private function GetTotal_Not($type, $action = "")
    {
        $counter = 0;
        //$this->load->library( 'session' ); 
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();

        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];

            if (!empty($action)) {
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Test_Description` = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Staff' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResults)) {
                $counter++;
            }
        }

        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
            $T_ID = $Teacher['Id'];
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Test_Description` = '" . $type . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Teacher'  AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResultsT)) {
                $counter++;
            }
        }

        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurStudents as $Student) {
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student'  AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
     AND Created = '" . $today . "' AND UserType = 'Student' AND `Test_Description` = '" . $type . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResultsT)) {
                $counter++;
            }
        }

        return ($counter);
    }


    private function data_of_dept_co($sessiondata, $device)
    {
        $ci = &get_instance();
        $list = array();
        $today = date("Y-m-d");

        $Ourstaffs = $ci->db->query("SELECT * FROM l2_co_patient 
WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();

        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];
            $Position_Staff = $staff['Position'];
            $type = $staff['UserType'];

            $lastresult = $ci->db->query(" SELECT * FROM l2_co_result  WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` = '" . $device . "' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
            $first_result = $ci->db->query("SELECT * FROM l2_co_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` = '" . $device . "' ORDER BY `Id` ASC LIMIT 1 ")->result_array();


            if (!empty($lastresult) && !empty($first_result)) {
                $list[] = array(
                    "Username" => $staffname, "Id" => $ID, "LastResult" => $lastresult[0]['Result'], "FirstResult" => $first_result[0]['Result'],
                    'position' => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
                    "last_result_Creat" => $lastresult[0]['Created'], "last_result_time" => $lastresult[0]['Time']
                );
            }
        }

        return ($list);
    }




    private function data_of_user($type, $sessiondata, $device)
    {
        $ci = &get_instance();
        $list = array();
        $today = date("Y-m-d");

        if ($type == "Staff") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        } elseif ($type == "Teacher") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        } elseif ($type == "Student") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        }

        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];
            $Position_Staff = $staff['Position'];

            $lastresult = $ci->db->query(" SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' AND `Device` = '" . $device . "' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
            $first_result = $ci->db->query("SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass'  AND `Device` = '" . $device . "' ORDER BY `Id` ASC LIMIT 1 ")->result_array();


            //foreach($getResults as $results){
            //$creat = $results['Created'].' '.$results['Time'];

            if (!empty($lastresult) && !empty($first_result)) {
                $list[] = array(
                    "Username" => $staffname, "Id" => $ID, "LastResult" => $lastresult[0]['Result'], "FirstResult" => $first_result[0]['Result'],
                    'position' => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
                    "last_result_Creat" => $lastresult[0]['Created'], "last_result_time" => $lastresult[0]['Time']
                );
            }

            //} 
        }
        return ($list);
    }



    private function data_of_user_by_id($type, $sessiondata, $id)
    {
        $ci = &get_instance();
        $list = array();
        $today = date("Y-m-d");

        if ($type == "Staff") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
        } elseif ($type == "Teacher") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_teacher WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
        } elseif ($type == "Student") {
            $Ourstaffs = $ci->db->query("SELECT * FROM l2_student WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();
        }


        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];
            $Position_Staff = $staff['Position'];

            $lastresult = $ci->db->query(" SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "' 
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' 
AND `Device` != '' ORDER BY `Id` DESC ")->result_array();
            $first_result = $ci->db->query("SELECT * FROM l2_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND Added_By = 'Smart GateWay' OR Added_by = 'SmartPass' 
AND `Device` != '' ORDER BY `Id` ASC  ")->result_array();


            //foreach($getResults as $results){
            //$creat = $results['Created'].' '.$results['Time'];

            $our_devices = $this->db->query(" SELECT * FROM `l2_devices` ")->result_array();

            if (!empty($lastresult) && !empty($first_result)) {
                foreach ($lastresult as $reslt) {
                    $deviceData = $this->db->query(" SELECT * FROM `l2_devices` WHERE `D_Id` = '" . $reslt['Device'] . "' ")->result_array();

                    $Device_desc = "";
                    $Site = "";

                    if (!empty($deviceData)) {
                        $Device_desc = $deviceData[0]['Description'];
                        $Site = $deviceData[0]['Site'];
                    }

                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID, "LastResult" => $reslt['Result'], "FirstResult" => $first_result[0]['Result'],
                        "position" => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
                        "last_result_Creat" => $reslt['Created'], "last_result_time" => $reslt['Time'], "Device_desc" => $Device_desc,
                        "Site" => $Site
                    );
                }
                /*
echo sizeof($lastresult);
	print_r($lastresult);
*/
            }

            //} 
        }
        return ($list);
    }

    private function data_of_user_by_id_for_co($type, $sessiondata, $id)
    {
        $ci = &get_instance();
        $list = array();
        $today = date("Y-m-d");

        $Ourstaffs = $ci->db->query("SELECT * FROM `l2_co_patient` WHERE
`Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $id . "' LIMIT 1 ")->result_array();


        foreach ($Ourstaffs as $staff) {
            $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
            $ID = $staff['Id'];
            $Position_Staff = $staff['Position'];

            $lastresult = $ci->db->query(" SELECT * FROM l2_co_history_result WHERE `UserId` = '" . $staff['Id'] . "' 
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` != '' ORDER BY `Id` DESC ")->result_array();
            $first_result = $ci->db->query("SELECT * FROM l2_co_history_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Created = '" . $today . "' AND UserType = '" . $type . "' AND `Device` != '' ORDER BY `Id` ASC  ")->result_array();


            //foreach($getResults as $results){
            //$creat = $results['Created'].' '.$results['Time'];

            $our_devices = $this->db->query(" SELECT * FROM `l2_co_devices` ")->result_array();

            if (!empty($lastresult) && !empty($first_result)) {
                foreach ($lastresult as $reslt) {
                    $deviceData = $this->db->query(" SELECT * FROM `l2_co_devices` WHERE `D_Id` = '" . $reslt['Device'] . "' ")->result_array();

                    $Device_desc = "";
                    $Site = "";

                    if (!empty($deviceData)) {
                        $Device_desc = $deviceData[0]['Description'];
                        $Site = $deviceData[0]['Site'];
                    }

                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID, "LastResult" => $reslt['Result'], "FirstResult" => $first_result[0]['Result'],
                        "position" => $Position_Staff, "first_result_Creat" => $first_result[0]['Created'], "first_result_time" => $first_result[0]['Time'],
                        "last_result_Creat" => $reslt['Created'], "last_result_time" => $reslt['Time'], "Device_desc" => $Device_desc,
                        "Site" => $Site
                    );
                }
                /*
echo sizeof($lastresult);
	print_r($lastresult);
*/
            }

            //} 
        }
        return ($list);
    }

    private function symps($symps)
    {
        $ci = &get_instance();
        $Symps_array = explode(';', $symps);
        $sz =  sizeof($Symps_array);
        //print_r($Symps_array);  
        if ($sz > 1) {
            foreach ($Symps_array as $sympsArr) {
                //print_r($sympsArr);
                //echo sizeof($Symps_array);
                $SempName = $ci->db->query("SELECT * FROM `r_symptoms` WHERE `code` = '" . $sympsArr . "'")->result_array();
                foreach ($SempName as $name) {
                    echo $name['symptoms_EN'] . ",";
                }
            }
        } else {
            echo "No Symptoms Found ";
        }
    }

    public function boxes_Colors($result, $risk = "")
    {
    ?>
        <style>
            .Td-Results_font span {
                font-size: 20px !important;
                padding: 6px;
            }

            .Td-Results .badge {
                padding: 6px;
            }
        </style>

        <td class="Td-Results_font">
            <?php if ($result >= 38.50 && $result <= 45.00) { ?>
                <!-- Hight Bilal 26 Dec 2020 -->
                <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"> <?php echo $result; ?> </span>
            <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
                <!-- Moderate -->
                <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"> <?php echo $result; ?> </span>
            <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
                <!-- No Risk -->
                <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"> <?php echo $result; ?></span>
            <?php } elseif ($result <= 36.20) { ?>
                <!-- Low -->
                <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"> <?php echo $result; ?> </span>
            <?php } elseif ($result > 45) { ?>
                <!-- Error -->
                <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"> <?php echo $result; ?> </span>
            <?php } ?>
        </td>

        <?php if (empty($risk)) { ?>
            <td class="Td-Results">
                <?php if ($result >= 38.50 && $result <= 45.00) { ?>
                    <span class="badge error" style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">عالي</span>
                    <!-- Hight Bilal 26 Dec 2020 -->
                <?php } elseif ($result >= 37.60 && $result <= 38.40) { ?>
                    <span class="badge" style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">معتدل</span>
                    <!-- Moderate -->
                <?php } elseif ($result >= 36.30 && $result <= 37.50) { ?>
                    <span class="badge" style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">طبيعي</span>
                <?php } elseif ($result <= 36.20) { ?>
                    <!-- Low -->
                    <span class="badge" style="width: 100%;border-radius: 10px;background: #cdfc00;color: #3B3B3B;">منخفض</span>
                <?php } elseif ($result > 45) { ?>
                    <!-- Error -->
                    <span class="badge" style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">قراءة خاطئة</span>
                <?php } ?>
            </td>
        <?php  } ?>

        <?php
    }


    public function getResultsbyDevice()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        if ($this->form_validation->run()) {
            $device = $this->input->post("type");
            $Staff_list = $this->data_of_user("Staff", $sessiondata, $device);
            $Student_list = $this->data_of_user("Student", $sessiondata, $device);
            $Teacher_list = $this->data_of_user("Teacher", $sessiondata, $device);

        ?>
            <div class="container">

                <div class="control_results col-md-12" style="padding-bottom: 15px;">
                    <button type="button" form_target="Staff_list_results" class="btn btn-primary w-md contr_btn">
                        <i class="uil uil-list"></i>Staff
                    </button>

                    <button type="button" form_target="Teachers_list_results" class="btn w-md contr_btn">
                        <i class="uil uil-list"></i>Teacher
                    </button>
                    <button type="button" form_target="Studnts_list_results" class="btn w-md contr_btn">
                        <i class="uil uil-list"></i>Student
                    </button>
                </div>
                <!-- end control -->

                <div class="row formcontainer_results" id="Staff_list_results">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Staff </h4>
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <?php $title_in = "Time in" ?>
                                        <?php $title_out = "Time out" ?>
                                        <tr>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> First Result </th>
                                            <th> Last Result </th>
                                            <th> <?php echo $title_in; ?> </th>
                                            <th> <?php echo $title_out ?> </th>
                                            <th> Total </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($Staff_list as $staffsRes) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                        <?php echo $staffsRes['position']; ?></p>
                                                </td>
                                                <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                                                <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                                                <td><?php echo $staffsRes['first_result_time'] ?></td>
                                                <td><?php echo $staffsRes['last_result_time'] ?></td>
                                                <td>
                                                    <?php
                                                    $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row formcontainer_results" id="Studnts_list_results">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Students </h4>
                                <div class="students_button"></div>
                                <table id="Students_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> First Result </th>
                                            <th> Last Result </th>
                                            <th> <?php echo $title_in; ?> </th>
                                            <th> <?php echo $title_out ?> </th>
                                            <th> Total </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Student_list as $studentResults) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $studentResults['Id'] . "' AND
											 `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal">
                                                        <?php echo $studentResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $studentResults['position']; ?></p>
                                                </td>
                                                <?php $this->boxes_Colors($studentResults['FirstResult'], "Show"); ?>
                                                <?php $this->boxes_Colors($studentResults['LastResult'], "Show"); ?>
                                                <td><?php echo $studentResults['first_result_time'] ?></td>
                                                <td><?php echo $studentResults['last_result_time'] ?></td>
                                                <td>
                                                    <?php
                                                    $this->between($studentResults['first_result_time'], $studentResults['last_result_time']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row formcontainer_results" id="Teachers_list_results">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Teachers </h4>
                                <table id="Teacher_table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> First Result </th>
                                            <th> Last Result </th>
                                            <th> <?php echo $title_in; ?> </th>
                                            <th> <?php echo $title_out ?> </th>
                                            <th> Total </th>
                                        </tr>
                                    </thead>



                                    <tbody>
                                        <?php foreach ($Teacher_list as $TeacherResults) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $TeacherResults['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal">
                                                        <?php echo $TeacherResults['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i> <?php echo $TeacherResults['position']; ?></p>
                                                </td>
                                                <?php $this->boxes_Colors($TeacherResults['FirstResult'], "Show"); ?>
                                                <?php $this->boxes_Colors($TeacherResults['LastResult'], "Show"); ?>
                                                <td><?php echo $TeacherResults['first_result_time'] ?></td>
                                                <td><?php echo $TeacherResults['last_result_time'] ?></td>
                                                <td>
                                                    <?php
                                                    $this->between($TeacherResults['first_result_time'], $TeacherResults['last_result_time']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <script>
                $('#Teachers_list_results').hide();
                $('#Studnts_list_results').hide();

                $('#Staff_list_results').show();

                $('.control_results button').click(function() {
                    $('.control_results button').removeClass('btn-primary');
                    $(this).addClass('btn-primary');
                    $('.formcontainer_results').hide();
                    var to = $(this).attr('form_target');
                    $('#' + to).show();
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    title: ' Sorry.',
                    text: 'Error was found. Please try again later.',
                    icon: 'error'
                });
            </script>
        <?php
        }
    }


    public function getResultsbyDevice_co()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        if ($this->form_validation->run()) {
            $device = $this->input->post("type");
            $Staff_list = $this->data_of_dept_co($sessiondata, $device);
        ?>
            <div class="container">
                <div class="row formcontainer_results" id="Staff_list_results">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Results </h4>
                                <table id="data_results" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <?php $title_in = "Time in" ?>
                                        <?php $title_out = "Time out" ?>
                                        <tr>
                                            <th> Img </th>
                                            <th> Name </th>
                                            <th> First Result </th>
                                            <th> Last Result </th>
                                            <th> <?php echo $title_in; ?> </th>
                                            <th> <?php echo $title_out ?> </th>
                                            <th> Total </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($Staff_list as $staffsRes) { ?>

                                            <tr>
                                                <td style="width: 20px;">
                                                    <?php
                                                    $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                    WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                    ?>
                                                    <?php if (empty($avatar)) {  ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                        <?php echo $staffsRes['position']; ?></p>
                                                </td>
                                                <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                                                <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                                                <td><?php echo $staffsRes['first_result_time'] ?></td>
                                                <td><?php echo $staffsRes['last_result_time'] ?></td>
                                                <td>
                                                    <?php
                                                    $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <script>
                var table_st = $('#data_results').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis'],
                });
                table_st.buttons().container().appendTo('#data_results_wrapper .col-md-6:eq(0)');

                $('#Teachers_list_results').hide();
                $('#Studnts_list_results').hide();

                $('#Staff_list_results').show();

                $('.control_results button').click(function() {
                    $('.control_results button').removeClass('btn-primary');
                    $(this).addClass('btn-primary');
                    $('.formcontainer_results').hide();
                    var to = $(this).attr('form_target');
                    $('#' + to).show();
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    title: ' Sorry.',
                    text: 'Error was found. Please try again later.',
                    icon: 'error'
                });
            </script>
            <?php
        }
    }

    public function getResultsbyname()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post("name");
            $name_tree = explode(" ", $name);
            if (sizeof($name_tree) >= 3) {
                $user_q = $this->db->query(" SELECT Id FROM `l2_staff` WHERE 
		  `F_name_EN` = '" . $name_tree[0] . "' AND `M_name_EN` = '" . $name_tree[1] . "'
		  AND `L_name_EN` = '" . $name_tree[2] . "' ")->result_array();
                if (empty($user_q)) {
                    $user_q = $this->db->query(" SELECT Id FROM `l2_teacher` WHERE 
		  `F_name_EN` = '" . $name_tree[0] . "' AND `M_name_EN` = '" . $name_tree[1] . "'
		  AND `L_name_EN` = '" . $name_tree[2] . "' ")->result_array();
                    $usertype = "Teacher";
                    if (empty($user_q)) {
                        $user_q = $this->db->query(" SELECT Id FROM `l2_student` WHERE 
		  `F_name_EN` = '" . $name_tree[0] . "' AND `M_name_EN` = '" . $name_tree[1] . "'
		  AND `L_name_EN` = '" . $name_tree[2] . "' ")->result_array();
                        $usertype = "Student";
                    }
                } else {
                    $usertype = "Staff";
                }
            }

            if (isset($usertype) && !empty($user_q)) {
                $id = $user_q[0]['Id'];
                $userdata = $this->data_of_user_by_id($usertype, $sessiondata, $id);
            }
            if (!empty($userdata)) {
            ?>
                <div class="container">

                    <!-- end control -->
                    <div class="row formcontainer">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> Data For : <?php echo $name; ?> </h4>
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> Img </th>
                                                <th> Name </th>
                                                <th> First Result </th>
                                                <th> Last Result </th>
                                                <th> Time in </th>
                                                <th> Time out </th>
                                                <th> Total </th>
                                                <th> Site </th>
                                                <th> Device Desc </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($userdata as $staffsRes) { ?>

                                                <tr>
                                                    <td style="width: 20px;">
                                                        <?php

                                                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                        ?>
                                                        <?php if (empty($avatar)) {  ?>
                                                            <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                            <?php echo $staffsRes['position']; ?></p>
                                                    </td>
                                                    <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                                                    <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                                                    <td><?php echo $staffsRes['first_result_time'] ?></td>
                                                    <td><?php echo $staffsRes['last_result_time'] ?></td>
                                                    <td>
                                                        <?php
                                                        $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                                                        ?>
                                                    </td>
                                                    <td><?php echo $staffsRes['Site']; ?></td>
                                                    <td><?php echo $staffsRes['Device_desc']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            <?php
            } else { ?>
                <script>
                    Swal.fire({
                        title: ' Sorry.',
                        text: ' No data was found for this user. Please try again later. ',
                        icon: 'error'
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: ' Sorry.',
                    text: 'Error was found. Please try again later.',
                    icon: 'error'
                });
            </script>
            <?php
        }
    }



    public function Home()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Home ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Parent/Home");
        $this->load->view("EN/inc/footer");
    }

    public function Videos()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Videos ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Parent/Videos");
        $this->load->view("EN/inc/footer");
    }


    public function getResultsbyname_co()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post("name");
            $name_tree = explode(" ", $name);
            if (sizeof($name_tree) >= 3) {

                $user_q = $this->db->query(" SELECT Id,UserType FROM `l2_co_patient` WHERE 
		  `F_name_EN` = '" . $name_tree[0] . "' AND `M_name_EN` = '" . $name_tree[1] . "'
		   AND `L_name_EN` = '" . $name_tree[2] . "' LIMIT 1 ")->result_array();
                if (!empty($user_q)) {
                    $usertype = $user_q[0]['UserType'];
                }
            }

            if (isset($usertype) && !empty($user_q)) {
                $id = $user_q[0]['Id'];
                $userdata = $this->data_of_user_by_id_for_co($usertype, $sessiondata, $id);
            }
            if (!empty($user_q)) {
            ?>
                <div class="container">

                    <!-- end control -->
                    <div class="row formcontainer">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> Data For : <?php echo $name; ?> </h4>
                                    <table id="datatable_results" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> Img </th>
                                                <th> Name </th>
                                                <th> First Result </th>
                                                <th> Last Result </th>
                                                <th> Time in </th>
                                                <th> Time out </th>
                                                <th> Total </th>
                                                <th> Site </th>
                                                <th> Device Desc </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($userdata as $staffsRes) { ?>

                                                <tr>
                                                    <td style="width: 20px;">
                                                        <?php

                                                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`
											 WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                                                        ?>
                                                        <?php if (empty($avatar)) {  ?>
                                                            <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <h6 class="font-size-15 mb-1 font-weight-normal"><?php echo $staffsRes['Username']; ?></h6>
                                                        <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i>
                                                            <?php echo $staffsRes['position']; ?></p>
                                                    </td>
                                                    <?php $this->boxes_Colors($staffsRes['FirstResult'], "Show"); ?>
                                                    <?php $this->boxes_Colors($staffsRes['LastResult'], "Show"); ?>
                                                    <td><?php echo $staffsRes['first_result_time'] ?></td>
                                                    <td><?php echo $staffsRes['last_result_time'] ?></td>
                                                    <td>
                                                        <?php
                                                        $this->between($staffsRes['first_result_time'], $staffsRes['last_result_time']);
                                                        ?>
                                                    </td>
                                                    <td><?php echo $staffsRes['Site']; ?></td>
                                                    <td><?php echo $staffsRes['Device_desc']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <script>
                    var table_st = $('#datatable_results').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    });
                    table_st.buttons().container().appendTo('#datatable_results_wrapper .col-md-6:eq(0)');
                </script>
            <?php
            } else { ?>
                <script>
                    Swal.fire({
                        title: ' Sorry.',
                        text: ' No data was found for this user. Please try again later. ',
                        icon: 'error'
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: ' Sorry.',
                    text: 'Error was found. Please try again later.',
                    icon: 'error'
                });
            </script>
<?php
        }
    }

    private function between($f_result_date, $l_result_date)
    {
        // Declare and define two dates 
        $date1 = strtotime($f_result_date);
        $date2 = strtotime($l_result_date);

        // Formulate the Difference between two dates 
        $diff = abs($date2 - $date1);


        // To get the year divide the resultant date into 
        // total seconds in a year (365*60*60*24) 
        $years = floor($diff / (365 * 60 * 60 * 24));


        // To get the month, subtract it with years and 
        // divide the resultant date into 
        // total seconds in a month (30*60*60*24) 
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
            / (30 * 60 * 60 * 24));


        // To get the day, subtract it with years and 
        // months and divide the resultant date into 
        // total seconds in a days (60*60*24) 
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
            $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


        // To get the hour, subtract it with years, 
        // months & seconds and divide the resultant 
        // date into total seconds in a hours (60*60) 
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
            / (60 * 60));


        // To get the minutes, subtract it with years, 
        // months, seconds and hours and divide the 
        // resultant date into total seconds i.e. 60 
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60) / 60);


        // To get the minutes, subtract it with years, 
        // months, seconds, hours and minutes 
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));

        // Print the result 
        /*if($hours !== 0){
	 //echo date("HH:", strtotime($hours));  
	 echo $hours." hour(s), ";
}
	
if($minutes !== 0){
	echo $minutes." second(s) ";
}*/

        $alltime = $hours . ':' . $minutes;
        echo date("H:i", strtotime($alltime));
        /*printf("%d years, %d months, %d days, %d hours, "
	. "%d minutes, %d seconds", $years, $months, 
			$days, $hours, $minutes, $seconds); */
    }


    public function DedicatedSurveys()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dedicated Surveys List";
        $data['surveys'] = $this->db->query("SELECT 
        `sv_dedicated_surveys`.`Id` AS survey_id,
        `sv_dedicated_surveys`.`TimeStamp` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_dedicated_surveys`.`Message` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date, 
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        (SELECT COUNT(Id) FROM `sv_dedicated_surveys_students` WHERE `sv_dedicated_surveys_students`.`survey_request` = `sv_dedicated_surveys`.`Id`) AS students_count
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en` 
        JOIN `sv_dedicated_surveys` ON `sv_dedicated_surveys`.`Survey_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_dedicated_surveys_students` ON `sv_dedicated_surveys_students`.`survey_request` = `sv_dedicated_surveys`.`Id` 
        WHERE `sv_dedicated_surveys`.`completed` = '0' AND `sv_st1_surveys`.`Status` = '1' 
        AND `sv_dedicated_surveys`.`User_id` = '" . $sessiondata['admin_id'] . "' AND `sv_dedicated_surveys`.`usertype`  = 'Parent' GROUP BY `sv_dedicated_surveys`.`Id` ")->result_array();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/DedicatedSurveyList");
        $this->load->view("EN/inc/footer");
    }

    public function DedicatedSurvey()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dedicated Surveys";
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4)) {
                $id = $this->uri->segment(4);
                $data['survey_data'] = $this->db->query("SELECT 
                `sv_dedicated_surveys`.`Id` AS survey_id,
                `sv_dedicated_surveys`.`TimeStamp` AS Created_date,
                `sv_st_surveys`.`Id` AS main_survey_id,
                `sv_st1_surveys`.`Status` AS status,
                `sv_st1_surveys`.`title_en` AS Title_en,
                `sv_st1_surveys`.`title_ar` AS Title_ar,
                `sv_dedicated_surveys`.`Message` AS Message,
                `sv_st1_surveys`.`Startting_date` AS From_date,
                `sv_st1_surveys`.`End_date` AS To_date, 
                `sv_st_surveys`.`answer_group_en` AS group_id,
                `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
                `sv_st_surveys`.`code` AS serv_code,
                `sv_sets`.`title_en` AS set_name_en,
                `sv_sets`.`title_ar` AS set_name_ar ,
                `sv_set_template_answers`.`title_en` AS choices_en_title ,
                `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
                (SELECT COUNT(Id) FROM `sv_dedicated_surveys_students` WHERE `sv_dedicated_surveys_students`.`survey_request` = `sv_dedicated_surveys`.`Id`) AS students_count
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en` 
                JOIN `sv_dedicated_surveys` ON `sv_dedicated_surveys`.`Survey_id` = `sv_st1_surveys`.`Id`
                JOIN `sv_dedicated_surveys_students` ON `sv_dedicated_surveys_students`.`survey_request` = `sv_dedicated_surveys`.`Id` 
                WHERE `sv_dedicated_surveys`.`completed` = '0' AND `sv_st1_surveys`.`Status` = '1' 
                AND `sv_dedicated_surveys`.`User_id` = '" . $sessiondata['admin_id'] . "' AND `sv_dedicated_surveys`.`usertype`  = 'Parent' AND `sv_dedicated_surveys`.`Id` = '" . $id . "' ")->result_array();
                if (!empty($data['survey_data'])) {
                    $data['serv_id'] = $id;
                    $data['students'] = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name 
                    FROM `l2_student` WHERE EXISTS (SELECT Id FROM `sv_dedicated_surveys_students` 
                    WHERE `sv_dedicated_surveys_students`.`survey_request` = '" . $id . "' AND `sv_dedicated_surveys_students`.`student_id` = `l2_student`.`Id` )
                    AND NOT EXISTS (SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '" . $id . "' AND User_id = '" . $sessiondata['admin_id'] . "' AND  Student_id = l2_student.Id )")->result_array();
                    if ($this->uri->segment(5)) {
                        $student_id = $this->uri->segment(5);
                        $answers = $this->db->query("SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '" . $id . "' AND User_id = '" . $sessiondata['admin_id'] . "' AND  Student_id = '" . $student_id . "' ")->result_array();
                        if (empty($answers)) {
                            $data['user_data'] = $this->db->query("SELECT concat(F_name_EN , ' ', M_name_EN , ' ' , L_name_EN) AS name , DOP , Gender
                            FROM `l2_student` WHERE Id = '" . $student_id . "' ")->result_array()[0] ?? redirect('EN/parents/DedicatedSurveys/' . $id);
                            $group = $data['survey_data'][0]['main_survey_id'];
                            $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                            $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                            FROM `sv_st_questions`
                            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                            WHERE `survey_id` = '" . $group . "' AND  `sv_st_questions`.`Group_id` = '0' ")->result_array();
                            $group_coices = $data['survey_data'][0]['group_id'];
                            $data['choices'] = $this->db->query("SELECT `title_en` as title ,`Id` FROM `sv_set_template_answers_choices`
                            WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                        } else {
                            redirect('EN/parents/DedicatedSurvey/' . $id);
                        }
                    }
                    $this->load->view("EN/inc/header", $data);
                    $this->load->view("EN/Global/l3_school/StartDedicatedSurvey");
                    $this->load->view("EN/inc/footer");
                } else {
                    redirect('EN/parents/DedicatedSurveys');
                }
            } else {
                redirect('EN/parents/DedicatedSurveys');
            }
        } else if ($this->input->method() == "post") {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5))) {
                $counter_questions = $this->input->post("choices") - 1;
                $answers_counter = sizeof($this->input->post()) - 1;
                if ($counter_questions == $answers_counter) {
                    $started_at = new DateTime($this->input->get('time'));
                    $now = new DateTime(date('H:i:s'));
                    $timediff = $started_at->diff($now);
                    $finished_at_s = $timediff->h . ':' . $timediff->i . ':' . $timediff->s;
                    $finished_at = date("H:i:s", strtotime($finished_at_s));
                    $answers_data = array(
                        'User_id'         => $sessiondata['admin_id'],
                        'User_type'       => 'Parent', // mean parent
                        'finishing_time'  => $finished_at,
                        'Survey_id'         => $this->uri->segment(4),
                        "Student_id"      => $this->uri->segment(5),
                    );
                    if ($this->db->insert('sv_dedicated_surveys_answers', $answers_data)) {
                        $answers_id = $this->db->insert_id();
                        $all_questions = $this->input->post();
                        unset($all_questions['choices']);
                        // checking if the survey completed
                        $restofstudents = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name 
                        FROM `l2_student` WHERE EXISTS (SELECT Id FROM `sv_dedicated_surveys_students` 
                        WHERE `sv_dedicated_surveys_students`.`survey_request` = '" . $this->uri->segment(4) . "' AND `sv_dedicated_surveys_students`.`student_id` = `l2_student`.`Id` )
                        AND NOT EXISTS (SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '" . $this->uri->segment(4) . "' AND User_id = '" . $sessiondata['admin_id'] . "' AND  Student_id = l2_student.Id )")->num_rows();
                        if ($restofstudents == 0) {
                            $this->db->set('completed', '1');
                            $this->db->where('Id', $this->uri->segment(4));
                            $this->db->update('sv_dedicated_surveys');
                        }
                        $answers = array();
                        foreach ($all_questions as $question) {
                            $__question = explode('_', $question);
                            $choice_id   = $__question[0];
                            $question_id = $__question[1];
                            $answer_value = $__question[2];
                            $answers[] = array(
                                "choice_id"       => $choice_id,
                                "question_id"     => $question_id,
                                "answers_data_id" => $answers_id,
                                "answer_value"    => $answer_value
                            );
                        }
                        if ($this->db->insert_batch('sv_dedicated_surveys_answers_values', $answers)) {
                            echo "ok";
                        } else {
                            echo "Sorry, an unexpected error occurred.";
                        }
                    }
                }
            } else {
            }
        }
    }

    public function About_us()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | About us ';
        $data['sessiondata'] = $sessiondata;
        $user_data = $this->db->get_where('l2_parents', array('Id' => $sessiondata['admin_id']))->result_array();
        $students_arr = $this->db->query(" SELECT Added_By FROM `l2_student`
        WHERE Parent_NID = '" . $sessiondata['username'] . "' ")->result_array();
        $students_schools = implode(',', array_column($students_arr, 'Added_By'));
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['gender'];
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('EN/Users');
        }
        if (!empty($students_schools)) {
            $data['data'] = $this->db->query("SELECT `En_title` AS Title , `En_article` AS text , `en_image` AS img
        FROM l3_about_us WHERE `school_id` IN (" . $students_schools . ") AND `targeted_users` = 'parents' ")->result_array();
        } else {
            $data['data'] = array();
        }
        $this->load->view('EN/inc/header', $data);
        $this->load->view("EN/Global/l3_school/about_us");
        $this->load->view('EN/inc/footer');
    }
	 public function aboutus()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Dashboard';
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        $this->load->view('EN/students/aboutus');
        $this->load->view('EN/inc/footer');
    }
}
