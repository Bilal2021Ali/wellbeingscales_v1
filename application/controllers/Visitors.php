<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends CI_Controller {

    function __construct()
    {
		parent::__construct();
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
	}
	

	
	public function login()
	{
        $respons = array("status" => "error");
        if($this->input->post('username') && $this->input->post('password')){
        $name = $this->input->post('username');
        $token = sha1(mt_rand(1, 90000) . 'SALT');
        $password = $this->input->post('password');
        $tryfinding = $this->db->query(  "SELECT * FROM v_login WHERE 
        Username = '" . $name . "' AND `Type` =  'visitor' ORDER BY Id DESC LIMIT 1"  )->result_array();
            if(!empty($tryfinding)){
                if ( password_verify( $password, $tryfinding[0]['Password'] ) ) {
                    $login_id = $tryfinding[0]['Id'];
                    $respons = array(
                        'status'    => "ok",
                        'token'     => $token,
                        'login_key' => $login_id
                    );    
                    $this->db->query(  " UPDATE `v_login` SET `Token` = '".$token."' WHERE `Id` = '".$login_id."' "  );
                }else{
                    $respons = array("status" => "notfound");
                }
            }else{
                $respons = array("status" => "notfound");
            }

        }
       echo json_encode($respons);
    }

    public function Auth()
    {
        $respons = array("status" => "error");
        if($this->input->post('token') && $this->input->post('login_key')){
            $token      = $this->input->post('token');
            $login_key  = $this->input->post('login_key');
            $tryfinding = $this->db->query(" SELECT * FROM v_login WHERE 
            Id = '" . $login_key . "' AND `Token` = '".$token."' ORDER BY Id DESC LIMIT 1 ")->result_array();
            if(!empty($tryfinding)){
                $respons = array("status" => "ok" , "username" => $tryfinding[0]['Username']);
            }
        }
        echo json_encode($respons);
    }


    public function Get_avalaible_surveys()
    {
        $respons = array("status" => "error");
        if($this->input->post('token') && $this->input->post('login_key')){
            $token      = $this->input->post('token');
            $login_key  = $this->input->post('login_key');
            $userchcking = $this->db->query(" SELECT `l2_visitors`.`Id` AS User_id ,  `l2_visitors`.`Added_By` AS parent_id
            FROM v_login
            JOIN l2_visitors ON `l2_visitors`.`UserName` = `v_login`.`UserName`
            WHERE `v_login`.`Id` = '" . $login_key . "' AND `Token` = '".$token."' ORDER BY `v_login`.`Id` DESC LIMIT 1 ")->result_array();
            
            if(!empty($userchcking)){
                $user_id   = $userchcking[0]['User_id'];
                $parent_id = $userchcking[0]['parent_id'];
                $surveys = $this->db->query(" SELECT
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
                `en_answer_group`.`title_en` AS choices_en_title ,
                `ar_answer_group`.`title_en` AS choices_ar_title 
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
                JOIN `sv_school_published_surveys`  ON sv_school_published_surveys.`By_school` = '".$parent_id."'
                WHERE `sv_st1_surveys`.`Status` = '1' " )->result_array(); 
                $respons = array("status" => "ok" , "surveys" => $surveys);
            }
        }
        echo json_encode($respons);
    }

    public function get_serv_question()
    {
        $respons = array("status" => "error");
        if($this->input->post('srv_id')){
            $srv_id = $this->input->post('srv_id');
            $serv_data = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id
            FROM `sv_st1_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            WHERE `sv_school_published_surveys`.`Id` = '".$srv_id."' ")->result_array();
            if(!empty($serv_data)){
                $group = $serv_data[0]['main_survey_id'];
                $quastins = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `survey_id` = '".$group."' ")->result_array();  
                $group_coices = $serv_data[0]['group_id']; 
                $choices = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '".$group_coices."' ")->result_array();
                $respons = array("status" => "ok" , "serv_data" => $serv_data , "questions" => $quastins , "choices" => $choices);
            }
        }
        echo json_encode($respons);
    }
	
    public function get_serv_choices(){
        $respons = array("status" => "error");
        if($this->input->post("group_id")){
            $group_id = $this->input->post("group_id");
            $choices = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `group_id` = '".$group_id."' ")->result_array();
            $respons = array("status" => "ok" , "choices" => $choices);
        }
        echo json_encode($respons);
    }
    
}