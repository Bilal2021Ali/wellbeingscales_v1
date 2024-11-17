<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sv_reports extends CI_Model
{
    public $user_id = 0;
    public $userData = array();

    public function __construct()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->user_id = $sessiondata['admin_id'];
        $deptdata = $this->db->query(" SELECT * FROM `l1_co_department` WHERE `Id` = '" . $this->user_id . "' ")->result_array();
        if (!empty($deptdata)) {
            $this->userData = $deptdata[0];
        } else {
            $this->userData = array();
        }
    }

    public function SurveysLibrary()
    {
        $today = date('Y-m-d');
        $result = $this->db->query(" SELECT
            `sv_st1_co_surveys`.`Id` AS survey_id,
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
            `sv_set_template_answers`.`title_ar` AS choices_ar_title 
            FROM `sv_st1_co_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            WHERE `sv_st1_co_surveys`.`End_date` < '" . $today . "' ")->result_array();
        return $result;
    }


    public function getclimatesurveyslibrary()
    {
        return $this->db->query(" SELECT
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
        (SELECT COUNT(`scl_published_co_claimate`.`Id`) 
        FROM scl_published_co_claimate WHERE `scl_published_co_claimate`.`climate_id` = `scl_st_co_climate`.`Id` ) AS isUsed 
        FROM `scl_st0_climate`
        INNER JOIN `sv_sets` ON `sv_sets`.`Id` = `scl_st0_climate`.`set_id`
        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `scl_st0_climate`.`question_id`                
        INNER JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `scl_st0_climate`.`answer_group`
        JOIN `scl_st_co_climate` ON `scl_st_co_climate`.`Climate_id` = `scl_st0_climate`.`Id`
        LEFT JOIN `scl_published_co_claimate` ON `scl_published_co_claimate`.`climate_id` = `scl_st_co_climate`.`Id`
        JOIN `sv_st_category` ON `sv_st_category`.`Id` = `scl_st0_climate`.`category`
        INNER JOIN `l1_co_department` ON `l1_co_department`.`Added_By` = `scl_st_co_climate`.`Published_by` 
        WHERE `scl_st0_climate`.`targeted_type` = 'C' AND `l1_co_department`.`Id` = '" . $this->user_id . "'
        ORDER BY `scl_st0_climate`.`Id` ASC")->result_array();
    }

    public function GetClimatesurveys(array $filters = [], $byId = null)
    {
        $answers = true;
        if ($this->uri->segment(3) && $this->uri->segment(3) == "ClimateSurveys") {
            $answers = false;
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
        if ($answers) {
            $this->db->where('scl_co_climate_answers.TimeStamp >=', $today . " 00:00:00");
            $this->db->where('scl_co_climate_answers.TimeStamp <=', $today . " 23:59:59");
        }
        if ($byId !== null) {
            $this->db->where('scl_published_co_claimate.Id', $byId);
        }
        $this->db->where('scl_published_co_claimate.By_department', $this->user_id);
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
        $this->db->where('scl_published_co_claimate.By_department', $this->user_id);
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

    public function Answer($surveyid, $userId, $dates = [])
    {
        if ($this->uri->segment(1) == "AR") {
            $lang = "AR";
        } else {
            $lang = "EN";
        }
        $this->db->select('scl_st_choices.Id , AVG(scl_st_choices.mark) AS mark , scl_published_co_claimate.Id AS SurveyId , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
        sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ');
        $this->db->select('sv_set_template_answers_choices.title_en AS answer_en , sv_set_template_answers_choices.title_ar AS answer_ar ');
        $this->db->select("CONCAT(l2_co_patient.F_name_" . $lang . " ,' ',l2_co_patient.L_name_" . $lang . ") AS userName");
        $this->db->from('scl_co_climate_answers');
        $this->db->join('scl_st_choices', 'scl_co_climate_answers.answer_id = `scl_st_choices`.`id` ');
        $this->db->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id');
        $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id');
        $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
        $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
        $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
        $this->db->join('scl_published_co_claimate', 'scl_published_co_claimate.Id = `scl_co_climate_answers`.`climate_id` ');
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = scl_co_climate_answers.user_id');
        $this->db->where('scl_published_co_claimate.By_department', $this->user_id);
        if (!empty($date)) {
            $this->db->where('scl_co_climate_answers.TimeStamp >= ', date($dates[0] . ' 00:00:00'));
            $this->db->where('scl_co_climate_answers.TimeStamp <= ',  date($dates[1] . ' 23:59:59'));
        }
        $this->db->where('scl_co_climate_answers.user_id',  $userId);
        $this->db->where('scl_co_climate_answers.climate_id',  $surveyid);
        $data = $this->db->get()->result_array();
        // echo $this->db->last_query();
        if (!empty($data)) {
            $answer = (int) floatval($data[0]['mark']);
        } else {
            $answer = '--';
        }
        return $answer;
    }

    public function climateAverageChart()
    {
        $surveys = $this->GetClimatesurveys();
        $labels = array();
        $existsL = array();
        $existsC = array();
        $count = array();
        $answers = array();
        $activeValue = array('times' => 0, "value" => 0);
        foreach ($surveys as $climate_survye) {
            $this->db->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
            sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ');
            $this->db->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar');
            $this->db->select('COUNT(scl_co_climate_answers.Id) AS ChooseingTimes');
            $this->db->from('scl_st_choices');
            $this->db->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id');
            $this->db->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id');
            $this->db->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category');
            $this->db->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id');
            $this->db->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id');
            $this->db->join('scl_co_climate_answers', 'scl_co_climate_answers.climate_id = ' . $climate_survye['survey_id'] . ' AND  scl_co_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left');
            $this->db->where('servey_id', $climate_survye['main_survey_id']);
            $this->db->order_by('position', 'ASC');
            $this->db->group_by('scl_st_choices.Id');
            $choices = $this->db->get()->result_array();
            $isallempty = 0;
            foreach ($choices as $key => $choice) {
                if (!in_array($choice['id'], $existsL)) {
                    $isallempty += $choice['ChooseingTimes'];
                    $labels[] = '"' . $choice['title_en'] . '"';
                    $existsL[] = $choice['id'];
                }
            }
            for ($i = 1; $i < sizeof($choices) + 1; $i++) {
                if (!in_array($choices[($i - 1)]['id'], $existsC)) {
                    $value = round($i / (sizeof($choices) / 100), 2) - 0.1;
                    $count[] = $choices[($i - 1)]['ChooseingTimes'];
                    $existsC[] = $choices[($i - 1)]['id'];
                }
            }
        }
        for ($i = 0; $i < sizeof($count); $i++) {
            $value = $i == 0 ? 0.2 : round($i / (sizeof($count) / 100), 2) - 0.1;
            $answers[] = $value;
            if ($count[($i)] > $activeValue['times']) {
                $activeValue['times'] = $count[($i)];
                $activeValue['value'] = $value - 5;
            }
        }
        return ["labels" => $labels, "counts" => $answers, "value" => $activeValue];
    }

    // from company module
    public function our_surveys($expired = false)
    {
        // user_id stand for ministry id
        $query = "SELECT
        `sv_st1_co_surveys`.`TimeStamp` AS creating_date ,
        `sv_st1_co_surveys`.`Id` AS survey_id,
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
        `sv_co_published_surveys`.`Id` as pId , 
        (SELECT COUNT(Id) FROM sv_st1_co_answers WHERE `serv_id` = `sv_co_published_surveys`.`Id` ) AS answers_counter 
        FROM `sv_st1_co_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers`  ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->userData['Added_By'] . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
        LEFT JOIN `sv_co_published_surveys` ON `sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Published_by` = '" . $this->userData['Added_By'] . "' " .
            ($expired ? 'AND `sv_st1_co_surveys`.`End_date`  < "' . date('Y-m-d') . '"' : "AND `sv_st1_co_surveys`.`End_date` >=  '" . date('Y-m-d') . "' AND `sv_st1_co_surveys`.`Startting_date` <=  '" . date('Y-m-d') . "'") . "
        AND `sv_st_targeted_accounts`.`Status` = '1' GROUP BY `sv_st1_co_surveys`.`Id`";
        $results = $this->db->query($query)->result_array();
        return $results;
    }

    public function our_published_surveys()
    {
        return $this->db->query("SELECT
        `sv_co_published_surveys`.`Id` AS survey_id,
        `sv_co_published_surveys`.`Created` AS Created_date,
        `sv_co_published_surveys`.`TimeStamp` AS publish_date ,
        `sv_co_published_surveys`.`Status` AS status,
        `sv_st_surveys`.`Id` AS main_survey_id,
        `sv_st1_co_surveys`.`Status` AS Mainstatus,
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
        ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
        JOIN `sv_co_published_surveys_genders`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Status` = '1'
        GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
    }

    public function completed_surveys($filters = array("u_type" => null, "gender" => null))
    {
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
        $this->db->join("sv_co_published_surveys", "`sv_co_published_surveys`.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $this->user_id . "");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` ");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->join("sv_st1_co_answers", "`sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`");
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->where("EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` )");
        $this->db->where("sv_st1_co_surveys.Published_by", $this->userData['Added_By']);
        if (isset($filters['u_type']) &&  $filters['u_type'] !== null) {
            $this->db->where("l2_co_patient.UserType", $filters['u_type']);
        }
        if (isset($filters['gender']) &&  $filters['gender'] !== null) {
            $this->db->where("l2_co_patient.Gender", $filters['gender']);
        }
        $this->db->group_by("`sv_st1_co_surveys`.`Id`");
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
        AND `sv_co_published_surveys`.`Created_By` = " . $this->user_id . "
        AND `sv_st1_co_surveys`.`Published_by` = '" . $this->userData['Added_By'] . "'
        GROUP BY `sv_st1_co_surveys`.`Id` )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
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
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
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
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
                JOIN `sv_co_published_surveys_types`  
                ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`
                JOIN `sv_co_published_surveys_genders` `sv_co_published_surveys_genders` ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` AND `sv_co_published_surveys_genders`.`Gender_code` = '1'
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
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
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
                ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
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

    public function category_publishid_surveys($user_id, $cat_id)
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
        ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $user_id . "'
        JOIN `sv_co_published_surveys_types`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` 
        JOIN `sv_co_published_surveys_genders`  
        ON `sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`
        LEFT JOIN sv_st1_co_answers ON `sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`
        WHERE `sv_st1_co_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = '" . $cat_id . "'
        GROUP BY survey_id ORDER BY `sv_st1_co_answers`.`TimeStamp` DESC")->result_array();
        return $our_surveys;
    }


    public function surveys_by_gender($gender = "", $usertype = "")
    {
        $this->db->select('`sv_co_published_surveys`.`Id` AS survey_id');
        $this->db->from('sv_st1_co_surveys');
        $this->db->join('sv_st_surveys', '`sv_st1_co_surveys`.`Survey_id` = `sv_st_surveys`.`Id`');
        $this->db->join('sv_sets', '`sv_sets`.`Id` = `sv_st_surveys`.`set_id`');
        $this->db->join('sv_set_template_answers', '`sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`');
        $this->db->join('sv_co_published_surveys', "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $this->user_id . " ");
        $this->db->join('sv_co_published_surveys_types', "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id` ");
        $this->db->join('sv_co_published_surveys_genders', "`sv_co_published_surveys_genders`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->where('`sv_st1_co_surveys`.`Status`', '1');
        $this->db->where('`sv_st1_co_surveys`.`Published_by`', $this->userData['Added_By']);
        if ($usertype !== '') {
            $this->db->where('`sv_co_published_surveys_types`.`Type_code`', $usertype);
        }
        if ($gender !== '') {
            $this->db->where('`sv_co_published_surveys_genders`.`Gender_code`', $gender);
        }
        $this->db->group_by('`sv_st1_co_surveys`.`Id`');
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
        if (isset($filters["usertype"]) && $filters["usertype"] !== null) {
            $this->db->where('`l2_co_patient`.`Gender`', $filters["gender"]);
        }
        if (isset($filters["m_status"]) && $filters["m_status"] !== null) {
            $this->db->where('`l2_co_patient`.`martial_status`', $filters["m_status"]);
        }
        $this->db->where('`l2_co_patient`.`Added_By`', $this->user_id);
        $results = $this->db->get()->result_array();
        if (isset($filters["age"]) && $filters["age"]) {
            $results = $this->group_by("TypeKey", $this->change_to_age($results));
            $results = $this->change_to_age($results);
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

    public function supported_types()
    {
        $result =  $this->db->query("SELECT `r_usertype`.`UserType` AS name , `r_usertype`.`Id` AS typeKey
            FROM `r_usertype` 
            JOIN `l2_co_patient` ON `l2_co_patient`.`UserType` = `r_usertype`.`Id` 
            JOIN l1_co_department
            ON l1_co_department.Id = '" . $this->user_id . "'
            AND `l2_co_patient`.`Added_By` = l1_co_department.Id
            GROUP BY `r_usertype`.`Id` ")->result_array();
        return $result;
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
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->userData['Added_By'] . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_fillable_surveys`.`Id`
            WHERE `sv_st_fillable_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'C' AND `sv_st_targeted_accounts`.`Status` = '1'
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
            JOIN `sv_st_targeted_accounts` ON `sv_st_targeted_accounts`.`account_id` = '" . $this->userData['Added_By'] . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id`
            WHERE `sv_st_surveys`.`status` = '1' AND `sv_st_surveys`.`targeted_type` = 'C' AND `sv_st_targeted_accounts`.`Status` = '1'
            GROUP BY `sv_st_questions`.`survey_id` ORDER BY `sv_st_surveys`.`Id` ASC")->result_array();
            // echo $this->db->last_query();
        }
        return $results;
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
        $this->db->where('`l2_co_patient`.`Added_By`', $this->user_id);
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
        $this->db->where('`l2_co_patient`.`Added_By`', $this->user_id);
        $results = $this->db->get()->result_array();

        $results = $this->group_by("Mar_status", $results);

        if ($this->uri->segment(1) == "AR") {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name_ar");
        } else {
            $names = array_column($this->db->get('l2_martial_status')->result_array(), "name");
        }
        $dataresults = array();
        // $results = str_replace(array_keys($results), $names, $site['Site_For']);
        foreach ($results as $key => $result) {
            $key = str_replace(array_keys($results), $names, $key);
            $dataresults[$key] = sizeof($result);
        }
        return $dataresults;
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
        $this->db->join("sv_co_published_surveys", "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $this->user_id . "");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`  AND `sv_co_published_surveys_types`.`Type_code` = '" . $type . "'");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id` ");
        $this->db->where("`sv_st_surveys`.`targeted_type`", 'C');
        if ($filters['expired']) {
            $this->db->where("`sv_st1_co_surveys`.`End_date` < ", date('Y-m-d'));
        }
        $this->db->where('`sv_st1_co_surveys`.`Published_by`', $this->userData['Added_By']);
        $this->db->group_by("`sv_co_published_surveys`.`Id`");
        $this->db->order_by("`sv_co_published_surveys`.`Id`", "DESC");
        $surveys = $this->db->get()->result_array();
        return $surveys;
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
        JOIN `sv_co_published_surveys` ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $this->user_id . "
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st_surveys`.`targeted_type` = 'M' AND `sv_st1_co_surveys`.`Published_by` = '" . $this->userData['Added_By'] . "'
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
        $this->db->join("sv_co_published_surveys", "sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = " . $this->user_id . "");
        $this->db->join("sv_co_published_surveys_types", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_types`.`Survey_id`");
        $this->db->join("sv_co_published_surveys_genders", "`sv_co_published_surveys`.`Id` = `sv_co_published_surveys_genders`.`Survey_id`");
        $this->db->join("sv_st1_co_answers", "`sv_st1_co_answers`.`serv_id` =  `sv_co_published_surveys`.`Id`");
        $this->db->join('l2_co_patient', 'l2_co_patient.Id = sv_st1_co_answers.user_id');
        $this->db->join("sv_st_targeted_accounts", "`sv_st_targeted_accounts`.`account_id` =  '" . $this->userData['Added_By'] . "'  AND `sv_st_targeted_accounts`.`survey_id` = `sv_st_surveys`.`Id` AND `sv_st_targeted_accounts`.`Status` = '1'");
        $this->db->where("`sv_st1_co_surveys`.`Status`", '1');
        $this->db->where("`sv_st_surveys`.`targeted_type`", 'C');
        $this->db->where("EXISTS (SELECT Id FROM `sv_st1_co_answers` WHERE `serv_id` = `sv_co_published_surveys`.`Id` ) ");
        if ($filters['type'] !== null) {
            $this->db->where("`l2_co_patient`.`UserType`", $filters['type']);
        }
        $this->db->where('`sv_st1_co_surveys`.`Published_by`', $this->userData['Added_By']);
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
            ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
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
            ON sv_co_published_surveys.`Serv_id` = `sv_st1_co_surveys`.`Id` AND  `sv_co_published_surveys`.`Created_By` = '" . $this->user_id . "'
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
}
