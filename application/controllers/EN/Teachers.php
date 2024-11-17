<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Teachers extends CI_Controller
{

    public $schoolid = 0;
    public $userdata = 0;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || empty($sessiondata) || $sessiondata['level'] !== 3 || $sessiondata['type'] !== "Teacher") {
            redirect('EN/users');
            exit();
        } else {
            $userdata = $this->db->get_where('l2_teacher', ['Id' => $sessiondata['admin_id']])->result_array();
            if (!empty($userdata)) {
                $this->userdata = $userdata;
                $this->schoolid = $userdata[0]['Added_By'];
            } else {
                redirect('EN/users');
                exit();
            }
        }
    }

    public function Dashboard()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dashboard ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/teachers/Dashboard");
        $this->load->view("EN/inc/footer");
    }


    public function Show_surveys()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_teacher', array('Id' => $sessiondata['admin_id']), 1)->result_array();
        $teacherClasses = $this->schoolHelper->teacherClasses($sessiondata['admin_id']);
        $teacherClasses = implode(',' , array_column($teacherClasses , "class_Key"));
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['Gender'] == '1' ? '1' : '2';
            $school_id = $user_data[0]['Added_By'];
        } else {
            $this->load->library('session');
            print_r($user_data);
            session_destroy();
            redirect('EN/Users');
        }
        $today = date('Y-m-d');
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
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' 
        AND `sv_st1_surveys`.`Status` = '1' 
        AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '3' AND `survey_type` = 'fillable' ) 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'teacher' AND `sv_school_published_surveys`.`status` = '1' 
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN `sv_school_published_surveys_levels` ON `sv_school_published_surveys_levels`.`Survey_id` = `sv_school_published_surveys`.`Id` AND `sv_school_published_surveys_levels`.`Level_code` IN (" . $teacherClasses . ")
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_school_published_surveys`.`status` = '1' AND NOT EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '3' )
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
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
                        'user_type'       => '3', // mean parent
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
                    ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                    $group_coices = $data['serv_data'][0]['group_id'];
                    $data['choices'] = $this->db->query("SELECT `title_en` as title ,`Id` FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                    $this->load->view("EN/inc/header", $data);
                    $this->load->view("EN/Global/l3_school/start_survey");
                    $this->load->view("EN/inc/footer");
                } else {
                    echo "no data found";
                }
            } else {
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
                    'user_type'       => '3', // mean parent
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
                // echo "counter_questions : ".$counter_questions;
                // echo "answers_counter : ".$answers_counter;
                echo "please be sure to answer all the questions";
            }
        }
    }

    public function Surveys_history()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_teacher', array('Id' => $sessiondata['admin_id']), 1)->result_array();
        if (!empty($user_data)) {
            $user_gender = $user_data[0]['Gender'] == '1' ? '1' : '2';
            $school_id = $user_data[0]['Added_By'];
        } else {
            $this->load->library('session');
            print_r($user_data);
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '3' ) 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC LIMIT 20 ")->result_array();
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
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $school_id . "
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' AND `sv_st1_surveys`.`Status` = '1' 
        AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `sv_st1_answers`.`user_type` = '3' AND `survey_type` = 'fillable' ) 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'teacher'  
        AND `sv_school_published_fillable_surveys_targetedusers`.`user_id` = '" . $sessiondata['admin_id'] . "' 
        AND `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Show_surveys_history");
        $this->load->view("EN/inc/footer");
    }

    public function Home()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Home ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/teachers/Home");
        $this->load->view("EN/inc/footer");
    }

    public function Videos()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Videos ";
        $data['videos'] = $this->db->get_where('l3_videos', ['by_school' => $this->schoolid])->result_array();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Videos");
        $this->load->view("EN/inc/footer");
    }

    public function Profile()
    {
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && $this->uri->segment(4) == "edite") {
                // load edite pages
                echo "You want to edit your self ????";
            } else {
                $sessiondata = $this->session->userdata('admin_details');
                $data['sessiondata'] = $sessiondata;
                $data['page_title'] = " Qlick Health | My Profile ";
                $user_data = $this->db->query(" SELECT `l2_teacher`.* , Link , `l1_school`.`School_Name_EN` AS Schoolname
                FROM `l2_teacher` 
                LEFt JOIN `l2_avatars` ON `l2_avatars`.`For_User` = '" . $sessiondata['admin_id'] . "' AND `l2_avatars`.`Type_Of_User` = 'Teacher'
                JOIN `l1_school` ON `l1_school`.`Id` = `l2_teacher`.`Added_by` 
                WHERE `l2_teacher`.Id = '" . $sessiondata['admin_id'] . "' LIMIT 1 ")->result_array();
                if (!empty($user_data)) {
                    $data['all_user_data'] = $user_data[0];
                    $data['user_gender'] = $user_data[0]['Gender'] == '1' ? '1' : '2';
                    $data['school_id'] = $user_data[0]['Added_By'];
                    $data['school_name'] = $user_data[0]['Schoolname'];
                    $data['student_name'] = $user_data[0]['F_name_EN'] . ' ' . $user_data[0]['L_name_EN'];
                    $data['img_url'] = $user_data[0]['Link'] == "" ? "default_avatar.jpg" : $user_data[0]['Link'];
                } else {
                    $this->load->library('session');
                    session_destroy();
                    redirect('EN/Users');
                }
                $data['contriesarray'] = $this->db->query('SELECT * FROM `r_countries` ORDER BY `name` ASC')->result_array();
                $data['rerquest_type'] = "view";
                $this->load->view("EN/inc/header", $data);
                $this->load->view("EN/teachers/Profile");
                $this->load->view("EN/inc/footer");
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
                if ($this->db->update('l2_teacher')) {
                    echo "ok";
                }
            } else {
                echo validation_errors();
            }
        }
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
        AND `sv_dedicated_surveys`.`User_id` = '" . $sessiondata['admin_id'] . "' AND `sv_dedicated_surveys`.`usertype`  = 'teacher' GROUP BY `sv_dedicated_surveys`.`Id` ")->result_array();
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
        if($this->input->method() == "get"){
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
                AND `sv_dedicated_surveys`.`User_id` = '" . $sessiondata['admin_id'] . "' AND `sv_dedicated_surveys`.`usertype`  = 'teacher' AND `sv_dedicated_surveys`.`Id` = '" . $id . "' ")->result_array();
                if (!empty($data['survey_data'])) {
                    $data['serv_id'] = $id;
                    $data['students'] = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name 
                    FROM `l2_student` WHERE EXISTS (SELECT Id FROM `sv_dedicated_surveys_students` 
                    WHERE `sv_dedicated_surveys_students`.`survey_request` = '" . $id . "' AND `sv_dedicated_surveys_students`.`student_id` = `l2_student`.`Id` )
                    AND NOT EXISTS (SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '".$id."' AND User_id = '".$sessiondata['admin_id'] . "' AND  Student_id = l2_student.Id )")->result_array();    
                    if ($this->uri->segment(5)) {
                        $student_id = $this->uri->segment(5);
                        $answers = $this->db->query("SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '".$id."' AND User_id = '".$sessiondata['admin_id'] . "' AND  Student_id = '".$student_id."' ")->result_array();
                        if(empty($answers)){
                            $data['user_data'] = $this->db->query("SELECT concat(F_name_EN , ' ', M_name_EN , ' ' , L_name_EN) AS name , DOP , Gender
                            FROM `l2_student` WHERE Id = '" . $student_id . "' ")->result_array()[0] ?? redirect('EN/teachers/DedicatedSurveys/' . $id);
                            $group = $data['survey_data'][0]['main_survey_id'];
                            $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                            $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                            FROM `sv_st_questions`
                            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                            WHERE `survey_id` = '" . $group . "' AND  `sv_st_questions`.`Group_id` = '0' ")->result_array();
                            $group_coices = $data['survey_data'][0]['group_id'];
                            $data['choices'] = $this->db->query("SELECT `title_en` as title ,`Id` FROM `sv_set_template_answers_choices`
                            WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                        }else{
                            redirect('EN/teachers/DedicatedSurvey/' . $id);
                        }
                    }
                    $this->load->view("EN/inc/header", $data);
                    $this->load->view("EN/Global/l3_school/StartDedicatedSurvey");
                    $this->load->view("EN/inc/footer");
                } else {
                    redirect('EN/teachers/DedicatedSurveys');
                }
            } else {
                redirect('EN/teachers/DedicatedSurveys');
            }
        }else if ($this->input->method() == "post"){
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
                        'User_type'       => 'teacher', // mean parent
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
                        AND NOT EXISTS (SELECT Id FROM `sv_dedicated_surveys_answers` WHERE Survey_id = '".$this->uri->segment(4)."' AND User_id = '".$sessiondata['admin_id'] . "' AND  Student_id = l2_student.Id )")->num_rows(); 
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
                        }else{
                            echo "Sorry, an unexpected error occurred.";
                        }
                    }
                }
            }else{ 
                echo "error";
            }
        }
    }

    public function About_us()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | About us ';
        $data['sessiondata'] = $sessiondata;
        $user_data = $this->db->get_where('l2_teacher', array('Id' => $sessiondata['admin_id']))->result_array();
        if (!empty($user_data)) {
            $school_id = $user_data[0]['Added_By'];
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('EN/Users');
        }

        $data['data'] = $this->db->query("SELECT `En_title` AS Title , `En_article` AS text , `en_image` AS img
        FROM l3_about_us WHERE `school_id` = '".$school_id."' AND `targeted_users` = 'teachers' ")->result_array();
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
        $this->load->view('EN/teachers/aboutus');
        $this->load->view('EN/inc/footer');
    }
}
