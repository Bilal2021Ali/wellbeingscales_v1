<?php

namespace Traits\schools;

use Basic_functions;
use CI_Input;
use Helper;
use permissions;
use schools_temperature;
use sv_school_reports;

/**
 * @property sv_school_reports $sv_school_reports
 * @property Basic_functions $schoolHelper
 * @property schools_temperature $schools_temperature
 * @property permissions $permissions
 * @property Helper $helper
 * @property CI_Input $input
 */
trait Dashboard
{
    public function dashboard(): void
    {
        $this->lang->load('Dashboard', self::LANGUAGE == "EN" ? "english" : "arabic");
        $this->load->model('schools/sv_school_reports');
        $this->load->model('schools/schools_temperature');
        $this->load->model('helper');
        $this->load->library('encrypt_url');

        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['school'] = $this->db->where("Id", $this->sessionData['admin_id'])->get("l1_school")->row();
        $this->response->abort_if(404, !isset($data['school']->Id));

        $data['temprature']['staff'] = $this->schools_temperature->staff()->temperature();
        $data['temprature']['teachers'] = $this->schools_temperature->teachers()->temperature();
        $data['permissions'] = $this->permissions->school();
        $data['counters'] = $this->schoolHelper->counters();
        // wellness
        $getedType = $data['school']->Type_Of_School;
        $saurce_id = $data['school']->Added_By;
        $today = date('Y-m-d');
        $this->load->model('schools/sv_school_reports');
        $data['cards'] = $this->schoolHelper->DashboardCards();
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = '" . $this->sessionData["admin_id"] . "'
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
        ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id` AND  `sv_school_published_surveys`.`By_school` = " . $this->sessionData['admin_id'] . "
        JOIN `sv_school_published_surveys_types`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
        JOIN `sv_school_published_surveys_genders`  
        ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
        JOIN sv_st1_answers ON `sv_st1_answers`.`serv_id` =  `sv_school_published_surveys`.`Id` 
        WHERE EXISTS (SELECT Id FROM `sv_st1_answers` WHERE `serv_id` = `sv_school_published_surveys`.`Id` ) 
        AND `sv_st1_surveys`.`Published_by` = '" . $saurce_id . "'
        GROUP BY survey_id ORDER BY `sv_st1_answers`.`TimeStamp` DESC ")->result_array();
        $data['our_surveys'] = $this->sv_school_reports->our_surveys($this->sessionData['admin_id']);
        $data['used_categorys'] = $this->sv_school_reports->usedcategorys($this->sessionData['admin_id']);

        $data['t'] = 1;
        $data['c'] = 'd';
        $cond = "";
        $filterToday = "'" . date('Y-m-d');
        if ($this->input->method() == "post") {
            $data['t'] = $this->input->post('t');
            $data['c'] = $this->input->post('c');
            $date = match ($data['c']) {
                'y' => "'" . date('Y-01-01'),
                'm' => "'" . date('Y-m-01'),
                default => "'" . date('Y-m-d'),
            };
        } else {
            $date = "'" . date('Y-m-d');
        }
        $cond .= $date ? "AND sca.TimeStamp >=" . $date . " 00:00:00'" . " AND sca.TimeStamp <=" . $filterToday . " 23:59:59'" : "";
        if ($this->helper->set($data['t'])->isValid()) {
            $cond .= "AND sca.user_type = '" . $data['t'] . "'";
        }

        $data['results'] = $this->db->query("SELECT sscc.`Climate_id`,
        setd.title_en as title,
        COUNT(sca.`climate_id`) d1,
        SUM(ssc.`mark`) ss ,
        sq.`en_title` AS question ,
        (SUM(ssc.`mark`) /COUNT(sca.`climate_id`))/(SELECT COUNT(`id`)
        FROM `scl_st_choices` 
        WHERE  `servey_id` =sscc.`Climate_id`
        GROUP BY `servey_id`) *100  ff 
        FROM `scl_climate_answers` AS sca ,
            `scl_published_claimate` spc,
            `scl_st_climate` AS sscc ,
            `scl_st_choices` AS ssc,
            `scl_st0_climate` AS ss0c,
            `sv_questions_library` AS sq,
            `sv_sets` AS setd
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            AND ss0c.`Id` = sscc.`Climate_id`
            AND sq.`Id` = ss0c.`question_id`
            AND setd.`Id` = ss0c.`set_id`
            $cond
        GROUP BY sscc.`Climate_id`,sca.`climate_id`")->result_array();
        $data['fullpage'] = true;
        $data['userstypes'] = $this->helper->get();
        $data['speakout'] = $this->sv_school_reports->speakout();
        $data['templevels'] = [
            'low' => [
                'from' => 0,
                'to' => 36.2,
                'color' => '#07aae2'
            ],
            'normal' => [
                'from' => 36.3,
                'to' => 37.5,
                'color' => '#528233'
            ],
            'moderate' => [
                'from' => 37.6,
                'to' => 38.4,
                'color' => '#fcbf00'
            ],
            'high' => [
                'from' => 38.5,
                'to' => 45,
                'color' => '#f70300'
            ],
        ];
        $usersTypes = ['staff', 'teacher', 'student'];
        foreach ($data['templevels'] as $t => $temp) {
            $data['temperature'][$t] = $this->sv_school_reports->temperature([
                'from' => $temp['from'],
                'to' => $temp['to'],
                'date' => date("Y-m-d")
            ]);
            foreach ($usersTypes as $usertype) {
                $data['temperature'][$usertype][$t] = $this->sv_school_reports->temperature([
                    'from' => $temp['from'],
                    'to' => $temp['to'],
                    'date' => date("Y-m-d"),
                    'usertype' => $usertype,
                ]);
            }
        }
        foreach ($usersTypes as $key => $type) {
            $data['temperature'][$type]['quarantine'] = $this->sv_school_reports->temperature([
                'usertype' => $type,
                'in' => "Quarantine",
            ]);
            $data['temperature'][$type]['home'] = $this->sv_school_reports->temperature([
                'usertype' => $type,
                'in' => "Home",
            ]);
        }
        $data['tests'] = $this->db->get("r_testcode")->result();
        foreach ($data['tests'] as $key => $test) {
            $data['labtests'][$test->Test_Desc]['negative'] = $this->sv_school_reports->lab([
                'type' => $test->Test_Desc,
                'result' => 0,
                'date' => date("Y-m-d")
            ]);
            $data['labtests'][$test->Test_Desc]['positive'] = $this->sv_school_reports->lab([
                'type' => $test->Test_Desc,
                'result' => 1,
                'date' => date("Y-m-d")
            ]);
        }
        $data['today'] = date("Y-m-d");
        $data['active_classes'] = $this->schoolHelper->getActiveSchoolClassesByStudents();
        $data['ClassesResultsDefault'] = [
            'students' => $this->db->get("l2_student")->num_rows(),
            'appsent' => $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_student.F_name_EN, ' ' , l2_student.L_name_EN) AS name")
                ->from("l2_student")
                ->join('absence_records', 'absence_records.userid = l2_student.Id')
                ->join('l2_avatars', 'l2_avatars.For_User = l2_student.Id AND l2_avatars.Type_Of_User = "Student" ', "LEFT")
                ->where("absence_records.usertype", "student")
                ->where("absence_records.day", date("Y-m-d"))
                ->where("absence_records.undone", 0)
                ->get()->num_rows(),
            "quarantine" => $this->sv_school_reports->temperature([
                'usertype' => 'student',
                'date' => date("Y-m-d"),
                'in' => "Quarantine",
            ]),
            "home" => $this->sv_school_reports->temperature([
                'usertype' => 'student',
                'date' => date("Y-m-d"),
                'in' => "Home",
            ]),
        ];
        $data['userscounters'] = [
            "staff" => $this->db->query("SELECT * FROM `l2_staff` WHERE `Added_By` = '" . $this->sessionData['admin_id'] . "' ")->num_rows(),
            "teachers" => $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $this->sessionData['admin_id'] . "' ")->num_rows(),
            "students" => $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $this->sessionData['admin_id'] . "' ")->num_rows(),
            "parents" => 0,
        ];
        $data['language'] = self::LANGUAGE;
        $this->show('Shared/Schools/Dashboard/latest-dashboard', $data);
    }

    public function students_classes(): void
    {
        $this->lang->load('Dashboard', self::LANGUAGE == "EN" ? "english" : "arabic");
        $this->load->model('helper');
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = 'Qlick Health | report climate';
        $data['active_classes'] = $this->schoolHelper->getActiveSchoolClassesByStudents();
        $data['ClassesResults'] = [];
        foreach ($data['active_classes'] as $key => $class) {
            $data['ClassesResults'][$class['Id']] = [
                "className" => $class['Class'],
                'students' => $this->db->where("Class", $class['Id'])->get("l2_student")->num_rows(),
                'appsent' => $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_student.F_name_" . self::LANGUAGE . ", ' ' , l2_student.L_name_" . self::LANGUAGE . ") as name")
                    ->from("l2_student")
                    ->join('absence_records', 'absence_records.userid = l2_student.Id')
                    ->join('l2_avatars', 'l2_avatars.For_User = l2_student.Id AND l2_avatars.Type_Of_User = "Student" ', "LEFT")
                    ->where("absence_records.usertype", "student")
                    ->where("absence_records.day", date("Y-m-d"))
                    ->where("absence_records.undone", 0)
                    ->where("l2_student.class", $class['Id'])
                    ->get()->num_rows(),
                "quarantine" => $this->sv_school_reports->temperature([
                    'usertype' => 'student',
                    'class' => $class['Id'],
                    'date' => date("Y-m-d"),
                    'in' => "Quarantine",
                ]),
                "home" => $this->sv_school_reports->temperature([
                    'usertype' => 'student',
                    'class' => $class['Id'],
                    'date' => date("Y-m-d"),
                    'in' => "Home",
                ]),
            ];
        }
        $this->show('Shared/Schools/Dashboard/schools-classes-counters', $data);
    }
}