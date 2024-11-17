<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sv_ministry_reports extends CI_Model
{

    public $schoolsarr = array();
    public $schools = array();
    public $user_id = 0;

    public function __construct()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->user_id = $sessiondata['admin_id'];
        $schools_data = $this->db->get_where('l1_school', ['Added_By' => $sessiondata['admin_id']])->result_array();
        $this->schoolsarr = array_column($schools_data, "Id");
        $this->schools = implode(',', array_column($schools_data, "Id"));
    }

    public function our_schools()
    {
        return $this->db->get_where('l1_school', array('Added_By' => $this->user_id))->result_array();
    }

    public function getSchools($asArray = false)
    {
        if ($asArray) {
            return $this->schoolsarr;
        }
        return $this->schools;
    }

    public function fullDataOfour_schools()
    {
        $schools = $this->db->query("SELECT l1_school.* , l2_avatars.Link AS Avatar
        FROM l1_school 
        LEFT JOIN l2_avatars ON `For_User` = l1_school.Id AND Type_Of_User = 'school'
        WHERE l1_school.Added_By = '" . $this->user_id . "' ")->result_array();
        // echo $this->db->last_query();
        return $schools;
    }

    public function our_surveys($user_id, $onlyFillable = false)
    {
        if ($onlyFillable) {
            $results = $this->db->query("SELECT
            `sv_st1_surveys`.`TimeStamp` AS creating_date ,
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
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Published_by` = '" . $user_id . "' AND `sv_st1_surveys`.`survey_type` = 'fillable'
            AND `sv_st_targeted_accounts`.`Status` = '1'
            GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        } else {
            if (empty($this->schools)) return [];

            $results = $this->db->query("SELECT
            `sv_school_published_surveys`.`Id` AS SVID,
            `sv_school_published_surveys`.`Created` AS Created_date,
            `sv_st_surveys`.`Id` AS main_survey_id,
            `sv_st1_surveys`.`Id` AS survey_id,
            `sv_st1_surveys`.`Status` AS status,
            `sv_st1_surveys`.`title_en` AS Title_en,
            `sv_st1_surveys`.`title_ar` AS Title_ar,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st1_surveys`.`TimeStamp` AS creating_date,
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
            (SELECT COUNT(DISTINCT sv_st1_answers.Id) FROM sv_st1_answers 
              JOIN sv_school_published_surveys svps ON svps.Serv_id = `sv_st1_surveys`.`Id` 
              WHERE sv_st1_answers.serv_id = svps.Id
              AND svps.`By_school` IN (" . $this->schools . ")
            ) AS answers_counter 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            LEFT JOIN `sv_school_published_surveys`  ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            LEFT JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
            LEFT JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Published_by` = " . $this->user_id . "
            GROUP BY sv_st1_surveys.Id ORDER BY `sv_st1_surveys`.`Id` DESC")->result_array();

            // user_id stand for ministry id
            // $results = $this->db->query("SELECT
            // `sv_st1_surveys`.`TimeStamp` AS creating_date ,
            // `sv_st1_surveys`.`Id` AS survey_id,
            // `sv_school_published_surveys`.`Id` AS SVID,
            // `sv_st_surveys`.`Id` AS main_survey_id,
            // `sv_st1_surveys`.`Status` AS status,
            // `sv_st1_surveys`.`title_en` AS Title_en,
            // `sv_st1_surveys`.`title_ar` AS Title_ar,
            // `sv_st1_surveys`.`Startting_date` AS From_date,
            // `sv_st1_surveys`.`End_date` AS To_date,
            // `sv_st_surveys`.`answer_group_en` AS group_id,
            // `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
            // `sv_st_surveys`.`code` AS serv_code,
            // `sv_sets`.`title_en` AS set_name_en,
            // `sv_sets`.`title_ar` AS set_name_ar ,
            // `sv_set_template_answers`.`title_en` AS choices_en_title ,
            // `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
            // (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter
            // FROM `sv_st1_surveys`
            // JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            // JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            // JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            // JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            // LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            // WHERE `sv_st1_surveys`.`Published_by` = '" . $user_id . "' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' GROUP BY `sv_st1_surveys`.`Id`")->result_array();
        }
        return $results;
    }


    public function surveysByType($typeCode)
    {
        if (empty($this->schools)) return [];

        return $this->db->query("SELECT
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
        (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $typeCode . "' ) AS answers_counter 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $typeCode . "' 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1'
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
    }

    public function avalaible_surveys($isfillable = false)
    {
        if ($isfillable) {
            $results = $this->db->query(" SELECT
            `sv_st_fillable_surveys`.`Id` AS survey_id,
            `sv_st_fillable_surveys`.`status` AS status,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
            `sv_st_fillable_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_st_fillable_questions`.`survey_id` AS connId ,
            COUNT(`sv_st_fillable_questions`.`Id`) AS questions_count
            FROM `sv_st_fillable_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_fillable_surveys`.`set_id`
            INNER JOIN `sv_st_fillable_questions` ON `sv_st_fillable_questions`.`survey_id` = `sv_st_fillable_surveys`.`Id`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_fillable_surveys`.`category`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_fillable_surveys`.`Id`
            WHERE `sv_st_fillable_surveys`.`status` = '1' AND `sv_st_targeted_accounts`.`Status` = '1'
            GROUP BY `sv_st_fillable_questions`.`survey_id` ORDER BY `sv_st_fillable_surveys`.`Id` ASC ")->result_array();
        } else {
            if (empty($this->schools)) return [];

            $results = $this->db->query(" SELECT
            `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_surveys`.`TimeStamp` AS Created,
            `sv_st_category`.`Cat_en` AS Title_en,
            `sv_st_category`.`Cat_ar` AS Title_ar,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_en` AS choices_ar_title ,
            `sv_st_questions`.`survey_id` AS connId ,
            (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter ,
            (SELECT COUNT(Id) FROM sv_st_questions WHERE `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id` ) AS questions_count
            FROM `sv_st_surveys`
            LEFT JOIN `sv_st1_surveys` ON `sv_st_surveys`.`Id` = `sv_st1_surveys`.`Survey_id`
            LEFT JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            AND `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
            LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
            GROUP BY `sv_st_surveys`.`Id` ORDER BY `sv_st_surveys`.`Id` ASC")->result_array();
        }
        // SELECT *,`" . $q_name . "`.`Id` AS q_id
        //   FROM `" . $q_name . "`
        //   INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_name . "`.`question_id`
        //   WHERE `survey_id` = '" . $group . "'
        return $results;
    }


    public function Get_surveys()
    {
        // this method used in serv_reports
        $today = date('Y-m-d');
        $surveys = $this->db->query(" SELECT
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
        `sv_set_template_answers`.`title_ar` AS choices_ar_title  ,
        (SELECT COUNT(Id) FROM `sv_school_published_surveys` WHERE `Serv_id` = `sv_st1_surveys`.`Id`) AS use_count 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_targeted_accounts`.`Status` = '1' AND `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st1_surveys`.`End_date` >= '" . $today . "' AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "' ")->result_array();
        return $surveys;
    }

    public function expired_surveys()
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
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' ")->result_array();
        return $expired_surveys;
    }

    public function expired_surveys_by_type($user_id, $usertype)
    {
        if (empty($this->schools)) return [];

        // this method used in serv_reports
        $today = date('Y-m-d');
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN ('" . $this->schools . "')
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
        AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' AND `sv_st_surveys`.`targeted_type` = 'M'  GROUP BY `sv_st1_surveys`.`Id` AND `sv_st_targeted_accounts`.`Status` = '1'")->result_array();
        return $expired_surveys;
    }

    public function completed_surveys($usertype = null)
    {
        // this method used in serv_reports
        //  AND `sv_st1_surveys`.`End_date` >= '" . $today . "' AND `sv_st1_surveys`.`Startting_date` <= '" . $today . "'
        $today = date('Y-m-d');
        if (empty($this->schools)) return [];

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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE `sv_st_surveys`.`targeted_type` = 'M'
        AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` " . ($usertype !== null ? "AND `sv_st1_answers`.`user_type`= '" . $usertype . "' " : "") . ") 
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        return $completed_surveys;
    }

    public function answerd_quastions()
    {
        if (empty($this->schools)) return [];

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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
        AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
        GROUP BY `sv_sets`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        return $answerd_quastions;
    }

    public function specific_type_surveys($user_id, $type, $onlyExpired = false)
    {
        if (empty($this->schools)) return [];

        $expired = "AND sv_st1_surveys.End_date >= '" . date("Y-m-d") . "' ";
        if ($onlyExpired) {
            $expired = "AND sv_st1_surveys.End_date < '" . date("Y-m-d") . "' ";
        }
        // this method used in serv_reports
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "' 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        WHERE `sv_st_surveys`.`targeted_type` = 'M' $expired
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        return $surveys;
    }


    public function specific_type_questions($user_id, $type)
    {
        if (empty($this->schools)) return [];

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
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`targeted_type` = 'M'
        GROUP BY  `sv_st_questions`.`Id`  ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
        return $quastions;
    }
	
    public function specific_type_completed_surveys($user_id, $type, $cat_id = "")
    {
        if (empty($this->schools)) return [];

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
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
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
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `sv_st_targeted_accounts`.`type` = 'Ministry' AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
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
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_surveys`.`category` = '" . $cat_id . "' AND `sv_st_targeted_accounts`.`Status` = '1'
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
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
                JOIN `sv_school_published_surveys_genders`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_surveys`.`category` = '" . $cat_id . "' AND `sv_st_targeted_accounts`.`Status` = '1'
                AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
                GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            }
        }

        return $specific_type_completed_surveys;
    }

    public function specific_type_timeOfFinishing($user_id, $type = "")
    {
        if (empty($this->schools)) return [];

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
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
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
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        }

        return $specific_type_timeOfFinishing;
    }


    public function surveys_by_gender($user_id, $gender = "", $usertype = "", $onlyExpired = false)
    {
        $dynamiccond[] = " sv_st1_surveys.End_date >= '" . date("Y-m-d") . "' ";
        if ($onlyExpired) {
            $dynamiccond[] = " sv_st1_surveys.End_date < '" . date("Y-m-d") . "' ";
        }

        if ($usertype !== "") {
            $dynamiccond[] = "  `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "' ";
        }

        if ($gender !== "") {
            $dynamiccond[] = "  `sv_school_published_surveys_genders`.`Gender_code` = '" . $gender . "' ";
        }


        $results = $this->db->query(" SELECT
        `sv_school_published_surveys`.`Id` AS survey_id
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        WHERE " . implode(' AND ', $dynamiccond) . " AND `sv_st1_surveys`.`Id` = " . $this->user_id . "
        GROUP BY survey_id  ")->num_rows();

        //echo $this->db->last_query();
        return $results;
    }

    // start of reports in survey_reports

    public function users_passed_survey($surv_id, $type = "", $filters = ['schools' => null, 'classes' => null])
    {
        $cond = "(SELECT sv_st1_answers.Id FROM `sv_school_published_surveys`
        JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
        WHERE `sv_school_published_surveys`.`Serv_id` = '" . $surv_id . "')";
        if ($type !== "") {
            $cond = "(SELECT sv_st1_answers.Id FROM `sv_school_published_surveys`
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
            WHERE `sv_school_published_surveys`.`Serv_id` = '" . $surv_id . "' AND `sv_st1_answers`.`user_type` = '" . $type . "' )";
        }
        $userFilter = "";
        if ($filters["schools"] !== null) {
            $schools = implode(', ', $filters["schools"]);
            $userFilter .= " AND Added_By IN (" . $schools . ") ";
        }

        $StudentFilter = "";
        if ($filters["classes"] !== null) {
            $classes = implode(', ', $filters["classes"]);
            $StudentFilter .= " AND Class IN (" . $classes . ") ";
        }
        $results = $this->db->query("SELECT 
           CONCAT (`sv_st1_answers`.`user_id`, '_', `sv_st1_answers`.`user_type`) AS GroupKey,
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` $userFilter )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` $userFilter $StudentFilter)
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` $userFilter )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN(SELECT name_en FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`))
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
            `sv_st1_answers`.`Id` AS answerkey ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            WHERE `sv_st1_answers`.`Id` IN $cond 
            AND (CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` $userFilter )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` $userFilter $StudentFilter)
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` $userFilter )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` )
                ELSE NULL
            END) IS NOT NULL  
            GROUP BY GroupKey
            ORDER BY `sv_st1_answers`.`Id`  DESC ")->result_array();

        //echo $this->db->last_query();
        if ($filters["classes"] !== null || $filters["schools"]) {
            $filtredresults = [];
            foreach ($results as $key => $result) {
                if ($result['U_Name'] !== null) {
                    $filtredresults[] = $result;
                }
            }
            return $filtredresults;
        } else {
            return $results;
        }
    }

    public function users_passed_category($cat, $type = "")
    {
        if (empty($type)) {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` )
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
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            JOIN `l1_school` ON `l1_school`.`Id` = `sv_school_published_surveys`.`By_school`
            WHERE `sv_st_surveys`.`category` = '" . $cat . "' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
            AND `l1_school`.`Added_By` = '" . $this->user_id . "'
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        } else {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`show_user_name` = '0' THEN 'sent as anonymous'
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` )
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
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            JOIN `l1_school` ON `l1_school`.`Id` = `sv_school_published_surveys`.`By_school`
            WHERE  `sv_st_surveys`.`category` = '" . $cat . "' AND `sv_st1_answers`.`user_type` = '" . $type . "' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
            AND `l1_school`.`Added_By` = '" . $this->user_id . "'
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        }
        return $results;
    }


    public function survey_q_results($surv_id)
    {
        $result = $this->db->query(" SELECT
        `sv_set_template_answers_choices`.`title_en` AS `choices_en` ,
        `sv_set_template_answers_choices`.`title_ar` AS `choices_ar` ,
        `sv_set_template_answers_choices`.`Id` AS `Id`
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st_surveys`.`Id` = `sv_st1_surveys`.`Survey_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers_choices` ON `sv_set_template_answers_choices`.`group_id` = `sv_set_template_answers`.`Id`
        WHERE `sv_st1_surveys`.`Id` = '" . $surv_id . "' AND `sv_st_surveys`.`targeted_type` = 'M' ")->result_array();
        // echo $this->db->last_query();
        return $result;
    }

    public function get_surv_data($surv_id)
    {
        $serv_data = $this->db->query(" SELECT 
        `sv_st1_surveys`.`title_en` AS Title_en,
        `sv_st_surveys`.`Message_en` AS Message,
        `sv_st_surveys`.`answer_group_en` AS group_id ,
        `sv_st_surveys`.`Id` AS main_survey_id
        FROM `sv_st1_surveys` 
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Id` = '" . $surv_id . "' AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' ")->result_array();
        return $serv_data;
    }

    public function get_surv_quastions($surv_id)
    {
        $surv_data = $this->get_surv_data($surv_id);
        if (!empty($surv_data)) {
            $main_surv_id = $surv_data[0]['main_survey_id'];
            $result = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
            FROM `sv_st_questions`
            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
            WHERE `sv_st_questions`.`survey_id` = '" . $main_surv_id . "' ")->result_array();
            return $result;
        }
        return array();
    }

public function get_surv_percintage_graph($surv_id)
    {
        $result = $this->db->query("SELECT 
        COUNT(`sv_st1_answers_values`.`Id`) AS All_Count 
        FROM `sv_st1_answers_values` 
        GROUP BY `choice_id`")->result_array();
        return $result;
    }

    public function get_surv_percintage_by_gender($surv_id, $gender, $usertype = "", $filters = ['schools' => null, 'classes' => null])
    {
        $cond = "(SELECT sv_st1_answers.Id FROM `sv_school_published_surveys`
        JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
        WHERE `sv_school_published_surveys`.`Serv_id` = '" . $surv_id . "')";
        if ($usertype !== "") {
            $cond = "(SELECT sv_st1_answers.Id FROM `sv_school_published_surveys`
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
            WHERE `sv_school_published_surveys`.`Serv_id` = '" . $surv_id . "' AND `sv_st1_answers`.`user_type` = '" . $usertype . "' )";
        }


        $userFilter = "";
        if (isset($filters["schools"]) && $filters["schools"] !== null) {
            $schools = implode(', ', $filters["schools"]);
            $userFilter .= " AND Added_By IN (" . $schools . ") ";
        }
        $StudentFilter = "";
        if (isset($filters["classes"]) && $filters["classes"] !== null) {
            $classes = implode(', ', $filters["classes"]);
            $StudentFilter .= " AND Class IN (" . $classes . ") ";
        }

        if ($usertype == "") {
            // the basic function (wthout the type)
            // passed 0 mean male
            $p_gender = $gender == "M" ? "1" : "2";
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' $userFilter LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' $userFilter $StudentFilter LIMIT  1 )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' $userFilter LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $p_gender . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            WHERE `sv_st1_answers`.`Id` IN $cond
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        } else {
            $p_gender = $gender == "M" ? "1" : "2";
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' $userFilter LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' $userFilter $StudentFilter LIMIT  1 )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' $userFilter LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $p_gender . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            WHERE `sv_st1_answers`.`Id` IN $cond
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        }
    }

    public function get_all_surv_percintage_by_gender($gender, $usertype = null)
    {
        if (empty($usertype)) {
            // the basic function (wthout the type)
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
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            JOIN `sv_st1_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` 
            WHERE (CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT Id FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT Id FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' LIMIT  1 )
                WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT Id FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
                WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT Id FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $gender . "' LIMIT 1 )
                ELSE NULL
            END) IS NOT NULL
            AND sv_st1_surveys.Published_by = " . $this->user_id . "
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        } else {
            $results = $this->db->query("SELECT 
            CASE
                WHEN `sv_st1_answers`.`user_type` = '" . $usertype . "' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
                ELSE NULL
            END AS U_Name ,
            `sv_st1_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_answers`.`finishing_time` AS Finish_time
            FROM `sv_st1_answers`
            JOIN `sv_school_published_surveys` ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            JOIN `sv_st1_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` 
            WHERE (CASE
                WHEN `sv_st1_answers`.`user_type` = '" . $usertype . "' THEN (SELECT Id FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
            ELSE NULL
            END) IS NOT NULL
            AND sv_st1_surveys.Published_by = " . $this->user_id . "
            AND `sv_st1_answers`.`user_type` = '" . $usertype . "'
            ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
            return $results;
        }
    }


    // for more detailed report
    public function get_q_answer_percintage_by_gender($surv_id, $quastion, $choice, $gender)
    {
        // passed 0 mean male
        $p_gender = $gender == "0" ? "1" : "2";
        $results = $this->db->query("SELECT 
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $gender . "' LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` AND `l2_student`.`Gender` = '" . $gender . "' LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $gender . "' LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` AND `l2_parents`.`gender` = '" . $p_gender . "' LIMIT 1 )
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

    public function get_users_ages($surv_id, $usertype)
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
        FROM `sv_st1_answers` WHERE `sv_st1_answers`.`serv_id` = '" . $surv_id . "' AND `user_type` = '" . $usertype . "'
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        $results = $this->change_to_age($data);
        return $results;
    }


    private function change_to_age($data)
    {
        $dops = array_column($data, "DOP");
        foreach ($dops as $key => $dop) {
            $todayDate = date('Y-m-d');
            $year = date("Y-m-d", strtotime($dop));
            $data[$key]['DOP'] = date_diff((new DateTime($year)), (new DateTime($todayDate)))->y;
        }
        return $data;
    }


    /**
     * @categorys reports
     */
    public function category_by_gender($user_id, $gender = "", $usertype = "", $cat = "")
    {
        if (empty($this->schools)) return [];

        if ($usertype == "") {
            if (!empty($gender)) {
                // for spicifec gender
                $other_gen = ($gender == '1' ? '2' : '1');
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '" . $gender . "'
                JOIN `sv_school_published_surveys_genders` __females ON `sv_school_published_surveys`.`Id` = __females.`Survey_id` AND __females.`Gender_code` != '" . $other_gen . "'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
                GROUP BY `sv_school_published_surveys`.`Id` ")->num_rows();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '1'
                JOIN `sv_school_published_surveys_genders` __females ON `sv_school_published_surveys`.`Id` = __females.`Survey_id` AND __females.`Gender_code` = '2'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
                GROUP BY `sv_school_published_surveys`.`Id` ")->num_rows();
            }
        } else {
            if (!empty($gender)) {
                // for spicifec gender
                $other_gen = ($gender == '1' ? '2' : '1');
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '" . $gender . "'
                JOIN `sv_school_published_surveys_genders` __females ON `sv_school_published_surveys`.`Id` = __females.`Survey_id` AND __females.`Gender_code` != '" . $other_gen . "'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
                GROUP BY `sv_school_published_surveys`.`Id`")->num_rows();
            } else {
                $results = $this->db->query(" SELECT
                `sv_school_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_school_published_surveys` 
                ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
                JOIN `sv_school_published_surveys_types`  
                ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_school_published_surveys_genders` __males ON `sv_school_published_surveys`.`Id` = __males.`Survey_id` AND __males.`Gender_code` = '1'
                JOIN `sv_school_published_surveys_genders` __females ON `sv_school_published_surveys`.`Id` = __females.`Survey_id` AND __females.`Gender_code` = '2'
                JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
                WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND `sv_st_targeted_accounts`.`Status` = '1'
                GROUP BY `sv_school_published_surveys`.`Id`")->num_rows();
            }
        }
        return $results;
    }

    public function category_publishid_surveys($user_id, $cat_id)
    {
        if (empty($this->schools)) return [];

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
        (SELECT COUNT(Id) FROM sv_st1_answers WHERE  `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter ,
        (SELECT GROUP_CONCAT(sv_sets.title_en) FROM sv_sets WHERE  `sv_sets`.`Id` = `sv_st_surveys`.`set_id`) AS surveysTitles 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
        AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1'
        GROUP BY sv_st1_surveys.Survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        return $our_surveys;
    }


    public function ages_forall_users($user_id, $grouping = true)
    {
        $data = $this->db->query("SELECT DOP , Id , 'staff' as type FROM l2_staff 
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

    public function ages_for_all_passed_users($user_id, $grouping = true)
    {
    $data = $this->db->query("
        SELECT 
            TIMESTAMPDIFF(YEAR, 
                CASE
                    WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT DOP FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1)
                    WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT DOP FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1)
                    WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT DOP FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1)
                    WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT DOP FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1)
                    ELSE NULL
                END, NOW()) AS age,
            CASE
                WHEN `sv_st1_answers`.`user_type` = '1' THEN 'staff'
                WHEN `sv_st1_answers`.`user_type` = '2' THEN 'Student'
                WHEN `sv_st1_answers`.`user_type` = '3' THEN 'teacher'
                WHEN `sv_st1_answers`.`user_type` = '4' THEN 'parents'
                ELSE NULL
            END AS type 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_school_published_surveys` ON `sv_school_published_surveys`.`Serv_id` = `sv_st1_surveys`.`Id` 
        JOIN `sv_school_published_surveys_types` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN `sv_st1_answers` ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id`) 
        AND `sv_st1_surveys`.`Published_by` = $user_id
        GROUP BY `sv_st1_answers`.`user_type`, `sv_st1_answers`.`user_id`
    ")->result_array();

    return ($grouping) ? $this->group_by("type", $data) : $data;
}


    public function martial_status($user_type)
    {
        if (empty($this->schools)) return [];

        $data = $this->db->query(" SELECT 
        DISTINCT(`sv_st1_answers`.`Id`) ,
        CASE
            WHEN `sv_st1_answers`.`user_type` = '1' THEN (SELECT martial_status FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '2' THEN (SELECT martial_status FROM `l2_student` WHERE `l2_student`.`Id` = `sv_st1_answers`.`user_id` LIMIT  1 )
            WHEN `sv_st1_answers`.`user_type` = '3' THEN (SELECT martial_status FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            WHEN `sv_st1_answers`.`user_type` = '4' THEN (SELECT martial_status FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_st1_answers`.`user_id` LIMIT 1 )
            ELSE NULL
        END AS Mar_status ,
        `sv_st1_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_answers`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Id` = `sv_st1_answers`.`serv_id` 
        AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
        WHERE `sv_st1_answers`.`user_type`  = '" . $user_type . "'
        GROUP BY `sv_st1_answers`.`user_type`, `sv_st1_answers`.`user_id`
        ORDER BY `sv_st1_answers`.`Id` DESC ")->result_array();
        $returned_results = $this->group_by("Mar_status", $data);
        $names = array_column($this->db->get('l2_martial_status')->result_array(), "name");
        $results = array();
        // $results = str_replace(array_keys($results), $names, $site['Site_For']);
        foreach ($returned_results as $key => $result) {
            $key = str_replace(array_keys($returned_results), $names, $key);
            $results[$key] = sizeof($result);
        }
        return $results;
    }

    private function group_by($key, $data)
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

    public function usedcategorys()
    {
        $results = $this->db->query(" SELECT * ,
        ( SELECT COUNT(`sv_st1_surveys`.`Id`)
        FROM `sv_st1_surveys` 
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` AND `sv_st_surveys`.`targeted_type` = 'M' ) AS counter_of_using
        FROM `sv_st_category`
        /* start exist condition */
        WHERE EXISTS ( SELECT `sv_st1_surveys`.`Id`
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`  
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` AND `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st_targeted_accounts`.`Status` = '1' AND `sv_st_targeted_accounts`.`Status` = '1'
        AND `sv_st1_surveys`.`Published_by` = '" . $this->user_id . "' )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
        return $results;
    }

    public function usedClimatesCategories()
    {
        $results = $this->db->query(" SELECT * ,
        ( SELECT COUNT(`scl_st_climate`.`Id`)
        FROM `scl_st_climate` 
        JOIN `scl_st0_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'   AND `sv_st_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate`.`category` = `sv_st_category`.`Id` AND `scl_st0_climate`.`targeted_type` = 'M' ) AS counter_of_using
        FROM `sv_st_category`
        /* start exist condition */
        WHERE EXISTS ( SELECT `scl_st_climate`.`Id`
        FROM `scl_st_climate`
        JOIN `scl_st0_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`  
        JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        WHERE `scl_st0_climate`.`category` = `sv_st_category`.`Id` AND `scl_st0_climate`.`targeted_type` = 'M' AND `scl_st_climate`.`Published_by` = '" . $this->user_id . "' )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
        return $results;
    }

    public function schoolsBySurveys()
    {
        if ($this->uri->segment(1) == "AR") { // setting the name based on the link
            $col = "School_Name_AR";
        } else {
            $col = "School_Name_EN";
        }
        $result = $this->db->query("SELECT `l1_school`.`" . $col . "` AS school_name , `l1_school`.`Id` , 
        (SELECT COUNT(Id) FROM `sv_school_published_surveys` WHERE `sv_school_published_surveys`.`By_school` = `l1_school`.`Id` ) AS surveysCount
        FROM `l1_school`
        WHERE `Added_By` = '" . $this->user_id . "' AND EXISTS (SELECT Id FROM sv_school_published_surveys 
        WHERE `sv_school_published_surveys`.`By_school` = `l1_school`.`Id` ) ")->result_array();
        return $result;
    }

    public function ClimatesurveysLibrary()
    {
        $results = $this->db->query(" SELECT
        `scl_st0_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS survey_id,
        `scl_st0_climate`.`status` AS status,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`en_title` AS question ,
        `sv_questions_library`.`ar_title` AS question_ar ,
        (SELECT COUNT(`scl_published_claimate`.`Id`) 
        FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`                
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        LEFT JOIN `scl_st_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        JOIN `scl_st0_climate_targeted_accounts` ON `scl_st0_climate_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `scl_st0_climate_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate_targeted_accounts`.`Status` = '1'  AND `scl_st0_climate`.`targeted_type` = 'M' 
        GROUP BY `scl_st0_climate`.`Id`
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
        return $results;
    }

    public function OurClimatesurveys()
    {
        $results = $this->db->query(" SELECT
        `scl_st0_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_st0_climate`.`status` AS adminStatus,
        `scl_st_climate`.`Id` AS survey_id,
        `scl_st_climate`.`status` AS status,
        `scl_st_climate`.`Title_en` AS Title_en,
        `scl_st_climate`.`Title_ar` AS Title_ar,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`en_title` AS question ,
        `sv_questions_library`.`ar_title` AS question_ar ,
        `scl_st_climate`.`Startting_date` AS From_date ,
        `scl_st_climate`.`End_date` AS To_date ,
        (SELECT COUNT(`scl_published_claimate`.`Id`) 
        FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`                
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        JOIN `scl_st_climate` ON `scl_st_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        JOIN `scl_st0_climate_targeted_accounts` ON `scl_st0_climate_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `scl_st0_climate_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate`.`targeted_type` = 'M'  AND `scl_st0_climate_targeted_accounts`.`Status` = '1'  AND `scl_st_climate`.`Published_by` = '" . $this->user_id . "'
        GROUP BY `scl_st_climate`.`Id`
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
        return $results;
    }

    // climate surveys reports
    public function GetClimatesurveys(array $filters = [], $byId = null)
    {
        if (empty($this->schools)) return [];

        /*
        filters array example :
        *[
            'surveyid' => "number" ,
            'school' => "number" ,
            'title' => "string" ,
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
        $this->db->select('`scl_st0_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_published_claimate`.`Id` AS survey_id,
        `scl_published_claimate`.`Status` AS status,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `sv_st_category`.`Id` AS Cat_id,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_sets`.`Id` AS set_id,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`' . $q . '` AS question ,
        `scl_st_climate`.`Startting_date` AS from_date ,
        `scl_published_claimate`.`TimeStamp` AS publishedAt,
        `scl_st_climate`.`End_date` AS to_date,scl_climate_answers.Id AS AnswerKey ');
        $this->db->select("(SELECT CASE
                WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT (DOP) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT (DOP) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT  1 )
                WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT (DOP) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT (DOP) FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
            ELSE 0
        END ) AS DOP ");
        $this->db->select('COUNT(scl_climate_answers.Id) AS answers_counter');
        $this->db->select("(SELECT GROUP_CONCAT(Gender_code) FROM scl_published_claimate_genders WHERE scl_published_claimate_genders.Climate_id = `scl_published_claimate`.`Id`) AS genderslist");
        $this->db->select('(SELECT GROUP_CONCAT(r_levels.' . $col . ') FROM scl_published_claimate_levels 
        JOIN `r_levels` ON `r_levels`.`Id` = `scl_published_claimate_levels`.`Level_code`
        WHERE `scl_published_claimate_levels`.`Claimate_id` = `scl_published_claimate`.`Id`) AS levelslist');
        $this->db->select('(SELECT GROUP_CONCAT(Type_code) FROM scl_published_claimate_types WHERE scl_published_claimate_types.Climate_id = `scl_published_claimate`.`Id`) AS typeslist');
        $this->db->from('scl_published_claimate');
        $this->db->join('scl_st_climate', 'scl_st_climate.Id = scl_published_claimate.climate_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_climate.Climate_id');
        $this->db->join('sv_set_template_answers', 'sv_set_template_answers.Id = scl_st0_climate.answer_group');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('l1_school', 'l1_school.Added_By = scl_st_climate.Published_by');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('scl_climate_answers', 'scl_published_claimate.Id = scl_climate_answers.climate_id', 'left');
        if (isset($filters['gender'])) {
            $this->db->where(" (CASE
            WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` AND `l2_student`.`Gender` = '" . $filters['gender'] . "' LIMIT  1 )
            WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` AND `l2_parents`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )
        ELSE NULL
        END)", "IS NOT NULL", false);
        }
        if (isset($filters['usertype'])) {
            $this->db->where('scl_climate_answers.user_type', $filters['usertype']);
        }
        if (isset($filters['surveyid'])) {
            $this->db->where('scl_published_claimate.Id', $filters['surveyid']);
        }
        $this->db->where('scl_climate_answers.TimeStamp >=', $today . " 00:00:00");
        $this->db->where('scl_climate_answers.TimeStamp <=', $today . " 23:59:59");
        if (!empty($filters['school'])) {
            $this->db->where('scl_published_claimate.By_school', $filters['school']);
        } else {
            $this->db->where_in('scl_published_claimate.By_school', $this->schoolsarr);
        }
        if ($byId !== null) {
            $this->db->where('scl_published_claimate.Id', $byId);
        }
        $this->db->group_by('scl_published_claimate.Id');
        $this->db->order_by('scl_st0_climate.Id', 'ASC');
        // title
        if (!empty($filters['title'])) {
            $this->db->like('scl_st_climate.Title_en', $filters["title"]);
            $this->db->or_like('scl_st_climate.Title_ar', $filters["title"]);
        }
        if ($byId !== null) {
            $data = $this->db->get()->row();
        } else {
            $data = $this->db->get()->result_array();
        }
        // age filter
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

    public function ClimateChoices(array $filters = [])
    {
        if (empty($this->schools)) return [];

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

        $this->db->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
        sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ');
        $this->db->select("(SELECT CASE
                WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT (DOP) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT (DOP) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT  1 )
                WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT (DOP) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
                WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT (DOP) FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )
            ELSE 0
        END ) AS DOP ");
        $this->db->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar');
        $this->db->select('COUNT(scl_climate_answers.Id) AS ChooseingTimes');
        $this->db->from('scl_st_choices');
        $this->db->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('scl_climate_answers', 'scl_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left');
        $this->db->join('scl_published_claimate', 'scl_published_claimate.Id = `scl_climate_answers`.`climate_id` ');
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
        $this->db->where_in('scl_published_claimate.By_school', $this->schoolsarr);
        // $this->db->order_by('position', 'ASC');
        $this->db->group_by('scl_st_choices.Id');
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

    public function getclimatesurveyslibrary($categories)
    {
        $group = "GROUP BY `scl_st_climate`.`Id`";
        if ($categories) {
            $group = " GROUP BY `sv_st_category`.`Id` ";
        }
        return $this->db->query(" SELECT
        `scl_st_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_st_climate`.`Id` AS survey_id,
        `scl_st_climate`.`status` AS status,
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
        WHERE `scl_st_climate`.`Published_by` = '" . $this->user_id . "'
        $group
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
    }

    public function GetClimateAnswers($surveyId, $main_survey_id, $filters = [])
    {
        /**
         *  Filters :
         * 'ByType' => null, 'gender' => null
         */
        $this->db
            ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
            sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
            ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
            ->select('COUNT(scl_climate_answers.Id) AS ChooseingTimes')
            ->from('scl_st_choices')
            ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
            ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
            ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
            ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
            ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
            ->join('scl_climate_answers', 'scl_climate_answers.climate_id = ' . $surveyId . ' AND  scl_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left')
            ->where('servey_id', $main_survey_id);
        if (isset($filters['ByType'])) {
            $this->db->where('scl_climate_answers.user_type', $filters['ByType']);
        }
        if (isset($filters['gender'])) {
            $this->db->where(" (CASE
            WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` AND `l2_staff`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` AND `l2_student`.`Gender` = '" . $filters['gender'] . "' LIMIT  1 )
            WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` AND `l2_teacher`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )
            WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` AND `l2_parents`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )
        ELSE NULL
        END)", "IS NOT NULL", false);
        }
        $this->db->order_by('position', 'ASC');
        $this->db->group_by('scl_climate_answers.answer_id');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function timeOfFinishingForThisSurvey($survey_id, $type = "")
    {
        if (empty($this->schools)) return [];

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
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '" . $type . "'
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_answers` 
            WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "' ) 
            AND `sv_school_published_surveys`.`Serv_id` = '" . $survey_id . "'
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
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` IN (" . $this->schools . ")
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_answers` 
            WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
            AND `sv_school_published_surveys`.`Serv_id` = '" . $survey_id . "'
            GROUP BY `sv_st1_answers`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
        }
        return $results;
    }
}
