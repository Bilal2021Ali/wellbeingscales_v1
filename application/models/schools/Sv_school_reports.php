<?php
defined('BASEPATH') or exit('No direct script access allowed');

// from 6 To 374 created for serv_reports method in Controller of Schools
class sv_school_reports extends CI_Model
{
    public $schoolId = null;
    public $school_data = array();

    public function __construct($id = null)
    {
        // session dealing
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if ($id !== null) {
            $this->schoolId = $id;
        } else if (!empty($sessiondata)) {
            $this->schoolId = $sessiondata['admin_id'];
        } else {
            return false;
        }
        // db dealing
        $schoolData = $this->db->query(" SELECT * FROM `l1_school` WHERE `Id` = '" . $this->schoolId . "' ")->result_array();
        if (!empty($schoolData)) {
            $this->school_data = $schoolData[0];
        } else {
            exit();
        }

        // $this->response->json(['school_data' => $schoolData]);
    }

    public
    function setupSchoolId($id)
    {
        // for ministry
        $this->schoolId = $id;
    }

    public
    function Get_surveys($type, $fillablonly = false)
    {
        $today = date('Y-m-d');
        if (!$fillablonly) {
            $surveys = $this->db->query("SELECT
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
            (SELECT COUNT(Id) FROM `sv_school_published_surveys` WHERE `Serv_id` = `sv_st1_surveys`.`Id` AND `By_school` = '" . $this->schoolId . "' ) AS use_count 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Published_by` = '" . $this->school_data['Added_By'] . "' 
            AND (`sv_st1_surveys`.`Avalaible_to` = '" . $type . "' OR `sv_st1_surveys`.`Avalaible_to` = '1')
            AND  `sv_st1_surveys`.`Status` = '1' AND `sv_st1_surveys`.`End_date` >= '" . $today . "' AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "'
            GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        } else {
            $surveys = $this->db->query("SELECT
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_fillable_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_fillable_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter 
            FROM `sv_st1_surveys`
            JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Published_by` = '" . $this->school_data['Added_By'] . "' AND `sv_st1_surveys`.`survey_type` = 'fillable'
            AND  `sv_st1_surveys`.`Status` = '1' AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND  `sv_st1_surveys`.`End_date` >= '" . $today . "' 
            GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        }
        return $surveys;
    }

    public
    function expired_surveys()
    {
        // this method used in serv_reports
        $today = date('Y-m-d');
        $expired_surveys = $this->db->query(" SELECT
        `sv_st1_surveys`.`Id` AS survey_id,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' ")->result_array();
        return $expired_surveys;
    }

    public
    function expired_surveys_by_type($user_id, $usertype = null)
    {
        // this method used in serv_reports
        $today = date('Y-m-d');
        if ($usertype !== null) {
            $expired_surveys = $this->db->query(" SELECT
            `sv_school_published_surveys`.`Id` AS publishId ,
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS surv_status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
            AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
            WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        } else {
            $expired_surveys = $this->db->query(" SELECT
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Status` AS surv_status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st1_surveys`.`Startting_date` AS From_date,
            `sv_st1_surveys`.`End_date` AS To_date,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
            WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        }
        return $expired_surveys;
    }

    public
    function completed_surveys($user_id, $usertype = null, $gender = null)
    {
        // this method used in serv_reports
        $today = date('Y-m-d');
        $completed_surveys = $this->db->query(" SELECT
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
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $user_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` " . ($usertype !== null ? "AND `sv_st1_answers`.`user_type`= '" . $usertype . "' " : "") . ") 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        // echo $this->db->last_query();
        return $completed_surveys;
    }


    public
    function specific_user_completed_surveys($user_id, $usertype = null)
    {
        $completed_surveys = $this->db->query(" SELECT
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
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` 
        AND `sv_st1_answers`.`user_type`= '" . $usertype . "' AND `sv_st1_answers`.`user_id` = '" . $user_id . "' ) 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        // echo $this->db->last_query();
        return $completed_surveys;
    }

    public
    function answerd_quastions($user_id)
    {
        // this method used in serv_reports
        $answerd_quastions = $this->db->query(" SELECT
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
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $user_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
        GROUP BY `sv_sets`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        return $answerd_quastions;
    }

    public
    function specific_type_surveys($user_id, $type = null, $onlyExpired = false)
    {
        $expired = "WHERE sv_st1_surveys.End_date >= '" . date("Y-m-d") . "' ";
        if ($onlyExpired) {
            $expired = "WHERE sv_st1_surveys.End_date < '" . date("Y-m-d") . "' ";
        }
        // this method used in serv_reports
        if ($type !== null) {
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
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "' 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` $expired
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        } else {
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
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` $expired 
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        }
        return $surveys;
    }


    public
    function specific_type_questions($user_id, $type)
    {
        $quastions = $this->db->query(" SELECT
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
        `sv_st_questions`.`Id`   AS q_id,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
        JOIN `sv_school_published_surveys_types` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        GROUP BY  `sv_st_questions`.`Id`  ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        return $quastions;
    }


    public
    function specific_type_completed_surveys($user_id, $type, $cat_id = "")
    {
        if ($cat_id == "") {
            if ($type == 2) {
                $specific_type_completed_surveys = $this->db->query(" SELECT
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
                `sv_sets`.`title_ar` AS set_name_ar,
                `sv_set_template_answers`.`title_en` AS choices_en_title ,
                `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
                `sv_st1_answers`.`TimeStamp` AS answer_date ,
                (SELECT `Class` FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 ) AS Student_class
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
                AND `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            } else {
                $specific_type_completed_surveys = $this->db->query(" SELECT
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
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
                AND `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            }
        } else {
            if ($type == 2) {
                $specific_type_completed_surveys = $this->db->query(" SELECT
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
                `sv_st1_answers`.`TimeStamp` AS answer_date ,
                (SELECT `Class` FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 ) AS Student_class
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
                AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            } else {
                $specific_type_completed_surveys = $this->db->query(" SELECT
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
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
                AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            }
        }

        return $specific_type_completed_surveys;
    }

    public
    function specific_type_timeOfFinishing($user_id, $type = "")
    {
        if (!empty($type)) {
            $specific_type_timeOfFinishing = $this->db->query(" SELECT
            `sv_st1_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
            GROUP BY `sv_st1_answers`.`Id`  ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        } else {
            $specific_type_timeOfFinishing = $this->db->query(" SELECT
            `sv_st1_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        }

        return $specific_type_timeOfFinishing;
    }


    public
    function timeOfFinishingForThisSurvey($survey_id, $type = "")
    {
        //schoolId
        if (!empty($type)) {
            $results = $this->db->query(" SELECT
            `sv_st1_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_answers` 
            WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
            AND `sv_school_published_surveys`.`Id` = '" . $survey_id . "'
            GROUP BY `sv_st1_answers`.`Id`  ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        } else {
            $results = $this->db->query(" SELECT
            `sv_st1_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_answers` 
            WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
            AND `sv_school_published_surveys`.`Id` = '" . $survey_id . "'
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        }

        return $results;
    }

    public
    function our_surveys($user_id, $for_user_type = "")
    {
        if ($for_user_type == "") {
            $our_surveys = $this->db->query("SELECT
            `sv_school_published_surveys`.`Id` AS survey_id,
            `sv_school_published_surveys`.`Created` AS Created_date,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Id` AS St1id,
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
            `sv_st1_answers`.`TimeStamp` AS answer_date ,
            (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1'
            GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        } else {
            $our_surveys = $this->db->query("SELECT
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
            `sv_st1_answers`.`TimeStamp` AS answer_date ,
            (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $for_user_type . "' ) AS answers_counter 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $for_user_type . "' 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1'
            GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        }
        return $our_surveys;
    }


    public
    function our_fillable_surveys($schoolId)
    {
        $results = $this->db->query(" SELECT
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
        `sv_st_category`.`action_en_url` AS report_link ,
        `sv_st_themes`.`image_name` AS image_link ,
        (SELECT COUNT(Id) FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`) AS targetedUsers,
        (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id` ) AS passedUsers,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` 
        AND  `sv_school_published_surveys`.`By_school` = " . $schoolId . "
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        LEFT JOIN `sv_st_category` ON `sv_st_category`.`Id` =  `sv_st_fillable_surveys`.`category`
        WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' AND `sv_st1_surveys`.`Status` = '1' 
        AND EXISTS (SELECT Id FROM sv_school_published_fillable_surveys_targetedusers 
        WHERE `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`)
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        return $results;
    }

    public
    function surveys_by_gender($user_id, $gender = "", $usertype = "", $onlyExpired = false)
    {
        $dynamiccond = "AND sv_st1_surveys.End_date >= '" . date("Y-m-d") . "' ";
        if ($onlyExpired) {
            $dynamiccond = "AND sv_st1_surveys.End_date < '" . date("Y-m-d") . "' ";
        }

        if ($usertype !== "") { // when specific ;
            if (!empty($gender)) {
                // for spicifec gender
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '" . $gender . "'
                WHERE `sv_st1_surveys`.`Status` = '1'  AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "' $dynamiccond 
                GROUP BY survey_id ")->num_rows();
                // echo $this->db->last_query();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '1'
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "' $dynamiccond 
                GROUP BY survey_id ")->num_rows();
                // echo $this->db->last_query();
            }
        } else {  // when not specific ;
            if (!empty($gender)) {
                // for spicifec gender
                $other_gen = $gender == '1' ? '2' : '1';
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '" . $gender . "'
                WHERE `sv_st1_surveys`.`Status` = '1'  $dynamiccond 
                GROUP BY `sv_school_published_surveys`.`Id` ")->num_rows();
                // echo $this->db->last_query();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '1'
                WHERE `sv_st1_surveys`.`Status` = '1' $dynamiccond 
                GROUP BY survey_id ")->num_rows();
                // echo $this->db->last_query();
            }
        }
        // print_r($results);
        // exit();
        return $results;
    }

// start of reports in survey_reports

    public
    function users_passed_survey($surv_id, $type = "", $filters = ["classes" => null])
    {
        if ($this->uri->segment(1) == "AR") {
            $names = ['موظف', "طالب", "معلم", "ولي أمر"];
            $lang = "AR";
        } else {
            $names = ['Staff', "Student", "Teacher", "Parent"];
            $lang = "EN";
        }

        $StudentFilter = "";
        if ($filters["classes"] !== null) {
            $classes = implode(', ', $filters["classes"]);
            $StudentFilter .= " AND Class IN (" . $classes . ") ";
        }

        if (empty($type)) {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN ( SELECT name_en FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                            WHERE `l2_student`.`Added_By` = '" . $this->schoolId . "')  )
                ELSE 'We cant find this user !'
            END AS U_Name ,
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN '" . $names[0] . "'
                WHEN `sv_st1_answers`.`user_type` = '2' THEN '" . $names[1] . "'
                WHEN `sv_st1_answers`.`user_type` = '3' THEN '" . $names[2] . "'
                WHEN `sv_st1_answers`.`user_type` = '4' THEN '" . $names[3] . "'
                ELSE 'We cant find this type of users !'
            END AS UserType ,
            `sv_st1_answers`.`Id` AS answerKey ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "'
            AND sv_school_published_surveys.By_school = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            // (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter
            // $this->response->dd($results);
        } else {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN ( SELECT name_en FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                            WHERE `l2_student`.`Added_By` = '" . $this->schoolId . "')  )
                ELSE 'We cant find this user !'
            END AS U_Name ,
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN '" . $names[0] . "'
                WHEN `sv_st1_answers`.`user_type` = '2' THEN '" . $names[1] . "'
                WHEN `sv_st1_answers`.`user_type` = '3' THEN '" . $names[2] . "'
                WHEN `sv_st1_answers`.`user_type` = '4' THEN '" . $names[3] . "'
                ELSE 'We cant find this type of users !'
            END AS UserType ,
            `sv_st1_answers`.`Id` AS answerKey ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "' AND `sv_st1_answers`.`user_type` = '" . $type . "'
            AND sv_school_published_surveys.By_school = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        }
        return $results;
    }

    public
    function users_passed_category($cat, $type = "")
    {
        if (empty($type)) {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN ( SELECT name_en FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                            WHERE `l2_student`.`Added_By` = '" . $this->schoolId . "')  )
                ELSE 'We cant find this user !'
            END AS U_Name ,
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN 'Staff'
                WHEN `sv_st1_answers`.`user_type` = '2' THEN 'Student'
                WHEN `sv_st1_answers`.`user_type` = '3' THEN 'Teacher'
                WHEN `sv_st1_answers`.`user_type` = '4' THEN 'Parent'
                ELSE 'We cant find this type of users !'
            END AS UserType ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_surveys` ON `sv_st_surveys`.`id` = `sv_st1_surveys`.`Survey_id`
            WHERE `sv_st_surveys`.`category` = '" . $cat . "'
            AND `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        } else {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND Added_By = '" . $this->schoolId . "' )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN ( SELECT name_en FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                            WHERE `l2_student`.`Added_By` = '" . $this->schoolId . "')  )
                ELSE 'We cant find this user !'
            END AS U_Name ,
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN 'Staff'
                WHEN `sv_st1_answers`.`user_type` = '2' THEN 'Student'
                WHEN `sv_st1_answers`.`user_type` = '3' THEN 'Teacher'
                WHEN `sv_st1_answers`.`user_type` = '4' THEN 'Parent'
                ELSE 'We cant find this type of users !'
            END AS UserType ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            JOIN `sv_st_surveys` ON `sv_st_surveys`.`id` = `sv_st1_surveys`.`Survey_id`
            WHERE  `sv_st_surveys`.`category` = '" . $cat . "' AND `sv_st1_answers`.`user_type` = '" . $type . "'
            AND `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        }
        return $results;
    }


    public
    function survey_q_results($surv_id)
    {
        $result = $this->db->query(" SELECT
        `sv_set_template_answers_choices`.`title_en` AS `choices_en` ,
        `sv_set_template_answers_choices`.`title_ar` AS `choices_ar` ,
        `sv_set_template_answers_choices`.`Id` AS `Id`
        FROM `sv_school_published_surveys`
        JOIN `sv_st1_surveys` ON  `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
        JOIN `sv_st_surveys` ON `sv_st_surveys`.`Id` = `sv_st1_surveys`.`Survey_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers_choices` ON `sv_set_template_answers_choices`.`group_id` = `sv_set_template_answers`.`Id`
        WHERE `sv_school_published_surveys`.`Id` = '" . $surv_id . "' 
        AND sv_school_published_surveys.By_school = '" . $this->schoolId . "' ")->result_array();
        return $result;
    }

    public
    function get_surv_quastions($surv_id)
    {
        $surv_data = $this->get_surv_data($surv_id);
        if (empty($surv_data)) {
            $this->output->set_status_header('404');
            die();
        }
        $main_surv_id = $surv_data[0]['main_survey_id'];
        $result = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
        FROM `sv_st_questions`
        INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
        JOIN `sv_st_surveys` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_st1_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` 
        WHERE   `sv_school_published_surveys`.`By_school` = " . $this->schoolId . " AND `sv_st_questions`.`survey_id` = '" . $main_surv_id . "' ")->result_array();
        return $result;
    }

    public
    function get_surv_data($surv_id)
    {
        $serv_data = $this->db->query(" SELECT 
        `sv_st1_surveys`.`title_en` AS Title_en,
		`sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st_surveys`.`answer_group_en` AS group_id ,
        `sv_st_surveys`.`Id` AS main_survey_id ,
        `sv_st_themes`.`file_name` AS serv_theme ,
        `sv_st_themes`.`image_name` AS image_name 
        FROM `sv_st1_surveys` 
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
        JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
        WHERE `sv_school_published_surveys`.`Id` = '" . $surv_id . "' 
        AND sv_school_published_surveys.By_school = '" . $this->schoolId . "' ")->result_array();
        return $serv_data;
    }

    public
    function get_surv_percintage_graph($surv_id)
    {
        $result = $this->db->query("SELECT 
        COUNT(`sv_st1_answers_values`.`Id`) AS All_Count 
        FROM `sv_st1_answers_values` 
        GROUP BY `choice_id`")->result_array();
        return $result;
    }

    public
    function get_surv_percintage_by_gender($surv_id, $gender, $usertype = "", $filters = ['classes' => null])
    {
        $StudentFilter = "";
        if ($filters["classes"] !== null) {
            $classes = implode(', ', $filters["classes"]);
            $StudentFilter .= " AND Class IN (" . $classes . ") ";
        }
        if ($usertype == "") {
            // the basic function (wthout the type)
            // passed 0 mean male

            // JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
            // AND sv_school_published_surveys.By_school = '" . $this->schoolId . "'

            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' $StudentFilter LIMIT  1)
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . ($gender == "M" ? 1 : 2) . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "'
            AND sv_school_published_surveys.By_school = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        } else {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' $StudentFilter LIMIT  1 )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . ($gender == "M" ? 1 : 2) . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
            WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "' AND `sv_st1_answers`.`user_type` = '" . $usertype . "'
            AND sv_school_published_surveys.By_school = '" . $this->schoolId . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        }
    }

    public function get_all_surv_percintage_by_gender($gender, $usertype = null)
    {
        if (empty($usertype)) {
            // the basic function (wthout the type)
            // passed 0 mean male
            return $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' LIMIT  1 )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $gender . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        } else {
            $p_gender = $gender == "0" ? "1" : "2";
            return $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '" . $usertype . "' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            AND `sv_st1_answers`.`user_type` = '" . $usertype . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        }
    }


// for more detailed report
    public function get_q_answer_percintage_by_gender($surv_id, $quastion, $choice, $gender)
    {
        // passed 0 mean male
        $results = $this->db->query("SELECT 
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $gender . "' LIMIT 1 )
            ELSE NULL
        END AS U_Name ,
        `sv_st1_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_answers_values`
        JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id`
        WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $quastion . "' 
        AND `sv_st1_answers_values`.`choice_id` = '" . $choice . "'
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        return $results;
    }

    public
    function get_users_ages($surv_id, $usertype)
    {   // this function built for survey_reports first time
        $data = $this->db->query("SELECT 
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT (DOP) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT (DOP) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT (DOP) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT (DOP) FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            ELSE 0
        END AS DOP ,
        `sv_st1_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_answers` 
        JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Id` = `sv_st1_answers`.`serv_id`
        WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "' AND `user_type` = '" . $usertype . "'
        AND `sv_school_published_surveys`.`By_school` = '" . $this->schoolId . "'
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        $results = $this->change_to_age($data);
        return $results;
    }


    private
	function change_to_age($data)
		{
		// Assuming $data contains information about dates

		foreach ($data as $key => $item) {
			// Check if 'DOP' key exists and is not null
			if (isset($item['DOP']) && $item['DOP'] !== null) {
				$dop = $item['DOP'];
				
				// Use strtotime only if $dop is not null
				$timestamp = strtotime($dop);

				if ($timestamp !== false) {
					// Successfully converted to timestamp, proceed with your logic
					$todaydate = new DateTime();
					$dob = new DateTime($dop);
					$age = $todaydate->diff($dob)->y;
					$data[$key]['DOP'] = $age;
				} else {
					// Handle the case where strtotime() fails (invalid date)
					// You might want to log an error, provide a default value, etc.
					$data[$key]['DOP'] = 'Invalid Date';
				}
			} else {
				// Handle the case where 'DOP' is not set or is null
				// You might want to log an error, provide a default value, etc.
				$data[$key]['DOP'] = 'Missing Date';
			}
		}

		return $data;
	}


    /**
     * @categorys reports
     */
    public
    function category_by_gender($user_id, $gender = "", $usertype = "", $cat = "")
    {
        if ($usertype == "") {
            if (!empty($gender)) {
                // for spicifec gender
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $gender . "'
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->num_rows();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '1'
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->num_rows();
            }
        } else {
            if (!empty($gender)) {
                // for spicifec gender
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '" . $gender . "'
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->num_rows();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` AND `sv_school_published_surveys_genders`.`Gender_code` = '1'
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->num_rows();
            }
        }
        return $results;
    }

    public
    function category_publishid_surveys($user_id, $cat_id)
    {
        $lang = $this->uri->segment(1) == "AR" ? "ar" : "en";

        return $this->db->query("SELECT
        `sv_school_published_surveys`.`Id` AS survey_id,
        `sv_school_published_surveys`.`Created` AS Created_date,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_surveys`.`Status` AS status,
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st1_surveys`.`title_ar` AS Title_ar,
        `sv_st_surveys`.`Message_" . $lang . "` AS Message,
        `sv_st1_surveys`.`Startting_date` AS From_date,
        `sv_st1_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date ,
        (SELECT GROUP_CONCAT(sv_sets.title_" . $lang . ") FROM sv_sets WHERE  `sv_sets`.`Id` = `sv_st_surveys`.`set_id`) AS surveysTitles ,
        (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
         AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
    }


    public
    function ages_forall_users($user_id, $grouping = true)
    {
        $data = $this->db->query("SELECT DOP , Id , 'staff' as type FROM l2_staff WHERE Added_By = '" . $user_id . "'
        UNION 
        SELECT DOP , Id , 'teacher' as type FROM l2_teacher WHERE Added_By = '" . $user_id . "'
        UNION 
        SELECT DOP , Id , 'stdent' as type  FROM l2_student WHERE Added_By = '" . $user_id . "'
        UNION 
        SELECT DOP , Id , 'Parent' as type  FROM l2_parents 
        WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
        JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
        OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
        JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
        WHERE `l2_student`.`Added_By` = '" . $user_id . "') ")->result_array();
        if ($grouping) {
            $results = $this->group_by("type", $this->change_to_age($data));
        } else {
            $results = $this->change_to_age($data);
        }
        return $results;
    }

    private
    function group_by($key, $data)
    {
        $result = array();
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }
        return $result;
    }

    public
    function ages_for_all_passed_users($user_id, $grouping = true)
    {
        // return data ages of the passed users only
        $data = $this->db->query("SELECT
        DISTINCT(`sv_st1_answers`.`Id`) ,
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT DOP  FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT DOP  FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT DOP  FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT DOP FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            ELSE NULL
        END AS DOP ,
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN 'staff'
            WHEN `sv_st1_answers`.`user_type` = '2' THEN 'Student'
            WHEN `sv_st1_answers`.`user_type` = '3' THEN 'teacher'
            WHEN `sv_st1_answers`.`user_type` = '4' THEN 'parents'
            ELSE NULL
        END AS type ,
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
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $user_id . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id`  ) 
        GROUP BY `sv_st1_answers`.`user_type`, `sv_st1_answers`.`user_id`
        ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();

        if ($grouping) {
            $results = $this->group_by("type", $this->change_to_age($data));
        } else {
            $results = $this->change_to_age($data);
        }
        return $results;
    }

    public
    function martial_status($user_id, $user_type)
    {
        $data = $this->db->query(" SELECT 
        DISTINCT(`sv_st1_answers`.`Id`) ,
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT martial_status  FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT martial_status  FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT martial_status  FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT martial_status  FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            ELSE NULL
        END AS Mar_status ,
        `sv_st1_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_answers`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Id` = `sv_st1_answers`.`serv_id` 
        AND  `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
        WHERE `sv_st1_answers`.`user_type`  = '" . $user_type . "'
        GROUP BY `sv_st1_answers`.`user_type`, `sv_st1_answers`.`user_id`
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        $returned_results = $this->group_by("Mar_status", $data);
        if ($this->uri->segment(1) == "AR") {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name_ar");
        } else {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name");
        }
        $results = array();
        // $results = str_replace(array_keys($results), $names, $site['Site_For']);
        foreach ($returned_results as $key => $result) {
            $key = str_replace(array_keys($returned_results), $names, $key);
            $results[$key] = sizeof($result);
        }
        return $results;
    }

    public
    function usedcategorys($user_id)
    {
        $results = $this->db->query(" SELECT * ,
        ( SELECT COUNT(`sv_school_published_surveys`.`Id`)
        FROM `sv_st1_surveys` 
        JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` 
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` ) AS counter_of_using 
        FROM `sv_st_category`
        /* start exist condition */
        WHERE EXISTS ( SELECT COUNT(`sv_school_published_surveys`.`Id`)
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`  
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = `sv_st_category`.`Id`
        AND `sv_school_published_surveys`.`By_school` = '" . $user_id . "'
        GROUP BY `sv_school_published_surveys`.`Id` )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
        return $results;
    }

    public
    function allourusersinonearray($schoolId)
    {
        $data = $this->db->query("SELECT DOP , Id , 'staff' as type FROM l2_staff 
        UNION 
        SELECT DOP , Id , 'teacher' as type FROM l2_teacher WHERE Added_By = '" . $schoolId . "'
        UNION 
        SELECT DOP , Id , 'stdent' as type  FROM l2_student WHERE Added_By = '" . $schoolId . "'
        UNION 
        SELECT DOP , Id , 'Parent' as type  FROM l2_parents 
        WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
        JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
        OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
        JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
        WHERE `l2_student`.`Added_By` = '" . $schoolId . "') ")->result_array();
        return $data;
    }

    public
    function userspassedprivatesurvey($survey_id)
    {
        $results = $this->db->query("SELECT 
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id`  LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            ELSE 'Not knowen'
        END AS name ,
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN 'staff'
            WHEN `sv_st1_answers`.`user_type` = '2' THEN 'Student'
            WHEN `sv_st1_answers`.`user_type` = '3' THEN 'teacher'
            WHEN `sv_st1_answers`.`user_type` = '4' THEN 'parents'
            ELSE NULL
        END AS type ,
        `sv_st1_answers`.`Id` AS answer_id ,
        `sv_st1_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_answers` WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers`.`survey_type` = 'fillable'
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        return $results;
    }


    public
    function our_published_surveys($type = "", $filters = [])
    {
        $today = date('Y-m-d');
        //
        if ($type == "fillabe") {
            $result = $this->db->query(" SELECT
            `sv_school_published_surveys`.`Id` AS survey_id,
            `sv_school_published_surveys`.`TimeStamp` AS publish_date,
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
            (SELECT COUNT(Id) FROM sv_school_published_fillable_surveys_targetedusers 
            WHERE `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = `sv_school_published_surveys`.`Id`) AS trgetedUsersCounter ,
            (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `survey_type` = 'fillable' ) AS completed ,
            `sv_school_published_surveys`.`status` AS status
            FROM `sv_st1_surveys`
            JOIN `sv_st_fillable_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_fillable_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
            JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $this->schoolId . "
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`survey_type` = 'fillable' AND `sv_st1_surveys`.`Status` = '1' 
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        } else {
            $statusCondition = "";

            if (isset($filters['status'])) {
                $statusCondition = "AND sv_school_published_surveys.Status = " . $filters['status'];
            }
            $result = $this->db->query(" SELECT
            `sv_school_published_surveys`.`Id` AS survey_id,
            `sv_school_published_surveys`.`TimeStamp` AS publish_date,
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
            `sv_st_themes`.`image_name` AS image_link ,
            `sv_st1_surveys`.`Startting_date` , `sv_st1_surveys`.`End_date` ,
            (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `survey_type` = 'notfillable' ) AS completed ,
            `sv_school_published_surveys`.`status` AS status
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' AND `sv_st1_surveys`.`End_date` >= '" . $today . "'
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $this->schoolId . "
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
            WHERE `sv_school_published_surveys`.`survey_type` = 'notfillable' AND `sv_st1_surveys`.`Status` = '1' $statusCondition
            GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC  ")->result_array();
        }
        return $result;
    }

    public
    function surveyTargetedUsers($servId)
    {
        //$this->schoolId
        $targetedUsers = array();
        $types = $this->db->query("SELECT * FROM sv_school_published_surveys_types WHERE Survey_id = '" . $servId . "' ")->result_array();
        $genders = $this->db->query("SELECT * FROM sv_school_published_surveys_genders WHERE Survey_id = '" . $servId . "' ")->result_array();
        $classesData = $this->db->query("SELECT * FROM sv_school_published_surveys_levels WHERE Survey_id = '" . $servId . "' ")->result_array();
        $genders = array_values($genders);
        $genders = str_replace(['1', '2'], ['M', 'F'], $genders);
        $Gender_codes = array();
        $classes = array();
        foreach ($genders as $gender) {
            $Gender_codes[] = "'" . str_replace(['1', '2'], ['M', 'F'], $gender['Gender_code']) . "'";
        }
        foreach ($classesData as $classeData) {
            $classes[] = $classeData['Level_code'];
        }
        $classes = implode(', ', $classes);
        $Gender_codes = implode(', ', $Gender_codes);
        foreach ($types as $type) {
            if ($type['Type_code'] == "1") {
                $table = 'l2_staff';
            } else if ($type['Type_code'] == "2") {
                $table = 'l2_student';
            } else if ($type['Type_code'] == "3") {
                $table = 'l2_teacher';
            } else if ($type['Type_code'] == "4") {
                $table = 'l2_parents';
            } else {
                $table = '';
            }
            if ($table !== '') {
                if (!in_array($table, ['l2_staff', 'l2_parents'])) {
                    $users = $this->db->query("SELECT Id FROM " . $table . " WHERE `Added_By` = '" . $this->schoolId . "' AND `Gender` IN (" . $Gender_codes . ") ")->result_array();
                    foreach ($users as $user) {
                        $targetedUsers[] = array(
                            "user_id" => $user['Id'],
                            "user_type" => str_replace("l2_", '', $table),
                        );
                    }
                } else if ($table == "l2_student") {
                    $users = $this->db->query("SELECT Id FROM `l2_student` WHERE `Added_By` = '" . $this->schoolId . "' AND `Gender` IN (" . $Gender_codes . ") AND `Class` IN (" . $classes . ") ")->result_array();
                    foreach ($users as $user) {
                        $targetedUsers[] = array(
                            "user_id" => $user['Id'],
                            "user_type" => str_replace("l2_", '', $table),
                        );
                    }
                } else if ($table == "l2_teacher") {
                    $users = $this->db->query("SELECT `l2_teacher`.`Id` AS Id FROM `l2_teacher`
                    JOIN l2_teachers_classes ON `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id` AND `class_id` IN (" . $classes . ")
                    WHERE `l2_teacher`.`Added_By` = '" . $this->schoolId . "' AND `Gender` IN (" . $Gender_codes . ") AND `Class` IN (" . $classes . ") ")->result_array();
                    foreach ($users as $user) {
                        $targetedUsers[] = array(
                            "user_id" => $user['Id'],
                            "user_type" => str_replace("l2_", '', $table),
                        );
                    }
                }
            }
        }
        return $targetedUsers;
    }

    public function getclimatesurveyslibrary($categories = false, $single = false)
    {
        $type = $this->school_data['Type_Of_School'] == "Government" ? "2" : "3";
        $group = "GROUP BY `scl_st_climate`.`Id`";
        if ($categories) {
            $group = " GROUP BY `sv_st_category`.`Id` ";
        }

        $condition = "AND `scl_st_climate`.`Published_by` = '" . $this->school_data['Added_By'] . "'";
        if ($single) {

        }
        return $this->db->query(" SELECT
        `scl_st_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_st0_climate`.`status` AS main_survey_status,
        `scl_st_climate`.`Id` AS survey_id,
        `scl_st_climate`.`Status` AS status,
        `sv_st_category`.`Id` AS category_id,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`en_title` AS question ,
        `scl_st_climate`.`Startting_date` AS from_date ,
        `scl_st_climate`.`End_date` AS to_date
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        JOIN `scl_st_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        WHERE (`scl_st_climate`.`Avalaible_to` = '" . $type . "' OR `scl_st_climate`.`Avalaible_to` = '1')
        $condition   $group
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
    }

    public function GetClimatesurveys(array $filters = [], $byId = null, bool $withoutAnswers = false)
    {
        $answers = true;
        if (($this->uri->segment(3) && $this->uri->segment(3) == "ClaimateSurveys") || $withoutAnswers) {
            $answers = false;
        }
        /*
        filters array example :
        *[
            'surveyId' => "number" ,
            'gender' => "M" ,
            'usertype' => 2 ,
            'age' => [
                'min'=> 12 ,
                "max" => 20
            ]
        ] */
        if ($this->uri->segment(1) == "AR") {
            $col = "Class_ar";
            $q = "ar_title";
        } else {
            $col = "Class";
            $q = "en_title";
        }
        $today = date('Y-m-d');
        $this->db->select('`scl_st0_climate`.`TimeStamp` as created_at ,
        `scl_st0_climate`.`Id` as main_survey_id,
        `scl_st0_climate`.`status` as main_survey_status,
        `scl_st0_climate`.`climate_image`,
        `scl_published_claimate`.`Id` as survey_id,
        `scl_published_claimate`.`Status` as status,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `sv_st_category`.`Id` as Cat_id,
        `scl_st0_climate`.`answer_group` as group_id,
        `sv_sets`.`title_en` as set_name_en,
        `sv_sets`.`title_ar` as set_name_ar ,
        `sv_set_template_answers`.`title_en` as choices_title ,
        `sv_questions_library`.`' . $q . '` as question ,
        `scl_st_climate`.`Status` as ministry_survey_status ,
        `scl_st_climate`.`Startting_date` as from_date ,
        `scl_published_claimate`.`TimeStamp` as publishedAt,
        `scl_st_climate`.`End_date` as to_date,scl_climate_answers.Id as AnswerKey ');
        $this->db->select("(SELECT CASE
                WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT (DOP) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT (DOP) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT  1 )
                WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT (DOP) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT (DOP) FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
            ELSE 0
        END ) AS DOP ");
        $this->db->select("COUNT(DISTINCT scl_climate_answers.Id) as answers_counter");
        $this->db->select("(SELECT GROUP_CONCAT(Gender_code) FROM scl_published_claimate_genders WHERE scl_published_claimate_genders.Climate_id = `scl_published_claimate`.`Id`) AS genderslist");
        $this->db->select("(SELECT GROUP_CONCAT(r_levels." . $col . ") FROM scl_published_claimate_levels
        JOIN `r_levels` ON `r_levels`.`Id` = `scl_published_claimate_levels`.`Level_code`
        WHERE `scl_published_claimate_levels`.`Claimate_id` = `scl_published_claimate`.`Id`) as levelslist");
        $this->db->select("(SELECT GROUP_CONCAT(Type_code) FROM scl_published_claimate_types WHERE scl_published_claimate_types.Climate_id = `scl_published_claimate`.`Id`) as typeslist");
        $this->db->from("scl_published_claimate");
        $this->db->join("scl_st_climate", "scl_st_climate.Id = scl_published_claimate.climate_id");
        $this->db->join("scl_st0_climate", "scl_st0_climate.Id = scl_st_climate.Climate_id");
        $this->db->join("sv_set_template_answers", "sv_set_template_answers.Id = scl_st0_climate.answer_group");
        $this->db->join("sv_sets", '"sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join("sv_questions_library", "sv_questions_library.Id = scl_st0_climate.question_id");
        $this->db->join("l1_school", "l1_school.Added_By = scl_st_climate.Published_by");
        $this->db->join("sv_st_category", "sv_st_category.Id = scl_st0_climate.category");
        $this->db->join("scl_climate_answers", "scl_published_claimate.Id = scl_climate_answers.climate_id", ($byId == null || $withoutAnswers ? 'left' : "INNER"));
        if (isset($filters['gender'])) {
            $this->db->where(" (CASE
            WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` AND `l2_student`.`Gender` = '" . $filters['gender'] . "' LIMIT  1 )
            WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` AND `l2_parents`.`gender` = '" . ($filters['gender'] == "M" ? 1 : 2) . "' LIMIT 1 )
        ELSE NULL
        END)", "IS NOT NULL", false);
        }
        if (isset($filters['usertype'])) {
            $this->db->where("scl_climate_answers.user_type", $filters['usertype']);
        }
        if (isset($filters['surveyid'])) {
            $this->db->where("scl_published_claimate.Id", $filters['surveyid']);
        }
        if (isset($filters['categoryId'])) {
            $this->db->where("sv_st_category.Id", $filters['categoryId']);
        }
        if (isset($filters['status'])) {
            $this->db->where("scl_published_claimate.Status", $filters['status']);
        }
        if ($answers) {
            $this->db->where("scl_climate_answers.TimeStamp >= ", $today . " 00:00:00");
            $this->db->where("scl_climate_answers.TimeStamp <= ", $today . " 23:59:59");
        }
        if ($byId !== null) {
            $this->db->where("scl_published_claimate.Id", $byId);
        }
        $this->db->where("scl_published_claimate.By_school", $this->schoolId);
        if (isset($filters['list'])) {
            $this->db->group_by("scl_published_claimate.id");
        } else {
            $this->db->group_by("scl_climate_answers.climate_id");
        }
        $this->db->order_by("scl_st0_climate.Id", 'ASC');
        if ($byId !== null) {
            $data = $this->db->get()->row();
        } else {
            $data = $this->db->get()->result_array();
        }
        if (isset($filters['age'])) {
            $data = $this->change_to_age($data);
            foreach ($data as $key => $result) {
                if ($result['DOP'] > $filters['age']['min'] || $result['DOP'] < $filters['age']['max']) {
                    $result['age'] = $result['DOP'];
                } else {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    public
    function GetClimateAnswers($surveyId, $filters = [])
    {
        /**
         *  Filters :
         * 'ByType' => null, 'gender' => null
         */
        $this->db
            ->select("scl_st_choices .* , sv_questions_library.en_title as questionName_en , sv_questions_library.ar_title as questionName_ar,
            sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en as set_name_en, sv_sets.title_ar as set_name_ar")
            ->select("sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar")
            ->select("scl_climate_answers.Id as AnswerId")
            ->select("COUNT(scl_climate_answers.Id) as ChooseingTimes")
            ->from('scl_st_choices')
            ->join("sv_set_template_answers_choices", "sv_set_template_answers_choices.Id = scl_st_choices.choice_id")
            ->join("scl_st0_climate", "scl_st0_climate.Id = scl_st_choices.servey_id")
            ->join("sv_st_category", "sv_st_category.Id = scl_st0_climate.category")
            ->join("sv_questions_library", "sv_questions_library.Id = scl_st0_climate.question_id")
            ->join("sv_sets", "sv_sets.Id = scl_st0_climate.set_id")
            ->join("scl_climate_answers", "scl_climate_answers.answer_id = `scl_st_choices`.`id`")
            ->where("scl_climate_answers.climate_id ", $surveyId);


        if (isset($filters['ByType'])) {
            $this->db->where('scl_climate_answers.user_type', $filters['ByType']);
        }
        if (isset($filters['gender'])) {
            $this->db->where(" (case
            WHEN `scl_climate_answers`.`user_type` = '1' THEN(SELECT CONCAT(`F_name_EN`, ' ', `L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` and `l2_staff`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '2' THEN(SELECT CONCAT(`F_name_EN`, ' ', `L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` and `l2_student`.`Gender` = '" . $filters['gender'] . "' LIMIT  1 )
            WHEN `scl_climate_answers`.`user_type` = '3' THEN(SELECT CONCAT(`F_name_EN`, ' ', `L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` and `l2_teacher`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '4' THEN(SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` and `l2_parents`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )
        else NULL
        END)", "IS NOT NULL", false);
        }
        $this->db->order_by('position', 'ASC');
        $this->db->group_by("scl_st_choices.Id");
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getClimateCounters($surveyId, $filters = [])
    {
        $this->db->select("COUNT(DISTINCT scl_climate_answers.Id) AS result");
        $this->db->join("scl_published_claimate", "scl_published_claimate.Id = scl_climate_answers.climate_id");
        if (isset($filters['between'])) {
            $this->db->where("scl_climate_answers.TimeStamp >= ", $filters['between']['from'] . " 00:00:00");
            $this->db->where("scl_climate_answers.TimeStamp <= ", $filters['between']['to'] . " 23:59:59");
        }
        $this->db->where('scl_published_claimate.By_school', $this->schoolId);
        $this->db->where('scl_published_claimate.Id', $surveyId);

        if (isset($filters['type'])) {
            $conditionsLines = [
                "staff" => "WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )",
                "students" => "WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT  1 )",
                "teachers" => "WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )",
                "parents" => "WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )"
            ];
            $this->db->where("(CASE
                " . $conditionsLines[$filters['type']] . "
                ELSE NULL
            END)", "IS NOT NULL", false);
        }

        $result = $this->db->get("scl_climate_answers")->result_array();

        return $result[0]['result'] ?? 0;
    }

    public
    function ClimateChoices(array $filters = [])
    {
        /*
        filters array example :
        *[
            'surveyid' => "number" ,
            'gender' => "M" ,
            'usertype' => 2 ,
            'age' => [
                'min'=> 12 ,
                "max" => 20
            ]
        ] */
        $this->db->select("COUNT(DISTINCT scl_climate_answers.Id)");
        $this->db->from('scl_climate_answers');
        if (isset($filters['between'])) {
            $this->db->where("scl_climate_answers.TimeStamp >= ", $filters['between']['from'] . " 00:00:00");
            $this->db->where("scl_climate_answers.TimeStamp <= ", $filters['between']['to'] . " 23:59:59");
        }
        $this->db->join("scl_published_claimate", "scl_published_claimate.Id = scl_climate_answers.climate_id");
        $this->db->where('scl_climate_answers.answer_id', '`scl_st_choices`.`id`', false);
        $this->db->where('scl_published_claimate.By_school', $this->schoolId);
        if (isset($filters['surveyid'])) {
            $this->db->where('scl_published_claimate.Id', $filters['surveyid']);
        }
        $subCounter = $this->db->get_compiled_select();

        $this->db->select('scl_st_choices.* , sv_questions_library.en_title as questionName_en , sv_questions_library.ar_title as questionName_ar,
        sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en as set_name_en, sv_sets.title_ar as set_name_ar  ');
        $this->db->select("(SELECT CASE
                WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT (DOP) FROM `l2_staff`   WHERE `l2_staff`.`Id`   = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT (DOP) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT (DOP) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT (DOP) FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
            ELSE 0
        END ) AS DOP ");
        $this->db->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar');
        $this->db->select("(" . $subCounter . ") as ChooseingTimes");
        $this->db->from('scl_st_choices');
        $this->db->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('scl_climate_answers', 'scl_climate_answers . answer_id = `scl_st_choices`.`id` ', 'left');
        $this->db->join('scl_published_claimate', 'scl_published_claimate.Id = `scl_climate_answers`.`climate_id`');
        if (isset($filters['gender'])) {
            $this->db->where(" (CASE
            WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` AND `l2_student`.`Gender` = '" . $filters['gender'] . "' LIMIT  1 )
            WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` AND `l2_parents`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )
        ELSE NULL
        END)", "IS NOT NULL", false);
        }
        if (isset($filters['surveyid'])) {
            $this->db->where('scl_published_claimate.Id', $filters['surveyid']);
        }
        if (isset($filters['usertype'])) {
            $this->db->where('scl_climate_answers.user_type', $filters['usertype']);
        }

        $this->db->where('scl_published_claimate.By_school', $this->schoolId);
        // $this->db->order_by('position', 'ASC');
        $this->db->group_by('scl_st_choices.id');

        $data = $this->db->get()->result_array();

        if (isset($filters['age'])) {
            $data = $this->change_to_age($data);
            foreach ($data as $key => $result) {
                if ($result['DOP'] > $filters['age']['min'] || $result['DOP'] < $filters['age']['max']) {
                    $result['age'] = $result['DOP'];
                } else {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    public
    function speakout()
    {
        $results = [
            'pending' => [],
            'approved' => [],
            'resolved' => [],
            'seen' => [],
            'average' => [],
            'urgent' => [],
            'high' => [],
            'highest' => [],
            'all' => 0
        ];
        $data = $this->db->query("SELECT 
        l3_mylifereports . Id as id , l3_mylifereports . show_user_name, l3_mylifereports . status , l3_mylifereports . priority , l3_mylifereports . closed ,
        l3_mylifereports . description_en , l3_mylifereports . description_ar , l3_mylifereports . TimeStamp as reportdateandtime , sv_set_template_lifereports . title_en as groupname ,  sv_set_template_lifereports_choices . title_en as reptype ,
        l2_student . Id as userid ,CONCAT(`l2_student` . `F_name_EN`, ' ', `l2_student` . `L_name_EN`) as username  , `l2_avatars` . `Link` as useravatar ,
        (SELECT COUNT(Id) FROM `l3_mylifereportsmedia` WHERE `l3_mylifereportsmedia` . `report_id` = `l3_mylifereports` . `Id` ) as Media
        FROM `l3_mylifereports`
        JOIN sv_set_template_lifereports ON sv_set_template_lifereports . Id = l3_mylifereports . group_id
        JOIN sv_set_template_lifereports_choices ON sv_set_template_lifereports_choices . Id = l3_mylifereports . type_id
        JOIN l2_student ON l2_student . Added_By = '" . $this->schoolId . "'
        LEFT JOIN `l2_avatars` ON `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'
        WHERE `l3_mylifereports` . `user_id` = `l2_student` . `Id` ORDER BY l3_mylifereports . TimeStamp DESC ")->result_array();
        foreach ($data as $key => $report) {
            $status = intval($report['status']);
            $priority = intval($report['priority']);
            // by status
            if ($status == 0) {
                $results['pending'][] = $report;
            }

            if ($status == 1) {
                $results['seen'][] = $report;
            }
            if ($status == 2) {
                $results['resolved'][] = $report;
            }

            if ($status == 3) {
                $results['seen'][] = $report;
            }
            // by priority
            if ($priority == 0) {
                $results['average'][] = $report;
            }

            if ($priority == 1) {
                $results['urgent'][] = $report;
            }

            if ($priority == 2) {
                $results['high'][] = $report;
            }

            if ($priority == 3) {
                $results['highest'][] = $report;
            }
        }
        $results['all'] = sizeof($data);

        return $results;
    }

    /**
     * $options = [
     *    'in' => '',
     *    'from' => '',
     *    'to' => '',
     *    'date' => '',
     * ]
     **/

// date("Y - m - d")
    public
    function temperature($options = [])
    {
        $counter = 0;

        $inCond = isset($options['in']) == null ? "" : " and `Action` = '" . $options['in'] . "'";
        $inCond .= isset($options['class']) ? " and class = '" . $options['class'] . "' " : "";

        $conditions = isset($options['date']) ? "and Result_Date = '" . $options['date'] . "'" : '';

        $Ourstaffs = [];
        $OurTeachers = [];
        $OurStudents = [];

        if (!isset($options['usertype']) || (isset($options['usertype']) && $options['usertype'] == 'staff')) {
            $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();
        }

        if (!isset($options['usertype']) || (isset($options['usertype']) && $options['usertype'] == 'teacher')) {
            $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();
        }

        if (!isset($options['usertype']) || (isset($options['usertype']) && $options['usertype'] == 'student')) {
            $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();
        }

        if (!empty($Ourstaffs)) {
            $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN(" . implode(", ", array_column($Ourstaffs, "Id")) . ")
                and UserType = 'Staff' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResults as $results) {
                if (!isset($options['from'])) {
                    $counter++;
                } else {
                    if ($results['Result'] >= $options['from'] && $results['Result'] <= $options['to']) {
                        $counter++;
                    }
                }
            }
        }

        if (!empty($OurTeachers)) {
            $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN(" . implode(", ", array_column($OurTeachers, "Id")) . ")
                and UserType = 'Teacher' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResultsT as $results) {
                if (!isset($options['from'])) {
                    $counter++;
                } else {
                    if ($results['Result'] >= $options['from'] && $results['Result'] <= $options['to']) {
                        $counter++;
                    }
                }
            }
        }

        if (!empty($OurStudents)) {
            $getResultsS = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN(" . implode(", ", array_column($OurStudents, "Id")) . ")
                and UserType = 'Student' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResultsS as $results) {
                if (!isset($options['from'])) {
                    $counter++;
                } else {
                    if ($results['Result'] >= $options['from'] && $results['Result'] <= $options['to']) {
                        $counter++;
                    }
                }
            }
        }

        return ($counter);
    }

    public
    function lab($options = [])
    {
        $counter = 0;
        $inCond = isset($options['in']) == null ? "" : " and `Action` = '" . $options['in'] . "'";

        $conditions = "";
        $conditions .= isset($options['date']) ? " and Created = '" . $options['date'] . "'" : '';
        if (isset($options['from'])) {
            $conditions .= " and Result >= " . $options['from'] . " and Result <= " . $options['to'];
        }
        $conditions .= isset($options['type']) && $options['type'] == "all" ? "" : " and `Test_Description` = '" . $options['type'] . "' ";
        $conditions .= isset($options['action']) ? " and `Action` = '" . $options['action'] . "' " : "";
        $conditions .= isset($options['result']) ? " and `Result` = '" . $options['result'] . "' " : "";

        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();
        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();
        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $this->schoolId . "' $inCond ")->result_array();

        if (!empty($Ourstaffs)) {
            $getResults = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` IN(" . implode(", ", array_column($Ourstaffs, "Id")) . ") and UserType = 'Staff' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResults as $results) {
                $counter++;
            }
        }

        if (!empty($OurTeachers)) {
            $getResultsT = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` IN(" . implode(", ", array_column($OurTeachers, "Id")) . ") and UserType = 'Teacher' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResultsT as $results) {
                $counter++;
            }
        }

        if (!empty($OurStudents)) {
            $getResultsS = $this->db->query("SELECT * FROM l2_labtests WHERE `UserId` IN(" . implode(", ", array_column($OurStudents, "Id")) . ") and UserType = 'Student' $conditions ORDER BY `Id` DESC")->result_array();
            foreach ($getResultsS as $results) {
                $counter++;
            }
        }

        return ($counter);
    }

    public function getClimateSurveysList($surveyId = null, $AdditionalConditions = [], $date = null) // used in : Climate_Details
    {
        $conditions = [];

        if ($date == null) {
            $date = "DATE_FORMAT(scl_climate_answers.TimeStamp, '%Y-%m-%d') = '" . date("Y-m-d") . "'";
        }

        if (!empty($surveyId)) {
            $conditions[] = "scl_published_claimate.Id = " . $surveyId;
        }

        $conditions = array_merge($AdditionalConditions, $conditions);

        $query = "SELECT scl_st0_climate.TimeStamp as created_at, scl_st0_climate.Id as main_survey_id, scl_published_claimate.Id as survey_id,
        scl_published_claimate.Status as status, sv_st_category.Cat_en, sv_st_category.Cat_ar, sv_st_category.Id as Cat_id,
        scl_st0_climate.answer_group as group_id, sv_sets.title_en as set_name_en, sv_sets.title_ar as set_name_ar,
        sv_set_template_answers.title_en as choices_title, sv_questions_library.en_title as question, scl_st_climate.Startting_date as from_date,
        scl_published_claimate.TimeStamp as publishedAt, scl_st_climate.End_date as to_date, scl_climate_answers.Id as AnswerKey,
        (SELECT case
            WHEN scl_climate_answers.user_type = '1' THEN(SELECT(DOP) FROM l2_staff WHERE l2_staff.Id = scl_climate_answers.user_id LIMIT 1 )
            WHEN scl_climate_answers.user_type = '2' THEN(SELECT(DOP) FROM l2_student WHERE l2_student.Id = scl_climate_answers.user_id LIMIT 1 )
            WHEN scl_climate_answers.user_type = '3' THEN(SELECT(DOP) FROM l2_teacher WHERE l2_teacher.Id = scl_climate_answers.user_id LIMIT 1 )
            WHEN scl_climate_answers.user_type = '4' THEN(SELECT(DOP) FROM l2_parents WHERE l2_parents.Id = scl_climate_answers.user_id LIMIT 1 )
        else 0 END ) as DOP,
        COUNT(scl_climate_answers.Id) as answers_counter,
        (SELECT GROUP_CONCAT(Gender_code) FROM scl_published_claimate_genders WHERE scl_published_claimate_genders.Climate_id = scl_published_claimate.Id) as genderslist,
        (SELECT GROUP_CONCAT(r_levels .class) FROM scl_published_claimate_levels
        JOIN r_levels ON r_levels.Id = scl_published_claimate_levels.Level_code
        WHERE scl_published_claimate_levels.Claimate_id = scl_published_claimate.Id) as levelslist,
        (SELECT GROUP_CONCAT(Type_code) FROM scl_published_claimate_types
        WHERE scl_published_claimate_types.Climate_id = scl_published_claimate.Id) as typeslist
        FROM scl_st_climate ,scl_st0_climate,sv_set_template_answers,sv_sets,sv_questions_library,l1_school,sv_st_category,scl_published_claimate
        LEFT JOIN scl_climate_answers ON scl_published_claimate.Id = scl_climate_answers.climate_id and $date
        WHERE scl_st_climate.Id = scl_published_claimate.climate_id
        and scl_st0_climate.Id = scl_st_climate.Climate_id
        and sv_set_template_answers.Id = scl_st0_climate.answer_group
        and sv_sets.Id = scl_st0_climate.set_id
        and sv_questions_library.Id = scl_st0_climate.question_id
        and sv_st_category.Id = scl_st0_climate.category
        and scl_st_climate.Published_by = l1_school.Added_By
        and l1_school.id = scl_published_claimate.By_school
        and l1_school.id = " . $this->schoolId . (empty($conditions) ? "" : (" and " . implode(' AND ', $conditions))) . "
        GROUP BY scl_climate_answers.climate_id
        ORDER BY scl_st0_climate.Id ASC;";
        //echo $query;
        //echo " ================================================ <br > ";
        //exit();

        return $this->db->query($query)->result_array();
    }

    public function published_courses(?int $id = null, ?int $category = null)
    {
        $language = $this->uri->segment(1);
        $type = $language == "AR" ? "AR_UserType" : "UserType";
        $level = $language == "AR" ? "Class_ar" : "Class";

        $this->db
            ->select("scou_st_courses.Startting_date AS from , scou_st_courses.End_date AS to , scou_st0_main_courses.Courses_Title AS courseTitle")
            ->select("COUNT(scou_st0_courses_topics.Id) AS topicsCount")
            ->select("(SELECT GROUP_CONCAT(r_levels." . $level . ") FROM scou_published_courses_levels
            JOIN `r_levels` ON `r_levels`.`Id` = `scou_published_courses_levels`.`Level_Id`
            WHERE `scou_published_courses_levels`.`Published_Courses_Id` = `scou_published_courses`.`Id`) as levelsList")
            ->select("(SELECT GROUP_CONCAT(r_usertype_school." . $type . ") FROM scou_published_courses_types 
            JOIN r_usertype_school ON r_usertype_school.Id = scou_published_courses_types.User_Type_Id
            WHERE scou_published_courses_types.Published_Courses_Id = `scou_published_courses`.`Id`) as typesList")
            ->select("(SELECT GROUP_CONCAT(r_gender.Gender_Type) FROM scou_published_courses_genders 
            JOIN r_gender ON r_gender.Id = 	scou_published_courses_genders.Gender_Id
            WHERE scou_published_courses_genders.Published_Courses_Id = `scou_published_courses`.`Id`) as gendersList")
            ->select("scou_published_courses.* ,scou_published_courses.Id as courseKey, scou_published_courses.TimeStamp AS publishedAt , scou_st_courses.*")
            ->select("scou_published_courses.Id as Id ,scou_published_courses.Status as status")
            ->join("scou_st_courses", "scou_published_courses.Courses_Id = scou_st_courses.Id")
            ->join("scou_st0_main_courses", "scou_st0_main_courses.Id = scou_st_courses.Main_Courses_Id")
            ->join("scou_st0_courses_topics", "scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id", "left")
            ->where("scou_published_courses.By_school", $this->schoolId)
            ->order_by("scou_published_courses.Id", "DESC")
            ->group_by("scou_published_courses.Id");

        if (!empty($category)) {
            $this->db->where("scou_st0_main_courses.Category_Id", $category);
        }

        return $this->db->get("scou_published_courses")->result_array();
    }
}
