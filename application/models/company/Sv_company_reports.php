<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sv_company_reports extends CI_Model
{

    public $departmentsarr = array();
    public $departments = array();
    public $user_id = 0;

    public function __construct()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->user_id = $sessiondata['admin_id'];
        $departments_data = $this->db->get_where('l1_co_department', array('Added_By' => $sessiondata['admin_id']))->result_array();
        $this->departmentsarr = array_column($departments_data, "Id");
        $this->departments = implode(',', array_column($departments_data, "Id"));
    }


    public function our_departments($returnString = false)
    {
        if (!$returnString) {
            $departments = $this->db->get_where("l1_co_department", ['Added_By' => $this->user_id])->result_array();
        } else {
            $departments = $this->departments;
        }
        return $departments;
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
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_fillable_surveys`.`Id`
            WHERE `sv_st_fillable_surveys`.`status` = '1' AND `sv_st_targeted_accounts`.`Status` = '1' AND `sv_st_targeted_accounts`.`Status` = '1' AND `sv_st_surveys`.`targeted_type` = 'C'
            GROUP BY `sv_st_fillable_questions`.`survey_id` ORDER BY `sv_st_fillable_surveys`.`Id` ASC ")->result_array();
        } else {
            $results = $this->db->query(" SELECT
            `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_category`.`Cat_en` AS Title_en,
            `sv_st_category`.`Cat_ar` AS Title_ar,
            `sv_st_surveys`.`answer_group_en` AS group_id,
            `sv_st_surveys`.`code` AS serv_code,
            `sv_sets`.`title_en` AS set_name_en,
            `sv_sets`.`title_ar` AS set_name_ar ,
            `sv_set_template_answers`.`title_en` AS choices_en_title ,
            `sv_set_template_answers`.`title_en` AS choices_ar_title ,
            `sv_st_questions`.`survey_id` AS connId ,
            COUNT(`sv_st_questions`.`survey_id`) AS questions_count,
            (SELECT COUNT(Id) FROM `sv_set_template_answers_choices` WHERE `group_id` = `sv_st_surveys`.`answer_group_en` ) AS choices_count
            FROM `sv_st_surveys`
            INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            INNER JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
            INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->user_id . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'C'  AND `sv_st_targeted_accounts`.`Status` = '1'
            GROUP BY `sv_st_questions`.`survey_id` ORDER BY `sv_st_surveys`.`Id` ASC")->result_array();
            // echo $this->db->last_query();
        }
        return $results;
    }

    public function our_surveys()
    {
        $query = "SELECT
        `sv_st1_co_surveys`.`Id` AS survey_id,
        `sv_st1_co_surveys`.`TimeStamp` AS creating_date ,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_co_surveys`.`Status` AS status,
        `sv_st1_co_surveys`.`title_en` AS Title_en,
        `sv_st1_co_surveys`.`title_ar` AS Title_ar,
        `sv_st1_co_surveys`.`Startting_date` AS From_date,
        `sv_st1_co_surveys`.`End_date` AS To_date,
        `sv_st_surveys`.`answer_group_en` AS group_id,
        `sv_st_surveys`.`answer_group_ar` AS group_id_ar,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title ,
        (SELECT COUNT(Id) FROM `sv_co_published_surveys` WHERE `Serv_id` = `sv_st1_co_surveys`.`Id` AND `Created_By` = '" . $this->user_id . "' ) AS use_count 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        LEFT JOIN `sv_co_published_surveys` ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Published_by` = '" .  $this->user_id . "' 
        AND `sv_st1_co_surveys`.`Avalaible_to` = 'C' OR `sv_st1_co_surveys`.`Avalaible_to` = '1'
        AND  `sv_st1_co_surveys`.`Status` = '1' AND `sv_st1_co_surveys`.`End_date` >= '" . date("Y-m-d") . "' AND `sv_st1_co_surveys`.`Startting_date` <= '" . date("Y-m-d") . "'
        GROUP BY `sv_st1_co_surveys`.`Id`";
        $results = $this->db->query($query)->result_array();
        // echo $query;
        return $results;
    }

    public function our_published_surveys()
    {
        $data = $this->db->query("SELECT
        `sv_co_published_surveys`.`Id` AS svId,
        `sv_st1_co_surveys`.`Id` AS survey_id,
        `sv_st1_co_surveys`.`Created` AS Created_date,
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
        (SELECT COUNT(Id) FROM `sv_co_published_surveys` WHERE `Serv_id` = `sv_st1_co_surveys`.`Id` AND `Created_By` IN (" . $this->departments . ") ) AS use_count  
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        LEFT JOIN `sv_co_published_surveys` ON `sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id`
        GROUP BY `sv_st1_co_surveys`.`Id` ORDER BY `sv_st1_co_surveys`.`TimeStamp` DESC")->result_array();
        return $data;
    }

    public function ClimatesurveysLibrary()
    {
        if ($this->uri->segment(1) == "AR") { // setting the name based on the link
            $col = "ar_title";
        } else {
            $col = "en_title";
        }
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
        `sv_questions_library`.`" . $col . "` AS question ,
        (SELECT COUNT(`scl_published_claimate`.`Id`) 
        FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_co_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`                
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        LEFT JOIN `scl_st_co_climate` ON `scl_st_co_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_co_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        JOIN `scl_st0_climate_targeted_accounts` ON `scl_st0_climate_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `scl_st0_climate_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate`.`status` = '1' AND `scl_st0_climate_targeted_accounts`.`Status` = '1' AND `scl_st0_climate`.`targeted_type` = 'C' 
        GROUP BY `scl_st0_climate`.`Id`
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
        return $results;
    }

    public function OurClimatesurveys()
    {
        $results = $this->db->query(" SELECT
        `scl_st0_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_st_co_climate`.`Id` AS survey_id,
        `scl_st_co_climate`.`status` AS status,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`en_title` AS question ,
        `scl_st_co_climate`.`Startting_date` AS from_date ,
        `scl_st_co_climate`.`End_date` AS to_date ,
        (SELECT COUNT(`scl_published_claimate`.`Id`) 
        FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_co_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`                
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        JOIN `scl_st_co_climate` ON `scl_st_co_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_co_claimate` ON `scl_published_co_claimate`.`climate_id` = `scl_st_co_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        JOIN `scl_st0_climate_targeted_accounts` ON `scl_st0_climate_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `scl_st0_climate_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate`.`targeted_type` = 'C' AND `scl_st0_climate_targeted_accounts`.`Status` = '1'  AND `scl_st_co_climate`.`Published_by` = '" . $this->user_id . "'
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
        return $results;
    }

    public function getAClimateSurvey($svid)
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
        (SELECT COUNT(`scl_published_claimate`.`Id`) 
        FROM scl_published_claimate WHERE `scl_published_claimate`.`climate_id` = `scl_st_co_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        LEFT JOIN `scl_st_co_climate` ON `scl_st_co_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_claimate` ON `scl_published_claimate`.`climate_id` = `scl_st_co_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        JOIN `scl_st0_climate_targeted_accounts` ON `scl_st0_climate_targeted_accounts`.`account_id` = '" . $this->user_id . "' AND `scl_st0_climate_targeted_accounts`.`survey_id` = `scl_st0_climate`.`Id`
        WHERE `scl_st0_climate`.`Id` = '" . $svid . "' AND `scl_st0_climate`.`targeted_type` = 'C' AND `scl_st0_climate_targeted_accounts`.`Status` = '1' 
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
        return $results;
    }


    public function specific_type_questions($type)
    {
        $quastions = $this->db->query(" SELECT
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
        `sv_st_questions`.`Id`   AS q_id,
        `sv_st_surveys`.`code` AS serv_code,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_en_title ,
        `sv_set_template_answers`.`title_ar` AS choices_ar_title 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_co_published_surveys` ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
        JOIN `sv_co_published_surveys_types` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`  AND `sv_co_published_surveys_types`.`Type_code` = '" . $type . "'
        JOIN `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` 
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`targeted_type` = 'M'
        GROUP BY  `sv_st_questions`.`Id`  ORDER BY `sv_co_published_surveys`.`Id` DESC")->result_array();
        return $quastions;
    }

    public function timeOfFinishing($filters = ['type' => null])
    {
        $this->db->select('`sv_st1_co_answers`.`finishing_time` AS Finishing_time,
        AVG(`sv_st1_co_answers`.`finishing_time`) AS Finishing_time_avg ,
        SUM(`sv_st1_co_answers`.`finishing_time`) AS sum_of_all');
        $this->db->from("sv_st1_co_surveys");
        $this->db->join("sv_st_surveys", "`sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`");
        $this->db->join("sv_sets", "`sv_sets`.`Id` = `sv_st_surveys`.`set_id`");
        $this->db->join("sv_set_template_answers", "`sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`");
        $this->db->join("sv_co_published_surveys", "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->join("sv_st1_co_answers", "`sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`");
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->join("sv_st_targeted_accounts", "`sv_st_targeted_accounts`.`account_id` =  '" . $this->user_id . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`  AND `sv_st_targeted_accounts`.`Status` = '1'");
        $this->db->where("`sv_st1_co_surveys`.`Status`", '1');
        $this->db->where("`sv_st_surveys`.`targeted_type`", 'C');
        $this->db->where("EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` ) ");
        if ($filters['type'] !== null) {
            $this->db->where("`l2_co_patient`.`UserType`", $filters['type']);
        }
        $this->db->group_by("`sv_st1_co_answers`.`Id`");
        $this->db->order_by("`sv_st1_co_answers`.`TimeStamp`", "DESC");
        $result = $this->db->get()->result_array();
        $result = $this->calculate_avg_time($result);
        return $result;
    }

    private function calculate_avg_time($returned_data)
    {
        $durations = array_column($returned_data, 'Finishing_time');
        $sum = 0.0;
        foreach ($durations as $duration) {
            list($h, $m, $s) = explode(':', $duration);
            $sum += $h * 3600 + $m * 60 + $s;
        }
        if ($sum !== 0.0) {
            $avg = $sum / count($durations);
            $hours = floor($avg / 3600);
            $mins = floor($avg / 60 % 60);
            $secs = floor($avg % 60);
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            return $timeFormat;
        } else {
            return "--:--:--";
        }
    }

    public function completed_surveys($filters = array("u_type" => null))
    {
        $today = date('Y-m-d');
        $this->db->select("`sv_co_published_surveys`.`Id` AS survey_id,
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
        `sv_st1_co_answers`.`TimeStamp` AS answer_date ");
        $this->db->from("sv_st1_co_surveys");
        $this->db->join("sv_st_surveys", "`sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`");
        $this->db->join("sv_sets", "`sv_sets`.`Id` = `sv_st_surveys`.`set_id`");
        $this->db->join("sv_set_template_answers", "`sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`");
        $this->db->join("sv_co_published_surveys", "`sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` ");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->join("sv_st1_co_answers", "`sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`");
        $this->db->where("EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` )");
        if ($filters['u_type'] !== null) {
            $this->db->where("sv_co_published_surveys_types.Type_code", $filters['u_type']);
        }
        $this->db->where("`sv_st1_co_surveys`.`Startting_date` <=", $today);
        $this->db->where("`sv_st1_co_surveys`.`End_date` >= ", $today);
        $this->db->group_by("survey_id");
        $this->db->order_by("`sv_st1_co_answers`.`TimeStamp`", "DESC");
        $results = $this->db->get()->result_array();
        return $results;
    }

    public function usedcategorys()
    {
        $results = $this->db->query(" SELECT * ,
        ( SELECT COUNT(`sv_co_published_surveys`.`Id`)
        FROM `sv_st1_co_surveys` 
        JOIN `sv_co_published_surveys` ON `sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id` 
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` ) AS counter_of_using 
        FROM `sv_st_category`
        /* start exist condition */
        WHERE EXISTS ( SELECT COUNT(`sv_co_published_surveys`.`Id`)
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`  
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_co_published_surveys` 
        ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id`
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
        JOIN `sv_co_published_surveys_genders`
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
        WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = `sv_st_category`.`Id`
        AND `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
        GROUP BY `sv_co_published_surveys`.`Id` )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
        return $results;
    }


    public function surveys_by_gender($gender = "", $usertype = "")
    {
        $this->db->select('`sv_co_published_surveys`.`Id` AS survey_id');
        $this->db->from('sv_st1_co_surveys');
        $this->db->join('sv_st_surveys', '`sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`');
        $this->db->join('sv_sets', '`sv_sets`.`Id` = `sv_st_surveys`.`set_id`');
        $this->db->join('sv_set_template_answers', '`sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`');
        $this->db->join('sv_co_published_surveys', "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ") ");
        $this->db->join('sv_co_published_surveys_types', "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` ");
        $this->db->join('sv_co_published_surveys_genders', "`sv_co_published_surveys_genders`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->where('`sv_st1_co_surveys`.`Status`', '1');
        if ($usertype !== '') {
            $this->db->where('`sv_co_published_surveys_types`.`Type_code`', $usertype);
        }
        if ($gender !== '') {
            $this->db->where('`sv_co_published_surveys_genders`.`Gender_code`', $gender);
        }
        $this->db->group_by('survey_id');
        $results = $this->db->get()->num_rows();
        return $results;
    }

    public function counter_of_completed_surveys_by_types($filters = array("gender" => null, "m_status" => null, "age" => null, 'usertype' => null))
    {
        $this->db->select('COUNT(sv_st1_co_answers.Id) AS counter');
        $this->db->select('`r_usertype`.`UserType` AS type');
        $this->db->select('l2_co_patient.UserType AS TypeKey');
        $this->db->from('sv_co_published_surveys');
        $this->db->join('sv_st1_co_answers', 'sv_st1_co_answers.serv_id = sv_co_published_surveys.Id');
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->join('r_usertype', 'r_usertype.Id = l2_co_patient.UserType');
        $this->db->group_by('sv_st1_co_answers.survey_type');
        if (isset($filters["gender"]) && $filters["gender"] !== null) {
            $this->db->where('`l2_co_patient`.`Gender`', $filters["gender"]);
        }
        if (isset($filters["m_status"]) && $filters["m_status"] !== null) {
            $this->db->where('`l2_co_patient`.`martial_status`', $filters["m_status"]);
        }
        if (isset($filters["usertype"]) && $filters["usertype"] !== null) {
            $this->db->where('`l2_co_patient`.`Gender`', $filters["gender"]);
        }
        $results = $this->db->get()->result_array();
        if (isset($filters["age"]) && $filters["age"]) {
            $results = $this->group_by("TypeKey", $this->change_to_age($results));
            $results = $this->change_to_age($results);
        }
        return $results;
    }

    public function category_publishid_surveys($cat_id)
    {
        $our_surveys = $this->db->query("SELECT
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
        `sv_st1_co_answers`.`TimeStamp` AS answer_date ,
        (SELECT COUNT(Id) FROM sv_st1_co_answers WHERE  `serv_id` = `sv_co_published_surveys`.`Id` ) AS answers_counter 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_co_published_surveys` 
        ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
        JOIN `sv_co_published_surveys_genders`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
        GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
        return $our_surveys;
    }

    public function ages($userType)
    {
        $this->db->select('COUNT(sv_st1_co_answers.Id) AS counter');
        $this->db->select('`r_usertype`.`UserType` AS type');
        $this->db->select('l2_co_patient.UserType AS TypeKey');
        $this->db->select('l2_co_patient.DOP');
        $this->db->from('sv_co_published_surveys');
        $this->db->join('sv_st1_co_answers', 'sv_st1_co_answers.serv_id = sv_co_published_surveys.Id');
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->join('r_usertype', 'r_usertype.Id = l2_co_patient.UserType');
        $this->db->group_by('sv_st1_co_answers.survey_type');
        if ($userType) {
            $this->db->where('`l2_co_patient`.`UserType`', $userType);
        }
        $results = $this->db->get()->result_array();
        $results = $this->group_by("TypeKey", $this->change_to_age($results));
        $results = $this->change_to_age($results);
        return $results;
    }

    public function matural_status($userType)
    {
        $this->db->select('DISTINCT(`sv_st1_co_answers`.`Id`)');
        $this->db->select('`r_usertype`.`UserType` AS type');
        $this->db->select('l2_co_patient.martial_status AS Mar_status');
        $this->db->select('l2_co_patient.DOP');
        $this->db->from('sv_co_published_surveys');
        $this->db->join('sv_st1_co_answers', 'sv_st1_co_answers.serv_id = sv_co_published_surveys.Id');
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->join('r_usertype', 'r_usertype.Id = l2_co_patient.UserType');
        $this->db->group_by('sv_st1_co_answers.survey_type');
        if ($userType) {
            $this->db->where('`l2_co_patient`.`UserType`', $userType);
        }
        $results = $this->db->get()->result_array();
        $results = $this->group_by("Mar_status", $results);

        if ($this->uri->segment(1) == "AR") {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name_ar");
        } else {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name");
        }
        $results = array();
        // $results = str_replace(array_keys($results), $names, $site['Site_For']);
        foreach ($results as $key => $result) {
            $key = str_replace(array_keys($results), $names, $key);
            $results[$key] = sizeof($result);
        }
        return $results;
    }



    public function ages_for_all_passed_users($grouping = true)
    {
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

    private function change_to_age($data)
    {
        $dops = array_column($data, "DOP");
        foreach ($dops as $key => $dop) {
            $todaydate = date('Y-m-d');
            $yaer = date("Y-m-d", strtotime($dop));
            $data[$key]['DOP'] = date_diff((new DateTime($yaer)), (new DateTime($todaydate)))->y;
        }
        return $data;
    }

    public function supported_types()
    {
        $result =  $this->db->query("SELECT `r_usertype`.`UserType` AS name , `r_usertype`.`Id` AS typeKey
            FROM `r_usertype` 
            JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
            JOIN l1_co_department
            ON l1_co_department.Added_By = '" . $this->user_id . "'
            AND `l2_co_patient`.`Added_By` = l1_co_department.Id
            GROUP BY `r_usertype`.`Id` ")->result_array();
        return $result;
    }

    public function specific_type_surveys($type, $filters = array("expired" => false))
    {
        $this->db->select('`sv_co_published_surveys`.`Id` AS survey_id,
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
        `sv_set_template_answers`.`title_ar` AS choices_ar_title');
        $this->db->from("sv_st1_co_surveys");
        $this->db->join("sv_st_surveys", "`sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id` ");
        $this->db->join("sv_sets", "`sv_sets`.`Id` = `sv_st_surveys`.`set_id`");
        $this->db->join("sv_set_template_answers", "`sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`");
        $this->db->join("sv_co_published_surveys", "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`  AND `sv_co_published_surveys_types`.`Type_code` = '" . $type . "'");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` ");
        $this->db->where("`sv_st_surveys`.`targeted_type`", 'C');
        if ($filters['expired']) {
            $this->db->where("`sv_st1_co_surveys`.`End_date` < ", date('Y-m-d'));
        }
        $this->db->group_by("`sv_co_published_surveys`.`Id`");
        $this->db->order_by("`sv_co_published_surveys`.`Id`", "DESC");
        $surveys = $this->db->get()->result_array();
        return $surveys;
    }

    // climate surveys
    public function GetClimatesurveys(array $filters = [], $byId = null)
    {
        if (empty($this->departmentsarr)) { // stop the script when the user doesn't have departments
            return array();
        }
        /*
        filters array example :
        *[
            'show_codes' => false,
            'surveyid' => "number" , 
            'gender' => "M" , 
            'usertype' => 2 , 
            'age' => [
                'min'=> 12 ,
                "max" => 20
            ]
        ] */
        if ($this->uri->segment(1) == "AR") {
            $q = "ar_title";
            if (isset($filters['show_codes'])) {
                $utype = "Id";
            } else {
                $utype = "AR_UserType";
            }
        } else {
            $q = "en_title";
            if (isset($filters['show_codes'])) {
                $utype = "Id";
            } else {
                $utype = "UserType";
            }
        }
        $today = date('Y-m-d');
        $this->db->select('`scl_st0_climate`.`TimeStamp` AS created_at ,
        `scl_st0_climate`.`Id` AS main_survey_id,
        `scl_published_co_claimate`.`Id` AS survey_id,
        `scl_published_co_claimate`.`status` AS status,
        `scl_published_co_claimate`.`By_department` AS By_department,
        `sv_st_category`.`Cat_en`,
        `sv_st_category`.`Cat_ar`,
        `sv_st_category`.`Id` AS Cat_id,
        `scl_st0_climate`.`answer_group` AS group_id,
        `sv_sets`.`title_en` AS set_name_en,
        `sv_sets`.`title_ar` AS set_name_ar ,
        `sv_set_template_answers`.`title_en` AS choices_title ,
        `sv_questions_library`.`' . $q . '` AS question ,
        `scl_st_co_climate`.`Startting_date` AS from_date ,
        `scl_published_co_claimate`.`TimeStamp` AS publishedAt,
        `scl_st_co_climate`.`End_date` AS to_date,scl_co_climate_answers.Id AS AnswerKey ');
        $this->db->select("(SELECT (DOP) FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `scl_co_climate_answers`.`user_id` LIMIT 1 ) AS DOP ");
        $this->db->select('COUNT(scl_co_climate_answers.Id) AS answers_counter');
        $this->db->select("(SELECT GROUP_CONCAT(Gender_code) FROM scl_published_co_claimate_genders WHERE scl_published_co_claimate_genders.Climate_id = `scl_published_co_claimate`.`Id`) AS genderslist");
        $this->db->select("(SELECT GROUP_CONCAT(r_usertype." . $utype . ") 
        FROM r_usertype 
        JOIN `scl_published_co_claimate_types` ON `scl_published_co_claimate_types`.`Type_code` = `r_usertype`.`Id`
        WHERE `scl_published_co_claimate_types`.`Climate_id` = `scl_published_co_claimate`.`Id`) AS typeslist");
        $this->db->from('scl_published_co_claimate');
        $this->db->join('scl_st_co_climate', 'scl_st_co_climate.Id = scl_published_co_claimate.climate_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_co_climate.Climate_id');
        $this->db->join('sv_set_template_answers', 'sv_set_template_answers.Id = scl_st0_climate.answer_group');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('l1_co_department', 'l1_co_department.Added_By = scl_st_co_climate.Published_by');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('scl_published_co_claimate_genders', 'scl_published_co_claimate.Id = scl_published_co_claimate_genders.Climate_id');
        $this->db->join('scl_published_co_claimate_types', 'scl_published_co_claimate.Id = scl_published_co_claimate_types.Climate_id');
        $this->db->join('scl_co_climate_answers', 'scl_published_co_claimate.Id = scl_co_climate_answers.climate_id', 'left');
        if (isset($filters['gender'])) {
            $this->db->where("(SELECT F_name_EN FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `scl_co_climate_answers`.`user_id` AND `l2_co_patient`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )", "IS NOT NULL", false);
        }
        if (isset($filters['usertype'])) {
            $this->db->where('scl_co_climate_answers.user_type', $filters['usertype']);
        }
        if (isset($filters['surveyid'])) {
            $this->db->where('scl_published_co_claimate.Id', $filters['surveyid']);
        }
        if ($byId !== null) {
            $this->db->where('scl_published_co_claimate.Id', $byId);
        }
        $this->db->where('scl_co_climate_answers.TimeStamp >=', $today . " 00:00:00");
        $this->db->where('scl_co_climate_answers.TimeStamp <=', $today . " 23:59:59");
        if (!empty($filters['dept'])) {
            $this->db->where('scl_published_co_claimate.By_department', $filters['dept']);
        } else {
            $this->db->where_in('scl_published_co_claimate.By_department', $this->departmentsarr);
        }
        $this->db->group_by('scl_published_co_claimate.Id');
        $this->db->order_by('scl_st0_climate.Id', 'ASC');
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

    public function GetClimateAnswers($surveyId, $filters = [])
    {
        /**
         *  Filters : 
         * 'ByType' => null, 'gender' => null
         */
        $this->db
            ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
            sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
            ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
            ->select('scl_co_climate_answers.Id AS AnswerId')
            ->select('COUNT(scl_co_climate_answers.Id) AS ChooseingTimes')
            ->from('scl_st_choices')
            ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
            ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
            ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
            ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
            ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
            ->join('scl_co_climate_answers', 'scl_co_climate_answers.answer_id = `scl_st_choices`.`id`')
            ->where('scl_co_climate_answers.climate_id ', $surveyId);
        if (isset($filters['ByType'])) {
            $this->db->where('scl_co_climate_answers.user_type', $filters['ByType']);
        }
        if (isset($filters['gender'])) {
            $this->db->where("EXISTS (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `scl_co_climate_answers`.`user_id` AND `l2_co_patient`.`Gender` = '" . $filters['gender'] . "' LIMIT 1 )");
        }
        $this->db->order_by('position', 'ASC');
        $this->db->group_by('scl_st_choices.Id');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function ClimateChoices(array $filters = [])
    {
        if (empty($this->departmentsarr)) { // stop the script when the user doesn't have departments
            return array();
        }
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
        $this->db->select("(SELECT (DOP) FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `scl_co_climate_answers`.`user_id` LIMIT 1 ) AS DOP ");
        $this->db->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar');
        $this->db->select('COUNT(scl_co_climate_answers.Id) AS ChooseingTimes');
        $this->db->from('scl_st_choices');
        $this->db->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('scl_co_climate_answers', 'scl_co_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left');
        $this->db->join('scl_published_co_claimate', 'scl_published_co_claimate.Id = `scl_co_climate_answers`.`climate_id` ');
        if (isset($filters['gender'])) {
            $this->db->where("(SELECT F_name_EN FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `scl_co_climate_answers`.`user_id` AND `l2_co_patient`.`gender` = '" . $filters['gender'] . "' LIMIT 1 )", "IS NOT NULL", false);
        }
        if (isset($filters['surveyid'])) {
            $this->db->where('scl_published_co_claimate.Id', $filters['surveyid']);
        }
        if (isset($filters['usertype'])) {
            $this->db->where('scl_co_climate_answers.user_type', $filters['usertype']);
        }
        $this->db->where_in('scl_published_co_claimate.By_department', $this->departmentsarr);
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

    public function published_by_department()
    {
        return $this->db->query("SELECT
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
        `sv_st1_co_answers`.`TimeStamp` AS answer_date ,
        (SELECT COUNT(Id) FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` ) AS answers_counter 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_co_published_surveys` 
        ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
        JOIN `sv_co_published_surveys_genders`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Status` = '1'
        GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
    }

    // survey_reports functions
    public function users_passed_survey($servey_id, $type = null, $gender = null)
    {
        if ($this->uri->segment(1) == "AR") {
            $lang = "AR";
            $usertype = "AR_UserType";
        } else {
            $lang = "EN";
            $usertype = "UserType";
        }
        $this->db->select(" CONCAT(`l2_co_patient`.`F_name_" . $lang . "`,' ',`l2_co_patient`.`L_name_" . $lang . "`) AS U_Name ,
            `r_usertype`.`$usertype` AS usertype , `sv_st1_co_answers`.`Id` AS answerKey ,
            `sv_st1_co_answers`.`TimeStamp` AS Finished_at ,
            `sv_st1_co_answers`.`finishing_time` AS Finish_time")
            ->from("sv_st1_co_answers")
            ->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id')
            ->join('r_usertype', 'r_usertype.Id = l2_co_patient.UserType')
            ->where('`sv_st1_co_answers`.`serv_id`', $servey_id);
        if ($type !== null) {
            $this->db->where('l2_co_patient.UserType', $type);
        }
        if ($gender !== null) {
            $this->db->where('l2_co_patient.Gender', $gender);
        }
        $results  = $this->db->get()->result_array();
        return $results;
    }

    public function survey_q_results($surv_id)
    {
        $result = $this->db->query(" SELECT
            `sv_set_template_answers_choices`.`title_en` AS `choices_en` ,
            `sv_set_template_answers_choices`.`title_ar` AS `choices_ar` ,
            `sv_set_template_answers_choices`.`Id` AS `Id`
            FROM `sv_co_published_surveys`
            JOIN `sv_st1_co_surveys` ON  `sv_st1_co_surveys`.`Id` = `sv_co_published_surveys`.`Serv_id`
            JOIN `sv_st_surveys` ON `sv_st_surveys`.`Id` = `sv_st1_co_surveys`.`Survey_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_set_template_answers_choices` ON `sv_set_template_answers_choices`.`group_id` = `sv_set_template_answers`.`Id`
            WHERE `sv_co_published_surveys`.`Id` = '" . $surv_id . "' ")->result_array();
        return $result;
    }

    public function get_surv_data($surv_id)
    {
        $serv_data = $this->db->query(" SELECT 
            `sv_st1_co_surveys`.`title_en` AS Title_en,
            `sv_st1_co_surveys`.`title_ar` AS Title_ar,
            `sv_st_surveys`.`Message_en` AS Message,
            `sv_st_surveys`.`answer_group_en` AS group_id ,
            `sv_st_surveys`.`Id` AS main_survey_id ,
            `sv_st_themes`.`file_name` AS serv_theme ,
            `sv_st_themes`.`image_name` AS image_name 
            FROM `sv_st1_co_surveys` 
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_co_published_surveys` ON `sv_st1_co_surveys`.`Id` = `sv_co_published_surveys`.`Serv_id`
            JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_co_published_surveys`.`theme_link`
            WHERE `sv_co_published_surveys`.`Id` = '" . $surv_id . "' ")->result_array();
        return $serv_data;
    }

    public function get_surv_quastions($surv_id)
    {
        $surv_data = $this->get_surv_data($surv_id);
        $main_surv_id = $surv_data[0]['main_survey_id'];
        $result = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
            FROM `sv_st_questions`
            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
            WHERE `sv_st_questions`.`survey_id` = '" . $main_surv_id . "' ")->result_array();
        return $result;
    }

    public function get_surv_percintage_graph($surv_id)
    {
        $result = $this->db->query("SELECT 
            COUNT(`sv_st1_co_answers_values`.`Id`) AS All_Count 
            FROM `sv_st1_co_answers_values` 
            GROUP BY `choice_id`")->result_array();
        return $result;
    }

    public function get_q_answer_percintage_by_gender($surv_id, $quastion, $choice, $gender)
    {
        // passed 0 mean male
        $results = $this->db->query("SELECT (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_co_patient` WHERE `l2_co_patient`.`Id` = `sv_st1_co_answers`.`user_id` AND `l2_co_patient`.`Gender` = '" . $gender . "' LIMIT 1 ) AS U_Name ,
        `sv_st1_co_answers`.`TimeStamp` AS Finished_at ,
        `sv_st1_co_answers`.`finishing_time` AS Finish_time
        FROM `sv_st1_co_answers_values`
        JOIN `sv_st1_co_answers` ON `sv_st1_co_answers`.`Id` = `sv_st1_co_answers_values`.`answers_data_id`
        WHERE `sv_st1_co_answers`.`serv_id` = '" . $surv_id . "' AND `sv_st1_co_answers_values`.`question_id` = '" . $quastion . "' 
        AND `sv_st1_co_answers_values`.`choice_id` = '" . $choice . "'
        ORDER BY `sv_st1_co_answers`.`Id` DESC ")->result_array();
        return $results;
    }

    public function category_by_gender($gender = "", $usertype = "", $cat = "")
    {
        if ($usertype == "") {
            if (!empty($gender)) {
                // for spicifec gender
                $results = $this->db->query(" SELECT
                `sv_co_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_co_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_co_published_surveys` 
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
                JOIN `sv_co_published_surveys_types`  
                ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`
                JOIN `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '" . $gender . "'
                LEFT JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
                WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->num_rows();
            } else {
                $results =  $this->db->query(" SELECT
                `sv_co_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_co_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_co_published_surveys` 
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
                JOIN `sv_co_published_surveys_types`  
                ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`
                JOIN `sv_co_published_surveys_genders` `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
                JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
                WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->num_rows();
            }
        } else {
            if (!empty($gender)) {
                // for spicifec gender
                $results = $this->db->query(" SELECT
                `sv_co_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_co_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_co_published_surveys` 
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
                JOIN `sv_co_published_surveys_types`  
                ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` AND `sv_co_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_co_published_surveys_genders` `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '" . $gender . "'
                JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
                WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->num_rows();
            } else {
                $results =  $this->db->query(" SELECT
                `sv_co_published_surveys`.`Id` AS survey_id
                FROM `sv_st1_co_surveys`
                JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
                JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
                JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
                JOIN `sv_co_published_surveys` 
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
                JOIN `sv_co_published_surveys_types`  
                ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` AND `sv_co_published_surveys_types`.`Type_code` = '" . $usertype . "'
                JOIN `sv_co_published_surveys_genders` `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '1'
                JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
                WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat . "'
                GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->num_rows();
            }
        }
        return $results;
    }

    public function timeOfFinishingForThisSurvey($survey_id, $type = "")
    {
        //schoolId
        if (!empty($type)) {
            $results = $this->db->query(" SELECT
            `sv_st1_co_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_co_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_co_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_co_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_co_published_surveys` 
            ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
            JOIN `sv_co_published_surveys_types`  
            ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` AND `sv_co_published_surveys_types`.`Type_code` = '" . $type . "'
            JOIN `sv_co_published_surveys_genders`  
            ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
            WHERE `sv_st1_co_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_co_answers` 
            WHERE `serv_id` = `sv_co_published_surveys`.`Id` AND `sv_st1_co_answers`.`user_type` = '" . $type . "' ) 
            AND `sv_co_published_surveys`.`Id` = '" . $survey_id . "'
            GROUP BY `sv_st1_co_answers`.`Id`  ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
        } else {
            $results = $this->db->query(" SELECT
            `sv_st1_co_answers`.`finishing_time` AS Finishing_time,
            AVG(`sv_st1_co_answers`.`finishing_time`) AS Finishing_time_avg ,
            SUM(`sv_st1_co_answers`.`finishing_time`) AS sum_of_all
            FROM `sv_st1_co_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_co_published_surveys` 
            ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` IN (" . $this->departments . ")
            JOIN `sv_co_published_surveys_types`  
            ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
            JOIN `sv_co_published_surveys_genders`  
            ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
            WHERE `sv_st1_co_surveys`.`Status` = '1' 
            AND EXISTS (SELECT Id FROM `sv_st1_co_answers` 
            WHERE `serv_id` = `sv_co_published_surveys`.`Id` ) 
            AND `sv_co_published_surveys`.`Id` = '" . $survey_id . "'
            GROUP BY `sv_st1_co_answers`.`Id` ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
        }
        return $results;
    }
}
