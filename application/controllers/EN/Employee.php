<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Employee extends CI_Controller
{

    public $permissions_array = array();
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!isset($sessiondata) || $sessiondata['level'] !== 3 || $sessiondata['type'] !== 'co_Employee') {
            redirect('users');
            exit();
        }
    }

    public function index()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | Dashboard ";
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/employee/Dashboard");
        $this->load->view("EN/inc/footer");
    }

    public function Show_surveys()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_co_patient', array('Id' => $sessiondata['admin_id']), 1)->row();
        $today = date("Y-m-d");
        if (!empty($user_data)) {
            $user_gender = $user_data->Gender == 'M' ? '1' : '2';
            $data['surveys'] = $this->db->query(" SELECT
            `sv_co_published_surveys`.`Id` AS survey_id,
            `sv_co_published_surveys`.`Created` AS Created_date,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_co_surveys`.`Status` AS status,
            `sv_st1_co_surveys`.`title_en` AS Title_en,
            `sv_st1_co_surveys`.`title_ar` AS Title_ar,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st1_co_surveys`.`Startting_date` AS From_date,
            `sv_st1_co_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
            `sv_st_themes`.`image_name` AS image_link
            FROM `sv_st1_co_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id` AND `sv_st1_co_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_co_surveys`.`End_date` >= '" . $today . "'
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_co_published_surveys` ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $user_data->Added_By . "
            JOIN `sv_co_published_surveys_types` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` AND `sv_co_published_surveys_types`.`Type_code` = " . $user_data->UserType . "
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_co_published_surveys`.`theme_link`
            JOIN `sv_co_published_surveys_genders`  
            ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
            WHERE `sv_co_published_surveys`.`survey_type` = 'notfillable' AND `sv_st1_co_surveys`.`Status` = '1' AND `sv_co_published_surveys`.`status` = '1'
            AND NOT EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' AND `survey_type` = 'notfillable' ) 
            GROUP BY `sv_co_published_surveys`.`Id` ORDER BY `sv_co_published_surveys`.`Id` DESC  ")->result_array();
        } else {
            $this->load->library('session');
            session_destroy();
            redirect('EN/Users');
        }
        $today = date('Y-m-d');
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Show_avalaible_surveys", [
            "usertype" => 'staff'
        ]);
        $this->load->view("EN/inc/footer");
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
                    `sv_st1_co_surveys`.`title_en` AS Title_en,
                    `sv_st_surveys`.`Message_en` AS Message,
                    `sv_st_surveys`.`answer_group_en` AS group_id ,
                    `sv_st_surveys`.`reference_en` ,  `sv_st_surveys`.`reference_ar` ,  `sv_st_surveys`.`disclaimer_en` , `sv_st_surveys`.`disclaimer_ar` ,
                    `sv_st_surveys`.`Id` AS main_survey_id ,
                    `sv_st_themes`.`file_name` AS serv_theme ,
                    `sv_sets`.`title_en` AS set_name_en,
                    `sv_sets`.`title_ar` AS set_name_ar ,
                    `sv_st_themes`.`image_name` AS image_name 
                    FROM `sv_st1_co_surveys` 
                    JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                    JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                    JOIN `sv_co_published_surveys` ON `sv_st1_co_surveys`.`Id` = `sv_co_published_surveys`.`Serv_id`
                    JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_co_published_surveys`.`theme_link`
                    WHERE `sv_co_published_surveys`.`Id` = '" . $serv_id . "' ")->result_array();
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
                    $data['choices'] = $this->db->query("SELECT `title_en` AS title ,`Id` FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                    $this->load->view("EN/inc/header", $data);
                    $this->load->view("EN/Global/l3_school/start_survey");
                    $this->load->view("EN/inc/footer");
                }
            } else {
                redirect('EN/Employee/surveys');
            }
        } elseif ($this->input->method() == "post") {
            $counter_questions = $this->input->post("choices");
            $answers_counter = sizeof($this->input->post()) - 2;
            if ($counter_questions == $answers_counter) {
                $started_at = new DateTime($this->input->get('time'));
                $now = new DateTime(date('H:i:s'));
                $timediff = $started_at->diff($now);
                $finished_at_s = $timediff->h . ':' . $timediff->i . ':' . $timediff->s;
                $finished_at = date("H:i:s", strtotime($finished_at_s));
                $answers_data = array(
                    'user_id'         => $sessiondata['admin_id'],
                    'finishing_time'  => $finished_at,
                    'serv_id'         => $this->input->get('serv'),
                );
                if ($this->db->insert('sv_st1_co_answers', $answers_data)) {
                    $this->db->select('Id');
                    $this->db->where('user_id', $sessiondata['admin_id']);
                    $this->db->where('serv_id', $this->input->get('serv'));
                    $this->db->order_by('Id', 'DESC');
                    $this->db->limit(1);
                    $answer_data_id = $this->db->get('sv_st1_co_answers')->result_array();
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
                    if ($this->db->insert_batch('sv_st1_co_answers_values', $answers)) {
                        // $returned_id = $this->db->query("SELECT MAX(Id) as lastadded FROM `sv_st1_co_answers`
                        // WHERE `user_id` = '".$sessiondata['admin_id']."' AND `user_type` = '1' LIMIT 1 ")->result_array();
                        // $respons = array("status" => "ok" , "Id" => $returned_id[0]['lastadded'] , 'md5id' => md5($returned_id[0]['lastadded']) );
                        echo "ok";
                    }
                }
            } else {
                // $respons = array("status" => "error" , "message" => "" );
                echo "please be sure to answer all the questions";
            }
        }
    }

    public function Surveys_history()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = " Qlick Health | surveys ";
        $user_data = $this->db->get_where('l2_co_patient', array('Id' => $sessiondata['admin_id']), 1)->row();
        if (!empty($user_data)) {
            $user_gender = $user_data->Gender == 'M' ? '1' : '2';
        } else {
            $this->load->library('session');
            print_r($user_data);
            session_destroy();
            redirect('EN/Users');
        }
        $data['surveys'] = $this->db->query(" SELECT
        `sv_co_published_surveys`.`Id` AS survey_id,
        `sv_co_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_co_surveys`.`Status` AS status,
        `sv_st1_co_surveys`.`title_en` AS Title_en,
        `sv_st1_co_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st1_co_surveys`.`Startting_date` AS From_date,
        `sv_st1_co_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_en` AS choices_ar_title ,
        `sv_st1_co_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_co_published_surveys` 
        ON `sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $user_data->Added_By . "
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` AND `sv_co_published_surveys_types`.`Type_code` = " . $user_data->UserType . "
        JOIN `sv_co_published_surveys_genders`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '" . $user_gender . "'
        JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` AND `user_id` = '" . $sessiondata['admin_id'] . "' )
        GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC LIMIT 20  ")->result_array();
        $this->load->view("EN/inc/header", $data);
        $this->load->view("EN/Global/l3_school/Show_surveys_history");
        $this->load->view("EN/inc/footer");
    }

}
