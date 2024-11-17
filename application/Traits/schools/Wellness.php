<?php

namespace Traits\schools;

trait Wellness
{
    public function wellness()
    {
        $today = date('Y-m-d');
        $sessiondata = $this->session->userdata('admin_details');
        $permission = $this->db->query(" SELECT `v0_permissions`.`Id`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`surveys` = '1' ")->result_array();
        $schooldata = $this->db->query(" SELECT * FROM `l1_school` WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        if (!empty($permission) && !empty($schooldata)) {
            $data['page_title'] = "Qlick Health | wellness ";
            $data['sessiondata'] = $sessiondata;
            $data['themes'] = $this->db->query(" SELECT * FROM `sv_st_themes` ")->result_array();
            $getedType = $schooldata[0]['Type_Of_School'];
            $saurce_id = $schooldata[0]['Added_By'];
            if ($getedType == "Government") {
                $type = '2';
            } else {
                $type = '3';
            }
            $data['type'] = $type;
            $data['expired_surveys'] = $this->db->query(" SELECT
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
            (SELECT COUNT(Id) FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) AS answers_counter 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata["admin_id"] . "'
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            LEFT JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
            WHERE `sv_st1_surveys`.`End_date` < '" . $today . "' GROUP BY sv_school_published_surveys.Id AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "' ")->result_array();
            $data['completed_surveys'] = $this->db->query(" SELECT
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
            `ar_answer_group`.`title_en` AS choices_ar_title ,
            `sv_st1_answers`.`TimeStamp` AS answer_date 
            FROM `sv_st1_surveys`
            JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
            JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
            JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
            JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
            JOIN `sv_school_published_surveys` 
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $sessiondata['admin_id'] . "
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
            WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
            AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
            GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
            $data['answerd_quastions'] = $this->db->query(" SELECT
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
        `ar_answer_group`.`title_en` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $sessiondata['admin_id'] . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
        AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY `sv_sets`.`Id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
            $data['teachers_surveys'] = $this->db->query(" SELECT
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
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '3' 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        WHERE `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY `sv_school_published_surveys`.`Id` ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
            $data['teachers_quastions'] = $this->db->query(" SELECT
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
        `en_answer_group`.`title_en` AS choices_en_title ,
        `ar_answer_group`.`title_en` AS choices_ar_title 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id` 
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'
        JOIN `sv_school_published_surveys_types` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id`  AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders` ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id` 
        JOIN `sv_st_questions` ON `sv_st_questions`.`survey_id` = `sv_st_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY  `sv_st_questions`.`Id`  ORDER BY `sv_school_published_surveys`.`Id` DESC")->result_array();
            $data['teachers_completed_surveys'] = $this->db->query(" SELECT
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
        `ar_answer_group`.`title_en` AS choices_ar_title ,
        `sv_st1_answers`.`TimeStamp` AS answer_date 
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '3' ) 
        AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            $finishing_teachers_data = $this->db->query(" SELECT
        `sv_st1_answers`.`finishing_time` AS Finishing_time,
        AVG(`sv_st1_answers`.`finishing_time`) AS Finishing_time_avg ,
        SUM(`sv_st1_answers`.`finishing_time`) AS sum_of_all
        FROM `sv_st1_surveys`
        JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
        JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
        JOIN `sv_set_template_answers` en_answer_group ON en_answer_group.`Id` = `sv_st_surveys`.`answer_group_en`
        JOIN `sv_set_template_answers` ar_answer_group ON ar_answer_group.`Id` = `sv_st_surveys`.`answer_group_ar`
        JOIN `sv_school_published_surveys` 
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` AND `sv_school_published_surveys_types`.`Type_code` = '3'
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id`
        WHERE `sv_st1_surveys`.`Status` = '1' AND EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` AND `sv_st1_answers`.`user_type` = '3' ) 
        AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY `sv_st1_surveys`.`survey_id` ORDER BY `sv_st1_answers`.`TimeStamp` DESC")->result_array();
            $data['our_teachers'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->result_array();
            $data['our_staff'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->result_array();
            $data['our_student'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->result_array();
            $data['our_parents'] = $this->db->query(" SELECT * FROM l2_parents 
            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
            WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "') ")->result_array();
            $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
            $this->load->model('schools/sv_school_reports');
            $data['surveys'] = $this->sv_school_reports->Get_surveys($type);
            // print_r($data['surveys']);
            $data['fillable_surveys'] = $this->sv_school_reports->Get_surveys($type, true); // return only the fillable surveys
            $data['our_surveys'] = $this->sv_school_reports->our_surveys($sessiondata['admin_id']);
            $data['surveys_for_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1');
            $data['surveys_for_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2');
            $data['surveys_for_all_genders'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id']);
            $ages_arr = array_column($this->sv_school_reports->ages_forall_users($sessiondata['admin_id'], false), "DOP");
            $users_passed_survey_ages_options_ages = array_column($this->sv_school_reports->ages_for_all_passed_users($sessiondata['admin_id'], false), "DOP");
            $data['used_categorys'] = $this->sv_school_reports->usedcategorys($sessiondata['admin_id']);
            $data['published_surveys_unfillable'] = $this->sv_school_reports->our_published_surveys();
            $data['published_surveys_fillable'] = $this->sv_school_reports->our_published_surveys("fillabe");
            // teachers start  expired_surveys
            $data['teachers_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '3');
            $data['teachers_quastions'] = $this->sv_school_reports->specific_type_questions($sessiondata['admin_id'], '3');
            $data['teachers_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '3');
            $finishing_teachers_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '3');
            $data['finishing_time_teachers'] = $this->calculate_avg_time($finishing_teachers_data);
            // staffs start
            $data['staff_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '1');
            $data['staff_quastions'] = $this->sv_school_reports->specific_type_questions($sessiondata['admin_id'], '1');
            $data['staff_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '1');
            $finishing_staffs_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '1');
            $data['finishing_time_staff'] = $this->calculate_avg_time($finishing_staffs_data);
            // parents start
            $data['parents_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '4');
            $data['parents_quastions'] = $this->sv_school_reports->specific_type_questions($sessiondata['admin_id'], '4');
            $data['parents_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '4');
            $finishing_parents_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '4');
            $data['finishing_time_parents'] = $this->calculate_avg_time($finishing_parents_data);
            // students start
            $data['students_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '2');
            $data['students_quastions'] = $this->sv_school_reports->specific_type_questions($sessiondata['admin_id'], '2');
            $data['students_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
            $finishing_students_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], '2');
            $data['finishing_time_students'] = $this->calculate_avg_time($finishing_students_data);
            // loading the vie2
            $data['surveys_for_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1');
            $data['surveys_for_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2');
            $data['surveys_for_males'] = [];
            $data['surveys_for_females'] = [];
            $data['surveys_for_males']['active'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', "", false);
            $data['surveys_for_females']['active'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', "", false);
            $data['surveys_for_males']['expired'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', "", true);
            $data['surveys_for_females']['expired'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', "", true);
            $data['surveys_for_all_genders'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id']);
            $finishing_all_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id']);
            $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
            $data['ages'] = array_count_values($ages_arr);
            $data['users_passed_survey_ages_options_ages'] = array_count_values($users_passed_survey_ages_options_ages);
            $data['ages_with_groups'] = $this->sv_school_reports->ages_forall_users($sessiondata['admin_id'], true);
            $data['ages_with_groups'] = $this->sv_school_reports->ages_for_all_passed_users($sessiondata['admin_id'], true);
            foreach (['expired', 'active'] as $type) {
                $data['teachers_surveys'][$type] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '3', ($type == "expired"));
                $data['staff_surveys'][$type] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '1', ($type == "expired"));
                $data['parents_surveys'][$type] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '4', ($type == "expired"));
                $data['students_surveys'][$type] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '2', ($type == "expired"));
            }
            // $data['teachers_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '3');
            // $data['staff_surveys']    = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '1');
            // $data['parents_surveys']  = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '4');
            // $data['students_surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '2');
            // students reports students_matural
            $data['gend_students_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', '2');
            $data['gend_students_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', '2');
            $data['students_matural'] = $this->sv_school_reports->martial_status($sessiondata['admin_id'], '2');
            // teachers reports
            $data['gend_teachers_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', '3');
            $data['gend_teachers_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', '3');
            $data['teachers_matural'] = $this->sv_school_reports->martial_status($sessiondata['admin_id'], '3');
            // staff reports
            $data['gend_staffs_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', '1');
            $data['gend_staffs_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', '1');
            $data['staffs_matural'] = $this->sv_school_reports->martial_status($sessiondata['admin_id'], '1');
            // parents reports
            $data['gend_parents_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', '4');
            $data['gend_parents_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', '4');
            $data['parents_matural'] = $this->sv_school_reports->martial_status($sessiondata['admin_id'], '4');
            /// published surveys counters
            $counter_of_published_surveys = array();
            $counter_of_published_surveys['all'] = sizeof($this->sv_school_reports->specific_type_surveys($sessiondata['admin_id']));
            $counter_of_published_surveys['students'] = sizeof($this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '2'));
            $counter_of_published_surveys['teachers'] = sizeof($this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '3'));
            $counter_of_published_surveys['staffs'] = sizeof($this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '1'));
            $counter_of_published_surveys['Parents'] = sizeof($this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], '4'));
            // Expired  surveys counters
            $counter_of_expired_surveys = array();
            $counter_of_expired_surveys['all'] = sizeof($this->sv_school_reports->expired_surveys_by_type($sessiondata['admin_id']));
            $counter_of_expired_surveys['students'] = sizeof($this->sv_school_reports->expired_surveys_by_type($sessiondata['admin_id'], '2'));
            $counter_of_expired_surveys['teachers'] = sizeof($this->sv_school_reports->expired_surveys_by_type($sessiondata['admin_id'], '3'));
            $counter_of_expired_surveys['staffs'] = sizeof($this->sv_school_reports->expired_surveys_by_type($sessiondata['admin_id'], '1'));
            $counter_of_expired_surveys['Parents'] = sizeof($this->sv_school_reports->expired_surveys_by_type($sessiondata['admin_id'], '4'));
            // completed  surveys counters
            $counter_of_completed_surveys = array();
            $counter_of_completed_surveys['all'] = sizeof($this->sv_school_reports->completed_surveys($sessiondata['admin_id']));
            $counter_of_completed_surveys['students'] = sizeof($this->sv_school_reports->completed_surveys($sessiondata['admin_id'], '2'));
            $counter_of_completed_surveys['teachers'] = sizeof($this->sv_school_reports->completed_surveys($sessiondata['admin_id'], '3'));
            $counter_of_completed_surveys['staffs'] = sizeof($this->sv_school_reports->completed_surveys($sessiondata['admin_id'], '1'));
            $counter_of_completed_surveys['Parents'] = sizeof($this->sv_school_reports->completed_surveys($sessiondata['admin_id'], '4'));
            // passing arrays to the view  answerd_quastions
            $data['counter_of_published_surveys'] = $counter_of_published_surveys;
            $data['counter_of_expired_surveys'] = $counter_of_expired_surveys;
            $data['counter_of_completed_surveys'] = $counter_of_completed_surveys;
            $data['categorys'] = $this->db->query("SELECT * FROM `sv_st_category`
            WHERE (action_en_url AND report_en_url AND media_en_url) IS NOT NULL ORDER BY `Id` DESC ")->result_array();
            $this->load->helper('directory');
            $data['gallery_files'] = directory_map('./assets/images/gallery');
            //$this->response->json($data);
            $this->show('EN/schools/wellness', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }


    public function survey_preview()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_en` AS Title_en,
            sv_st_surveys.Id as mainId ,
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
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' 
                ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                $this->show("EN/schools/preview_survey", $data);
            } else {
                $this->load->view('EN/Global/accessForbidden');
            }
        } else {
            redirect('EN/schools/wellness');
        }
    }

    public function survey_report_view()
    {
        $this->load->model('schools/sv_school_reports');
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $serv_id = $this->uri->segment(4);
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Members List ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['page_title'] = " Qlick Health | survey preview ";
            $data['serv_data'] = $this->db->query(" SELECT 
            `sv_st1_surveys`.`title_ar` AS Title_ar,
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
            WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_surveys`.`Status` = '1'
            AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            if (!empty($data['serv_data'])) {
                $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
                $data['serv_theme'] = $data['serv_data'][0]['serv_theme'];
                $data['serv_img'] = $data['serv_data'][0]['image_name'];
                $group = $data['serv_data'][0]['main_survey_id'];
                $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'
                ORDER BY `sv_st_groups`.`position` ASC")->result_array();
                $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                FROM `sv_st_questions`
                INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0' 
                ORDER BY `sv_st_questions`.`position` ASC")->result_array();
                $group_coices = $data['serv_data'][0]['group_id'];
                $data['group_choices'] = $group_coices;
                $data['choices'] = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
                WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                $this->show("EN/schools/report_view_survey", $data);
            } else {
                $this->load->view('EN/Global/accessForbidden');

            }
        } else {
            redirect('EN/schools/wellness');
        }
    }

    public function question_choice_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7)) {
            $survey_id = $this->uri->segment(4);
            $choice_id = $this->uri->segment(5);
            $question_id = $this->uri->segment(6);
            $perc = $this->uri->segment(7);
            $sessiondata = $this->session->userdata('admin_details');
            $choice_data = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `Id` = '" . $choice_id . "' ")->result_array();
            $data['name'] = $choice_data[0]['title_en'];
            $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice_id . "' ")->num_rows();
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $survey_id;
            $data['question_id'] = $question_id;
            $data['choice_id'] = $choice_id;
            $data['question_id'] = $question_id;
            $data['perc'] = $perc;
            $data['by_types'] = $this->db->query("SELECT 
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
            (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
            JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
            WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
            AND `sv_st1_answers_values`.`choice_id` = '" . $choice_id . "' ) AS Total  
            ")->result_array();
            //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
            $this->load->model('schools/sv_school_reports');
            $data['males'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "M"));
            $data['females'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice_id, "F"));
            $this->load->view("EN/schools/report_question_survey", $data);
        }
    }


    public function publish_serv()
    {
        if ($this->input->post('type') && $this->input->post('gender') && $this->input->post('serv_id')) {
            $sessiondata = $this->session->userdata('admin_details');
            $user_id = $sessiondata['admin_id'];
            $types = $this->input->post('type');
            $genders = $this->input->post('gender');
            $levels = $this->input->post('levels');
            $theme = $this->input->post('theme') ? $this->input->post('theme') : "0";
            $types_arr = array();
            $genders_arr = array();
            $levels_arr = array();
            $data = array(
                'By_school' => $user_id,
                'Serv_id' => $this->input->post('serv_id'),
                'Created' => date('Y-m-d'),
                'Time' => date("H:i:s"),
                "theme_link" => $theme
            );
            try {
                $this->db->trans_start();

                // Insert survey data into sv_school_published_surveys table
                $this->db->insert('sv_school_published_surveys', $data);
                $last_serv = $this->db->insert_id();

                // Insert survey types into sv_school_published_surveys_types table
                foreach ($types as $type) {
                    $types_arr[] = array(
                        "Survey_id" => $last_serv,
                        "Type_code" => $type,
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s'),
                    );
                }
                $this->db->insert_batch('sv_school_published_surveys_types', $types_arr);

                // Insert survey levels into sv_school_published_surveys_levels table
                if (!empty($levels)) {
                    foreach ($levels as $level) {
                        $levels_arr[] = array(
                            "Survey_id" => $last_serv,
                            "Level_code" => $level,
                            "Created" => date('Y-m-d'),
                            "Time" => date('H:i:s'),
                        );
                    }
                    $this->db->insert_batch('sv_school_published_surveys_levels', $levels_arr);
                }

                // Insert survey genders into sv_school_published_surveys_genders table
                foreach ($genders as $gender) {
                    $genders_arr[] = array(
                        "Survey_id" => $last_serv,
                        "Gender_code" => $gender,
                        "Created" => date('Y-m-d'),
                        "Time" => date('H:i:s'),
                    );
                }
                $this->db->insert_batch('sv_school_published_surveys_genders', $genders_arr);

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    // Transaction failed, return error response
                    $this->response->json(['status' => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]);
                } else {
                    // Transaction successful, return success response
                    $this->response->json(['status' => "ok"]);
                }

            } catch (Throwable $th) {
                $this->response->json(['status' => "error", "message" => "Sorry !! we have an unexpected error, please try again later"]);
            }
        } else {
            $this->response->json(['status' => "error", "message" => "Check Your Inputs Please !"]);
        }
    }

    public function results_by_question_chart()
    {
        $hasFilters = false;
        $serv_id = $this->uri->segment(4);
        $this->lang->load("QuestionResults", self::LANGUAGE === "EN" ? "english" : "arabic");

        if ($serv_id && is_numeric($serv_id) && $this->db->where('Id', $serv_id)->count_all_results('sv_school_published_surveys') > 0 && !$this->uri->segment(5)) {
            $this->load->model('schools/sv_school_reports');
            $sessiondata = $this->session->userdata('admin_details');

            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);

            if ($this->input->method() === 'post') {
                $hasFilters = true;
                $data['filters']['classes'] = $this->input->post('classes');
            } else {
                $data['filters']['classes'] = null;
            }

            $data['colors'] = self::COLORS;

            $data['serv_data'] = $this->db->query("SELECT 
					`sv_st1_surveys`.`title_en` AS Title_en,
					`sv_st1_surveys`.`title_ar` AS Title_ar,
					`sv_st1_surveys`.`Startting_date` AS From_date,
					`sv_st1_surveys`.`End_date` AS To_date,
					`sv_st_surveys`.`Message_en` AS Message,
					`sv_st_surveys`.`answer_group_en` AS group_id,
					`sv_st_surveys`.`Id` AS main_survey_id,
					`sv_st_themes`.`file_name` AS serv_theme,
					`sv_sets`.`title_en` AS set_name_en,
					`sv_sets`.`title_ar` AS set_name_ar,
					`sv_st_surveys`.`reference_en` AS reference,
					`sv_st_themes`.`image_name` AS image_name 
				FROM `sv_st1_surveys` 
				JOIN `sv_st_surveys` ON `sv_st1_surveys`.`Survey_id` = `sv_st_surveys`.`Id`
				JOIN `sv_sets` ON `sv_sets`.`Id` = `sv_st_surveys`.`set_id`
				JOIN `sv_school_published_surveys` ON `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
				JOIN `sv_st_themes` ON `sv_st_themes`.`Id` = `sv_school_published_surveys`.`theme_link`
				WHERE `sv_school_published_surveys`.`Id` = '" . $serv_id . "' AND `sv_st1_surveys`.`Status` = '1'
				AND  `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'")->row_array();

            if (!empty($data['serv_data'])) {
                $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
                $data['serv_theme'] = $data['serv_data']['serv_theme'];
                $data['serv_img'] = $data['serv_data']['image_name'];
                $group = $data['serv_data']['main_survey_id'];

                $data['used_groups'] = $this->db->where('serv_id', $group)->get('sv_st_groups')->result_array();
                $data['static_questions'] = $this->db->query("SELECT *, `sv_st_questions`.`Id` AS q_id
					FROM `sv_st_questions`
					INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
					WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`group_id` = '0'")->result_array();

                $group_choices = $data['serv_data']['group_id'];
                $data['group_choices'] = $group_choices;
                $data['choices'] = $this->db->where('group_id', $group_choices)->get('sv_set_template_answers_choices')->result_array();

                $data['filtersResults'] = [];
                if ($hasFilters) {
                    $data['filtersResults']['Students'] = $this->sv_school_reports->users_passed_survey($serv_id, '2', $data["filters"]);
                    $data['filtersResults']['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M', "", $data["filters"]));
                    $data['filtersResults']['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F', "", $data["filters"]));
                }

                $data['Staffs'] = $this->sv_school_reports->users_passed_survey($serv_id, '1');
                $data['Teachers'] = $this->sv_school_reports->users_passed_survey($serv_id, '3');
                $data['Students'] = $this->sv_school_reports->users_passed_survey($serv_id, '2');
                $data['Parents'] = $this->sv_school_reports->users_passed_survey($serv_id, '4');
                $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M'));
                $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F'));
                $finishing_all_data = $this->sv_school_reports->timeOfFinishingForThisSurvey($serv_id);
                $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
                $data['serv_id'] = $serv_id;
                $data['page_title'] = 'Qlick Health | Chart survey';
                $data['sessiondata'] = $sessiondata;
                $data["classes"] = $this->schoolHelper->school_classes();

                $data['language'] = self::LANGUAGE;
                $data['isEn'] = self::LANGUAGE === "EN";
                $this->show('EN/schools/results_by_question_chart', $data);
            } else {
                echo "No Data Found !!";
            }
        } else {
            echo "No Data Found !!";
        }
    }

    public function published_surveys_list()
    {
        $this->load->model('schools/sv_school_reports');
        $status = intval($this->input->get('status') ?? 1);

        $surveys = $this->sv_school_reports->our_published_surveys("", ['status' => $status]);
        $this->load->view('EN/schools/inc/published-surveys', ['published_surveys_unfillable' => $surveys]);
    }

}