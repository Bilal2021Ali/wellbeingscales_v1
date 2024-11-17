<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once __DIR__ . "/../../Menus/SchoolMenus.php";
require_once __DIR__ . "/../../BaseControllers/Schools/courses.php";
require_once __DIR__ . "/../../Traits/schools/ClimatesNewReport.php";
require_once __DIR__ . "/../../Traits/schools/LabTests.php";
require_once __DIR__ . "/../../Traits/schools/UserProfile.php";
require_once __DIR__ . "/../../Traits/schools/SpeakOut.php";
require_once __DIR__ . "/../../Traits/schools/Wellness.php";
require_once __DIR__ . "/../../Traits/schools/SaveStudentProfilePic.php";
require_once __DIR__ . "/../../Traits/schools/Attendance.php";
require_once __DIR__ . "/../../Traits/schools/Dashboard.php";
require_once __DIR__ . "/../../Traits/schools/Profile.php";
require_once __DIR__ . "/../../Traits/schools/Categories.php";
require_once __DIR__ . "/../../Traits/schools/Incidents.php";
require_once __DIR__ . "/../../Traits/schools/Climates.php";
require_once __DIR__ . "/../../Traits/Reusable/Protection.php";
require_once __DIR__ . "/../../Traits/Shared/DoctorReport.php";
require_once __DIR__ . "/../../Traits/schools/SchoolRefrigeratorResults.php";
require_once __DIR__ . "/../../Traits/schools/StudentsAttendance.php";
require_once __DIR__ . "/../../Traits/schools/TasksReport.php";
require_once 'vendor/autoload.php';

use App\Traits\schools\SchoolRefrigeratorResults;
use App\Traits\schools\StudentsAttendance;
use App\Traits\schools\TasksReport;
use App\Traits\Shared\RefrigeratorCards;
use Traits\Reusable\Protection;
use Traits\schools\Attendance;
use Traits\schools\Categories;
use Traits\schools\Climates;
use Traits\schools\Climates as SchoolsClimates;
use Traits\schools\ClimatesNewReport;
use Traits\schools\Dashboard;
use Traits\schools\Incidents;
use Traits\schools\LabTests;
use Traits\schools\Profile;
use Traits\schools\SaveStudentProfilePic;
use Traits\schools\SpeakOut;
use Traits\schools\UserProfile;
use Traits\schools\Wellness;
use Traits\Shared\DoctorReport;

// Include the Attendance trait here

class Schools extends CI_Controller
{
    use StudentsAttendance;
    use SchoolsClimates;
    use ClimatesNewReport, Protection, LabTests, UserProfile, SpeakOut,
        Wellness, SaveStudentProfilePic, Attendance, // Include Attendance here
        Dashboard, Profile, Categories, Incidents, Climates, SchoolRefrigeratorResults,
        TasksReport,
        DoctorReport {
        StudentsAttendance::initializeAttendance insteadof Attendance;
    }

    public const LANGUAGE = "EN";
    public const GENDERS = ['1' => 'Male', '2' => 'Female'];
    public const USERS_TYPES = ['1' => 'staff', '2' => 'students', '3' => 'teachers', '4' => 'parents'];
    public const COLORS = ['#FF6633', '#FFB399', '#FF33FF', '#00B3E6',
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];
    public const TYPE = "school";
    public $permissions_array = array();
    public $coursesHelper;
    public $sessionData = null;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        $this->subaccounts->can("incidents");
        $method = $_SERVER['REQUEST_METHOD'];
        $this->sessionData = $sessiondata;
        if (isset($sessiondata)) {
            if ($sessiondata['level'] == 2 && $sessiondata['type'] == "school") {
            } else if ($sessiondata['type'] == "School_Perm" && $method == "POST") {
            } else {
                redirect('EN/users');
                exit();
            }
            // every thing is good
            $data['temperatureandlabs'] = $this->permissions->temperatureandlabs();
            $data['attendance_permissions'] = $this->permissions->attendance();
            $data['apicopy'] = $this->permissions->apicopy();
            $this->permissions_array["temperatureandlabs"] = $data['temperatureandlabs'];
            $this->permissions_array["apicopy"] = $data['apicopy'];
            $this->permissions_array["attendance_permissions"] = $data['attendance_permissions'];
            $this->load->vars($data);
        } else {
            redirect('EN/users');
            exit();
        }
        $this->coursesHelper = new Courses($this, "en");
    }

    private function apicopy()
    {
        // $Api_db = $this->load->database('Api_db', TRUE);
        $url = 'https://qlickhealth.com/admin/api/QA/services/copyTrackUsers';
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'GET',
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    private static function getTypeCondition($type): string
    {
        $conditionsLines = [
            "staff" => "WHEN `scl_climate_answers`.`user_type` = '1' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )",
            "students" => "WHEN `scl_climate_answers`.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = `scl_climate_answers`.`user_id` LIMIT  1 )",
            "teachers" => "WHEN `scl_climate_answers`.`user_type` = '3' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )",
            "parents" => "WHEN `scl_climate_answers`.`user_type` = '4' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `scl_climate_answers`.`user_id` LIMIT 1 )"
        ];
        return " (
        CASE
        " . $conditionsLines[$type] . "
        ELSE NULL
        END) IS NOT NULL";
    }

    public function welcome()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $data['school'] = $this->db->where("Id", $sessiondata['admin_id'])->get("l1_school")->row();
        $this->show('EN/schools/welcome', $data);
    }

    private function show($view, $data = [])
    {
        $sessionData = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessionData;
        $this->load->view('autoload/schools', ['usersTypes' => self::USERS_TYPES]);
        $this->load->view('EN/inc/header', $data);
        $this->load->view($view);
        $this->load->view('EN/inc/footer');
    }

    public function index()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('schools/sv_school_reports');
        $this->load->library('encrypt_url');
        if (!empty($sessiondata)) {
            $data['page_title'] = "Qlick Health | Dashboard ";
            $data['sessiondata'] = $sessiondata;
            $this->load->library('encrypt_url');
            $data['tempr']['NORMAL'] = $this->GetTotalIn(36.3, 37.5, null);
            // Low Temp Counter
            $data['cards'] = $this->schoolHelper->DashboardCards();
            // climate survey example
            $data['climate_survyes'] = $this->sv_school_reports->GetClimatesurveys();
            $data['tempr']['LOW'] = $this->GetTotalIn(0, 36.2, null);
            $data['tempr']['LOW_In_Home'] = $this->GetTotalIn(0, 36.2, 'Home');
            $data['tempr']['LOW_In_Quern'] = $this->GetTotalIn(0, 36.2, 'Quarantine');
            $data['tempr']['LOW_In_School'] = $this->GetTotalIn(0, 36.2, 'School');
            $data['tempr']['MODERATE'] = $this->GetTotalIn(37.6, 38.4, null);
            $data['tempr']['MODERATE_In_Home'] = $this->GetTotalIn(37.6, 38.4, 'Home');
            $data['tempr']['MODERATE_In_Quern'] = $this->GetTotalIn(37.6, 38.4, 'Quarantine');
            $data['tempr']['MODERATE_In_School'] = $this->GetTotalIn(37.6, 38.4, 'School');
            $this->load->library('Check_account_status');
            $data['account_status'] = $this->check_account_status->schools($sessiondata["admin_id"]);
            $data['tempr']['HIGH'] = $this->GetTotalIn(38.5, 45, null);
            $data['tempr']['HIGH_In_Home'] = $this->GetTotalIn(38.5, 45, 'Home');
            $data['tempr']['HIGH_In_Quern'] = $this->GetTotalIn(38.5, 45, 'Quarantine');
            $data['tempr']['HIGH_In_School'] = $this->GetTotalIn(38.5, 45, 'School');
            $data['list_Tests'] = $this->db->query("SELECT * FROM `r_testcode`")->result_array();
            $data['climate_survyes'] = $this->sv_school_reports->GetClimatesurveys();
            $data["absent"]["staff"] = $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_staff.F_name_EN, ' ' , l2_staff.L_name_EN) AS name")
                ->from("l2_staff")
                ->join('absence_records', 'absence_records.userid = l2_staff.Id')
                ->join('l2_avatars', 'l2_avatars.For_User = l2_staff.Id AND l2_avatars.Type_Of_User = "Staff" ', "LEFT")
                ->where("absence_records.usertype", "staff")
                ->where("absence_records.day", date("Y-m-d"))
                ->where("absence_records.undone", 0)
                ->get()->result_array();
            $data["absent"]["teachers"] = $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_teacher.F_name_EN, ' ' , l2_teacher.L_name_EN) AS name")
                ->from("l2_teacher")
                ->join('absence_records', 'absence_records.userid = l2_teacher.Id')
                ->join('l2_avatars', 'l2_avatars.For_User = l2_teacher.Id AND l2_avatars.Type_Of_User = "Teacher" ', "LEFT")
                ->where("absence_records.usertype", "teacher")
                ->where("absence_records.day", date("Y-m-d"))
                ->where("absence_records.undone", 0)
                ->get()->result_array();
            $data["absent"]["students"] = $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_student.F_name_EN, ' ' , l2_student.L_name_EN) AS name")
                ->from("l2_student")
                ->join('absence_records', 'absence_records.userid = l2_student.Id')
                ->join('l2_avatars', 'l2_avatars.For_User = l2_student.Id AND l2_avatars.Type_Of_User = "Student" ', "LEFT")
                ->where("absence_records.usertype", "student")
                ->where("absence_records.day", date("Y-m-d"))
                ->where("absence_records.undone", 0)
                ->get()->result_array();
            $this->show('EN/schools/dash', $data);
        } else {
            redirect('EN/users');
        }
    }

    private function GetTotalIn($from, $To, $In = null)
    {
        $sessiondata = $this->session->userdata('admin_details');
        $counter = 0;
        $today = date("Y-m-d");
        $inCond = $In == null ? "" : " AND `Action` = '" . $In . "'";
        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE 
        `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();
        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE
        `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();
        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE
        `Added_By` = '" . $sessiondata['admin_id'] . "' $inCond ")->result_array();
        if (!empty($Ourstaffs)) {
            $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($Ourstaffs, "Id")) . ")
            AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }
        if (!empty($OurTeachers)) {
            $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($OurTeachers, "Id")) . ")
            AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResultsT as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }
        if (!empty($OurStudents)) {
            $getResultsS = $this->db->query("SELECT * FROM l2_result WHERE `UserId` IN (" . implode(",", array_column($OurStudents, "Id")) . ")
            AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResultsS as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }
        return ($counter);
    }

    public function labtestall()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('schools/sv_school_reports');
        $this->load->model('helper');
        $this->load->library('encrypt_url');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $data['school'] = $this->db->where("Id", $sessiondata['admin_id'])->get("l1_school")->row();
        if (!isset($data['school']->Id)) {
            $this->output->set_status_header('404');
            return;
        }
        $data['permissions'] = $this->permissions->school();
        $data['counters'] = $this->schoolHelper->counters();
        $data['martial_statuses'] = $this->db->get('l2_martial_status')->result_array();
        $data['counters']['martialCounters'] = $this->schoolHelper->martialCounters($data['counters']);
        $data['counters']['gendersCounters'] = $this->schoolHelper->gendersCounters($data['counters']);
        // wellness
        $getedType = $data['school']->Type_Of_School;
        $saurce_id = $data['school']->Added_By;
        $today = date('Y-m-d');
        $this->load->model('schools/sv_school_reports');
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
        $data['our_surveys'] = $this->sv_school_reports->our_surveys($sessiondata['admin_id']);
        $data['used_categorys'] = $this->sv_school_reports->usedcategorys($sessiondata['admin_id']);
        // source
        $data['t'] = 1;
        $data['c'] = 'd';
        $cond = "";
        $filtertoday = "'" . date('Y-m-d');
        if ($this->input->method() == "post") {
            $data['t'] = $this->input->post('t');
            $data['c'] = $this->input->post('c');
            $cond = "";
            switch ($data['c']) {
                case 'd':
                    $date = "'" . date('Y-m-d');
                    break;
                case 'y':
                    $date = "'" . date('Y-01-01');
                    break;
                case 'm':
                    $date = "'" . date('Y-m-01');
                    break;
                default:
                    $date = "'" . date('Y-m-d');
                    break;
            }
        } else {
            $date = "'" . date('Y-m-d');
        }
        $cond .= $date ? "AND sca.TimeStamp >=" . $date . " 00:00:00'" . " AND sca.TimeStamp <=" . $filtertoday . " 23:59:59'" : "";
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
        $data['temperature']['low'] = $this->sv_school_reports->temperature([
            'from' => 0,
            'to' => 36.2,
            'date' => date("Y-m-d")
        ]);
        $data['temperature']['normal'] = $this->sv_school_reports->temperature([
            'from' => 36.3,
            'to' => 37.5,
            'date' => date("Y-m-d")
        ]);
        $data['temperature']['moderate'] = $this->sv_school_reports->temperature([
            'from' => 37.6,
            'to' => 38.4,
            'date' => date("Y-m-d")
        ]);
        $data['temperature']['high'] = $this->sv_school_reports->temperature([
            'from' => 38.5,
            'to' => 45,
            'date' => date("Y-m-d")
        ]);
        foreach (['staff', 'teacher', 'student'] as $key => $type) {
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
        foreach ($data['active_classes'] as $key => $class) {
            $data['ClassesResults'][$class['Id']] = [
                "className" => $class['Class'],
                'students' => $this->db->where("Class", $class['Id'])->get("l2_student")->num_rows(),
                'appsent' => $this->db->select("l2_avatars.Link as avatar , absence_records.recorded_at , CONCAT(l2_student.F_name_EN, ' ' , l2_student.L_name_EN) AS name")
                    ->from("l2_student")
                    ->join('absence_records', 'absence_records.userid = l2_student.Id')
                    ->join('l2_avatars', 'l2_avatars.For_User = l2_student.Id AND l2_avatars.Type_Of_User = "Student" ', "LEFT")
                    ->where("absence_records.usertype", "student")
                    ->where("absence_records.day", date("Y-m-d"))
                    ->where("absence_records.undone", 0)
                    ->where("l2_student.Class", $class['Id'])
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
        $this->show('EN/schools/labtestall', $data);
    }

    public function all_labtests_results()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('schools/sv_school_reports');
        $this->load->model('helper');
        $this->load->library('encrypt_url');
        $data['page_title'] = "Qlick Health | Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $data['permissions'] = $this->permissions->school();
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
        $this->show("EN/schools/all-labtests-results", $data);
    }

    public function AddMembers()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['added_areas'] = $this->db->query("SELECT 
        `air_areas`.`Id` ,
        `air_areas`.`mac_adress` ,
        `air_areas`.`Description` ,
        `air_areas`.`TimeStamp`  AS Added_in ,
        CONCAT(`r_sites`.`Site_Name`,' - ',`r_sites`.`Site_Code`) AS Site_name
        FROM `air_areas` 
        JOIN `r_sites` ON `r_sites`.`Id` = `air_areas`.`Site_Id` 
        WHERE `air_areas`.`source_id` = '" . $sessiondata['admin_id'] . "' AND `air_areas`.`user_type` = 'school' ")->result_array();
        $data['sites'] = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $data['vehicles'] = $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
        LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
        WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $data['av_relationships'] = $this->db->query("SELECT * FROM `l2_martial_status`")->result_array();
        $data["vehicle_types"] = $this->db->get('l2_vehicle_type')->result_array();
        $data['Positions'] = $this->db->query("SELECT * FROM `r_positions_sch`")->result_array();
        $data['Positions_tech'] = $this->db->query("SELECT * FROM `r_positions_tech`")->result_array();
        $data['prms'] = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`Air_quality` = '1'
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        $data['cars_permissions'] = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        AND  `v0_permissions`.`cars` = '1'
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        $data['classes'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
        $data["vehicle_types"] = $this->db->get('l2_vehicle_type')->result_array();
        //$this->response->json($data);
        $this->show('EN/schools/AddMembers', $data);
    }

    public function AddDevice()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Device ";
        $data['sessiondata'] = $sessiondata;
        $data['devices_types'] = $this->db->get("r_device_type")->result_array();
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && !empty($this->db->get_where("l2_devices", ["Added_By" => $sessiondata['admin_id'], "UserType" => 'school', "Id" => $this->uri->segment(4)])->result_array())) {
            $data['device_data'] = $this->db->get_where("l2_devices", ["Added_By" => $sessiondata['admin_id'], "UserType" => 'school', "Id" => $this->uri->segment(4)])->result_array()[0] ?? array();
            $data['vehicles'] = $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
            LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
            WHERE `l2_vehicle`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND NOT EXISTS (SELECT Id FROM `l2_devices` WHERE car_id = `l2_vehicle`.`Id` AND `l2_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "' AND `l2_devices`.`Id` != '" . $this->uri->segment(4) . "' ) ")->result_array();
        } else {
            $data['vehicles'] = $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
            LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
            WHERE `l2_vehicle`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND NOT EXISTS (SELECT Id FROM `l2_devices` WHERE car_id = `l2_vehicle`.`Id` AND `l2_devices`.`Added_by` = '" . $sessiondata['admin_id'] . "')   ")->result_array();
            $data["device"]['D_Id'] = 0;
        }
        //$this->response->json($data);
        $this->show('EN/schools/AddDevice', $data);
    }

    public function published_surveys_control()
    {
        if ($this->input->method() == "post" && $this->input->post('request_for') == "status" && $this->input->post('survey_id')) {
            $id = $this->input->post('survey_id');
            if ($this->db->query("UPDATE sv_school_published_surveys SET Status = IF(Status=1, 0, 1) WHERE Id ='" . $id . "' ")) {
                echo "ok";
            } else {
                echo "error";
            }
        } elseif ($this->input->method() == "post" && $this->input->post('request_for') == "targetedusers" && $this->input->post('survey_id')) {
            $names = ['Staff', "Student", "Teacher", "Parent"];
            $lang = "EN";
            $surv_id = $this->input->post('survey_id');
            $users = $this->db->query("SELECT 
            CASE
                WHEN `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'staff' THEN (SELECT CONCAT(`F_name_" . $lang . "`,' ',`L_name_" . $lang . "`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `sv_school_published_fillable_surveys_targetedusers`.`user_id` )
                WHEN `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Student' THEN (SELECT CONCAT(`F_name_" . $lang . "`,' ',`L_name_" . $lang . "`) FROM `l2_student` WHERE `l2_student`.`Id` = `sv_school_published_fillable_surveys_targetedusers`.`user_id` )
                WHEN `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'teacher' THEN (SELECT CONCAT(`F_name_" . $lang . "`,' ',`L_name_" . $lang . "`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `sv_school_published_fillable_surveys_targetedusers`.`user_id` )
                WHEN `sv_school_published_fillable_surveys_targetedusers`.`user_Type` = 'Parent' THEN (SELECT name_en FROM `l2_parents` WHERE `l2_parents`.`Id` = `sv_school_published_fillable_surveys_targetedusers`.`user_id` )
                ELSE `sv_school_published_fillable_surveys_targetedusers`.`user_Type`
            END AS name ,
            `sv_school_published_fillable_surveys_targetedusers`.`user_Type` AS type
            FROM `sv_school_published_fillable_surveys_targetedusers`
            WHERE `sv_school_published_fillable_surveys_targetedusers`.`Survey_id` = '" . $surv_id . "'
            ORDER BY `sv_school_published_fillable_surveys_targetedusers`.`Id` DESC ")->result_array();
            $this->response->json(["status" => "ok", "users" => $users]);
        }
    }

    public function MembersList()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Members List ";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/Global/Avatars', $data);
    }

    public function setLocation()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Set lcation";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/setLocation', $data);
    }

    public function insrtLocation()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $id = $sessiondata['admin_id'];
        if ($this->input->post('lat') && $this->input->post('lon')) {
            $this->form_validation->set_rules('lat', 'lat', 'trim|required|numeric');
            $this->form_validation->set_rules('lon', 'lon', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                // set data
                $this->db->set('Latitude', $this->input->post('lat'))->set('Longitude', $this->input->post('lon'))->where('id', $id)->update('l1_school');
            }
        }
    }

    public function ListOfStaff()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List of Staff ";
        $data['sessiondata'] = $sessiondata;
        $data["today"] = date("Y-m-d");
        $data['listofaStaffs'] = $this->db->query("SELECT `l2_staff`.* ,
        (SELECT COUNT(Id) FROM absence_records WHERE day = '" . $data["today"] . "' AND absence_records.usertype = 'staff' AND absence_records.userid = l2_staff.Id LIMIT 1) AS AbsenceRecord , 
        `r_positions_sch`.`Position` AS Position_name
        FROM l2_staff 
        LEFT JOIN `r_positions_sch` ON `l2_staff`.`Position` = `r_positions_sch`.`Id`
        WHERE `l2_staff`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->show('EN/schools/List_Stuff', $data);
    }

    public function UpdateStaffData()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_staff WHERE Id =  '" . $SUFFID . "'
        AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Staff Data ";
            $data['sessiondata'] = $sessiondata;
            $data['av_relationships'] = $this->db->query("SELECT * FROM `l2_martial_status`")->result_array();
            $data['StaffData'] = $this->db->query("SELECT * FROM l2_staff WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->show('EN/schools/Update_Stuff', $data);
        } else {
            redirect('EN/schools');
        }
    }

    public function listOfTeachers()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Teachers ";
        $data['sessiondata'] = $sessiondata;
        $data["today"] = date("Y-m-d");
        $data['teacherslist'] = $this->db->query("SELECT `l2_teacher`.* , 
        (SELECT COUNT(Id) FROM absence_records WHERE day = '" . $data["today"] . "' AND absence_records.usertype = 'teacher' AND absence_records.userid = l2_teacher.Id LIMIT 1) AS AbsenceRecord , 
        `r_positions_tech`.`Position` AS Position_name
        FROM l2_teacher 
        LEFT JOIN `r_positions_tech` ON `l2_teacher`.`Position` = `r_positions_tech`.`Id`
        WHERE `l2_teacher`.`Added_By` = '" . $sessiondata['admin_id'] . "'")->result_array();
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->show('EN/schools/List_Teachers', $data);
    }

    public function UpdateTeacher()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_teacher WHERE Id =  '" . $SUFFID . "'
        AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Teacher ";
            $data['sessiondata'] = $sessiondata;
            $data['av_relationships'] = $this->db->query("SELECT * FROM `l2_martial_status`")->result_array();
            $data['data'] = $this->db->query("SELECT * FROM l2_teacher WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->show('EN/schools/Update_Teacher', $data);
        } else {
            redirect('schools');
        }
    }

    public function UpdateSite()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_site WHERE Id =  '" . $SUFFID . "'
        AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Teacher ";
            $data['sessiondata'] = $sessiondata;
            $data['sitesdata'] = $this->db->query("SELECT * FROM l2_site WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->show('EN/schools/Update_site', $data);
        } else {
            redirect('schools');
        }
    }

    public function serv_reports() // thisd page in included with ajax request
    {
        // new function
        $today = date('Y-m-d');
        $this->load->model('schools/sv_school_reports');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Device";
        $data['sessiondata'] = $sessiondata;
        $schooltype = $this->db->query(" SELECT `Type_Of_School` FROM `l1_school` WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $data['themes'] = $this->db->query(" SELECT * FROM `sv_st_themes` ")->result_array();
        $getedType = $schooltype[0]['Type_Of_School'];
        if ($getedType == "Government") {
            $type = '2';
        } else {
            $type = '3';
        }
        $data['type'] = $type;
        // get results from model
        $data['surveys'] = $this->sv_school_reports->Get_surveys($type);
        $data['expired_surveys'] = $this->sv_school_reports->expired_surveys($type);
        $data['completed_surveys'] = $this->sv_school_reports->expired_surveys($sessiondata['admin_id']);
        $data['answerd_quastions'] = $this->sv_school_reports->answerd_quastions($sessiondata['admin_id']);
        // teachers start
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
        $data['surveys_for_all_genders'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id']);
        $finishing_all_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id']);
        // published durveys fo the scroll of reports
        $data['our_surveys'] = $this->sv_school_reports->our_surveys($sessiondata['admin_id']);
        // totals counter
        $ages_arr = $this->sv_school_reports->ages_forall_users($sessiondata['admin_id']);
        $types = array();
        foreach ($ages_arr as $key => $age) {
            $types[] = array("type" => $key, "values" => array_count_values(array_column($age, "DOP")));
        }
        $data['ages'] = $types;
        $data['count_all_staffs'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['count_all_Teachers'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['count_all_Students'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
        $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
        $data['finishing_time_all'] = $this->calculate_avg_time($finishing_all_data);
        $this->load->view('EN/schools/inc/serv_reports', $data);
    }

    private function calculate_avg_time($returned_data)
    {
        $durations = array_column($returned_data, 'Finishing_time');
        $sum = '0';
        foreach ($durations as $duration) {
            list($h, $m, $s) = explode(':', $duration);
            $sum = bcadd($sum, bcmul($h, '3600'));
            $sum = bcadd($sum, bcmul($m, '60'));
            $sum = bcadd($sum, $s);
        }
        $count = count($durations);
        if ($count !== 0) {
            $avg = bcdiv($sum, $count);
            $hours = floor($avg / 3600);
            $mins = intval(bcdiv(bcmod($avg, '3600'), '60'));
            $secs = intval(bcmod($avg, '60'));
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            return $timeFormat;
        } else {
            return "--:--:--";
        }
    }

    public function survey_reports()
    {
        $accepte = ["staff", "teachers", "students", "parents"];
        $sessiondata = $this->session->userdata('admin_details');
        if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
            $this->output->set_status_header('404');
            return;
        }
        $serv_id = $this->uri->segment(4);
        $survey = $this->db->select("Id")
            ->where("Id", $this->uri->segment(4))
            ->where("By_school", $sessiondata['admin_id'])
            ->get('sv_school_published_surveys')
            ->result_array();
        if (empty($survey)) {
            $this->output->set_status_header('404');
            return;
        }
        if (!$this->uri->segment(5)) {
            // start querys here
            $this->load->model('schools/sv_school_reports');
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['sessiondata'] = $sessiondata;
            $data['serv_id'] = $serv_id;
            $data['users_types'] = array(1, 2, 3, 4);
            // for all
            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            // Staffs
            $data['Staffs'] = $this->sv_school_reports->users_passed_survey($serv_id, '1');
            // teachers
            $data['Teachers'] = $this->sv_school_reports->users_passed_survey($serv_id, '3');
            // students
            $data['Students'] = $this->sv_school_reports->users_passed_survey($serv_id, '2');
            // Parents
            $data['Parents'] = $this->sv_school_reports->users_passed_survey($serv_id, '4');
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_school_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_school_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_school_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M'));
            $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F'));
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "id" => $choice['Id'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/schools/survey_report', $data);
        } elseif ($this->uri->segment(5) && in_array(strtolower($this->uri->segment(5)), $accepte)) { // here start the spicific function page
            // setting variables
            $type = $this->uri->segment(5);
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['type_of_user'] = strtolower($type);
            // start data getting
            $this->load->model('schools/sv_school_reports');
            $serv_id = $this->uri->segment(4);
            $data['page_title'] = "Qlick Health | survey reports ";
            $data['serv_id'] = $serv_id;
            if ($data['type_of_user'] == "staff") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '1');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $user_type_code = '1';
                $data['count_all'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
            } elseif ($data['type_of_user'] == "teachers") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '3');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '3';
            } elseif ($data['type_of_user'] == "students") {
                // making the data for showing it in #radial_chart
                $levels = array();
                $accepted_foreach = array();
                $simple_levels_names_arr = array();
                $avalaible_types_of_classes = $this->db->get('education_profile')->result_array();
                $students_completed_surveys = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '2');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                // students_completed_surveys
                foreach ($avalaible_types_of_classes as $cl_id => $class) {
                    $levels[$class['name']] = 0;
                    $simple_levels_names_arr[] = $class['name'];
                    $accepted_foreach[$class['name']] = explode(";", $class['Classes']);
                }
                foreach ($students_completed_surveys as $key => $students) {
                    foreach ($levels as $key => $level) {
                        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
                            $levels[$key] = $levels[$key] + 1;
                        }
                    }
                }
                $lables_arr = array_map(function ($name) {
                    return "'" . $name . "'";
                }, $simple_levels_names_arr);
                // pass the data
                $data['levels'] = $levels;
                $data['lables_arr'] = $lables_arr;
                // static
                $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '2';
            } elseif ($data['type_of_user'] == "parents") {
                $ages_array = $this->sv_school_reports->get_users_ages($serv_id, '4');
                $ages_array = array_column($ages_array, "DOP");
                $data['ages'] = array_count_values($ages_array);
                $data['count_all'] = "10"; // chnage later
                $user_type_code = '4';
            }
            // for all
            $data['users_passed_survey'] = $this->sv_school_reports->users_passed_survey($serv_id);
            $data['allPassed_Counter'] = sizeof($data['users_passed_survey']);
            $data['used_choices'] = $this->sv_school_reports->survey_q_results($serv_id);
            $data['quastions'] = $this->sv_school_reports->get_surv_quastions($serv_id);
            $data['results_array'] = array();
            $data['main_surv_id'] = $this->sv_school_reports->get_surv_data($serv_id)[0]['main_survey_id'];
            $data['percintage_graph'] = $this->sv_school_reports->get_surv_percintage_graph($serv_id);
            $data['males_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'M', $user_type_code));
            $data['females_count'] = $this->count_gender($this->sv_school_reports->get_surv_percintage_by_gender($serv_id, 'F', $user_type_code));
            $data['users_types'] = array($user_type_code);
            $data['reportdata'] = $this->sv_school_reports->users_passed_survey($serv_id, $user_type_code);
            $data['user_code'] = $user_type_code;
            $choice_arr = array();
            foreach ($data['used_choices'] as $key => $choice) {
                $choice_arr[] = array($choice['choices_en'], "counter" => 0);
            }
            $data['choice_arr'] = $choice_arr;
            $this->show('EN/schools/survey_report_sp', $data);
        } else {
            $this->load->view('EN/Global/accessForbidden');
        }
    }

    private function count_gender($result_array)
    {
        $counter = 0;
        foreach ($result_array as $key => $result) {
            if (!empty($result['U_Name'])) {
                $counter++;
            }
        }
        return $counter;
    }

    public function question_detailed_report()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && $this->uri->segment(7)) {
            $survey_id = $this->uri->segment(4);
            $question_id = $this->uri->segment(5);
            $group_choices = $this->uri->segment(6);
            $data['__count'] = 0;
            $sessiondata = $this->session->userdata('admin_details');
            $choices = $this->db->query("SELECT `title_en`,`Id` FROM `sv_set_template_answers_choices`
            WHERE `group_id` = '" . $group_choices . "' ")->result_array();
            foreach ($choices as $choice) {
                $data['__count']++;
                $data['sessiondata'] = $sessiondata;
                $data['serv_id'] = $survey_id;
                $data['name'] = $choice['title_en'];
                $data['question_id'] = $question_id;
                $data['choice_id'] = $choice['Id'];
                $data['question_id'] = $question_id;
                $data['use_count'] = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "' AND `choice_id` = '" . $choice['Id'] . "' ")->num_rows();
                $all_count = $this->db->query(" SELECT Id FROM `sv_st1_answers_values` WHERE `question_id` = '" . $question_id . "'  ")->num_rows();
                $perc = $this->calc_perc($data['use_count'], $all_count);
                $data['perc'] = $perc;
                $data['by_types'] = $this->db->query("SELECT 
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '4' ) AS Parents ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '1' ) AS Staffs ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '2' ) AS Students ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' AND `sv_st1_answers`.`user_type` = '3' ) AS Teachers  ,
                (SELECT COUNT(`sv_st1_answers_values`.`Id`) FROM sv_st1_answers_values 
                JOIN `sv_st1_answers` ON `sv_st1_answers`.`Id` = `sv_st1_answers_values`.`answers_data_id` 
                WHERE `sv_st1_answers`.`serv_id` = '" . $survey_id . "' AND `sv_st1_answers_values`.`question_id` = '" . $question_id . "' 
                AND `sv_st1_answers_values`.`choice_id` = '" . $choice['Id'] . "' ) AS Total  
                ")->result_array();
                //get_q_answer_percintage_by_gender($surv_id,$quastion,$choice,$gender)
                $this->load->model('schools/sv_school_reports');
                $data['males'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "M"));
                $data['females'] = $this->count_gender($this->sv_school_reports->get_q_answer_percintage_by_gender($survey_id, $question_id, $choice['Id'], "F"));
                $this->load->view("EN/schools/report_question_survey", $data);
            }
        } else {
            redirect('EN/Schools/wellness');
        }
    }

    private function calc_perc($perc, $all)
    {
        $x = $perc;
        $y = $all;
        if ($x > 0 && $y > 0) {
            $percent = $x / $y;
            $percent_friendly = number_format($percent * 100); // change 2 to # of decimals
        } else {
            $percent_friendly = 0;
        }
        return $percent_friendly;
    }

    public function specific_surveys_reports()
    {
        $accepte = ["staff", "teachers", "students", "parents"];
        if ($this->uri->segment(4) && in_array(strtolower($this->uri->segment(4)), $accepte)) {
            $today = date('Y-m-d');
            $data['type_of_user'] = strtolower($this->uri->segment(4));
            $this->load->model('schools/sv_school_reports');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | specific surveys reports";
            $data['sessiondata'] = $sessiondata;
            $schooltype = $this->db->query(" SELECT `Type_Of_School` FROM `l1_school` WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            $data['themes'] = $this->db->query(" SELECT * FROM `sv_st_themes` ")->result_array();
            $getedType = $schooltype[0]['Type_Of_School'];
            if ($getedType == "Government") {
                $type = '2';
            } else {
                $type = '3';
            }
            $data['type'] = $type;
            if ($data['type_of_user'] == "staff") {
                $user_type_code = '1';
                $data['count_all'] = $this->db->get_where('l2_staff', array('Added_By' => $sessiondata['admin_id']))->num_rows();
            } elseif ($data['type_of_user'] == "teachers") {
                $data['count_all'] = $this->db->get_where('l2_teacher', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '3';
            } elseif ($data['type_of_user'] == "students") {
                $data['students_completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], '2');
                $data['count_all'] = $this->db->get_where('l2_student', array('Added_By' => $sessiondata['admin_id']))->num_rows();
                $user_type_code = '2';
            } elseif ($data['type_of_user'] == "parents") {
                $data['count_all'] = "10"; // chnage later
                $user_type_code = '4';
            }
            // get results from model
            $data['surveys'] = $this->sv_school_reports->Get_surveys($type);
            $data['expired_surveys'] = $this->sv_school_reports->expired_surveys($type);
            $data['completed_surveys'] = $this->sv_school_reports->expired_surveys($sessiondata['admin_id']);
            $data['answerd_quastions'] = $this->sv_school_reports->answerd_quastions($sessiondata['admin_id']);
            $data['used_categorys'] = $this->sv_school_reports->usedcategorys($sessiondata['admin_id']);
            // teachers start
            $data['surveys'] = $this->sv_school_reports->specific_type_surveys($sessiondata['admin_id'], $user_type_code);
            $data['quastions'] = $this->sv_school_reports->specific_type_questions($sessiondata['admin_id'], $user_type_code);
            $data['completed_surveys'] = $this->sv_school_reports->specific_type_completed_surveys($sessiondata['admin_id'], $user_type_code);
            $finishing_data = $this->sv_school_reports->specific_type_timeOfFinishing($sessiondata['admin_id'], $user_type_code);
            $data['finishing_time'] = $this->calculate_avg_time($finishing_data);
            // loading the vie2
            $data['surveys_for_males'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '1', $user_type_code);
            $data['surveys_for_females'] = $this->sv_school_reports->surveys_by_gender($sessiondata['admin_id'], '2', $user_type_code);
            // published durveys fo the scroll of reports
            $data['our_surveys'] = $this->sv_school_reports->our_surveys($sessiondata['admin_id'], $user_type_code);
            // totals counter
            $data['avalaible_types_of_classes'] = $this->db->get('education_profile')->result_array();
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | " . $data['type_of_user'] . " Reports ";
            $data['sessiondata'] = $sessiondata;
            $this->show('EN/schools/specific_surveys_reports', $data);
        } else {
            redirect('EN/Schools/wellness');
        }
    }

    public function get_questions_of_avalaible_surveys()
    {
        if ($this->input->post("group_id")) {
            $group = $this->input->post("group_id");
            if ($this->input->post('surveyType') == 'fillable') {
                $q_table = "sv_st_fillable_questions";
            } else {
                $q_table = "sv_st_questions";
            }
            $quastins = $this->db->query("SELECT *,`" . $q_table . "`.`Id` AS q_id
            FROM `" . $q_table . "`
            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `" . $q_table . "`.`question_id`
            WHERE `survey_id` = '" . $group . "' ")->result_array();
            if (!empty($quastins)) {
                foreach ($quastins as $key => $question) { ?>
                    <div id="question_<?= $question['q_id'] ?>" class="animate__animated">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none" style="border: 0px;">
                                <a href="#quas_<?= $question['q_id'] ?>" class="text-dark" data-toggle="collapse"
                                   aria-expanded="true" aria-controls="quas_<?= $question['q_id'] ?>">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            <?= ($key + 1) . ". " . $question['en_title']; ?>
                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"
                                               style="margin-top: -5px;"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="quas_<?= $question['q_id'] ?>" class="collapse" aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <h6><?= $question['code']; ?> | <?= $question['TimeStamp']; ?></h6>
                                        <p><?= $question['en_desc'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <img src="<?= base_url() ?>assets/images/404-error.png" alt="" class="w-100">
                <h3 class="text-center">No data found!!</h3>
                <?php
            }
        }
    }

    public function publish_fillable_serv()
    {
        if ($this->input->post('Targetusers') && $this->input->post('serv_id')) {
            if (!empty($this->input->post('Targetusers'))) {
                $sessiondata = $this->session->userdata('admin_details');
                $user_id = $sessiondata['admin_id'];
                $theme = $this->input->post('theme') ? $this->input->post('theme') : "0";
                $targetUsers = $this->input->post('Targetusers');
                $data = array(
                    'By_school' => $user_id,
                    'Serv_id' => $this->input->post('serv_id'),
                    'Created' => date('Y-m-d'),
                    'Time' => date("H:i:s"),
                    "theme_link" => $theme,
                    "survey_type" => "fillable",
                );
                if ($this->db->insert('sv_school_published_surveys', $data)) {
                    $last_serv = $this->db->query("SELECT Id FROM `sv_school_published_surveys`
                    WHERE `By_school` = '" . $user_id . "' ORDER BY Id DESC LIMIT 1 ")->result_array();
                    if (!empty($last_serv)) {
                        $serv_id = $last_serv[0]['Id'];
                        $users = array();
                        foreach ($targetUsers as $user) {
                            $userdata = explode(':', $user);
                            $users[] = array(
                                "Survey_id" => $serv_id,
                                "user_Type" => $userdata[0],
                                "user_id" => $userdata[1],
                            );
                        }
                        if ($this->db->insert_batch('sv_school_published_fillable_surveys_targetedusers', $users)) {
                            echo "ok";
                        }
                    }
                }
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    }

    public function listOfStudents()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Sites ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM l2_student WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->show('EN/schools/List_Students', $data);
    }

// Callback function to validate and format the date

    public function listOfSites()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List Of Sites ";
        $data['sessiondata'] = $sessiondata;
        $data['listofaStaffs'] = $this->db->query("SELECT * FROM `l2_site` WHERE Added_By = '" . $sessiondata['admin_id'] . "'")->result_array();
        $this->show('EN/schools/List_sites', $data);
    }

    public function UpdateStudent()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $SUFFID = $this->uri->segment(4);
        $iscorrect = $this->db->query("SELECT * FROM l2_student WHERE Id =  '" . $SUFFID . "'
        AND Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
        if ($iscorrect > 0) {
            $data['page_title'] = "Qlick Health | Update Teacher ";
            $data['sessiondata'] = $sessiondata;
            $data['av_relationships'] = $this->db->query("SELECT * FROM `l2_martial_status`")->result_array();
            $data['StaffData'] = $this->db->query("SELECT * FROM l2_student WHERE Id  = '" . $SUFFID . "' LIMIT 1")->result_array();
            $this->show('EN/schools/Update_Students', $data);
        } else {
            redirect('schools');
        }
    }

    public function startAddStaff()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            //$this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required|callback_validate_date');

            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('relationship', 'relationship type', 'trim|required|numeric');
            $this->form_validation->set_rules('mac_address', 'watch Mac address', 'trim|max_length[200]|is_unique[l2_staff.watch_mac]');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                //$DOP = $this->input->post('DOP');
                $DOP = $this->input->post('DOP', true); // Add the second parameter `true` to sanitize the value


                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $password = "12345678";
                $genration = $this->generatecode($sessiondata['admin_id'], $National_Id);
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $addme = "";
                if (isset($sessiondata['Teacher_ID'])) {
                    $addme = $sessiondata['Teacher_ID'] . ';Teacher';
                } elseif (isset($sessiondata['Staff_ID'])) {
                    $addme = $sessiondata['Staff_ID'] . ';Staff';
                }
                $relationship = $this->input->post('relationship');
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    if ($iscrrent == 0) {
                        $data = [
                            "Prefix" => $Prefix,
                            "F_name_EN" => $First_Name_EN,
                            "M_name_EN" => $Middle_Name_EN,
                            "L_name_En" => $Last_Name_EN,
                            "F_name_AR" => $First_Name_AR,
                            "M_name_AR" => $Middle_Name_AR,
                            "L_name_AR" => $Last_Name_AR,
                            //"DOP" => $DOP,
                            "DOP" => $DOP,
                            "Phone" => $Phone,
                            "Gender" => $Gender,
                            "National_Id" => $National_Id,
                            "Nationality" => $Nationality,
                            "Position" => $Position,
                            "Email" => $Email,
                            "Password" => $hash_pass,
                            "UserName" => $National_Id,
                            "Added_By" => $sessiondata['admin_id'],
                            "generation" => $genration,
                            "Created" => date('Y-m-d H:i:s'), // Format : 2021-02-25 16:39:11
                            "martial_status" => $relationship,
                            "watch_mac" => $this->input->post('mac_address') ?? ""
                        ];
                        if ($this->db->insert('l2_temp_staff', $data)) {
                            $userid = $this->db->insert_id();
                            $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                            if ($this->permissions_array["apicopy"]) {
                                if ($this->apicopy()) {
                                    $this->response->json(["status" => "ok"]);
                                } else {
                                    $this->response->json(["status" => "error", "message" => "we have unexpected error in copying data !"]);
                                }
                            } else {
                                $this->response->json(["status" => "ok"]);
                            }
                        }
                    } else {
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    private function generatecode($sessiondata, $n_id)
    {
        $parent = $this->db->query("SELECT Added_By,Country FROM `l1_school` 
		WHERE Id = '" . $sessiondata . "' ORDER BY `Id` DESC")->result_array();
        $parentId = str_pad($parent[0]['Added_By'], 4, '0', STR_PAD_LEFT);
        $s_id = str_pad($sessiondata, 4, '0', STR_PAD_LEFT);
        $country = $parent[0]['Country'];
        $g_country = str_pad($country, 4, '0', STR_PAD_LEFT);
        $genrationcode = $g_country . $parentId . $s_id . $n_id;
        return ($genrationcode);
    }

    // Teacher

    public function validate_date($date)
    {
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);

        if ($dateObj && $dateObj->format('Y-m-d') === $date) {
            // Convert the date to "YYYY-MM-DD" format and store it back to the form field
            $_POST['DOP'] = $dateObj->format('Y-m-d');
            return true;
        } else {
            $this->form_validation->set_message('validate_date', 'The {field} field must be in the format YYYY-MM-DD.');
            return false;
        }
    }

    public function sync()
    {
        /*$this->load->model('Test_db2');
		$this->Test_db2->sync_two_databases();*/
        echo "This Page Not Work Now !!";
    }

    public function UpdateStaff()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('relationship', 'relationship status', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                //style="padding: 10px;background: #f3f8fb;"
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $Nationality = $this->input->post('Nationality');
                //$Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                //$old_NID = $this->input->post('old_NID');
                $ID = $this->input->post('ID');
                $Position = $this->input->post('Position');
                $relationship = $this->input->post('relationship');
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 && $finalyage < 90) {
                    if ($this->db->query("UPDATE `l2_temp_staff` SET Prefix = '" . $Prefix . "' , 
                    F_name_EN = '" . $First_Name_EN . "' , M_name_EN = '" . $Middle_Name_EN . "' , L_name_EN = '" . $Last_Name_EN . "' ,
                    F_name_AR = '" . $First_Name_AR . "' , M_name_AR = '" . $Middle_Name_AR . "' , L_name_AR = '" . $Last_Name_AR . "' ,
                    DOP = '" . $DOP . "' , Phone = '" . $Phone . "' , Gender = '" . $Gender . "' , Nationality = '" . $Nationality . "' ,
                    Email = '" . $Email . "' , `martial_status` = '" . $relationship . "' , `Position` = '" . $Position . "' , `adding_method` = 'page' 
                    WHERE User_id = '" . $ID . "'
                    ")) { ?>
                        <script>
                            Swal.fire({
                                title: 'Good job!',
                                text: 'The data was inserted.',
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.href = "<?= base_url("EN/schools/listOfStaff") ?>";
                            }, 1000);
                        </script>
                    <?php }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function startAddTeacher()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Position', 'Position', 'trim|required');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('relationship', 'relationship type', 'trim|required|numeric');
            $this->form_validation->set_rules('Classes[]', 'Classes', 'trim|required');
            $this->form_validation->set_rules('mac_address', 'watch Mac address', 'trim|max_length[200]|is_unique[l2_teacher.watch_mac]');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $National_Id = $this->input->post('N_Id');
                $Nationality = $this->input->post('Nationality');
                $Position = $this->input->post('Position');
                $Email = $this->input->post('Email');
                $Classes = $this->input->post('Classes');
                $relationship = $this->input->post('relationship');
                $addme = "";
                if (isset($sessiondata['Teacher_ID'])) {
                    $addme = $sessiondata['Teacher_ID'] . ';Teacher';
                } elseif (isset($sessiondata['Staff_ID'])) {
                    $addme = $sessiondata['Staff_ID'] . ';Staff';
                }
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $genration = $this->generatecode($sessiondata['admin_id'], $National_Id);
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
                    if ($iscrrent == 0) {
                        $data = [
                            "Prefix" => $Prefix,
                            "F_name_EN" => $First_Name_EN,
                            "M_name_EN" => $Middle_Name_EN,
                            "L_name_En" => $Last_Name_EN,
                            "F_name_AR" => $First_Name_AR,
                            "M_name_AR" => $Middle_Name_AR,
                            "L_name_AR" => $Last_Name_AR,
                            "DOP" => $DOP,
                            "Phone" => $Phone,
                            "Gender" => $Gender,
                            "National_Id" => $National_Id,
                            "Nationality" => $Nationality,
                            "Position" => $Position,
                            "Email" => $Email,
                            "Password" => $hash_pass,
                            "UserName" => $National_Id,
                            "Added_By" => $sessiondata['admin_id'],
                            // "Add_Me"           => $addme,
                            "generation" => $genration,
                            "Created" => date('Y-m-d H:i:s'), // Format : 2021-02-25 16:39:11
                            "martial_status " => $relationship,
                            "watch_mac" => $this->input->post('mac_address') ?? ""
                        ];
                        if ($this->db->insert('l2_temp_teacher', $data)) {
                            $id = $this->db->insert_id();
                            // insert classes data
                            $techerClasses = array();
                            foreach ($Classes as $class) {
                                $techerClasses[] = array(
                                    "class_id" => $class,
                                    "teacher_id" => $id
                                );
                            }
                            //end classes
                            if ($this->db->insert_batch('l2_teachers_classes', $techerClasses)) {
                                $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                                if ($this->permissions_array["apicopy"]) {
                                    if ($this->apicopy()) {
                                        $this->response->json(["status" => "ok"]);
                                    } else {
                                        $this->response->json(["status" => "error", "message" => "we have unexpected error in copying data !"]);
                                    }
                                } else {
                                    $this->response->json(["status" => "ok"]);
                                }
                            }
                        }
                    } else {
                        echo "The National ID already exists.";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function startaddvehicle()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('vic_no', 'Vehicle No', 'trim|required|max_length[200]|min_length[3]|is_unique[l2_vehicle.No_vehicle]');
        $this->form_validation->set_rules('vic_type', 'Vehicle type', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('vic_company', 'Vehicle company', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('vic_Country', 'Vehicle Country', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('vic_Model', 'Vehicle Model', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('vic_year', 'Vehicle year', 'trim|required|exact_length[4]|numeric');
        $this->form_validation->set_rules('colors_select', 'Vehicle Color', 'trim|required|max_length[200]');
//        $this->form_validation->set_rules('mac_address', 'Mac address', 'trim|required|max_length[200]|valid_mac|is_unique[l2_vehicle.watch_mac]');
        $this->form_validation->set_rules('mac_address', 'Mac address', 'trim|max_length[200]|valid_mac|is_unique[l2_vehicle.watch_mac]');
        if ($this->form_validation->run()) {
            $data = [
                "No_vehicle" => $this->input->post('vic_no'),
                "type_vehicle" => $this->input->post('vic_type'),
                "Company_vehicle" => $this->input->post('vic_company'),
                "Country_vehicle" => $this->input->post('vic_Country'),
                "Model_vehicle" => $this->input->post('vic_Model'),
                "Year_vehicle" => $this->input->post('vic_year'),
                "Color_vehicle" => $this->input->post('colors_select'),
                "Color_vehicle" => $this->input->post('colors_select'),
                "watch_mac" => $this->input->post('mac_address'),
                "Added_By" => $sessiondata['admin_id'],
                "Company_Type" => 5,
            ];
            if ($this->db->insert('l2_vehicle', $data)) {
                echo "ok";
            }
        } else {
            echo validation_errors();
        }
    }

    public function UpdateTeacherData()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');

        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules([
                ['field' => 'Prefix', 'label' => 'Prefix', 'rules' => 'trim|required'],
                // Include other validation rules here...
            ]);

            if ($this->form_validation->run()) {
                $ID = $this->input->post('ID');
                $DOP = $this->input->post('DOP');
                $age = date_diff(date_create($DOP), date_create('today'))->y;

                if ($age >= 4 && $age <= 70) {
                    $Prefix = $this->input->post('Prefix');
                    $First_Name_EN = $this->input->post('First_Name_EN');
                    $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                    $Last_Name_EN = $this->input->post('Last_Name_EN');
                    $First_Name_AR = $this->input->post('First_Name_AR');
                    $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                    $Last_Name_AR = $this->input->post('Last_Name_AR');
                    $DOP = $this->input->post('DOP');
                    $Phone = $this->input->post('Phone');
                    $Gender = $this->input->post('Gender');
                    $Nationality = $this->input->post('Nationality');
                    $Position = $this->input->post('Position');
                    $Email = $this->input->post('Email');
                    $relationship = $this->input->post('relationship');
                    $password = "12345678"; // For demonstration purposes, don't use hardcoded passwords in production
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

                    // Construct the data array for the update
                    $data = [
                        'Prefix' => $Prefix,
                        'F_name_EN' => $First_Name_EN,
                        'M_name_EN' => $Middle_Name_EN,
                        'L_name_EN' => $Last_Name_EN,
                        'F_name_AR' => $First_Name_AR,
                        'M_name_AR' => $Middle_Name_AR,
                        'L_name_AR' => $Last_Name_AR,
                        'DOP' => $DOP,
                        'Phone' => $Phone,
                        'Gender' => $Gender,
                        'Nationality' => $Nationality,
                        'Email' => $Email,
                        'Position' => $Position,
                        'martial_status' => $relationship
                    ];

                    // Update the database
                    if ($this->db->update('l2_temp_teacher', $data, ['User_id' => $ID])) {
                        $Classes = $this->input->post('Classes');
                        $this->db->delete('l2_teachers_classes', ['teacher_id' => $ID]);  // DELETE OLD data
                        $teacherClasses = [];
                        foreach ($Classes as $class) {
                            $teacherClasses[] = [
                                "class_id" => $class,
                                "teacher_id" => $ID
                            ];
                        }
                        if ($this->db->insert_batch('l2_teachers_classes', $teacherClasses)) {
                            // Show success message or redirect
                            echo "The Data Is Inserted.";
                            echo "<script>
                            Swal.fire({title: 'Good!', text: 'The data was updated.', icon: 'success'});
                            setTimeout(function(){
                                location.href = '" . base_url() . "EN/schools/listOfTeachers'; 
                            }); </script>";
                        }
                    }
                } else {
                    echo "Please provide a valid date of birth within the age range of 4 to 70 years.";
                }
            } else {
                echo validation_errors();
            }
        }
    }


    public function ListofDevices()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | List of Staff ";
        $data['sessiondata'] = $sessiondata;
        $data['listofadevices'] = $this->db->query("SELECT * FROM l2_devices 
          WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'school' ")->result_array();
        $this->show('EN/schools/List_Devices', $data);
    }

    public function DeletDevice()
    {
        $id = $this->input->post('Conid');
        if ($this->db->query(" DELETE FROM l2_devices WHERE Id = '" . $id . "'  ")) {
            echo "The device was deleted.";
        } else {
            echo "oops We have A error Please Try Again Later";
        }
    }

    public function UpdateStudentData()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post('Prefix')) {
            $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
            // English
            $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
            $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
            // Arabic
            $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
            $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
            $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
            $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
            $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('Classes', 'Classes ', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Grades', 'Grade', 'trim|required');
            $this->form_validation->set_rules('relationship', 'relationship', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                $Prefix = $this->input->post('Prefix');
                $First_Name_EN = $this->input->post('First_Name_EN');
                $Middle_Name_EN = $this->input->post('Middle_Name_EN');
                $Last_Name_EN = $this->input->post('Last_Name_EN');
                //    AR inputs
                $First_Name_AR = $this->input->post('First_Name_AR');
                $Middle_Name_AR = $this->input->post('Middle_Name_AR');
                $Last_Name_AR = $this->input->post('Last_Name_AR');
                //style="padding: 10px;background: #f3f8fb;"
                $DOP = $this->input->post('DOP');
                $Phone = $this->input->post('Phone');
                $Gender = $this->input->post('Gender');
                $Nationality = $this->input->post('Nationality');
                $Email = $this->input->post('Email');
                $ID = $this->input->post('ID');
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                ////clases
                $clases = $this->input->post('Classes');
                $grade = $this->input->post('Grades');
                $relationship = $this->input->post('relationship');
                $age = explode('-', $DOP);
                $thisyear = date('Y');
                $finalyage = $thisyear - $age[2];
                if ($finalyage > 4 || $finalyage < 70) {
                    $newdata = [
                        "Prefix" => $Prefix,
                        "F_name_EN" => $First_Name_EN,
                        "M_name_EN" => $Middle_Name_EN,
                        "L_name_EN" => $Last_Name_EN,
                        "F_name_AR" => $First_Name_AR,
                        "M_name_AR" => $Middle_Name_AR,
                        "L_name_AR" => $Last_Name_AR,
                        "DOP" => $DOP,
                        "Phone" => $Phone,
                        "Gender" => $Gender,
                        "Nationality" => $Nationality,
                        "Email" => $Email,
                        "Class" => $clases,
                        "Grades" => $grade,
                        "martial_status" => $relationship,
                    ];
                    if ($this->input->post('parent_nid') !== $this->input->post('old_parentid_1')) {
                        if ($this->db->get_where('v_nationalids', ["National_Id" => $this->input->post('parent_nid')])->num_rows() <= 0) {
                            $newdata['Parent_NID'] = $this->input->post('parent_nid');
                            $this->db->set('National_Id', $this->input->post('parent_nid'));
                            $this->db->where('National_Id', $this->input->post('old_parentid_1'));
                            $this->db->update('v_nationalids');
                            $this->db->reset_query();
                            $this->db->set('Username', $this->input->post('parent_nid'));
                            $this->db->where('Username', $this->input->post('old_parentid_1'));
                            $this->db->update('v_login');
                        } else {
                            exit("The parent id must be unique !!");
                        }
                    }
                    if ($this->input->post('parent_nid_2') !== $this->input->post('old_parentid_2')) {
                        if ($this->db->get_where('v_nationalids', ["National_Id" => $this->input->post('parent_nid')])->num_rows() > 0) {
                            $newdata['Parent_NID_2'] = $this->input->post('parent_nid_2');
                            $this->db->set('National_Id', $this->input->post('parent_nid_2'));
                            $this->db->where('National_Id', $this->input->post('old_parentid_2'));
                            $this->db->update('v_nationalids');
                            $this->db->reset_query();
                            $this->db->set('Username', $this->input->post('parent_nid_2'));
                            $this->db->where('Username', $this->input->post('old_parentid_2'));
                            $this->db->update('v_login');
                        } else {
                            exit("The second parent id must be unique !!");
                        }
                    }
                    $this->db->set($newdata);
                    $this->db->where('User_id', $ID);
                    if ($this->db->update('l2_temp_student')) {
                        echo "The Data Is Inserted.";
                        echo "<script>
                        Swal.fire({title: 'Good !',text: 'The data was updated.',icon: 'success'});
                        setTimeout(function(){
                            location.href = '" . base_url() . "EN/schools/listOfStudents'; 
                        },1200);
                        </script>";
                    }
                } else {
                    echo "Please correct Your Date Of Birth";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function startAddStudent()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Prefix', 'Prefix', 'trim|required');
        // English
        $this->form_validation->set_rules('First_Name_EN', 'First Name EN', 'trim|required');
        $this->form_validation->set_rules('Middle_Name_EN', 'Middle Name EN', 'trim|required');
        $this->form_validation->set_rules('Last_Name_EN', 'Last Name EN', 'trim|required');
        // Arabic
        $this->form_validation->set_rules('First_Name_AR', 'First Name AR', 'trim|required');
        $this->form_validation->set_rules('Middle_Name_AR', 'Middle Name AR', 'trim|required');
        $this->form_validation->set_rules('Last_Name_AR', 'Last Name AR', 'trim|required');
        // Information
        $this->form_validation->set_rules('DOP', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('N_Id', 'National Id', 'trim|required');
        $this->form_validation->set_rules('Nationality', 'Nationality', 'trim|required');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('P_NID', 'Parent Natinal Id', 'trim|required');
        $this->form_validation->set_rules('M_NID', 'Second Natinal Id', 'trim|differs[P_NID]');
        $this->form_validation->set_rules('Classes', 'Classes', 'trim|required|numeric');
        $this->form_validation->set_rules('Grades', 'Grade', 'trim|required|min_length[4]|max_length[10]');
        $this->form_validation->set_rules('relationship', 'relationship type', 'trim|required|numeric');
        $this->form_validation->set_rules('mac_address', 'watch Mac address', 'trim|max_length[200]|valid_mac|is_unique[l2_student.watch_mac]');
        if (!$this->form_validation->run()) {
            echo validation_errors();
            return;
        }

        $Prefix = $this->input->post('Prefix');
        $First_Name_EN = $this->input->post('First_Name_EN');
        $Middle_Name_EN = $this->input->post('Middle_Name_EN');
        $Last_Name_EN = $this->input->post('Last_Name_EN');
        //    AR inputs
        $First_Name_AR = $this->input->post('First_Name_AR');
        $Middle_Name_AR = $this->input->post('Middle_Name_AR');
        $Last_Name_AR = $this->input->post('Last_Name_AR');
        $relationship = $this->input->post('relationship');
        $DOP = $this->input->post('DOP');
        $Phone = $this->input->post('Phone');
        $Gender = $this->input->post('Gender');
        $National_Id = $this->input->post('N_Id');
        $Nationality = $this->input->post('Nationality');
        $Email = $this->input->post('Email');
        $P_NID = $this->input->post('P_NID');
        $M_NID = $this->input->post('M_NID') ?? "";
        $clases = $this->input->post('Classes');
        $grade = $this->input->post('Grades');
        $addme = "";
        if (isset($sessiondata['Teacher_ID'])) {
            $addme = $sessiondata['Teacher_ID'] . ';Teacher';
        } elseif (isset($sessiondata['Staff_ID'])) {
            $addme = $sessiondata['Staff_ID'] . ';Staff';
        }
        $password = "12345678";
        $Sec_password = "12345678";
        $hash_Sec_password = password_hash($Sec_password, PASSWORD_DEFAULT);
        $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
        $m_hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
        $genration = $this->generatecode($sessiondata['admin_id'], $National_Id, $Nationality);
        $age = explode('-', $DOP);
        $thisyear = date('Y');
        $finalyage = $thisyear - $age[2];
        if ($finalyage > 4 || $finalyage < 70) {
            $iscrrent = $this->db->query("SELECT * FROM `v_nationalids` WHERE National_Id = '" . $National_Id . "'")->num_rows();
            if ($iscrrent == 0) {
                $data = [
                    "Prefix" => $Prefix,
                    "F_name_EN" => $First_Name_EN,
                    "M_name_EN" => $Middle_Name_EN,
                    "L_name_En" => $Last_Name_EN,
                    "F_name_AR" => $First_Name_AR,
                    "M_name_AR" => $Middle_Name_AR,
                    "L_name_AR" => $Last_Name_AR,

                    "DOP" => date('Y-m-d', strtotime($DOP)),

                    "Phone" => $Phone,
                    "Gender" => $Gender,
                    "National_Id" => $National_Id,
                    "Nationality" => $Nationality,
                    "Email" => $Email,
                    "Password" => $hash_pass,
                    "UserName" => $National_Id,
                    "Added_By" => $sessiondata['admin_id'],
                    // "Add_Me"           => $addme,
                    "generation" => $genration,
                    "Created" => date('Y-m-d H:i:s'), // Format : 2021-02-25 16:39:11
                    "martial_status" => $relationship,
                    "Grades" => $grade,
                    "Parent_NID" => $P_NID,
                    "Parent_NID_2" => $M_NID,
                    "Class" => $clases,
                    "watch_mac" => $this->input->post('mac_address') ?? ""
                ];
                if ($this->db->insert("l2_temp_student", $data)) {
                    $id = $this->db->insert_id();
                    //$this->response->json($this->db->get("l2_student")->result_array());
                    $num_Username = $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $P_NID . "' LIMIT 1 ")->num_rows();
                    $secon_uscount = strlen($M_NID) < 11 ? 'notadded' : $this->db->query("SELECT * FROM `v_login` WHERE Username = '" . $M_NID . "' LIMIT 1 ")->num_rows();
                    if ($num_Username == 0) {
                        // $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`,`Created` , `generation`) VALUES ('" . $P_NID . "','" . $hash_pass . "','Parent','" . date('Y-m-d H:i:s') . "','" . $genration . "')");
                    }
                    if ($secon_uscount == 0) {
                        // $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`,`Created` , `generation`) VALUES ('" . $M_NID . "','" . $m_hash_pass . "','Parent','" . date('Y-m-d H:i:s') . "','" . $genration . "')");
                    }
                    if ($age >= 12) {
                        // $this->db->query("INSERT INTO `v_login` (`Username`,`Password`,`Type`,`Created`, `generation`) VALUES ('" . $National_Id . "','" . $hash_Sec_password . "','Student','" . date('Y-m-d H:i:s') . "','" . $genration . "')");
                    }
                    // echo "The Data Is Inserted.";
                    // echo "<script>Swal.fire({title: 'Good job!',text: 'The data was inserted.',icon: 'success'});</script>";
                    $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];

                    $this->saveStudentProfilePic(null, $data['National_Id']);
                    if ($this->permissions_array["apicopy"]) {
                        $post = array();
                        $post[] = [
                            "email" => $National_Id,
                            "phone" => $National_Id,
                            "password" => "25d55ad283aa400af464c76d713c07ad",
                            "hash" => '9b8619251a19057cff70779273e95aa6',
                            "is_verified" => '1',
                            "reg_id" => $id,
                            "device_type" => "IOS",
                            "language" => "English",
                            "latitude" => "0.1",
                            "longitude" => "0.1",
                            "device_type" => "iso",
                            "city_id" => "789",
                            "country_id" => "143",
                            "companyName" => $school_data['School_Name_EN'] ?? "",
                            "nationalId" => $National_Id,
                            "username" => $First_Name_EN . " " . $Middle_Name_EN . " " . $Last_Name_EN,
                            "gender" => ($Gender == "M" ? "Male" : "Female"),
                            "date_of_birth" => date('Y-m-d', strtotime($DOP)),

                            "watch_mac" => $this->input->post('mac_address') ?? "Bind Watch",
                            "usertype" => "Student",
                            "companytype" => "School",
                            "companyid" => $sessiondata['admin_id'],
                            'uid' => 'user1',
                            'login_type' => 'normal',
                            'created' => date('Y-m-d H:i:s'),
                        ];
                        $post[] = [
                            "email" => $P_NID,
                            "phone" => $P_NID,
                            "password" => "25d55ad283aa400af464c76d713c07ad",
                            "hash" => '9b8619251a19057cff70779273e95aa6',
                            "is_verified" => '1',
                            "reg_id" => $id,
                            "device_type" => "IOS",
                            "language" => "English",
                            "latitude" => "0.1",
                            "longitude" => "0.1",
                            "device_type" => "iso",
                            "city_id" => "789",
                            "country_id" => "143",
                            "companyName" => $school_data['School_Name_EN'] ?? "",
                            "nationalId" => $P_NID,
                            "username" => "",
                            "gender" => "",
                            "date_of_birth" => "",
                            "watch_mac" => "Bind Watch",
                            "usertype" => "Parent",
                            "companytype" => "School",
                            "companyid" => $sessiondata['admin_id'],
                            'uid' => 'user1',
                            'login_type' => 'normal',
                            'created' => date('Y-m-d H:i:s'),
                        ];

                        if ($this->apicopy()) {
                            $this->response->json(["status" => "ok"]);
                        } else {
                            $this->response->json(["status" => "error", "message" => "we have unexpected error in copying data !"]);
                        }
                    } else {
                        $this->response->json(["status" => "ok"]);
                    }
                }
            } else {
                echo "The national id already exists.";
            }
        } else {
            echo "Please correct your date of birth";
        }

    }

    public function startUpdatingSchool()
    {
        // this function well get the infos from "add_level1_system" view .form id addSysteme .
        // the data sended by ajax method POST and include "Arabic_Title" and "English_Title" loook lines 40-44 ... ;
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        if ($this->input->post('Arabic_Title') && $this->input->post('English_Title')) {
            $this->form_validation->set_rules('Arabic_Title', 'Arabic Title', 'trim|required');
            $this->form_validation->set_rules('English_Title', 'English Title', 'trim|required');
            $this->form_validation->set_rules('Manager_AR', 'Manager Arabic Name', 'trim|required');
            $this->form_validation->set_rules('Manager_EN', 'Manager English Name', 'trim|required');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('Country', 'Country', 'trim|required');
            $this->form_validation->set_rules('city', 'city', 'trim|required');
            $this->form_validation->set_rules('School_Gender', 'School Gender', 'trim|required|in_list[Male,Female,mix]');
            $this->form_validation->set_rules('SchoolId', 'School Id', 'trim|required|min_length[3]|max_length[30]');
            if ($this->form_validation->run()) {
                $Arabic_Title = $this->input->post('Arabic_Title');
                $English_Title = $this->input->post('English_Title');
                $Manager_AR = $this->input->post('Manager_AR');
                $Manager_EN = $this->input->post('Manager_EN');
                $Phone = $this->input->post('Phone');
                $Email = $this->input->post('Email');
                $Country = $this->input->post('Country');
                $City = $this->input->post('city');
                $data = [
                    "School_Name_AR" => $Arabic_Title,
                    "School_Name_EN" => $English_Title,
                    "Manager_EN" => $Manager_EN,
                    "Manager_AR" => $Manager_AR,
                    "Email" => $Email,
                    "Phone" => $Phone,
                    "Country" => $Country,
                    "Citys" => $City,
                    "Gender" => $this->input->post('School_Gender'),
                    "Type_Of_School" => $this->input->post('Type'),
                    "SchoolId" => $this->input->post('SchoolId'),
                    'Directorate_Id' => $this->input->post("directorate"),
                    'Directorate_Type_Id' => $this->input->post("sub_directorate"),
                ];
                if ($this->db->set($data)->where('id', $sessiondata['admin_id'])->update("l1_school")) {
                    echo "<script>Swal.fire({title: 'Success!',text: 'The data is updated successfully.',icon: 'success'});</script>";
                    echo "<script>
				location.reload();
				</script>";
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function AddClasses()
    {
        /////// adding classes
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->post("classes")) {
            $data = array();
            $classes = $this->input->post("classes");
            $this->db->delete('l2_school_classes', array('school_id' => $sessiondata['admin_id']));  // DELETE OLD DATA
            foreach ($classes as $class) {
                $data[] = array(
                    "school_id" => $sessiondata['admin_id'],
                    "class_key" => $class
                );
            }
            if ($this->db->insert_batch('l2_school_classes', $data)) {
                echo "ok";
            } else {
                echo "error";
            }
        } else {
            $this->db->delete('l2_school_classes', array('school_id' => $sessiondata['admin_id']));  // DELETE OLD DATA
        }
    }

    public function startAddDevice()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $School_Id = $sessiondata['admin_id'];
        $this->load->library('form_validation');
        $Device_Id = $this->input->post('Device_Id');
        $this->form_validation->set_rules('Device_Id', 'Device MAC', 'trim|required');
        $this->form_validation->set_rules('Comments', 'Comments', 'trim|required');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Site_ar', 'Site AR', 'trim|required');
        $this->form_validation->set_rules('Description_ar', 'Description AR', 'trim|required');
        $this->form_validation->set_rules('car_id', 'The car', 'trim|required|numeric');
        $this->form_validation->set_rules('device_type', 'device type', 'trim|required|numeric');
        if ($this->form_validation->run()) {
            // $this->response->dd($this->input->post());
            if ($this->input->post('Device_Id')) {
                $pattern = "/@/";
                $is_has_aroabas = preg_match($pattern, $Device_Id);
                if ($is_has_aroabas) {
                    echo "<script>
                    Swal.fire({title: 'Error!',text: 'You Cant Enter \"@\" In The device Name',icon: 'error'});
                    </script>";
                } else {
                    $Site = $this->input->post('Site');
                    $Description = $this->input->post('Description');
                    $comments = $this->input->post("Comments");
                    if ($this->input->post("device_id") !== "0") {
                        $conter = 0;
                    } else {
                        $conter = $this->db->query("SELECT * FROM `l2_devices` WHERE D_Id = '" . $Device_Id . "'  ")->num_rows();
                    }
                    if ($conter == 0) {
                        $data = [
                            "D_Id" => $Device_Id,
                            "Added_by" => $School_Id,
                            "Comments" => $comments,
                            "Created" => date('Y-m-d'),
                            "UserType" => 'school',
                            "Site" => $Site,
                            "Description" => $Description,
                            "Site_ar" => $this->input->post("Site_ar"),
                            "Description_ar" => $this->input->post("Description_ar"),
                            "device_type" => $this->input->post("device_type"),
                            "car_id" => ($this->input->post("car_id") ?? 0),
                            'Company_Type' => 5,
                        ];
                        if ($this->input->post("active_device_id") !== "def") {
                            $this->db->set($data);
                            $this->db->where('Id', $this->input->post("active_device_id"));
                            $this->db->update('l2_devices');
                        } else {
                            $this->db->insert("l2_devices", $data);
                        }
                        echo "<script>
                        Swal.fire({title: 'Success!',text: 'The device is " . ($this->input->post("active_device_id") !== "def" ? "updated" : "inserted") . " successfully.',icon: 'success'});
                        location.reload();     
                        </script>";
                    } else {
                        echo "<script>
                    Swal.fire({title: 'Error!',text: 'This Device Id is Already Exist !!',icon: 'error'});
                    </script>";
                    }
                }
            }
        } else {
            $text = validation_errors();
            $f_text = str_replace("<p>", " ", $text);
            $l_text = str_replace("</p>", "\n", $f_text);
            ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: `<?= $l_text; ?>`,
                    icon: 'error',
                });
            </script>
            <?php
        }
    }

    public function startAddBatch()
    {
        $this->load->library('form_validation');
        if ($this->input->post('Batch')) {
            $Batch = $this->input->post('Batch');
            $ForDevice = $this->input->post("ForDevice");
            $dev_type = $this->input->post("DeviceType");
            $pattern = "/@/";
            $is_has_aroabas = preg_match($pattern, $Batch);
            if ($is_has_aroabas) {
                echo "<script>
                Swal.fire({title: 'Error!',text: 'You Cant Enter \"@\" In The device Batch',icon: 'error'});
                </script>";
            } else {
                $conter = $this->db->query("SELECT * FROM `l2_batches` WHERE Batch_Id = '" . $Batch . "' AND 
                For_Device = '" . $ForDevice . "' ")->num_rows();
                if ($conter == 0) {
                    $this->db->query("INSERT INTO 
                `l2_batches` ( `Batch_Id`, `For_Device`, `Device_Type` ,`Created`)
                VALUES ('" . $Batch . "', '" . $ForDevice . "', '" . $dev_type . "' , '" . date('Y-m-d') . "')");
                    echo "<script>
                    Swal.fire({title: 'Success!',text: 'The Batch is Added successfully.',icon: 'success'});
                    location.reload();     
                    </script>";
                } else {
                    echo "<script>
                    Swal.fire({title: 'Error!',text: 'This Batch Id is Already Exist !!',icon: 'error'});
                    </script>";
                }
            }
        } else {
            echo "<script>
            Swal.fire({title: 'Error!',text: 'Please Enter Valid Batch',icon: 'error'});
            </script>";
        }
    }

    public function startAddSite()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('Site_ar', 'Site AR', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Description_ar', 'Description AR', 'trim|required');
        $this->form_validation->set_rules('Site_for', 'What Site for', 'trim|required|numeric');
        if ($this->form_validation->run()) {
            $addme = "";
            if (isset($sessiondata['Teacher_ID'])) {
                $addme = $sessiondata['Teacher_ID'] . ';Teacher';
            } elseif (isset($sessiondata['Staff_ID'])) {
                $addme = $sessiondata['Staff_ID'] . ';Staff';
            }
            $Site = $this->input->post("Site");
            $Description = $this->input->post("Description");
            $Site_For = $this->input->post("Site_for");
            $data = [
                "Site_Code" => $Site,
                "Description" => $Description,
                "Added_By" => $sessiondata['admin_id'],
                "Add_Me" => $addme,
                "Site_For" => $Site_For,
                "Description_ar" => $this->input->post("Description_ar"),
                "Site_Code_ar" => $this->input->post("Site_ar"),
                "Created" => date("Y-m-d"),
                "Company_Type" => 5,
            ];
            if ($this->db->insert("l2_site", $data)) { ?>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'The data was inserted successfully.',
                        icon: 'success'
                    });
                    setTimeout(function () {
                        location.href = "<?= base_url(); ?>EN/schools/AddMembers?last=Site";
                    }, 900);
                </script>
                <?php
            } else {
                echo "sorry we have an error";
            }
        } else {
            echo validation_errors();
        }
    }

    public function StartUpdateSite()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $Description = $this->input->post("Description");
            $ID = $this->input->post("AZF_UFGFDX");
            if ($this->db->query("UPDATE `l2_site` SET `Description` = '" . $Description . "' WHERE `l2_site`.`Id` = $ID ")) { ?>
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'The data was updated successfully.',
                        icon: 'success'
                    });
                    setTimeout(function () {
                        location.href = "<?= base_url(); ?>EN/schools/listOfSites";
                    }, 900);
                </script>
                <?php
            } else {
                echo "error";
            }
        } else {
            echo validation_errors();
        }
    }

    public function startAddPermition()
    {
        $this->load->library('form_validation');
        if ($this->input->post('selectedPerm')) {
            $this->form_validation->set_rules('selectedPerm', 'User', 'trim|required');
            if ($this->form_validation->run()) {
                $selectedPerm = $this->input->post('selectedPerm');
                $ex_permition = explode(';', $selectedPerm);
                $Id = $ex_permition[0];
                $Type = $ex_permition[1];
                if ($Type == 'Staff') {
                    $this->db->query("UPDATE `l2_staff` SET PermSchool = 1 WHERE Id = '" . $Id . "'");
                    echo "The permission was added.";
                    echo "<script>
          Swal.fire({
          title: 'Success!',
          text: 'The permission was added.',
          icon: 'success'
          });
          </script>"; ?>
                    <script>
                        location.href = "<?= base_url();  ?>EN/schools";
                    </script>
                    <?php
                } elseif ($Type == 'Teacher') {
                    $this->db->query("UPDATE `l2_teacher` SET PermSchool = 1 WHERE Id = '" . $Id . "'");
                    echo "The permission was added.";
                    echo "<script>
          Swal.fire({
          title: 'Success!',
          text: 'The permission was added.',
          icon: 'success'
          });
          </script>"; ?>
                    <script>
                        location.reload();
                    </script>
                    <?php
                } else {
                    echo "Please Select an User !";
                }
            } else {
                echo validation_errors();
            }
        } else {
            echo "Please Select A Staff or Teacher !!";
        }
    }

    public function DeletPermition()
    {
        if ($this->input->post("Conid") && $this->input->post("TypeOfuser")) {
            $ID = $this->input->post("Conid");
            $Type = $this->input->post("TypeOfuser");
            if ($Type == "Teacher") {
                $tablename = "l2_teacher";
            } else {
                $tablename = "l2_staff";
            }
            $this->db->query("UPDATE $tablename SET PermSchool = 0 WHERE Id = '" . $ID . "' ");
            echo "The permission was removed.";
        }
    }

    //// chart for students

    public function ListOfStudentByClass()
    {
        $class = $this->input->post("NumberOfClass");
        if ($class !== "") {
            $class = $this->input->post("NumberOfClass");
            $sessiondata = $this->session->userdata('admin_details');
            $students = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "' ")->result_array();
            if (!empty($students)) { ?>
                <div class="card-body" style="padding-top: 0px;">
                    <table class="Students_Table" style="width: 100%;">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> Name</th>
                            <th> National ID</th>
                            <th> Enter</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $stud) { ?>
                            <tr id="TrStudId<?= $stud['Id']; ?>">
                                <th scope="row"> <?= $stud['Id']; ?> </th>
                                <td> <?= $stud['F_name_EN'] . ' ' . $stud['M_name_EN'] . ' ' . $stud['L_name_EN']; ?></td>
                                <td> <?= $stud['National_Id']; ?> </td>
                                <td>
                                    <form class="AddResultStudent">
                                        <input type="number" class="form-control form-control-sm"
                                               placeholder="Enter Data Here " name="Temp" value="37" min="30" max="50">
                                        <input type="hidden" value="<?= $stud['Id']; ?>" name="UserId">
                                        <input type="hidden" name="ST_Type" class="Test_type">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(".Students_Table").DataTable();
                    var Test_type_ST = $("#Test_type").children("option:selected").val();
                    $('.Test_type').val(Test_type_ST);
                    $('.Students_Table').on('focusout', '.AddResultStudent', function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>EN/Results/AddResultForStudent',
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                $('.JHZLNS').html(data);
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! we have a error',
                                    'error'
                                )
                            }
                        });
                    });
                </script>
            <?php }
        } else {
            echo "Please select the class.";
        }
    }

    // ajax end tests start

    public function ListOfStudentByClassCovid()
    {
        $class = $this->input->post("NumberOfClass");
        if ($class !== "") {
            $class = $this->input->post("NumberOfClass");
            $sessiondata = $this->session->userdata('admin_details');
            $students = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "' ")->result_array();
            if (!empty($students)) { ?>
                <table class="Students_Table table" style="width: 100%;">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Student Name</th>
                        <th> National ID</th>
                        <th> Enter Batch Number then Press Result Button</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $stud) { ?>
                        <tr id="Student_<?= $stud['Id']; ?>">
                            <th scope="row"> <?= $stud['Id']; ?> </th>
                            <td> <?= $stud['F_name_EN'] . ' ' . $stud['M_name_EN'] . ' ' . $stud['L_name_EN']; ?></td>
                            <td> <?= $stud['National_Id']; ?> </td>
                            <td>
                                <div style="display: flex;">
                                    <input id="KKZBBSQ<?= $stud['Id']; ?>NZIOAZS11" type="text" placeholder="Batch"
                                           class="form-control" style="width: auto;display: inherit;">
                                    <button class="btn btn-danger waves-effect waves-light btn-covid"
                                            onClick="addCovidTestStudent(<?= $stud['Id']; ?>,'Student','Pos');"><i
                                                class="uil uil-plus"></i></button>
                                    <button class="btn btn-success waves-effect waves-light btn-covid"
                                            onClick="addCovidTestStudent(<?= $stud['Id']; ?>,'Student','Nigative');"><i
                                                class="uil uil-minus"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $(".Students_Table").DataTable();
                    var Test_type_ST = $("#Test_type").children("option:selected").val();
                    $('.Test_type').val(Test_type_ST);

                    function addCovidTestStudent(id, user_type, val) {
                        var batch = $("#KKZBBSQ" + id + "NZIOAZS11").val();
                        // var test = par.child('input').val();
                        console.log("THEST Var Is   " + batch);
                        var TestDev = $('#Test_device').children("option:selected").val();
                        var Test_id = $('#Test_Id').children("option:selected").val();
                        //console.log("THEST DEV"+TestDev);
                        //alert('Test'+id+' '+user_type+' '+val);
                        var result;
                        if (val == 'Pos') {
                            result = 1;
                        } else {
                            result = 0;
                        }
                        if (batch !== "") {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url(); ?>EN/Results/AddCovidResult',
                                data: {
                                    UserId: id,
                                    Test_type: user_type,
                                    Temp: result,
                                    Device: TestDev,
                                    Batch: batch,
                                    Test: Test_id,
                                },
                                success: function (data) {
                                    $('.JHZLNS').html(data);
                                },
                                ajaxError: function () {
                                    Swal.fire(
                                        'error',
                                        'oops!! we have a error',
                                        'error'
                                    )
                                }
                            });
                        } else {
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Sorry, you need to enter the batch. ",
                                showConfirmButton: !1,
                                timer: 1500
                            })
                        }
                    }
                </script>
            <?php }
        } else {
            echo "Please select the class.";
        }
    }

    public function ListStudentsChangeAvatar()
    {
        $class = $this->input->post("NumberOfClass");
        if ($class !== "") {
            $class = $this->input->post("NumberOfClass");
            $sessiondata = $this->session->userdata('admin_details');
            $students = $this->db->query("SELECT * FROM `l2_student` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "' ")->result_array();
            if (!empty($students)) { ?>
                <table class="Students_Table table" style="width: 100%;">
                    <thead>
                    <tr>
                        <th></th>
                        <th> Name</th>
                        <th> National ID</th>
                        <th> Upload</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $stud) { ?>
                        <tr id="TrStafffId<?= $stud['Id']; ?>">
                            <th scope="row" class="Avatar" style="text-align: center;">
                                <?php
                                $avatar_teach = $this->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '" . $stud['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                                ?>
                                <?php if (empty($avatar_teach)) { ?>
                                    <a href="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                       class="image-popup-no-margins">
                                        <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                             class="avatar-xs rounded-circle " alt="...">
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url(); ?>uploads/avatars/<?= $avatar_teach[0]['Link']; ?>"
                                       class="image-popup-no-margins">
                                        <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar_teach[0]['Link']; ?>"
                                             class="avatar-xs rounded-circle " alt="...">
                                    </a>
                                <?php } ?>
                            </th>
                            <td> <?= $stud['F_name_EN'] . ' ' . $stud['M_name_EN'] . ' ' . $stud['L_name_EN']; ?></td>
                            <td><?= $stud['National_Id']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>EN/Schools/ChangeMemberAvatar/Student/<?= $stud['Id']; ?>/<?= $stud['National_Id'] ?>"><i
                                            class="uil uil-user"></i> </a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $("table").DataTable();
                </script>
            <?php }
        } else {
            echo "Please select the class.";
        }
    }

    public function ChartTempOfClass()
    {
        $class = $this->input->post("NumberOfClass");
        if ($class !== "") {
            $class = $this->input->post("NumberOfClass");
            $sessiondata = $this->session->userdata('admin_details');
            ?>
            <div id="hereGetedStudents">
                <?php
                $today = date("Y-m-d");
                $counter = 0;
                $Ourstaffs1 = $this->db->query("SELECT * FROM l2_student WHERE 
                `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "'  ")->result_array();
                foreach ($Ourstaffs1 as $staffs) {
                    $resultsIntable = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staffs['Id'] . "' AND UserType = 'Student'
                    AND Result_Date = '" . $today . "' ORDER BY `Id` DESC LIMIT 1")->num_rows();
                    if ($resultsIntable == 0) {
                        $counter++;
                    }
                }
                ?>
                <h4 class="card-title mb-4">Students Without Temperature Record: <a href=""> <?= $counter; ?></a></h4>
                <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
            </div>
            <?php
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Student'
ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Result" => $results['Result']);
                }
            }
            ?>
            <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
            <!-- apexcharts init -->
            <script>
                var options = {
                        chart: {
                            height: 300,
                            type: "line",
                            zoom: {
                                enabled: !1
                            },
                            toolbar: {
                                show: !1
                            }
                        },
                        colors: ["#5b73e8"],
                        dataLabels: {
                            enabled: !1
                        },
                        stroke: {
                            width: [3, 3],
                            curve: "straight"
                        },
                        series: [{
                            name: "Temperature",
                            // here data
                            data: [<?php foreach ($list as $finalresults) {
                                echo $finalresults['Result'] . ',';
                            } ?>]
                        }],
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: .2
                            },
                            borderColor: "#f1f1f1"
                        },
                        markers: {
                            style: "inverted",
                            size: 6
                        },
                        xaxis: {
                            categories: [<?php foreach ($list as $names) {
                                echo '"' . $names['Username'] . '",';
                            } ?>],
                            title: {
                                text: "Students’ Names"
                            }
                        },
                        yaxis: {
                            title: {
                                text: "Temperature"
                            },
                            min: 32,
                            max: 43
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "right",
                            floating: !0,
                            offsetY: -25,
                            offsetX: -5
                        },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: {
                                    toolbar: {
                                        show: !1
                                    }
                                },
                                legend: {
                                    show: !1
                                }
                            }
                        }]
                    },
                    chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
                chart.render();
            </script>
        <?php } else {
            echo "<h4>Plese Choice a Class!</h4>";
        }
    }

    public function tests()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Tests";
        $data['sessiondata'] = $sessiondata;
        if ($this->permissions_array['temperatureandlabs']) {
            $this->show('EN/schools/Test', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    //GetTotalIn(,,'');

    public function Lab_Tests()
    {
        if ($this->permissions_array['temperatureandlabs']) {
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Lab Tests";
            $devices_counter = $this->db->query("SELECT * FROM  `l2_devices` 
        WHERE `Added_by` = '" . $sessiondata['admin_id'] . "' AND `UserType` = 'school' ")->num_rows();
            $data['sessiondata'] = $sessiondata;
            if ($devices_counter !== 0) {
                $this->show('EN/schools/Test_lab', $data);
            } else {
                $data['hasntnav'] = true;
                $this->show('EN/Global/NoDecvices', $data);
            }
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function ChartofTempForStaff()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            $sessiondata = $this->session->userdata('admin_details');
            $today = date("Y-m-d");
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
                 AND Result_Date = '" . $today . "' AND UserType = 'Staff'  ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Result" => $results['Result']);
                }
            }
            $this->load->view("Shared/Schools/temperature-charts", ['today' => $today, 'list' => $list, 'type' => "Staff"]);
        } // end if post
    }

    public function ChartofTempForTeacher()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            $sessiondata = $this->session->userdata('admin_details');
            $today = date("Y-m-d");
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffName = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
                AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffName, "Result" => $results['Result']);
                }
            }
            $this->load->view("Shared/Schools/temperature-charts", ['today' => $today, 'list' => $list, 'type' => "Teacher"]);
        } // end if post
    }

    public function ListResultsOfStaffs()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            $sessiondata = $this->session->userdata('admin_details');
            $today = date("Y-m-d");
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $ID = $staff['Id'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Result_Date']);
                }
            } ?>
            <table class="table table-borderless table-centered table-nowrap">
                <thead>
                <tr>
                    <th> Test ID</th>
                    <th> Img</th>
                    <th> Name</th>
                    <th> Test Type</th>
                    <th> Date</th>
                    <th> Result</th>
                    <th> Result</th>
                </tr>
                </thead>
                <tbody>
                <style>
                    .badge {
                        text-align: center;
                    }
                </style>
                <?php foreach ($list as $staffsRes) { ?>
                    <tr>
                        <td><?= $staffsRes['TestId']; ?></td>
                        <td style="width: 20px;">
                            <?php
                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                            ?>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td> <?= $staffsRes['Username']; ?> </td>
                        <td><?= $staffsRes['Testtype']; ?></td>
                        <td> <?= $staffsRes['Creat']; ?> </td>
                        <?php if ($staffsRes['Result'] > 36.3 && $staffsRes['Result'] < 37.7) { ?>
                        <td><span class="badge badge-soft-success font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } elseif ($staffsRes['Result'] > 37.8) { ?>
                        <td><span class="badge badge-soft-danger font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } else { ?>
                        <td><span class="badge badge-soft-warning font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } ?>
                        <td>GRR</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <script>
                $("table").DataTable();
            </script>
            <?php
        } // end if post
    }

    public function ListResultsOfTeachers()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            $sessiondata = $this->session->userdata('admin_details');
            $today = date("Y-m-d");
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "'
")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $ID = $staff['Id'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Teacher' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array("Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Result_Date']);
                }
            } ?>
            <table class="table table-borderless table-centered table-nowrap">
                <thead>
                <tr>
                    <th> Test ID</th>
                    <th> Img</th>
                    <th> Name</th>
                    <th> Test Type</th>
                    <th> Date</th>
                    <th> Result</th>
                    <th> Result</th>
                </tr>
                </thead>
                <tbody>
                <style>
                    .badge {
                        text-align: center;
                    }
                </style>
                <?php foreach ($list as $staffsRes) { ?>
                    <tr>
                        <td><?= $staffsRes['TestId']; ?></td>
                        <td style="width: 20px;">
                            <?php
                            $avatar = $this->db->query("SELECT * FROM `l2_avatars`
     WHERE `For_User` = '" . $staffsRes['Id'] . "' AND `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                            ?>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td>
                            <?= $staffsRes['Username']; ?>
                        </td>
                        <td><?= $staffsRes['Testtype']; ?></td>
                        <td>
                            <?= $staffsRes['Creat']; ?>
                        </td>
                        <?php if ($staffsRes['Result'] > 36.3 && $staffsRes['Result'] < 37.7) { ?>
                        <td><span class="badge badge-soft-success font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } elseif ($staffsRes['Result'] > 37.8) { ?>
                        <td><span class="badge badge-soft-danger font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } else { ?>
                        <td><span class="badge badge-soft-warning font-size-12"
                                  style="width: 100%;"><?= $staffsRes['Result']; ?></span>
                            <?php } ?>
                        <td>GRR</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <script>
                $("table").DataTable();
            </script>
            <?php
        } // end if post
    }

    public function ListResultsOfDtudents()
    {
        $this->load->model('schools/schools_temperature');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST" && $this->input->post("class") !== "") {
            $class = $this->input->post("class");
            $sessiondata = $this->session->userdata('admin_details');
            $list = array();
            $today = date("Y-m-d");
            $Ourstaffs = $this->db->query("SELECT * FROM l2_student 
            WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' AND Class = '" . $class . "' ")->result_array();
            foreach ($Ourstaffs as $staff) {
                $staffname = $staff['F_name_EN'] . ' ' . $staff['L_name_EN'];
                $ID = $staff['Id'];
                $grade = $staff['Grades'];
                $action = $staff['Action'];
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
                AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
                foreach ($getResults as $results) {
                    $list[] = array(
                        "Username" => $staffname, "Id" => $ID, "TestId" => $results['Id'], "Testtype" => $results['Device_Test'], "Result" => $results['Result'], "Creat" => $results['Result_Date'], "Symptoms" => $results['Symptoms'], "Time" => $results['Time'], "In" => $results['Action'], "Grade" => $grade, "Action" => $action
                    );
                }
            }
            $results = $this->schools_temperature->students()->temperature(['class' => $this->input->post("class")]);
            $teachers = $this->db->query("SELECT l2_avatars.Link as avatar FROM  `l2_teacher`  
                                JOIN `l2_teachers_classes` ON `l2_teachers_classes`.`class_id` = '" . $class . "'
                                LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_teacher`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Teacher'
                                AND `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id`
                                WHERE  `l2_teacher`.`Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 3 ")->result_array();
            ?>
            <table class="table table-borderless table-centered table-nowrap students-results-list">
                <thead>
                <tr>
                    <th> #</th>
                    <th> Img</th>
                    <th> Name</th>
                    <th> Teachers</th>
                    <th> Grade</th>
                    <th> Date &amp; Time</th>
                    <th> Result</th>
                    <th> Risk</th>
                    <th> Symptoms</th>
                    <th> Actions</th>
                </tr>
                </thead>
                <tbody>
                <style>
                    .badge {
                        text-align: center;
                    }
                </style>
                <?php foreach ($results as $sn => $result) { ?>
                    <tr>
                        <td><?= $sn + 1; ?></td>
                        <td style="width: 20px;">
                            <?php if (empty($result['avatar'])) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $result['avatar']; ?>"
                                     class="avatar-xs rounded-circle " alt="...">
                            <?php } ?>
                        </td>
                        <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal"> <?= $result['Name']; ?></h6>
                            <?php if ($result['Action'] == "Home") { ?>
                                <p class="font-size-13 mb-0 text-primary"><b><?= $result['Action'] ?></b></p>
                            <?php } elseif ($result['Action'] == "Quarantine") { ?>
                                <p class="font-size-13 mb-0 text-danger"><b><?= $result['Action'] ?></b></p>
                            <?php } else { ?>
                                <p class="font-size-13 mb-0 text-success"><?= $result['Action'] ?></p>
                            <?php } ?>
                        </td>
                        <td style="padding-left: 40px;z-index: 1000;">
                            <?php foreach ($teachers as $teacher) { ?>
                                <?php if (empty($teacher['avatar'])) { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                         class="avatar-xs rounded-circle " alt="..."
                                         style="margin-left:-20px;border: 3px solid #fff;">
                                <?php } else { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/<?= $teacher['avatar']; ?>"
                                         class="avatar-xs rounded-circle " alt="..."
                                         style="margin-left:-20px;border: 3px solid #fff;">
                                <?php }
                            } ?>
                            <span class="More">
                                <a class="right-bar-toggle" onClick="initRightSidebar();"
                                   title="Double Click To Show More">
                                    <?= sizeof($teachers) > 2 ? sizeof($teachers) . "+" : sizeof($teachers); ?>
                                </a>
                            </span>
                        </td>
                        <td>
                            <?= $result['Grades']; ?>
                        </td>
                        <td>
                            <?= $result['Result_Date'] . " " . $result['Time']; ?>
                        </td>
                        <?php $this->boxes_colors($result['Result']); ?>
                        <td><?php $result['Symptoms'] ?></td>
                        <td>
                            <a href="javascript:void(0);" class="px-3 text-primary goHome" title="Stay Home"
                               theId="<?= $result['Id']; ?>">
                                <img src="<?= base_url(); ?>assets/images/icons/Home.png" alt="" width="20px">
                            </a>
                            <a href="javascript:void(0);" class="text-danger Quarantine" data-toggle="tooltip"
                               data-placement="top" title="Quarantine" data-original-title="Quarantine"
                               theId="<?= $result['Id']; ?>">
                                <img src="<?= base_url(); ?>assets/images/icons/quarntine.jpg" alt="" width="20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div id="return_stud_action"></div>
            <script>
                try {
                    $("table").DataTable();
                } catch (err) {
                    console.log(err);
                }
                $('.students-results-list').on("click", ".goHome", function () {
                    var theId = $(this).attr('theId');
                    console.log(theId);
                    Swal.fire({
                        title: 'Are you sure you want to do this action?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: `Yes, I am sure!`,
                        icon: 'warning',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url(); ?>EN/Schools/SetStudentInHouse',
                                data: {
                                    S_Id: theId,
                                    Action: 'Home',
                                },
                                success: function (data) {
                                    $('#return_stud_action').html(data);
                                },
                                ajaxError: function () {
                                    Swal.fire(
                                        'error',
                                        'oops!! we have a error',
                                        'error'
                                    )
                                }
                            });
                        }
                    })
                });
                $('.students-results-list').on("click", ".Quarantine", function () {
                    $(this).click(function () {
                        var theId = $(this).attr('theId');
                        console.log(theId);
                        Swal.fire({
                            title: ' Are you sure you want to do this action? ',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: `Yes, I am sure!`,
                            icon: 'warning',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?= base_url(); ?>EN/Schools/SetStudentInHouse',
                                    data: {
                                        S_Id: theId,
                                        Action: 'Quarantine',
                                    },
                                    success: function (data) {
                                        $('#return_stud_action').html(data);
                                    },
                                    ajaxError: function () {
                                        Swal.fire(
                                            'error',
                                            'oops!! we have a error',
                                            'error'
                                        )
                                    }
                                });
                            }
                        })
                    });
                });

                function initRightSidebar() {
                    // right side-bar toggle
                    $("body").toggleClass("right-bar-enabled");
                    ConnectedWithClass(<?= $class; ?>);
                }
            </script>
            <?php
        }
    }

    private function boxes_colors($result)
    {
        ?>
        <style>
            .Td-Results_font {
                font-size: 20px !important;
            }
        </style>
        <td class="Td-Results_font">
            <?php if ($result >= 38.500 && $result <= 45.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #ff2e00;"><?= $result; ?></span>
                <!-- Hight -->
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #cdfc00;"><?= $result; ?></span>
                <!-- Low -->
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #00ab00;"><?= $result; ?></span>
                <!-- No Risk -->
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color : #ff8200;"><?= $result; ?></span>
                <!-- Moderate -->
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge" style="width: 100%;border-radius: 10px;color: #272727;"><?= $result; ?></span>
                <!-- Error -->
            <?php } ?>
        </td>
        <td class="Td-Results">
            <?php if ($result >= 38.500 && $result <= 45.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff2e00;color: #fff;">High</span>
            <?php } elseif ($result >= 37.501 && $result <= 38.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #ff8200;color: #fff;">Moderate</span>
            <?php } elseif ($result >= 36.201 && $result <= 37.500) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #00ab00;color: #fff;">No Risk</span>
            <?php } elseif ($result <= 36.200) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #cdfc00;color: #fff;">Low</span>
            <?php } elseif ($result >= 45.501) { ?>
                <span class="badge font-size-12"
                      style="width: 100%;border-radius: 10px;background: #272727;color: #fff;">Error</span>
            <?php } ?>
        </td>
        <?php
    }

    //Class

    public function ListConnectedTeachers()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $class = $this->input->post("class") ?? "";
        $sessiondata = $this->session->userdata('admin_details');
        if ($method == "POST" && $this->input->post("class") !== "") {
            $teacher = $this->db->query("SELECT * , l2_teacher.Id AS Id  FROM  `l2_teacher`  
            JOIN `l2_teachers_classes` ON `l2_teachers_classes`.`class_id` = '" . $class . "'
            AND `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id`
            WHERE  `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            $isHimTeavher = array();
            foreach ($teacher as $teach) {
                $avatar_teach = $this->db->query("SELECT * FROM `l2_avatars` WHERE `For_User` = '" . $teach['Id'] . "' AND `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array(); ?>
                <div class="col-xl-12 col-sm-12">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="clearfix"></div>
                            <div class="mb-4">
                                <?php if (empty($avatar_teach)) { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg"
                                         class="avatar-lg rounded-circle img-thumbnail hoverZoomLink" alt="...">
                                <?php } else { ?>
                                    <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar_teach[0]['Link']; ?>"
                                         class="aavatar-lg rounded-circle img-thumbnail hoverZoomLink" alt="...">
                                <?php } ?>
                            </div>
                            <h5 class="font-size-16 mb-1">
                                <a href="#" class="text-dark">
                                    <?= $teach['F_name_EN'] . " " . $teach['L_name_EN']; ?>
                                </a>
                            </h5>
                            <p class="text-muted mb-2"><?= $this->schoolHelper->getTeacherPosition($teach['Position']) ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

    public function ListofStudentsForThisClass()
    {
        if ($this->input->post('NumberOfClass') !== "") {
            $class = $this->input->post('NumberOfClass');
            $sessiondata = $this->session->userdata('admin_details');
            $data["today"] = date("Y-m-d");
            $listofaStaffs = $this->db->query("SELECT `l2_student`.* , 
            (SELECT COUNT(Id) FROM absence_records WHERE day = '" . $data["today"] . "' AND absence_records.usertype = 'student' AND absence_records.userid = l2_student.Id LIMIT 1) AS AbsenceRecord
            FROM l2_student WHERE  `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $class . "' ")->result_array();
            $attendance_permissions = $this->db->query(" SELECT `v0_permissions`.`attendance` , `v0_permissions`.`Created`
            FROM `l1_school` 
            JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
            JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
            AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
            AND  `v0_permissions`.`attendance` = '1'
            WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
            ?>
            <div class="d-flex justify-content-between mb-4">
                <a href="<?= base_url(); ?>EN/Schools/infos_Card/Class/<?= $class; ?>" style="float: right;">
                    Show All List of Students (Class <?= $class ?>)
                    <i class="uil-arrow-up-right"></i>
                </a>
                <a target="_blank" href="<?= base_url(); ?>export/class/<?= $class; ?>" style="float: right;">
                    Export (Class <?= $class ?>)
                    <i class="uil-export"></i>
                </a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th> #</th>
                    <th> Img</th>
                    <th> Name</th>
                    <th> Grade</th>
                    <th> National ID</th>
                    <th> Phone Number</th>
                    <th> Nationality</th>
                    <th> Status</th>
                    <th> Edit</th>
                </tr>
                </thead>
                <tbody id="">
                <?php
                $sN = 0;
                foreach ($listofaStaffs as $admin) {
                    $sN++;
                    ?>
                    <tr id="User_<?= $admin['Id']; ?>">
                        <th scope="row"><?= $sN; ?></th>
                        <?php $avatars = $this->db->query("SELECT * FROM `l2_avatars` 
                            WHERE `For_User` = '" . $admin["Id"] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                        if (!empty($avatars)) {
                            foreach ($avatars as $avatar) {
                                ?>
                                <td><img class="rounded-circle img-thumbnail avatar-sm"
                                         src="<?= base_url() . "uploads/avatars/" . $avatar['Link']; ?>"
                                         alt="Not Found"></td>
                            <?php }
                        } else { ?>
                            <td><img class="rounded-circle img-thumbnail avatar-sm"
                                     src="<?= base_url() . "uploads/avatars/default_avatar.jpg"; ?>" alt="Not Found">
                            </td>
                        <?php } ?>
                        <td>
                            <h6 class="font-size-15 mb-1 font-weight-normal"><?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?></h6>
                            <p><?= $admin['Action']; ?></p>
                        </td>
                        <td><?= $admin['Grades']; ?></td>
                        <td><?= $admin['National_Id']; ?></td>
                        <td><?= $admin['Phone']; ?></td>
                        <td><?= $admin['Nationality']; ?></td>
                        <td>
                            <input type="checkbox" class="user-status" id="user-<?= $sN ?>"
                                   data-key="<?= $admin["Id"] ?>"
                                   switch="success" <?= $admin['status'] == 1 ? "checked" : "" ?> >
                            <label for="user-<?= $sN ?>" data-on-label=""
                                   data-off-label=""></label>
                        </td>
                        <td>
                            <a href="<?= base_url() ?>EN/schools/UpdateStudent/<?= $admin['Id']; ?>">
                                <i class="uil-pen" style="font-size: 25px;" title="Edit"></i></a>
                            <a href="<?= base_url() ?>EN/schools/infos_Card/Student/<?= $admin['Id']; ?>">
                                <i class="uil-credit-card" style="font-size: 25px;" title="QR Student Card"></i></a>
                            <i class="uil-trash" style="font-size: 25px;" title="Delete"
                               onClick="DeleteUser(<?= $admin['Id'] ?>,'<?= $admin['F_name_EN'] . ' ' . $admin['L_name_EN']; ?>','<?= $admin['National_Id'] ?>')"
                               data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
                            <a href="<?= base_url() ?>EN/schools/health-record/<?= $admin['Id']; ?>"
                               style="font-size: 25px;" title="Student Health Record"><i
                                        class="uil uil-file text-warning"></i></a>
                            <a title="Export..." target="_blank"
                               href="<?= base_url(); ?>export/student/<?= $admin['Id']; ?>">
                                <i class="uil-export" style="font-size: 22px;"></i>
                            </a>
                            <a title="Tasks Report" target="_blank"
                               href="<?= base_url('EN/schools/task-report/' . $admin['Id']); ?>">
                                <i class="uil-file-check-alt" style="font-size: 22px;"></i>
                            </a>
                            <?php if ($attendance_permissions) { ?>
                                <?php /*?> <button data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="<?= $admin["AbsenceRecord"] > 0 ? "Mark as Present" : "Mark as Absent" ?>"
                                        data-id="<?= $admin['Id'] ?>"
                                        class="btn btn-<?= $admin["AbsenceRecord"] > 0 ? "success" : "danger" ?> btn-rounded waves-effect waves-light p-0 change-attendance-status">
                                    <i class="uil uil-times"></i>
                                </button><?php */ ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php $this->load->view("EN/schools/inc/list-status-change-script", ['type' => 'students']) ?>
            <script>
                var table = $("table").DataTable();

                function DeleteUser(id, name, national_id) {
                    Swal.fire({
                        title: " Are you sure you want to delete " + name + "?",
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: `yes`,
                        cancelButtonText: `cancel`,
                        icon: 'warning',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url(); ?>EN/Schools/DeleteUser',
                                data: {
                                    userid: id,
                                    userType: 'Student',
                                    national_id: national_id,
                                },
                                success: function (data) {
                                    Swal.fire(
                                        'Success',
                                        data,
                                        'Success'
                                    );
                                    $('#User_' + id).fadeOut();
                                },
                                ajaxError: function () {
                                    Swal.fire(
                                        'error',
                                        'oops!! we have a error',
                                        'error'
                                    )
                                }
                            });
                        }
                    });
                }

                $(".table").on("click", ".change-attendance-status", function () {
                    const $this = $(this);
                    console.log($this);
                    $($this).attr("disabled", "");
                    const key = $(this).attr("data-id");
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url("EN/Ajax/absence-control")  ?>",
                        data: {
                            userid: key,
                            usertype: "student"
                        },
                        success: function (response) {
                            $($this).removeAttr("disabled");
                            if (response.status == "ok") {
                                $($this).removeClass("btn-danger btn-success");
                                $($this).addClass(response.to == "absent" ? "btn-success" : "btn-danger");
                                $($this).attr("data-original-title", response.to == "absent" ? "Mark as Present" : "Mark as Absent");
                            } else {
                                Swal.fire(
                                    'error',
                                    response.message,
                                    'error'
                                )
                            }
                        }
                    });
                });
                table.on('draw', function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
            <?php
        }
    }

    public function SetStudentInHouse()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $thisStudentData = $this->db->query(" SELECT * FROM `l2_student` WHERE `Id` = '" . $Id . "' LIMIT 1 ")->result_array();
        $Email = $thisStudentData[0]['Email'];
        $Name = $thisStudentData[0]['F_name_EN'] . " " . $thisStudentData[0]['L_name_EN'];
        if ($this->db->query("UPDATE `l2_result` SET `Action` = '" . $Action . "' WHERE `UserType` = 'Student'  AND UserId = '" . $Id . "' ")) {
            $this->db->query("UPDATE `l2_student` SET `Action` = '" . $Action . "' WHERE `Id` = '" . $Id . "' ");
            ?>
            <script>
                Swal.fire({
                    title: ' You need to refresh the page now. ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Yes, refresh now!`,
                    cancelButtonText: `No, I will do that later. `,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                Swal.fire({
                    title: ' Sorry. We have an error now !! ',
                    showDenyButton: true,
                    confirmButtonText: `Ok`,
                    icon: 'warning',
                });
            </script>
            <?php
        }
    }

    public function infos_Card()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Card ";
        $Type = $this->uri->segment(4);
        if ($this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(4) !== "Class") {
            $u_Id = $this->uri->segment(5);
            $data['Student_Id'] = $u_Id;
            $data['page_title'] = "Qlick Health | Card ";
            $data['sessiondata'] = $sessiondata;
            if ($Type == "Student") {
                $user_data = $this->db->query("SELECT * FROM l2_student WHERE Id  = '" . $u_Id . "' AND
                `Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
            } elseif ($Type == "Staff") {
                $user_data = $this->db->query("SELECT * FROM l2_staff WHERE Id  = '" . $u_Id . "' AND
                `Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
            } elseif ($Type == "Teacher") {
                $user_data = $this->db->query("SELECT * FROM l2_teacher WHERE Id  = '" . $u_Id . "' AND
                `Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
            } elseif ($Type == "Site") {
                $user_data = $this->db->query("SELECT * FROM l2_site WHERE Id  = '" . $u_Id . "' AND
                `Added_By` = '" . $sessiondata['admin_id'] . "' LIMIT 1")->result_array();
            }
        } elseif ($this->uri->segment(4) && !$this->uri->segment(5)) {
            $Type = $this->uri->segment(4);
            $data['Student_Id'] = "";
            $data['page_title'] = "Qlick Health | Card ";
            $data['sessiondata'] = $sessiondata;
            if ($Type == "AllTeachers") {
                $user_data = $this->db->query("SELECT * FROM l2_teacher 
                WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            } elseif ($Type == "AllStaffs") {
                $user_data = $this->db->query("SELECT * FROM l2_staff 
                WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            } elseif ($Type == "SitesList") {
                $user_data = $this->db->query("SELECT * FROM l2_site WHERE
                `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
            }
        } elseif ($Type == "Class") {
            $data['page_title'] = "Qlick Health | Card ";
            $u_Id = $this->uri->segment(5);
            $data['Student_Id'] = $u_Id;
            $user_data = $this->db->query("SELECT * FROM l2_student WHERE
            `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Class` = '" . $u_Id . "' ")->result_array();
        } elseif ($Type == "SitesList") {
            $user_data = $this->db->query("SELECT * FROM l2_site WHERE
            `Added_By` = '" . $sessiondata['admin_id'] . "' AND `Id` = '" . $u_Id . "' ")->result_array();
        }
        if (!empty($user_data)) {
            $this->infos_Card_load($user_data, $Type);
        } else {
            echo "<h3>Sorry. We Have a Error.....</h3>";
            ?>
            <script>
                setTimeout(function () {
                    location.href = "<?= base_url(); ?>EN/schools"
                }, 1000);
            </script>
            <?php
        }
        // Call views method
    }

    private function infos_Card_load($user_data, $user_type)
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($user_type == "Class" || $user_type == "AllTeachers" || $user_type == "AllStaffs") {
            $data['page_title'] = "Qlick Health | Card ";
            $data['user_data'] = $user_data;
            $data['hasntnav'] = true;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/schools/Class_Card', $data);
        } elseif ($user_type == "SitesList") {
            $data['page_title'] = "Qlick Health | Sites ";
            $data['user_data'] = $user_data;
            $data['hasntnav'] = true;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/schools/sites_card', $data);
        } elseif ($user_type == "Site") {
            $data['page_title'] = "Qlick Health | Site ";
            $data['user_data'] = $user_data;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/schools/site_card', $data);
        } else {
            $data['page_title'] = "Qlick Health | Card ";
            $data['user_data'] = $user_data;
            $this->load->view('EN/inc/header', $data);
            $this->load->view('EN/schools/infos_Card');
        }
        $this->load->view('EN/inc/footer');
    }

    public function SetStudentInHouse_LabTests()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $thisStudentData = $this->db->query(" SELECT * FROM `l2_student` WHERE `Id` = '" . $Id . "' LIMIT 1 ")->result_array();
        $Email = $thisStudentData[0]['Email'];
        $Name = $thisStudentData[0]['F_name_EN'] . " " . $thisStudentData[0]['L_name_EN'];
        $now = date('Y-m-d H:i:s'); //2021-01-09 20:07:38
        $response = ["status" => "success", "message" => ""];
        $user = $this->db->where("Id", $Id)->limit(1)->get("l2_student")->row();
        if (!isset($user->Id)) {
            $response = [
                "status" => "error",
                "message" => "we have an error please try again later"
            ];
        }
        if ($this->db->query("UPDATE `l2_labtests` SET `Action` = '" . $Action . "' WHERE `UserType` = 'Student'  AND UserId = '" . $Id . "' ")) {
            $this->db->query("UPDATE `l2_student` SET `Action` = '" . $Action . "' , `last_change_status_date` = '" . $now . "' WHERE `Id` = '" . $Id . "'");
            $Action = strtolower($Action) == "home" ? "home quarantine" : strtolower($Action);
            $response = [
                "status" => "success",
                "message" => $user->F_name_EN . " " . $user->L_name_EN . " is now in $Action."
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "we have an error please try again later"
            ];
        }
        ?>
        <script>
            Swal.fire({
                icon: "<?= $response['status'] ?>",
                title: "<?= ucfirst($response['status']) ?>!",
                text: "<?= $response['message'] ?>",
                showDenyButton: true,
                confirmButtonText: `Ok`,
            });
        </script>
        <?php
    }

    public function ApplyActionOnMember()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $UserType = $this->input->post("UserType");
        $response = ["status" => "success", "message" => ""];
        $table = [
            'staff' => "l2_staff",
            'teacher' => "l2_teacher",
            'student' => "l2_student",
        ];
        if (!isset($tabla[strtolower($UserType)])) {
            $response = [
                "status" => "error",
                "message" => "we have an error please try again later"
            ];
        }
        $user = $this->db->where("Id", $Id)->limit(1)->get($table[strtolower($UserType)])->row();
        if (!isset($user->Id)) {
            $response = [
                "status" => "error",
                "message" => "we have an error please try again later"
            ];
        }
        if ($this->db->query("UPDATE `l2_result` SET `Action` = '" . $Action . "' WHERE `UserType` = '" . $UserType . "'  AND UserId = '" . $Id . "' ")) {
            if ($UserType == 'Staff') {
                $this->db->query("UPDATE `l2_staff` SET `Action` = '" . $Action . "' WHERE `Id` = '" . $Id . "'");
            } elseif ($UserType == 'Teacher') {
                $this->db->query("UPDATE `l2_teacher` SET `Action` = '" . $Action . "' WHERE Id = '" . $Id . "' ");
            } elseif ($UserType == "Student") {
                $this->db->query("UPDATE `l2_student` SET `Action` = '" . $Action . "' WHERE Id = '" . $Id . "' ");
            }
            $Action = strtolower($Action) == "home" ? "home quarantine" : strtolower($Action);
            $response = [
                "status" => "success",
                "message" => $user->F_name_EN . " " . $user->L_name_EN . " is now in $Action."
            ];
            ?>
            <script>
                Swal.fire({
                    icon: "<?= $response['status'] ?>",
                    title: "<?= ucfirst($response['status']) ?>!",
                    text: "<?= $response['message'] ?>",
                    showDenyButton: true,
                    confirmButtonText: `Ok`,
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                Swal.fire({
                    title: ' Sorry, We have an error right now !! ',
                    showDenyButton: true,
                    confirmButtonText: `Ok`,
                    icon: 'error',
                })
            </script>
            <?php
        }
    }

    public function ApplyLabActionOnMember_lab()
    {
        $Id = $this->input->post("S_Id");
        $Action = $this->input->post("Action");
        $UserType = $this->input->post("UserType");
        $now = date('Y-m-d H:i:s'); //2021-01-09 20:07:38
        if ($this->db->query("UPDATE `l2_labtests` SET `Action` = '" . $Action . "' WHERE `UserType` = '" . $UserType . "'  AND UserId = '" . $Id . "' ")) {
            if ($UserType == 'Teacher') {
                $this->db->query("UPDATE `l2_teacher` SET `Action` = '" . $Action . "' , `last_change_status_date` = '" . $now . "' WHERE `Id` = '" . $Id . "'  ");
            } else {
                $this->db->query("UPDATE `l2_staff` SET `Action` = '" . $Action . "' , `last_change_status_date` = '" . $now . "' WHERE `Id` = '" . $Id . "' ");
            }
            ?>
            <script>
                Swal.fire({
                    title: ' You need to refresh the page now.  ',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Yes, refresh now!`,
                    cancelButtonText: `No, I will do that later.`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                Swal.fire({
                    title: ' Sorry, We have an error right now !! ',
                    showDenyButton: true,
                    confirmButtonText: `Ok`,
                    icon: 'error',
                })
            </script>
            <?php
        }
    }

    public function ListofBatches()
    {
        $id = $this->input->post('Deviceid');
        $batches = $this->db->query("SELECT * FROM `l2_batches` WHERE For_Device = '" . $id . "' ")->result_array();
        if (empty($batches)) { ?>
            <style>
                .avatar-xs {
                    position: relative;
                    left: 37%;
                    height: 110px;
                    width: 110px;
                }
            </style>
            <style>
                /* The switch - the box around the slider */
                .switch {
                    position: relative;
                    display: inline-block;
                    width: 60px;
                    height: 34px;
                }

                /* Hide default HTML checkbox */
                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }

                /* The slider */
                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 26px;
                    width: 26px;
                    left: 4px;
                    bottom: 4px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                input:checked + .slider {
                    background-color: #2196F3;
                }

                input:focus + .slider {
                    box-shadow: 0 0 1px #2196F3;
                }

                input:checked + .slider:before {
                    -webkit-transform: translateX(26px);
                    -ms-transform: translateX(26px);
                    transform: translateX(26px);
                }

                /* Rounded sliders */
                .slider.round {
                    border-radius: 34px;
                }

                .slider.round:before {
                    border-radius: 50%;
                }
            </style>
            <div class="mr-3">
                <div class="avatar-xs">
                    <div class="avatar-title rounded-circle" style="font-size: 38px;">
                        <i class="uil uil-shield-check"></i>
                    </div>
                </div>
                <h6 style="text-align: center;margin-top: 10px;">No Data Found Here !!</h6>
            </div>
        <?php } else { ?>
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th> Batch</th>
                    <th> Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($batches as $batch) :
                    $isuesd = $this->db->query("SELECT * FROM `l2_labtests` WHERE `Device_Batch` = '" . $batch['Batch_Id'] . "' ORDER BY `Id` DESC ")->num_rows();
                    ?>
                    <tr id="BatchesList<?= $batch['Id']; ?>">
                        <th scope="row"><?= $batch['Id']; ?></th>
                        <td style="text-align: center;"><?= $batch['Batch_Id']; ?></td>
                        <?php
                        if ($batch['Status'] == 0) {
                            $cheked = 'checked';
                        } else {
                            $cheked = '';
                        }
                        ?>
                        <?php if ($isuesd == 0) { ?>
                            <td style="text-align: center;"><label class="switch">
                                    <input type="checkbox" theAdminId="<?= $batch['Id']; ?>"
                                           id="status" <?= $cheked; ?>>
                                    <span class="slider round"></span></label>
                                <i class="bx bxs-trash-alt delet_batch" style="position: relative;top: -14px;"
                                   batch_id="<?= $batch['Id']; ?>"></i>
                            </td>
                        <?php } else { ?>
                            <td style="text-align: center;"><label class="switch">
                                    <input type="checkbox" theAdminId="<?= $batch['Id']; ?>"
                                           id="status" <?= $cheked; ?>>
                                    <span class="slider round"></span></label>
                                <i class="bx bxs-trash-alt delet_desabled" style="position: relative;top: -14px;"></i>
                            </td>
                        <?php } ?>
                    </tr>
                <?php endforeach;
                ?>
                </tbody>
            </table>
            <script>
                $('input[type="checkbox"]').each(function () {
                    $(this).change(function () {
                        var theAdminId = $(this).attr('theAdminId');
                        console.log(theAdminId);
                        console.log(this.checked);
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>EN/Schools/changeBatchstatus',
                            data: {
                                batchId: theAdminId,
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! we have a error',
                                    'error'
                                )
                            }
                        });
                    });
                });
                $('.delet_batch').each(function () {
                    $(this).click(function () {
                        var theAdminId = $(this).attr('batch_id');
                        console.log(theAdminId);
                        console.log(this.checked);
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url(); ?>EN/Schools/DeletBatch',
                            data: {
                                batchId: theAdminId,
                            },
                            success: function () {
                                $('#BatchesList' + theAdminId).remove();
                            },
                            ajaxError: function () {
                                Swal.fire(
                                    'error',
                                    'oops!! we have a error',
                                    'error'
                                )
                            }
                        });
                    });
                });
            </script>
            <?php
        }
    }

    public function changeBatchstatus()
    {
        $batch_id = $this->input->post("batchId");
        echo $batch_id;
        $batchstataus = $this->db->query(" SELECT `Status` FROM `l2_batches` WHERE `Id` = '" . $batch_id . "' LIMIT 1 ")->result_array();
        $batchStatusnow = $batchstataus[0]['Status'];
        if ($batchStatusnow == 0) {
            $this->db->query("UPDATE `l2_batches` SET `Status` = '1' WHERE `Id` = '" . $batch_id . "' ");
        } else {
            $this->db->query("UPDATE `l2_batches` SET `Status` = '0' WHERE `Id` = '" . $batch_id . "' ");
        }
    }

    public function DeletBatch()
    {
        $batch_id = $this->input->post("batchId");
        if ($this->db->query(" DELETE FROM `l2_batches` WHERE `Id` = '" . $batch_id . "' ")) { ?>
            <script>
                $('#BatchesList<?= $batch_id; ?>').remove();
            </script>
            <?php
        }
    }

    public function ChangeMemberAvatar()
    {
        if ($this->uri->segment(4) && $this->uri->segment(5) && $this->uri->segment(6)) {
            $userType = $this->uri->segment(4);
            $UserId = $this->uri->segment(5);
            $NationalId = $this->uri->segment(6);
            if ($userType == "Staff" || $userType == "Teacher" && is_numeric($UserId)) {
                $sessiondata = $this->session->userdata('admin_details');
                $data['page_title'] = "Qlick Health | Tests";
                $data['sessiondata'] = $sessiondata;
                $data['user_type'] = $userType;
                $data['user_id'] = $UserId;
                $data['NationalId'] = $NationalId;
                $this->show('EN/schools/ChangePhotoForMember', $data);
            } else if ($userType == "Student" && is_numeric($UserId)) {
                if ($this->uri->segment(5)) {
                    $Body['Comm_From_List'] = $this->uri->segment(5);
                }
                $sessiondata = $this->session->userdata('admin_details');
                $data['page_title'] = "Qlick Health | Tests";
                $data['sessiondata'] = $sessiondata;
                $data['user_type'] = $userType;
                $data['StudentId'] = $UserId;
                $data['NationalId'] = $NationalId;
                $this->show('EN/schools/ChangePhotoForMember', $data);
            } else {
                $this->load->view('EN/Global/404_error');
            }
        }
    }

    public function SchowStudentsFromClass()
    {
        if ($this->uri->segment(4)) {
            $data['class'] = $this->uri->segment(4);
        } else {
            redirect('Schools/Tests');
        }
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Tests";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/ListofStudentsInClass', $data);
    }

    public function Class_Avatars()
    {
        if ($this->uri->segment(4)) {
            $data['class'] = $this->uri->segment(4);
        } else {
            redirect('EN/Schools/Class_Avatars');
        }
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Students Avatrs";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/Students_Avatars', $data);
    }

    public function All_Tests_Today()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        if ($this->permissions_array['temperatureandlabs']) {
            $this->show('EN/schools/All_Tests_Today', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function RP()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/RP', $data);
    }

    public function Attendance_Report()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Attendance Report ";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/Attendance_Report', $data);
    }

    public function GetTheUserData()
    {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        if ($type == "Staff") {
            $this->GetStaffProfile($id);
        } elseif ($type == "Student") {
            $this->GetStudentProfile($id);
        } elseif ($type == "Teacher") {
            $this->GetTeacherProfile($id);
        }
    }

    private function GetStaffProfile($id)
    {
        $data = $this->db->query("SELECT * FROM `l2_staff` WHERE `Id` = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($data as $Profile) {
            $fullname = $Profile['F_name_EN'] . ' ' . $Profile['M_name_EN'] . ' ' . $Profile['L_name_EN'];
            ?>
            <style>
                .card {
                    border: 0px;
                    box-shadow: 0 0 black;
                }
            </style>
            <div class="card h-100">
                <div>
                    <div class="text-center">
                        <?php
                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`  WHERE `For_User` = '" . $id . "' AND
	    `Type_Of_User` = 'Staff' LIMIT 1 ")->result_array();
                        ?>
                        <div>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" alt=""
                                     class="avatar-lg rounded-circle img-thumbnail">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     alt="<?= $fullname; ?>" class="avatar-lg rounded-circle img-thumbnail">
                            <?php } ?>
                        </div>
                        <h5 class="mt-3 mb-1"><?= $Profile['UserName']; ?></h5>
                        <p class="text-muted"><?= $Profile['Position'] ?></p>
                    </div>
                    <hr class="my-4">
                    <div class="text-muted">
                        <div class="table-responsive mt-4" style="overflow: hidden;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <p class="mb-1">Name :</p>
                                        <h5 class="font-size-16"><?= $fullname; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">Mobile :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Phone'] ?>"><?= $Profile['Phone']; ?></a>
                                        </h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">E-mail :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Email'] ?>"><?= $Profile['Email']; ?></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4">
                                        <p class="mb-1">Nationality :</p>
                                        <h5 class="font-size-16"><?= $Profile['Nationality'] ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">DOP &amp; Age :</p>
                                        <?php
                                        $age = explode('-', $Profile['DOP']);
                                        $thisyear = date('Y');
                                        $finalyage = $thisyear - $age[2];
                                        ?>
                                        <h5 class="font-size-16"><?= $Profile['DOP'] . ' (' . $finalyage . 'y)'; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1"> Gender :</p>
                                        <?php if ($Profile['Gender'] == '1') { ?>
                                            <h5 class="font-size-16"><?= "Male"; ?></h5>
                                        <?php } else { ?>
                                            <h5 class="font-size-16"><?= "Female"; ?></h5>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function GetStudentProfile($id)
    {
        $data = $this->db->query("SELECT * , `r_levels`.`Class` AS StudentClass FROM `l2_student`
        JOIN `r_levels` ON `r_levels`.`Id` ON `l2_student`.`Class`
        WHERE `Id` = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($data as $Profile) {
            $fullname = $Profile['F_name_EN'] . ' ' . $Profile['M_name_EN'] . ' ' . $Profile['L_name_EN'];
            ?>
            <style>
                .card {
                    border: 0px;
                    box-shadow: 0 0 black;
                }
            </style>
            <div class="card h-100">
                <div>
                    <div class="text-center">
                        <?php
                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`  WHERE `For_User` = '" . $id . "' AND
                        `Type_Of_User` = 'Student' LIMIT 1 ")->result_array();
                        ?>
                        <div>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" alt=""
                                     class="avatar-lg rounded-circle img-thumbnail">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     alt="<?= $fullname; ?>" class="avatar-lg rounded-circle img-thumbnail">
                            <?php } ?>
                        </div>
                        <h5 class="mt-3 mb-1"><?= $Profile['UserName']; ?></h5>
                        <p class="text-muted"><?php echo ', ' . $Profile['Grades']; ?></p>
                    </div>
                    <hr class="my-4">
                    <div class="text-muted">
                        <div class="table-responsive mt-4" style="overflow: hidden;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <p class="mb-1">Name :</p>
                                        <h5 class="font-size-16"><?= $fullname; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">Mobile :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Phone'] ?>"><?= $Profile['Phone']; ?></a>
                                        </h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">E-mail :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Email'] ?>"><?= $Profile['Email']; ?></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4">
                                        <p class="mb-1">Nationality :</p>
                                        <h5 class="font-size-16"><?= $Profile['Nationality'] ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">DOP &amp; Age :</p>
                                        <?php
                                        $age = explode('-', $Profile['DOP']);
                                        $thisyear = date('Y');
                                        $finalyage = $thisyear - $age[2];
                                        ?>
                                        <h5 class="font-size-16"><?= $Profile['DOP'] . ' (' . $finalyage . 'y)'; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1"> Gender :</p>
                                        <?php if ($Profile['Gender'] == '1') { ?>
                                            <h5 class="font-size-16"><?= "Male"; ?></h5>
                                        <?php } else { ?>
                                            <h5 class="font-size-16"><?= "Female"; ?></h5>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mt-4">
                                        <p class="mb-1">Parent Id :</p>
                                        <h5 class="font-size-16"><?= $Profile['Parent_NID'] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function GetTeacherProfile($id)
    {
        $data = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Id` = '" . $id . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
        foreach ($data as $Profile) {
            $fullname = $Profile['F_name_EN'] . ' ' . $Profile['M_name_EN'] . ' ' . $Profile['L_name_EN'];
            ?>
            <style>
                .card {
                    border: 0px;
                    box-shadow: 0 0 black;
                }
            </style>
            <div class="card h-100">
                <div>
                    <div class="text-center">
                        <?php
                        $avatar = $this->db->query("SELECT * FROM `l2_avatars`  WHERE `For_User` = '" . $id . "' AND
                        `Type_Of_User` = 'Teacher' LIMIT 1 ")->result_array();
                        ?>
                        <div>
                            <?php if (empty($avatar)) { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/default_avatar.jpg" alt=""
                                     class="avatar-lg rounded-circle img-thumbnail">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>uploads/avatars/<?= $avatar[0]['Link']; ?>"
                                     alt="<?= $fullname; ?>" class="avatar-lg rounded-circle img-thumbnail">
                            <?php } ?>
                        </div>
                        <h5 class="mt-3 mb-1"><?= $Profile['UserName']; ?></h5>
                        <p class="text-muted"><?= $this->schoolHelper->teacherClasses($id, true); ?></p>
                    </div>
                    <hr class="my-4">
                    <div class="text-muted">
                        <div class="table-responsive mt-4" style="overflow: hidden;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <p class="mb-1">Name :</p>
                                        <h5 class="font-size-16"><?= $fullname; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">Mobile :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Phone'] ?>"><?= $Profile['Phone']; ?></a>
                                        </h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">E-mail :</p>
                                        <h5 class="font-size-16"><a
                                                    href="tel:<?= $Profile['Email'] ?>"><?= $Profile['Email']; ?></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4">
                                        <p class="mb-1">Nationality :</p>
                                        <h5 class="font-size-16"><?= $Profile['Nationality'] ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1">DOP &amp; Age :</p>
                                        <?php
                                        $age = explode('-', $Profile['DOP']);
                                        $thisyear = date('Y');
                                        $finalyage = $thisyear - $age[2];
                                        ?>
                                        <h5 class="font-size-16"><?= $Profile['DOP'] . ' (' . $finalyage . 'y)'; ?></h5>
                                    </div>
                                    <div class="mt-4">
                                        <p class="mb-1"> Gender :</p>
                                        <?php if ($Profile['Gender'] == '1') { ?>
                                            <h5 class="font-size-16"><?= "Male"; ?></h5>
                                        <?php } else { ?>
                                            <h5 class="font-size-16"><?= "Female"; ?></h5>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mt-4">
                                        <p class="mb-1">Parent Id :</p>
                                        <h5 class="font-size-16"><?= $Profile['Position'] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function LoadFromCsv()
    {
        // Retrieve user session data
        $sessiondata = $this->session->userdata('admin_details');
        // Query to check user permissions for CSV upload
        $this->db->select('v1_permissions.Air_quality, v1_permissions.Created');
        $this->db->from('l1_school');
        $this->db->join('v1_permissions', 'v1_permissions.user_id = l1_school.Id');
        $this->db->where('l1_school.Id', $sessiondata['admin_id']);
        $this->db->where('v1_permissions.user_type', 'school');
        $this->db->where('v1_permissions.LoadFromCsv', '1');
        $prms = $this->db->get()->result_array();
        // Define an array for page data and add some basic information
        $data = array(
            'page_title' => "Qlick Health | Load From CSV",
            'sessiondata' => $sessiondata
        );
        // Check if user has permissions for CSV upload
        if (!empty($prms)) {
            if ($this->uri->segment(4)) {
                $userType = strtolower($this->uri->segment(4));
                if (in_array($userType, array('staff', 'teachers', 'students'))) {
                    $data["userType"] = $userType;
                    $this->show('EN/schools/loadFromCsv/FormPage', $data);
                } else {
                    $this->show('EN/schools/Load_From_CSV', $data);
                }
            } else {
                $this->show('EN/schools/Load_From_CSV', $data);
            }
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function exportDataFromCsv()
    {
        // Set max execution time to infinity and enable implicit flushing of output buffer
        set_time_limit(0);
        ob_implicit_flush(true);
        // Close the session to prevent locking issues
        session_write_close();
        // Open a log file to write progress updates
        $log = Logger::getLogger('exportData');
        $log->info('Export started');
        // Use a CSV library to parse the file and export the data
        $csv = Reader::createFromPath('/path/to/file.csv');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        foreach ($records as $record) {
            // Do some processing on the record and export it to the desired format
            // ...
            // Log progress updates to the file
            $log->info('Exported record ' . $record->getId());
            // Sleep for a short period to prevent the process from overwhelming the server
            usleep(50000); // 50 milliseconds
        }
        // Log a final message indicating that the export is complete
        $log->info('Export complete');
        // Output a message to the browser indicating that the export is complete
        echo 'Export complete';
    }

    public function addcsv()
    {
        $filename = './resorses/staffadd.csv';
        $sessiondata = $this->session->userdata('admin_details');
        // The nested array to hold all the arrays
        $the_big_array = [];
        // Open the file for reading
        if (($h = fopen("{$filename}", "r")) !== FALSE) {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                // Each individual array is being pushed into the nested array
                $the_big_array[] = $data;
            }
            // Close the file
            fclose($h);
        }
        echo "<pre>";
        //var_dump($);
        $s_ar = sizeof($the_big_array[0]);
        if ($s_ar == 14) {
            unset($the_big_array[0]);
        }
        foreach ($the_big_array as $array) {
            $ad_id = $sessiondata['admin_id'];
            $password = "12345678";
            $genration = $this->generatecode($sessiondata['admin_id'], $array[10]);
            $hash_pass = password_hash($password, PASSWORD_DEFAULT);
            // start add the data
            $this->db->query("INSERT INTO `l2_staff`(`Prefix`,
            `F_name_EN`, `F_name_AR`, `M_name_EN`, `M_name_AR`, `L_name_EN`, `L_name_AR`, 
            `DOP`, `Phone`, `Gender`, `Created`, `UserName`, `National_Id`, `Nationality`,
            `Password`,
            `Position`, `Email`, `Added_By`,`generation`)
            VALUES ('" . $array[0] . "',
            '" . $array[1] . "','" . $array[4] . "','" . $array[2] . "','" . $array[5] . "','" . $array[3] . "','" . $array[6] . "',
            '" . $array[7] . "','" . $array[8] . "','" . $array[9] . "','" . date('Y-m-d') . "','" . $array[10] . "','" . $array[10] . "','" . $array[11] . "','" . $hash_pass . "',
            '" . $array[12] . "','" . $array[13] . "','" . $ad_id . "','" . $genration . "') ");
        }
        echo "</pre>";
    }

    public function Quarantine_monitor()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Quarantine Monitor";
        $data['sessiondata'] = $sessiondata;
        $data['Action'] = "quarantine";
        $this->show('EN/schools/q_s_monitor', $data);
    }

    public function StayHome_monitor()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health |  Stay Home Monitor";
        $data['sessiondata'] = $sessiondata;
        $data['Action'] = "Home";
        $this->show('EN/schools/q_s_monitor', $data);
    }

    public function monitor()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Quarantine Monitor";
        $data['sessiondata'] = $sessiondata;
        $data['Action'] = "quarantine";
        $this->show('EN/schools/q_s_day_monitor', $data);
    }

    public function monthResults()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        if ($this->permissions_array['temperatureandlabs']) {
            $this->show('EN/schools/monthResults', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function attendance_result()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/Attendance_Report_in_out', $data);
    }

    public function attendance_result_for_all()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Month Results";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/Attendance_Report_in_out_for_all', $data);
    }

    public function DeleteUser()
    {
        if ($this->input->post("userid") && $this->input->post("userType") && $this->input->post("national_id")) {
            $user_id = $this->input->post("userid");
            $user_type = $this->input->post("userType");
            $National_id = $this->input->post("national_id");
            $this->db->where('Id', $user_id);
            if ($user_type == "Staff") {
                $this->db->delete('l2_staff');
            } elseif ($user_type == "Teacher") {
                $this->db->delete('l2_teacher');
            } elseif ($user_type == "Student") {
                $this->db->delete('l2_student');
            }
            $this->db->query("DELETE FROM `v_nationalids` WHERE `National_Id` = '" . $National_id . "' ");
            $this->db->query("DELETE FROM `v_login` WHERE `Username` = '" . $National_id . "' AND `Type` = '" . $user_type . "' ");
            echo " The user was deleted successfully.";
        } else {
            echo "maybe you need try later ): ";
        }
    }

    public function sites_reports()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Sites Results";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/sites_reports', $data);
    }

    public function Air_Quality_Dashboard()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Air Quality Dashboard ";
        $data['sessiondata'] = $sessiondata;
        $prms = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms)) {
            $permission = $prms[0];
        } else {
            $permission = "";
        }
        if (!empty($permission) && $permission['Air_quality'] == '1') {
            $this->show('EN/schools/air_quality', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function startAddArea()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('Site', 'Site', 'trim|required');
        $this->form_validation->set_rules('MAC', 'MAC Address', 'trim|required'); // valid_mac
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        if ($this->form_validation->run()) {
            $Site = $this->input->post("Site");
            $MAC = $this->input->post("MAC");
            $Description = $this->input->post("Description");
            $generatecode = $sessiondata['admin_id'] . $MAC . rand(1000, 9999);
            $this->db->select('*');
            $this->db->from('air_areas');
            $this->db->where('mac_adress', $MAC);
            $mac_counter = $this->db->get()->num_rows();
            if ($mac_counter <= 0) {
                $data = [
                    'source_id' => $sessiondata['admin_id'],
                    'mac_adress' => $MAC,
                    'user_type' => 'school',
                    'Site_Id' => $Site,
                    'Description' => $Description,
                    'generation' => $generatecode,
                    'Company_Type' => '5',
                ];
                if ($this->db->insert('air_areas', $data)) {
                    ?>
                    <script>
                        Swal.fire({
                            title: ' Added  ',
                            text: 'Added successfully',
                            icon: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 900);
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    Swal.fire({
                        title: ' Problem  ',
                        text: 'This MAC Address Already exist',
                        icon: 'warning'
                    });
                    $('#MAC').val('');
                </script>
                <?php
            }
        } else {
            echo validation_errors();
        }
    }

    public function Realtime_Dashboard()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | More Details ";
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4)) {
            $device_mac = $this->uri->segment(4);
            $data['device_mac'] = $device_mac;
            $this->show('EN/schools/Realtime_Dashboard', $data);
        } else {
            $this->load->view('custom404view');
        }
    }

    public function startAddMachine()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $this->form_validation->set_rules('name', 'mac adress', 'trim|required|is_unique[refrigerator_area.mac_adress]|valid_mac');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('Site', 'site', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post("name");
            $type = $this->input->post("type");
            $Site = $this->input->post("Site");
            $description = $this->input->post("description");
            $pid = $sessiondata['admin_id'];
            $generatecode = $this->generatecode($sessiondata['admin_id'], "");
            $data = [
                'mac_adress' => $name,
                'type' => $type,
                'source_id' => $pid,
                'generation' => $generatecode,
                'Site_Id' => $Site,
                'user_type' => 'school',
                'Description' => $description,
                'Company_Type' => 5,
            ];
            if ($this->db->insert("refrigerator_area", $data)) { ?>
                <script>
                    Swal.fire({
                        title: 'Added ',
                        text: 'The data was added successfully.',
                        icon: 'success'
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 900);
                </script>
                <?php
            }
        } else {
            echo validation_errors();
        }
    }

    public function MacheneRP()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Results List";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/schools/macheneRP', $data);
    }


    public function return_surveys_of_category()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $respons = array("status" => "error", "cat" => "", "data" => []);
        if ($this->input->post('cat_id') && is_numeric($this->input->post('cat_id'))) {
            $id = $this->input->post('cat_id');
            $data = $this->db->query(" SELECT
            `sv_st_surveys`.`Id` AS survey_id,
            `sv_st_surveys`.`status` AS status,
            `sv_st_category`.`Cat_en`,
            `sv_st_category`.`Cat_ar`,
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
            ON sv_school_published_surveys.`Serv_id` = `sv_st1_surveys`.`Id`
            JOIN `sv_school_published_surveys_types`  
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_types`.`Survey_id` 
            JOIN `sv_school_published_surveys_genders`
            ON `sv_school_published_surveys`.`Id` = `sv_school_published_surveys_genders`.`Survey_id`
            JOIN `sv_st_category` ON `sv_st_category`.`Id` = `sv_st_surveys`.`category`
            WHERE `sv_st1_surveys`.`Status` = '1' AND `sv_st_surveys`.`category` = `sv_st_category`.`Id`
            AND `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "' AND `sv_st_surveys`.`category` = '" . $id . "'
            GROUP BY `sv_school_published_surveys`.`Id` ")->result_array();
            if (!empty($data)) {
                $respons = array("status" => "ok", "cat" => $data[0]['Cat_en'], "data" => $data);
            } else {
                $respons = array("status" => "ok", "cat" => "no title", "data" => []);
            }
        }
        echo json_encode($respons);
    }

    public function Vehicles_list()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $cars_perm = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`cars` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`cars` = '1' ")->result_array();
        if (!empty($cars_perm)) {
            if ($this->input->method() == "get") {
                $data['page_title'] = "Qlick Health | Results List";
                $data['sessiondata'] = $sessiondata;
                $data['vehicles'] = $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
                LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
                WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $data['teachers'] = $this->db->query("SELECT * FROM `l2_teacher` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $this->show('EN/schools/List_Vehicle', $data);
            } elseif ($this->input->method() == "post") { // post requests
                if ($this->input->post('car') && $this->input->post('teacher')) {
                    // connect driver
                    $car_id = $this->input->post('car');
                    $teacher_id = $this->input->post('teacher');
                    $using_count = $this->db->get_where('l2_vehicle_drivers', array('car_id' => $car_id, "teacher_id" => $teacher_id, "Added_by" => $sessiondata['admin_id']))->num_rows();
                    if ($using_count == 0) {
                        $data = [
                            "car_id" => $car_id,
                            "teacher_id" => $teacher_id,
                            "Added_by" => $sessiondata['admin_id'],
                            "Company_Type" => 5,
                        ];
                        if ($this->db->insert('l2_vehicle_drivers', $data)) {
                            echo "ok";
                        }
                    } else {
                        echo "error";
                    }
                } elseif ($this->input->post('car_key')) {
                    header('Content-Type: application/json'); //set the data header to return json
                    //--------- start operations -----------//
                    $car_id = $this->input->post('car_key');
                    $av_teachers = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS teachername , `l2_teacher`.`Id`  
                    FROM  `l2_teacher`
                    WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
                    AND NOT EXISTS (SELECT Id FROM l2_vehicle_drivers WHERE `teacher_id` = `l2_teacher`.`Id` AND `car_id` = '" . $car_id . "' ) GROUP BY `l2_teacher`.`Id` ")->result_array();
                    echo json_encode($av_teachers);
                } elseif ($this->input->post('teachers_of_car')) { // return drivers list as json
                    header('Content-Type: application/json'); //set the data header to return json
                    //--------- start operations -----------//
                    $car_id = $this->input->post('teachers_of_car');
                    $av_drivers = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS teachername , `l2_teacher`.`Id`  , 
                    `l2_vehicle_drivers`.`Id` AS connect_id , l2_avatars.Link AS avatar  , l2_vehicle_drivers.TimeStamp AS since 
                    FROM  `l2_teacher`
                    JOIN  `l2_vehicle_drivers` ON `l2_vehicle_drivers`.`teacher_id` = `l2_teacher`.`Id` AND `l2_vehicle_drivers`.`car_id` = '" . $car_id . "'
                    LEFT JOIN l2_avatars ON `l2_avatars`.`For_User` = l2_teacher.Id AND Type_Of_User = 'Teacher'
                    WHERE `l2_teacher`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_vehicle_drivers`.`Added_By`
                    AND  EXISTS (SELECT Id FROM l2_vehicle_drivers WHERE `teacher_id` = `l2_teacher`.`Id` AND `car_id` = '" . $car_id . "' ) ")->result_array();
                    echo json_encode($av_drivers);
                }
            } elseif ($this->input->method() == "delete") {
                if ($this->input->input_stream('connect_id')) { // delete driver (Teacher )
                    $id = $this->input->input_stream('connect_id');
                    $this->db->where('Id', $id);
                    if ($this->db->delete('l2_vehicle_drivers')) {
                        echo 'ok';
                    } else {
                        echo $this->db->last_query();
                    }
                }
            } else {
                echo "not supported !!" . $this->input->method();
            }
        } else {
            $this->load->view('EN/Global/accessForbidden'); // when user dosn't have permission
        }
    }

    public function Attendance_for_vichal()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $cars_perm = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`cars` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`cars` = '1' ")->result_array();
        if (!empty($cars_perm)) {
            if ($this->input->method() == "get") {
                $data['page_title'] = "Qlick Health | Results List";
                $data['sessiondata'] = $sessiondata;
                $this->show('EN/schools/Attendance_for_vichal', $data);
            } elseif ($this->input->method() == "post") {
                if ($this->input->post('teacher_id')) {
                    header('Content-Type: application/json'); //set the data header to return json
                    $respons = $this->db->query(" SELECT C ")->result_array();
                    echo json_encode($respons);
                } else {
                    $data['sessiondata'] = $sessiondata;
                    $data['from'] = $this->input->post('start');
                    $data['to'] = $this->input->post('end');
                    $data['page_title'] = "Qlick Health | Results From " . $data['from'] . " To " . $data['to'];
                    $data['list'] = $this->db->query("SELECT `l2_vehicles_attendance_result`.* , `l2_vehicle`.`No_vehicle` , `l2_vehicle`.`Id` AS V_Id , `l2_vehicle`.`Action` ,
                    IFNULL(`F_DV`.`Description` , `l2_vehicles_attendance_result`.`Device_first`) AS Device_first ,
                    IFNULL(`L_DV`.`Description` , `l2_vehicles_attendance_result`.`Device_last`) AS Device_last
                    FROM `l2_vehicles_attendance_result` 
                    JOIN `l2_vehicle` ON `l2_vehicle`.`watch_mac` = `l2_vehicles_attendance_result`.`Device_first` OR `l2_vehicle`.`watch_mac` = `l2_vehicles_attendance_result`.`Device_first`
                    LEFT JOIN `l2_devices` F_DV ON `F_DV`.`D_Id` = `l2_vehicles_attendance_result`.`Device_first`
                    LEFT JOIN `l2_devices` L_DV ON `L_DV`.`D_Id` = `l2_vehicles_attendance_result`.`Device_last`
                    WHERE `l2_vehicles_attendance_result`.`Created`  BETWEEN '" . $data['from'] . "' AND '" . $data['to'] . "' 
                    AND `l2_vehicle`.`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                    $this->show('EN/schools/Attendance_for_vichal', $data);
                }
            }
        } else {
            $this->load->view('EN/Global/accessForbidden'); // when user dosn't have permission
        }
    }

    public function Vehicle_results()
    {
        // this function is the backend of Attendance_for_vichal's actions
        $status = "error";
        $results = array();
        if ($this->input->method() == "post" && $this->input->post('user_type') && $this->input->post("car_id") && $this->input->post("from_date") && $this->input->post("to_date")) {
            $user_id = $this->input->post("car_id");
            $start = $this->input->post('from_date');
            $end = $this->input->post('to_date');
            // start results
            if ($this->input->post('user_type') == "teacher") {
                $status = "ok";
                $results = $this->db->query("SELECT CONCAT( `l2_teacher`.`F_name_EN` , ' ' , `l2_teacher`.`L_name_EN` ) AS username , `l2_teacher`.`Id` ,
                IF((SELECT l2_monthly_result.Id FROM `l2_monthly_result` 
                JOIN `l2_devices` ON `l2_devices`.`D_Id` = `l2_monthly_result`.`Device` AND `l2_devices`.`Site` = 'Buss'
                WHERE `UserId` = `l2_teacher`.`Id` AND `l2_monthly_result`.`UserType` = 'Teacher' AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status , 
                `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result 
                FROM `l2_vehicle`
                JOIN `l2_vehicle_drivers` ON `l2_vehicle_drivers`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_teacher` ON `l2_teacher`.`Id` = `l2_vehicle_drivers`.`teacher_id`
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_teacher`.`Id` AND `l2_monthly_result`.`UserType` = 'Teacher'
                WHERE `l2_vehicle`.`Id` = '" . $user_id . "' ")->result_array();
            } elseif ($this->input->post('user_type') == "Student") {
                $status = "ok";
                $results = $this->db->query("SELECT CONCAT( `l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN` ) AS username ,
                IF((SELECT l2_monthly_result.Id FROM `l2_monthly_result` 
                JOIN `l2_devices` ON `l2_devices`.`D_Id` = `l2_monthly_result`.`Device` AND `l2_devices`.`Site` = 'Buss'
                WHERE `UserId` = `l2_student`.`Id` AND `l2_monthly_result`.`UserType` = 'Student' AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status ,
                `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result
                FROM `l2_vehicle`
                JOIN `l2_vehicle_students` ON `l2_vehicle_students`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_student` ON `l2_student`.`Id` = `l2_vehicle_students`.`student_id`
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_student`.`Id` AND `l2_monthly_result`.`UserType` = 'Student'
                WHERE `l2_vehicle`.`Id` = '" . $user_id . "' ")->result_array();
            } elseif ($this->input->post('user_type') == "staff") {
                $status = "ok";
                $results = $this->db->query("SELECT CONCAT( `l2_staff`.`F_name_EN` , ' ' , `l2_staff`.`L_name_EN`  ) AS username ,
                IF((SELECT l2_monthly_result.Id FROM `l2_monthly_result`
                JOIN `l2_devices` ON `l2_devices`.`D_Id` = `l2_monthly_result`.`Device` AND `l2_devices`.`Site` = 'Buss'
                WHERE `UserId` = `l2_staff`.`Id` AND `l2_monthly_result`.`UserType` = 'Staff' AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status ,
                `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result
                FROM `l2_vehicle`
                JOIN `l2_vehicle_helpers` ON `l2_vehicle_helpers`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_staff` ON `l2_staff`.`Id` = `l2_vehicle_helpers`.`staff_id`
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_staff`.`Id` AND `l2_monthly_result`.`UserType` = 'Staff'
                WHERE `l2_vehicle`.`Id` = '" . $user_id . "' ")->result_array();
            }
        }
        $this->response->json(['status' => $status, "results" => $results]);
    }

    public function Vehicles_students_control()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $cars_perm = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`cars` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`cars` = '1' ")->result_array();
        if (!empty($cars_perm)) {
            if ($this->input->method() == "post") {
                //--------- start operations -----------//
                if ($this->input->post('car_key')) {
                    header('Content-Type: application/json'); //set the data header to return json
                    $car_id = $this->input->post('car_key');
                    $av_teachers = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS student_id , `l2_student`.`Id`  
                    FROM  `l2_student`
                    WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
                    AND NOT EXISTS (SELECT Id FROM l2_vehicle_students WHERE `student_id` = `l2_student`.`Id` AND `car_id` = '" . $car_id . "' ) ")->result_array();
                    echo json_encode($av_teachers);
                } elseif ($this->input->post('student_key') && $this->input->post('car_id')) {
                    $car_id = $this->input->post('car_id');
                    $student_key = $this->input->post('student_key');
                    $data = [
                        "car_id" => $car_id,
                        "student_id" => $student_key,
                        "Added_by" => $sessiondata['admin_id']
                    ];
                    if ($this->db->insert('l2_vehicle_students', $data)) {
                        echo "ok";
                    }
                } elseif ($this->input->post('students_of_car')) {
                    header('Content-Type: application/json'); //set the data header to return json
                    $car_id = $this->input->post('students_of_car');
                    $av_drivers = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS teachername , `l2_student`.`Id`  , `l2_vehicle_students`.`Id` AS connect_id
                    FROM  `l2_student`
                    JOIN  `l2_vehicle_students` ON `l2_vehicle_students`.`student_id` = `l2_student`.`Id` AND `l2_vehicle_students`.`car_id` = '" . $car_id . "'
                    WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_vehicle_students`.`Added_By`
                    AND  EXISTS (SELECT Id FROM l2_vehicle_students WHERE `student_id` = `l2_student`.`Id` AND `car_id` = '" . $car_id . "' ) ")->result_array();
                    echo json_encode($av_drivers);
                }
            } elseif ($this->input->method() == "delete") {
                if ($this->input->input_stream('connect_id')) { // delete driver (Teacher )
                    $id = $this->input->input_stream('connect_id');
                    $this->db->where('Id', $id);
                    if ($this->db->delete('l2_vehicle_students')) {
                        echo 'ok';
                    }
                }
            }
        }
    }

    public function Vehicles_staff_control()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $cars_perm = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`cars` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`cars` = '1' ")->result_array();
        if (!empty($cars_perm)) {
            if ($this->input->method() == "post") {
                //--------- start operations -----------//
                if ($this->input->post('car_key')) {
                    $car_id = $this->input->post('car_key');
                    $av_staff = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS staff_name , `l2_staff`.`Id` , `r_positions_sch`.`Position` AS position 
                    FROM  `l2_staff`
                    JOIN `r_positions_sch` ON `r_positions_sch`.`Id` = `l2_staff`.`Position`
                    WHERE `l2_staff`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
                    AND NOT EXISTS (SELECT Id FROM l2_vehicle_helpers WHERE `staff_id` = `l2_staff`.`Id` AND `car_id` = '" . $car_id . "' ) ")->result_array();
                    $this->response->json($av_staff);
                } elseif ($this->input->post('staffs_of_car')) {
                    $car_id = $this->input->post('staffs_of_car');
                    $helpers_staff = $this->db->query("SELECT CONCAT( F_name_EN , ' ' , L_name_EN ) AS staff_name , `l2_staff`.`Id`  ,
                    `l2_vehicle_helpers`.`Id` AS connect_id , `r_positions_sch`.`Position` AS position  , l2_avatars.Link AS avatar  , l2_vehicle_helpers.TimeStamp AS since 
                    FROM  `l2_staff`
                    JOIN `r_positions_sch` ON `r_positions_sch`.`Id` = `l2_staff`.`Position`
                    LEFT JOIN l2_avatars ON `l2_avatars`.`For_User` = l2_staff.Id AND Type_Of_User = 'Staff'
                    JOIN  `l2_vehicle_helpers` ON `l2_vehicle_helpers`.`staff_id` = `l2_staff`.`Id` AND `l2_vehicle_helpers`.`car_id` = '" . $car_id . "'
                    WHERE `l2_vehicle_helpers`.`Added_By` = '" . $sessiondata['admin_id'] . "' 
                    AND EXISTS (SELECT Id FROM l2_vehicle_helpers WHERE `staff_id` = `l2_staff`.`Id` AND `car_id` = '" . $car_id . "' ) ")->result_array();
                    $this->response->json($helpers_staff);
                } elseif ($this->input->post('staff_key') && $this->input->post('car_id')) {
                    $car_id = $this->input->post('car_id');
                    $staff_key = $this->input->post('staff_key');
                    $data = [
                        "car_id" => $car_id,
                        "staff_id" => $staff_key,
                        "Added_by" => $sessiondata['admin_id'],
                        "Company_Type" => 5,
                    ];
                    if ($this->db->insert('l2_vehicle_helpers', $data)) {
                        echo "ok";
                    }
                }
            } elseif ($this->input->method() == "delete") {
                if ($this->input->input_stream('connect_id')) { // delete driver (Teacher )
                    $id = $this->input->input_stream('connect_id');
                    $this->db->where('Id', $id);
                    if ($this->db->delete('l2_vehicle_helpers')) {
                        echo 'ok';
                    }
                }
            }
        } else {
            $this->response->json(['status' => "error", 'message' => "sorry you don't have this permission"]);
        }
    }

    public function List_all()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $links = array();
        $links[] = array(
            "title" => "CH P005: School List",
            "links" => [
                array(
                    'name' => "Staff List", "link" => base_url('EN/schools/listOfStaff'), "desc" => "", "icon" => "Staff.png"
                ),
                array(
                    'name' => "Teachers List", "link" => base_url('EN/schools/listOfTeachers'), "desc" => "", "icon" => "Teachers.png"
                ),
                array(
                    'name' => "Students List", "link" => base_url('EN/schools/listOfStudents'), "desc" => "", "icon" => "Students.png"
                ),
            ]
        );
        $links[] = array(
            "title" => 'CH P006: School Sites, Devices, Avatars Lists',
            "links" => [
                array(
                    'name' => "Sites List", "link" => base_url('EN/schools/listOfSites'), "desc" => "", "icon" => "Sites.png"
                ),
                array(
                    'name' => "Devices List", "link" => base_url('EN/schools/ListofDevices'), "desc" => "", "icon" => "Devices.png"
                ),
                array(
                    'name' => "Upload ID Photo", "link" => base_url('EN/schools/MembersList'), "desc" => "", "icon" => "Avatars.png"
                ),
            ]
        );
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->show('EN/Global/Links/Lists', $data);
    }

    public function reports_routes()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $sessiondata = $this->session->userdata('admin_details');
        $cars_perm = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`cars` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`cars` = '1' ")->result_array();
        $permission_survey = $this->db->query(" SELECT `v0_permissions`.`Id`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`surveys` = '1' ")->result_array();
        $links = array();
        $links[] = array(
            "title" => "CH P010: Health Reports",
            "links" => [
                array(
                    'name' => "Sites’ Reports", "link" => base_url('EN/schools/sites_reports'),
                    "desc" => "", "icon" => "reports.png"
                ),
                array(
                    'name' => "Disease Report", "link" => base_url('EN/schools/disease_report'),
                    "desc" => "", "icon" => "DiseasesReport.png"
                ),
                array(
                    'name' => "Disease Prevalence", "link" => base_url('EN/schools/labs_report'),
                    "desc" => "", "icon" => "DiseasePrevalence.png"
                ),
                array(
                    'name' => "Lab Reports", "link" => base_url('EN/schools/Lab_Reports'),
                    "desc" => "", "icon" => "LabReports.png"
                ),
                array(
                    'name' => "Daily Temperature & other Tests’ Report", "link" => base_url('EN/schools/All_Tests_Today'),
                    "desc" => "", "icon" => "DailyTemperature.png"
                ),
            ]
        );
        $links[] = array(
            "title" => "General Reports",
            "links" => [
                array(
                    'name' => "Monthly Temperature & Tests’ Report", "link" => base_url('EN/schools/monthResults'),
                    "desc" => "", "icon" => "DailyMonitor.png"
                ),
                array(
                    'name' => "Refrigerator Data Log Report", "link" => base_url('EN/schools/refrigerators_trips'),
                    "desc" => "", "icon" => "Refrigerator_Trip.png"
                ),
                array(
                    'name' => "Attendance by Date per User", "link" => base_url('EN/schools/attendance_result'),
                    "desc" => "", "icon" => "AttendenceByDataPerUser.png"
                ),
                array(
                    'name' => "Daily Attendance by Device & User", "link" => base_url('EN/schools/Attendance_Report'),
                    "desc" => "", "icon" => "DailyAttendanceByDeviceByUser.png"
                ),
                array(
                    'name' => "Attendance by Date for All Users", "link" => base_url('EN/schools/attendance_result_for_all'),
                    "desc" => "", "icon" => "ListofAttendance.png"
                ),
                array(
                    'name' => "Single Lab Test", "link" => base_url('EN/schools/patient-single-report'),
                    "desc" => "", "icon" => "AttendenceByDataPerUser.png"
                ),
                array(
                    'name' => "Combo Lab Test", "link" => base_url('EN/schools/patient-profile-report'),
                    "desc" => "", "icon" => "AttendenceByDataPerUser.png"
                ),
            ]
        );
        if (!empty($cars_perm)) {
            $links[] = array(
                "title" => "Vehicle Report",
                "links" => [
                    array('name' => "Student Attendance by Vehicle", "link" => base_url('EN/schools/Vehicles_Attendees'), "desc" => "", "icon" => "Vehicles1.png"),
                    array('name' => "Student Attendance by Class", "link" => base_url('EN/schools/Attendance_for_vichal'), "desc" => "", "icon" => "Vehicles2.png"),
                    array('name' => "Student Buss Attendance", "link" => base_url('EN/schools/student_buss_attendance'), "desc" => "", "icon" => "Vehicles2.png"),
                ]
            );
        }
        $data['links'] = $links;
        $data['page_title'] = "QlickSystems | List all ";
        $this->show('EN/Global/Links/Lists', $data);
    }

    public function Monitors_routes()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->permissions_array["temperatureandlabs"]) {
            $links = array();
            $links[] = array(
                'name' => "Cooling Control", "link" => base_url('EN/schools/refrigerator-cards'),
                "desc" => "", "icon" => "Refrigeratorcards.png"
            );
            $links[] = array(
                'name' => "Environment (Refrigerator)", "link" => base_url('EN/schools/MacheneRP'),
                "desc" => "", "icon" => "Environment.png"
            );
            $links[] = array('name' => "Quarantined (Staff, Teachers, and Students)", "link" => base_url('EN/schools/Quarantine_monitor'), "desc" => "", "icon" => "Quarantine.png");
            $links[] = array('name' => "Stay Home (Staff, Teachers, and Students)", "link" => base_url('EN/schools/StayHome_monitor'), "desc" => "", "icon" => "StayHomeR.png");
            $links[] = array(
                'name' => "Daily Monitor (Staff, Teachers, and Students)", "link" => base_url('EN/schools/monitor'),
                "desc" => "", "icon" => "DailyMonitorSTS.png"
            );
            $links[] = array(
                'name' => "Attendees by Vehicle", "link" => base_url('EN/schools/attendees_reports'),
                "desc" => "", "icon" => "AttendenceByvehaicle.png"
            );
            $links[] = array(
                'name' => "Attendees by Class", "link" => base_url('EN/schools/Attendees_By_class_reports'),
                "desc" => "", "icon" => "AttendenceByClass.png"
            );
            $links[] = array(
                'name' => "Student Cards", "link" => base_url('EN/schools/studentscards'),
                "desc" => "", "icon" => "StudentCards.png"
            );
            $links[] = array('name' => "Visitors by Device", "link" => base_url('EN/schools/Visitors'), "desc" => "", "icon" => "VisitorByDevice.png");
            $permission_visitors = $this->db->query(" SELECT `v0_permissions`.`visitors` , `v0_permissions`.`Created`
            FROM `l1_school` 
            JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
            JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
            AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
            WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`visitors` = '1' ")->result_array();
            if (!empty($permission_visitors)) {
                $links[] = array('name' => "Visitor Monitor", "link" => base_url('EN/schools/visitor_report'), "desc" => "", "icon" => "VisitorMonitor.png");
                $links[] = array('name' => "Public Visitor Monitor", "link" => base_url('EN/schools/Public_Visitors'), "desc" => "", "icon" => "PublicVisitorMonitor.png");
            }
            $data['links'] = $links;
            $data['page_title'] = "QlickSystems | List all ";
            $this->show('EN/Global/Links/Lists', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function questions_reports()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $this->load->model('schools/sv_school_reports');
            $data['quastions_all_data'] = $this->sv_school_reports->get_surv_quastions($data['survey_id']);
            $cutted_array = array_column($data['quastions_all_data'], 'en_title');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_school_reports->survey_q_results($data['survey_id']);
            if (empty($data['get_choices'])) {
                $this->output->set_status_header('404');
                die();
            }
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $data['types'] = array(
                [
                    "name" => "staff",
                    "code" => "1"
                ],
                [
                    "name" => "Teacher",
                    "code" => "3"
                ],
                [
                    "name" => "Student",
                    "code" => "2"
                ],
                [
                    "name" => "Parent",
                    "code" => "4"
                ]
            );
            $this->show('EN/schools/Questions_Reports', $data);
        } else {
            redirect('EN/Schools/categorys_reports');
        }
    }

    public function counter_questions()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['survey_id'] = $this->uri->segment(4);
            $data['page_title'] = "QlickSystems | Questions Reports ";
            $this->load->model('schools/sv_school_reports'); //
            $data['quastions_all_data'] = $this->sv_school_reports->get_surv_quastions($data['survey_id']);
            if (empty($data['quastions_all_data'])) {
                $this->output->set_status_header('404');
                die();
            }
            $cutted_array = array_column($data['quastions_all_data'], 'en_title');
            $questions = array_map(function ($name) {
                return '"' . $name . '"';
            }, $cutted_array);
            $data['quastions'] = $cutted_array;
            $data['survey_quastions'] = $questions;
            $data['get_choices'] = $this->sv_school_reports->survey_q_results($data['survey_id']);
            $used_choices = array_column($data['get_choices'], "choices_en");
            $used_choices = array_map(function ($choices) {
                return '"' . $choices . '"';
            }, $used_choices);
            $data['used_choices'] = $used_choices;
            $data['types'] = array(
                [
                    "name" => "staff",
                    "code" => "1"
                ],
                [
                    "name" => "Teacher",
                    "code" => "3"
                ],
                [
                    "name" => "Student",
                    "code" => "2"
                ],
                [
                    "name" => "Parent",
                    "code" => "4"
                ]
            );
            $this->show('EN/schools/Questions_Counter', $data);
        } else {
            redirect('EN/Schools/categorys_reports');
        }
    }

    public function Private_surveys()
    {
        echo $this->security->get_csrf_hash();
        $this->load->helper('cookie');
        if ($this->input->get('type')) {
            $type = $this->input->get('type');
            $cookie = array(
                'name' => 'showingtype',
                'value' => $type,
                'expire' => '1000',
                'secure' => TRUE
            );
            $this->input->set_cookie($cookie);
        }
        if ($this->input->get('type')) {
            $data['active_type'] = $this->input->get('type');
        } elseif ($this->input->cookie('showingtype')) {
            $data['active_type'] = $this->input->cookie('showingtype');
        } else {
            $data['active_type'] = "owl";
        }
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Fillable Surveys";
        $this->load->model('schools/sv_school_reports'); //
        $data['surveys'] = $this->sv_school_reports->our_fillable_surveys($sessiondata['admin_id']);
        $this->show('EN/schools/Private_surveys_reports', $data);
    }

    public function listofansererusersinprivatsurvey()
    {
        if ($this->input->post('survey_id')) {
            $this->load->model('schools/sv_school_reports');
            $survey_id = $this->input->post('survey_id');
            $users = $this->sv_school_reports->userspassedprivatesurvey($survey_id);
            $allcounter = $this->db->get_where('sv_school_published_fillable_surveys_targetedusers', array('Survey_id' => $survey_id))->num_rows();
            $this->response->json(["status" => 'ok', "users" => $users, "passed_counter" => sizeof($users), "all_counter" => $allcounter]);
        } else {
            $answer_id = $this->input->post("answer_id");
            $answers = $this->db->query("SELECT * , `sv_questions_library`.`en_title` AS question
            FROM `sv_st1_fillable_answers_values`
            JOIN `sv_st_fillable_questions` ON `sv_st_fillable_questions`.`Id` = `sv_st1_fillable_answers_values`.`QuestionId`
            INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_fillable_questions`.`question_id`
            WHERE `answer_data_id` = '" . $answer_id . "' ")->result_array();
            $this->response->json(["status" => 'ok', "answers" => $answers]);
        }
    }

    public function csv_users_check()
    {
        if ($this->uri->segment(4)) {
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | List of Staff ";
            $data['sessiondata'] = $sessiondata;
            $this->load->view('EN/inc/header', $data);
            if ($this->uri->segment(4) == "staff") {
                $listofaStaffs['listofaStaffs'] = $this->db->query("SELECT `l2_temp_staff`.* , 
                `r_positions_sch`.`Position` AS Position_name
                FROM l2_temp_staff 
                LEFT JOIN `r_positions_sch` ON `l2_temp_staff`.`Position` = `r_positions_sch`.`Id`
                WHERE `l2_temp_staff`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_temp_staff`.`adding_method` = 'csv' ")->result_array();
                $this->load->view('EN/schools/List_Stuff', $listofaStaffs);
            } elseif ($this->uri->segment(4) == "teachers") {
                $list['Teachers'] = $this->db->query("SELECT `l2_temp_teacher`.* , 
                `r_positions_tech`.`Position` AS Position_name
                FROM l2_temp_teacher 
                LEFT JOIN `r_positions_tech` ON `l2_temp_teacher`.`Position` = `r_positions_tech`.`Id`
                WHERE `l2_temp_teacher`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_temp_teacher`.`adding_method` = 'csv' ")->result_array();
                $this->load->view('EN/schools/List_Teachers', $list);
            } elseif ($this->uri->segment(4) == "students") {
                $list['listofaStudents'] = $this->db->query("SELECT * FROM l2_temp_student 
                WHERE Added_By = '" . $sessiondata['admin_id'] . "' AND `adding_method` = 'csv' ")->result_array();
                $this->load->view('EN/schools/Students_csv_preview', $list);
            }
            $this->load->view('EN/inc/footer');
        }
    }

    public function Upload_media_link()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
        if (!empty($this->input->post("media_link"))) {
            $this->load->library('form_validation');
            if (!empty($this->input->post("media_link"))) { // validation the link
                $sessiondata = $this->session->userdata('admin_details');
                // making array
                $data = array();
                $links = $this->input->post("media_link");
                // freach link
                foreach ($links as $link) {
                    $language = $link['language'];
                    if (!empty($link['link_title'])) {
                        $title = $link['link_title'];
                    } else {
                        $linkparts = explode("?", trim($link['media_link']));
                        if (sizeof($linkparts) == 2) {
                            $videoid = str_replace("v=", "", $linkparts[1]);
                            $apikey = 'AIzaSyAU4Pg_I5BGHHIrJ5WBF8neXPYfYut9A-8'; // api key
                            $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $videoid . '&key=' . $apikey . '&part=snippet');
                            $videoDetails = json_decode($json, true);
                            if (!empty($videoDetails['items'][0]['snippet']['title'])) {
                                $title = $videoDetails['items'][0]['snippet']['title'];
                            } else {
                                $title = "no title";
                            }
                        } else {
                            $title = "no title";
                        }
                    }
                    // making array of data
                    $data[] = array(
                        "link" => trim($link['media_link']),
                        "langauge" => $language,
                        "title" => $title,
                        "by_school" => $sessiondata['admin_id']
                    );
                }
                // insert data
                if ($this->db->insert_batch('l3_videos', $data)) {
                    $respons['status'] = "ok";
                } else {
                    $respons['status'] = "error";
                    $respons['messages'] = ["error" => "we cant update this url now , please try later"];
                }
            } else {
                $respons['messages'] = ["error" => "Please add a link "];
            }
        } else {
            $respons['messages'] = ["error" => "We have error in this request please refresh page and try again ", "posts" => $this->input->post()];
        }
        echo json_encode($respons);
    }

    public function medialinks()
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header("Content-Type: application/json; charset=UTF-8");
            $respons = array('status' => "error", "messages" => ["error" => "we cant update this url now , please try later"]);
            if ($this->input->input_stream('linkId')) {
                $linkId = $this->input->input_stream('linkId');
                if ($this->db->delete('l3_videos', array('Id' => $linkId))) {
                    $respons['status'] = "ok";
                } else {
                    $respons['status'] = "error";
                }
            }
            echo json_encode($respons);
        } elseif ($this->input->method() == "put" && $this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $id = $this->uri->segment(4);
            if ($this->db->query("UPDATE `l3_videos` SET status = IF(status=1, 0, 1) WHERE Id = $id")) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function Vehicles_Attendees()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $data['page_title'] = "QlickSystems | Vehicles Attendees ";
            $this->load->model('schools/sv_school_reports');
            $data['Vehicles'] = $this->db->query("SELECT *
            FROM  `l2_vehicle`
            WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND (EXISTS (SELECT Id FROM l2_vehicle_drivers WHERE `car_id` = `l2_vehicle`.`Id`) 
            OR   EXISTS (SELECT Id FROM l2_vehicle_helpers WHERE `car_id` = `l2_vehicle`.`Id`) )")->result_array();
            $this->show('EN/schools/Vehicles_Attendees', $data);
        } elseif ($this->input->method() == "post") {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('teacher', 'teacher', 'trim|required|numeric');
            if ($this->form_validation->run()) {
                $vichelid = $this->input->post('teacher');
                $start = $this->input->post('start');
                $end = $this->input->post('end');
                $list = array();
                $list['students'] = $this->db->query("SELECT CONCAT( `l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN` ) AS username ,
                IF((SELECT Id FROM `l2_monthly_result` WHERE `UserId` = `l2_student`.`Id` AND `l2_monthly_result`.`UserType` = 'Student'
                AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status ,
                `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result
                FROM `l2_vehicle`
                JOIN `l2_vehicle_students` ON `l2_vehicle_students`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_student` ON `l2_student`.`Id` = `l2_vehicle_students`.`student_id`
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_student`.`Id` AND `l2_monthly_result`.`UserType` = 'Student'
                WHERE `l2_vehicle`.`Id` = '" . $vichelid . "' ")->result_array();
                $list['teachers'] = $this->db->query("SELECT CONCAT( `l2_teacher`.`F_name_EN` , ' ' , `l2_teacher`.`L_name_EN` ) AS username ,
                IF((SELECT Id FROM `l2_monthly_result` WHERE `UserId` = `l2_teacher`.`Id` AND `l2_monthly_result`.`UserType` = 'Teacher'
                AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status , `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result 
                FROM `l2_vehicle`
                JOIN `l2_vehicle_drivers` ON `l2_vehicle_drivers`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_teacher` ON `l2_teacher`.`Id` = `l2_vehicle_drivers`.`teacher_id` 
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_teacher`.`Id` AND `l2_monthly_result`.`UserType` = 'Teacher'
                WHERE `l2_vehicle`.`Id` = '" . $vichelid . "' ")->result_array();
                $list['staffs'] = $this->db->query("SELECT CONCAT( `l2_staff`.`F_name_EN` , ' ' , `l2_staff`.`L_name_EN`  ) AS username ,
                IF((SELECT Id FROM `l2_monthly_result` WHERE `UserId` = `l2_staff`.`Id` AND `l2_monthly_result`.`UserType` = 'Staff'
                AND `l2_monthly_result`.`Created` >= '" . $start . "' AND `l2_monthly_result`.`Created` <= '" . $end . "' ) IS NULL , 'absent', 'present') as Attendees_status , `l2_monthly_result`.`Created` AS date , `l2_monthly_result`.`Result` AS Result
                FROM `l2_vehicle`
                JOIN `l2_vehicle_helpers` ON `l2_vehicle_helpers`.`car_id` = `l2_vehicle`.`Id` 
                JOIN `l2_staff` ON `l2_staff`.`Id` = `l2_vehicle_helpers`.`staff_id`
                LEFT JOIN `l2_monthly_result` ON `l2_monthly_result`.`UserId` = `l2_staff`.`Id` AND `l2_monthly_result`.`UserType` = 'Staff'
                WHERE `l2_vehicle`.`Id` = '" . $vichelid . "' ")->result_array();
                $this->response->json(["status" => "success", "records" => $list]);
            } else {
                $this->response->json(['status' => "error", "message" => "Please check your inputs"]);
            }
        }
    }

    public function disease_report()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | disease report ";
        $data["classes"] = $this->schoolHelper->getActiveSchoolClassesByStudents();
        $data['tests'] = $this->db->get('r_testcode')->result_array();
        if ($this->input->method() == "post") {
            // validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('classes[]', 'classes', 'trim|required|multiple_select');
            $this->form_validation->set_rules('grades[]', 'grades', 'trim|required|multiple_select');
            $this->form_validation->set_rules('tests[]', 'test type', 'trim|required|multiple_select');
            // check
            if ($this->form_validation->run()) {
                // teachers
                $this->db->select("concat(l2_teacher.F_name_EN,' ',l2_teacher.L_name_EN) AS name , 
                l2_labtests.Result , concat(l2_labtests.Created,' ',l2_labtests.Time) AS resultDate , l2_teacher.Action AS Action ,
                l2_labtests.Test_Description AS testName");
                $this->db->from('l2_labtests');
                $this->db->join('l2_teacher', 'l2_teacher.Id = l2_labtests.UserId');
                $this->db->join('l2_teachers_classes', "l2_teachers_classes.teacher_id = l2_teacher.Id");
                $this->db->where('l2_labtests.UserType', 'Teacher');
                $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($this->input->post('start'))));
                $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($this->input->post('end'))));
                $this->db->where_in('l2_labtests.Test_Description', $this->input->post('tests'));
                $this->db->where_in('l2_teachers_classes.class_id', $this->input->post('classes'));
                $teachers = $this->db->get()->result_array();
                $this->db->reset_query(); // reset
                // students
                $this->db->select("concat(l2_student.F_name_EN,' ',l2_student.L_name_EN) AS name , 
                l2_labtests.Result , concat(l2_labtests.Created,' ',l2_labtests.Time) AS resultDate , l2_student.Action AS Action ,
                l2_labtests.Test_Description AS testName");
                $this->db->from('l2_labtests');
                $this->db->join('l2_student', 'l2_student.Id = l2_labtests.UserId');
                $this->db->where('l2_labtests.UserType', 'Student');
                $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($this->input->post('start'))));
                $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($this->input->post('end'))));
                $this->db->where_in('l2_labtests.Test_Description', $this->input->post('tests'));
                $this->db->where_in('l2_student.Class', $this->input->post('classes'));
                $this->db->where_in('l2_student.Grades', $this->input->post('grades'));
                $students = $this->db->get()->result_array();
                $this->response->json(['status' => "ok", "students" => $students, "teachers" => $teachers]);
            } else {
                $this->response->json(['status' => "error", "messages" => validation_errors("<p class='mb-0'> + ", "</p>")]);
            }
        } else {
            $this->show('EN/schools/disease_report', $data);
        }
    }

    public function labs_report()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | disease report ";
        $data["classes"] = $this->schoolHelper->getActiveSchoolClassesByStudents();
        $data['tests'] = $this->db->get('r_testcode')->result_array();
        if ($this->input->method() == "post") {
            // validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start', 'start', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('end', 'end', 'trim|required|exact_length[10]');
            $this->form_validation->set_rules('classes[]', 'classes', 'trim|required|multiple_select');
            $this->form_validation->set_rules('tests[]', 'test type', 'trim|required|multiple_select');
            // check
            if ($this->form_validation->run()) {
                $tests = array();
                $inputtests = $this->input->post('tests');
                foreach ($this->input->post('tests') as $test_inp) {
                    $tests[] = str_replace(" ", '_', $test_inp);
                }
                // teachers
                $this->db->select("`r_levels`.`Class` AS class , `r_levels`.`Id` AS Class_key ");
                $this->db->from('l2_labtests');
                $this->db->join('l2_teacher', 'l2_teacher.Id = l2_labtests.UserId');
                $this->db->join('l2_teachers_classes', "l2_teachers_classes.teacher_id = l2_teacher.Id");
                $this->db->join('r_levels', 'r_levels.Id = l2_teachers_classes.class_id');
                $this->db->where('l2_labtests.UserType', 'Teacher');
                $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($this->input->post('start'))));
                $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($this->input->post('end'))));
                $this->db->where('l2_teacher.Added_By', $sessiondata['admin_id']);
                $this->db->where_in('l2_labtests.Test_Description', $this->input->post('tests'));
                $this->db->group_by('l2_teacher.Id');
                $teachers = $this->db->get()->result_array();
                $this->db->reset_query(); // reset
                // students
                $this->db->select("`r_levels`.`Class` AS class , `r_levels`.`Id` AS Class_key ");
                $this->db->from('l2_labtests');
                $this->db->join('l2_student', 'l2_student.Id = l2_labtests.UserId');
                $this->db->join('r_levels', 'r_levels.Id = l2_student.Class');
                $this->db->where('l2_labtests.UserType', 'Student');
                $this->db->where('l2_labtests.Created >=', date('Y-m-d', strtotime($this->input->post('start'))));
                $this->db->where('l2_labtests.Created <=', date('Y-m-d', strtotime($this->input->post('end'))));
                $this->db->where('l2_student.Added_By', $sessiondata['admin_id']);
                $this->db->where_in('l2_labtests.Test_Description', $this->input->post('tests'));
                $this->db->where_in('l2_student.Class', $this->input->post('classes'));
                $this->db->group_by('l2_student.Class');
                $students = $this->db->get()->result_array();
                //echo $this->db->last_query();
                // charts
                $studentsresults = array();
                $teachersresults = array();
                // second chart
                $secondChart = array('students' => array(), "teachers" => array(), "staffs" => array());
                ?>
                <div class="tab-pane active" id="teachers" role="tabpanel">
                    <div class="table-responsive">
                        <table id="teachers_table" class="table">
                            <thead>
                            <th>#</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <?php $t_positives = 0;
                            $t_nigatives = 0; ?>
                            <tbody>
                            <tr>
                                <td>Results</td>
                                <?php foreach ($tests as $key => $test) { ?>
                                    <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_teacher.Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows(); ?>
                                    <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_teacher ON `l2_teacher`.`Id` = `l2_labtests`.`UserId`
                                            JOIN l2_teachers_classes ON l2_teachers_classes.teacher_id = l2_teacher.Id
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_teacher`.`Id` AND l2_labtests.UserType = 'Teacher'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_teacher.Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows(); ?>
                                    <?php $secondChart['teachers'][$test] = ["Positive" => $Positive, "Negative" => $Negative, "both" => $Positive + $Negative]; ?>
                                    <?php $t_positives += $Positive;
                                    $t_nigatives += $Negative; ?>
                                    <td class="text-center">
                                        <span
                                                class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                        <span
                                                class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                        <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                    </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="column_chart_teachers" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_teachers" class="apex-charts" dir="ltr"></div>
                </div>
                <div class="tab-pane" id="Staff" role="tabpanel">
                    <div class="table-responsive">
                        <table id="teachers_table" class="table">
                            <thead>
                            <th>#</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <?php $t_positives = 0;
                            $t_nigatives = 0; ?>
                            <tbody>
                            <tr>
                                <td>Results</td>
                                <?php foreach ($tests as $key => $test) { ?>
                                    <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND
                                            l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows(); ?>
                                    <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_staff ON `l2_staff`.`Id` = `l2_labtests`.`UserId`
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_staff`.`Id` AND l2_labtests.UserType = 'Staff'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_staff.Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows(); ?>
                                    <?php $secondChart['staffs'][$test] = ["Positive" => $Positive, "Negative" => $Negative, "both" => $Positive + $Negative]; ?>
                                    <?php $t_positives += $Positive;
                                    $t_nigatives += $Negative; ?>
                                    <td class="text-center">
                                        <span
                                                class="badge rounded-pill bg-danger text-white p-2">Positive : <?= $Positive; ?></span><br>
                                        <span
                                                class="badge rounded-pill bg-success text-white p-2 mt-1">Negative : <?= $Negative; ?></span>
                                        <span class="badge rounded-pill bg-primary text-white p-2 mt-1">Prevalence Rate : <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                    </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="column_chart_teachers" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_staffs" class="apex-charts" dir="ltr"></div>
                </div>
                <div class="tab-pane" id="students" role="tabpanel">
                    <div class="table-responsive">
                        <table id="students_table" class="table">
                            <thead>
                            <th>#</th>
                            <th>Class Name</th>
                            <?php foreach ($inputtests as $test) { ?>
                                <th><?= $test ?></th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach ($students as $i => $student) { ?>
                                <?php $positives = 0;
                                $nigatives = 0; ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $student['class'] ?></td>
                                    <?php foreach ($tests as $key => $test) { ?>
                                        <?php $Positive = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '1' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_student.Added_By = '" . $sessiondata['admin_id'] . "' ")->num_rows();
                                        ?>
                                        <?php $Negative = $this->db->query("SELECT l2_labtests.Id FROM l2_labtests
                                            JOIN l2_student ON `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_student`.`Class` = '" . $student['Class_key'] . "' 
                                            WHERE l2_labtests.Created >= '" . date('Y-m-d', strtotime($this->input->post('start'))) . "' AND l2_labtests.Created <= '" . date('Y-m-d', strtotime($this->input->post('end'))) . "' AND l2_labtests.Result = '0' AND `l2_labtests`.`UserId` = `l2_student`.`Id` AND l2_labtests.UserType = 'Student'
                                            AND l2_labtests.Test_Description = '" . $inputtests[$key] . "' AND l2_student.Added_By = '" . $sessiondata['admin_id'] . "'  ")->num_rows(); ?>
                                        <?php $secondChart['students'][$test] = ["Positive" => ($secondChart['students'][$test]["Positive"] ?? 0) + $Positive, "Negative" => ($secondChart['students'][$test]["Negative"] ?? 0) + $Negative, "both" => ($secondChart['students'][$test]["both"] ?? 0) + ($Positive + $Negative)]; ?>
                                        <?php $positives += $Positive;
                                        $nigatives += $Negative; ?>
                                        <td class="text-center">
                                            <span
                                                    class="badge rounded-pill bg-danger text-white p-2">Positive: <?= $Positive; ?></span><br>
                                            <span
                                                    class="badge rounded-pill bg-success text-white p-2 mt-1">Negative: <?= $Negative; ?></span>
                                            <span
                                                    class="badge rounded-pill bg-primary text-white p-2 mt-1">Injury Rate: <?= $this->calc_perc($Positive, ($Positive + $Negative)); ?>%</span>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $studentsresults[] = ['value' => $this->calc_perc($positives, ($positives + $nigatives)), "name" => $student['class']];
                                ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div id="column_chart_students" class="apex-charts" dir="ltr"></div>
                    <hr>
                    <h3 class="card-title text-center">Test Chart:</h3>
                    <div id="second_chart_students" class="apex-charts" dir="ltr"></div>
                </div>
                <hr>
                <?php
                $chartClasses = array();
                foreach ($students as $class) {
                    $chartClasses[] = '"' . $class['class'] . '"';
                }
                $labels = array();
                foreach ($tests as $test) {
                    $labels[] = '"' . str_replace("_", " ", $test) . '"';
                }
                ?>
                <script>
                    $('.table').DataTable();
                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [
                            <?php foreach ($chartClasses as $i => $student) { ?> {
                                name: "<?= $studentsresults[$i]['name'] ?>",
                                data: [<?= $studentsresults[$i]['value'] ?>]
                            },
                            <?php } ?>
                        ],
                        colors: ['#f1b44c', '#5b73e8', '#34c38f'],
                        xaxis: {
                            categories: [<?= implode(',', $chartClasses); ?>],
                        },
                        yaxis: {
                            title: {
                                text: ' Prevalence Rate '
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "Prevalence Rate  : " + val + "%"
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(
                        document.querySelector("#column_chart_students"),
                        options
                    );
                    chart.render();
                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["students"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["students"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["students"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#second_chart_students"), options);
                    chart.render();
                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["staffs"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#second_chart_staffs"), options);
                    chart.render();
                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Positive',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "Positive")) ?>]
                        }, {
                            name: 'Negative',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "Negative")) ?>]
                        }, {
                            name: 'Total',
                            data: [<?= implode(",", array_column($secondChart["teachers"], "both")) ?>]
                        }],
                        colors: ['#f46a6a', '#34c38f', '#5b73e8'],
                        xaxis: {
                            categories: [<?= implode(',', $labels); ?>],
                        },
                        yaxis: {
                            title: {
                                text: 'Result(s)'
                            }
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Result(s)"
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#second_chart_teachers"), options);
                    chart.render();
                </script>
            <?php } else {
                $this->response->json(['status' => "error", "messages" => validation_errors("<p class='mb-0'> + ", "</p>")]);
            }
        } else {
            $this->show('EN/schools/labs_reports', $data);
        }
    }

    public function Lab_Reports()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Lab Report ";
        $data['sessiondata'] = $sessiondata;
        $data['tests'] = $this->db->get('r_testcode')->result_array();
        if ($this->input->method() == "post") {
            $data['start'] = $this->input->post("start");
            $data['end'] = $this->input->post("end");
            $data['selected_tests'] = $this->input->post("tests") ?? array_column($data['tests'], "Test_Desc");
        } else {
            $data['start'] = date('Y-m-d');
            $data['end'] = date('Y-m-d');
            $data['selected_tests'] = array_column($data['tests'], "Test_Desc");
        }
        $Acceptedtests = array();
        foreach ($data['selected_tests'] as $test) {
            $Acceptedtests[] = '"' . $test . '"';
        }
        $data['students'] = $this->db->query(" SELECT 
        l1_school.School_Name_EN AS H_name ,
        concat(l2_student.F_name_EN , ' ',l2_student.M_name_EN , ' ' , l2_student.L_name_EN) AS P_name ,
        '--' AS HIC_num ,
        l2_student.National_Id AS QID ,
        l2_student.DOP , l2_student.Nationality ,
        l2_labtests.Id,
        l2_labtests.TimeStamp AS Test_Date ,
        l2_labtests.Test_Description AS Test_Type ,
        IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
        IF(l2_student.Gender = 1 , 'Male' , 'Female') AS Gender
        FROM l2_labtests 
        JOIN l2_student ON l2_student.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Student'
        JOIN l1_school ON l2_student.Added_By = l1_school.Id
        WHERE l1_school.Id = '" . $sessiondata['admin_id'] . "'
        AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
        AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
        $data['teachers'] = $this->db->query(" SELECT 
        l1_school.School_Name_EN AS H_name ,
        concat(	l2_teacher.F_name_EN , ' ',	l2_teacher.M_name_EN , ' ' , l2_teacher.L_name_EN) AS P_name ,
        '--' AS HIC_num ,
        l2_teacher.National_Id AS QID ,
        l2_teacher.DOP , l2_teacher.Nationality ,
        l2_labtests.Id,
        l2_labtests.TimeStamp AS Test_Date ,
        l2_labtests.Test_Description AS Test_Type ,
        IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
        IF(	l2_teacher.Gender = 1 , 'Male' , 'Female') AS Gender
        FROM l2_labtests 
        JOIN l2_teacher ON l2_teacher.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Teacher'
        JOIN l1_school ON l2_teacher.Added_By = l1_school.Id
        WHERE l1_school.Id = '" . $sessiondata['admin_id'] . "'
        AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
        AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
        $data['staff'] = $this->db->query(" SELECT 
        l1_school.School_Name_EN AS H_name ,
        concat(	l2_staff.F_name_EN , ' ',	l2_staff.M_name_EN , ' ' , 	l2_staff.L_name_EN) AS P_name ,
        '--' AS HIC_num ,
        l2_staff.National_Id AS QID ,
        l2_labtests.Id,
        l2_staff.DOP , l2_staff.Nationality ,
        l2_labtests.TimeStamp AS Test_Date ,
        l2_labtests.Test_Description AS Test_Type ,
        IF(l2_labtests.Result = 1 , 'Positive' , 'Negative') AS Result, 
        IF(	l2_staff.Gender = 1 , 'Male' , 'Female') AS Gender
        FROM l2_labtests 
        JOIN l2_staff ON l2_staff.Id = l2_labtests.UserId AND l2_labtests.UserType = 'Staff'
        JOIN l1_school ON l2_staff.Added_By = l1_school.Id
        WHERE l1_school.Id = '" . $sessiondata['admin_id'] . "'
        AND l2_labtests.Created BETWEEN '" . $data['start'] . "' AND '" . $data['end'] . "'
        AND l2_labtests.Test_Description IN (" . implode(",", $Acceptedtests) . ") ")->result_array();
        $this->show('EN/schools/Lab_Reports', $data);
    }

    public function refrigerators_trips()
    {
        if ($this->permissions_array['temperatureandlabs']) {
            $sessiondata = $this->session->userdata('admin_details');
            $sessiondata = $this->session->userdata('admin_details');
            $data['page_title'] = "Qlick Health | Lab Report ";
            $data['sessiondata'] = $sessiondata;
            if ($this->input->method() == "post") {
                $data['from'] = $this->input->post("start");
                $data['to'] = $this->input->post("end");
                $data['tripName'] = $this->input->post("trip_name");
                $data['selected'] = $this->input->post("machine");
            } else {
                $data['tripName'] = "";
                $data['selected'] = "";
            }
            $conditions = array();
            // conditions
            if ($data['selected'] !== "") {
                $conditions['Machine_Id'] = $data['selected'];
                $trips = $this->db->query("SELECT DISTINCT trip_name 
                FROM `refrigerator_result_log_Daily` 
                WHERE Machine_Id = '" . $conditions['Machine_Id'] . "'
                ORDER BY `Machine_Id` ASC")->result_array();
            } else {
                $trips = array();
            }
            if ($data['tripName'] !== "") {
                $conditions['trip_name'] = $data['tripName'];
            }
            $data['time_chart'] = array();
            $data['results_chart'] = array();
            $data['Humidity_chart'] = array();
            //results array
            $data['results'] = $this->db->query("SELECT o.`EN_Title`,cd.`School_Name_EN`, ra.`Description` AS machene , ra.Id AS machineId 
            ,rrld.`mUtcTime`, rrld.`trip_name` , rrld.`Result`,rrld.`Humidity`,rrld.`Created`,rrld.`Time` 
            FROM `refrigerator_result_log_Daily` AS rrld ,`refrigerator_area` AS ra ,`l1_school` AS cd,`l0_organization` AS o
            WHERE ra.`Id` = rrld.`Machine_Id`
            AND ra.`user_type` = rrld.`user_type`
            AND ra.`source_id` =cd.`Id`
            AND cd.`Added_By` =o.`Id`
            " . ($data['selected'] !== "" ? "AND rrld.`Machine_Id` = " . $data['selected'] : '') . "
            " . ($data['tripName'] !== "" ? 'AND rrld.`trip_name` = ' . "'" . $data['tripName'] . "'" : '') . "
            AND rrld.`user_type`= 'school'
            AND ra.`source_id` = '" . $sessiondata['admin_id'] . "'  ;")->result_array();
            $data['machiens'] = array();
            $data['trips'] = $trips;
            foreach ($data['results'] as $key => $result) {
                if ($result['Created'] == date('Y-m-d')) {
                    $data['time_chart'][] = "'" . $result['Time'] . "'";
                    $data['results_chart'][] = $result['Result'];
                    $data['Humidity_chart'][] = $result['Humidity'];
                }
            }
            $this->show('EN/schools/refrigeratorsReports', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function tripNames_forthisMachine()
    {
        if ($this->input->method() == "post") {
            $id = $this->input->post('machine_id');
            $trips = $this->db->query("SELECT DISTINCT trip_name 
            FROM `refrigerator_result_log_Daily` 
            WHERE Machine_Id = '" . $id . "'
            ORDER BY `Machine_Id` ASC")->result_array();
            $this->response->json($trips);
        }
    }

    public function wellnessTwo()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | wellness Reports ";
        $data['sessiondata'] = $sessiondata;
        $permission = $this->db->query(" SELECT `v0_permissions`.`Id`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "' AND `v0_permissions`.`surveys` = '1' ")->result_array();
        if (!empty($permission)) {
            $data['our_teachers'] = $this->db->query("SELECT * FROM `l2_teacher` 
            WHERE Added_By = '" . $sessiondata['admin_id'] . "' 
            AND EXISTS (SELECT Id FROM `sv_dedicated_surveys` 
            WHERE `sv_dedicated_surveys`.`user_id` = `l2_teacher`.`Id` AND `sv_dedicated_surveys`.`usertype` = 'teacher'  AND `sv_dedicated_surveys`.`completed` = '1') ")->result_array();
            $data['our_parents'] = $this->db->query(" SELECT * FROM l2_parents 
            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
            WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "')  
            AND EXISTS (SELECT Id FROM `sv_dedicated_surveys` 
            WHERE `sv_dedicated_surveys`.`user_id` =  `l2_parents`.`Id` AND `sv_dedicated_surveys`.`usertype` = 'Parent' AND `sv_dedicated_surveys`.`completed` = '1' ) ")->result_array();
            if ($this->input->method() == "post") {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('Targetuser', 'Targeted user', 'trim|required');
                $this->form_validation->set_rules('survey', 'survey', 'trim|required|numeric');
                $this->form_validation->set_rules('results_user', 'results of user', 'trim|required|numeric');
                if ($this->form_validation->run()) {
                    $tageteduser = $this->input->post("results_user"); // the student id here
                    $survey = $this->input->post("survey"); // the survey id here
                    $pt_user = explode(":", $this->input->post("Targetuser")); // the teacher/parent id
                    // queries
                    $data['user_data'] = $this->db->query("SELECT concat(F_name_EN , ' ', M_name_EN , ' ' , L_name_EN) AS name , DOP , Gender
                    FROM `l2_student` WHERE Id = '" . $tageteduser . "' ")->result_array()[0] ?? header("Refresh:0");
                    $data['serv_data'] = $this->db->query("SELECT 
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
                    WHERE `sv_dedicated_surveys`.`completed` = '1' AND `sv_st1_surveys`.`Status` = '1' 
                    AND `sv_dedicated_surveys`.`User_id` = '" . $pt_user[1] . "' AND `sv_dedicated_surveys`.`usertype`  = '" . $pt_user[0] . "' AND `sv_dedicated_surveys`.`Id` = '" . $survey . "' ")->result_array();
                    if (!empty($data['serv_data'])) {
                        $data['answers'] = $this->db->query("SELECT `sv_dedicated_surveys_answers_values`.* FROM `sv_dedicated_surveys_answers` 
                        JOIN `sv_dedicated_surveys_answers_values` ON `sv_dedicated_surveys_answers_values`.`answers_data_id` = `sv_dedicated_surveys_answers`.`Id`
                        WHERE `sv_dedicated_surveys_answers`.`Survey_id` = '" . $survey . "' 
                        AND `sv_dedicated_surveys_answers`.`Student_id` = '" . $tageteduser . "'
                        AND `sv_dedicated_surveys_answers`.`User_id` = '" . $pt_user[1] . "' AND `sv_dedicated_surveys_answers`.`User_type` = '" . $pt_user[0] . "' ")->result_array();
                        // $this->response->dd($data['student_answers']);
                        $answers = array();
                        foreach ($data['answers'] as $answer) {
                            $answers[$answer['question_id']] = [
                                "choice_id" => $answer['choice_id'],
                                "answer_value" => $answer['answer_value'],
                            ];
                        }
                        $data['student_answers'] = $answers;
                        $data['questions_counter'] = 0;
                        $group = $data['serv_data'][0]['main_survey_id'];
                        $data['group'] = $group;
                        $data['standards'] = $this->db->get("r_standards")->result_array();
                        $data['used_groups'] = $this->db->query(" SELECT * FROM `sv_st_groups` WHERE `serv_id` = '" . $group . "'")->result_array();
                        $data['static_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                        FROM `sv_st_questions`
                        INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                        WHERE `sv_st_questions`.`survey_id` = '" . $group . "' AND `sv_st_questions`.`Group_id` = '0' ")->result_array();
                        $group_coices = $data['serv_data'][0]['group_id'];
                        $data['group_choices'] = $group_coices;
                        $data['choices'] = $this->db->query("SELECT `title_en` AS title ,`Id` FROM `sv_set_template_answers_choices`
                        WHERE `group_id` = '" . $group_coices . "' ")->result_array();
                        $data['standards_questions'] = $this->db->query(" SELECT *,`sv_st_questions`.`Id` AS q_id
                        FROM `sv_st_questions`
                        JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                        JOIN sv_standard_questions_groups ON sv_standard_questions_groups.Question_id = `sv_st_questions`.`Id`
                        JOIN sv_st_standars_groups ON sv_st_standars_groups.Id = sv_standard_questions_groups.results_standard_group 
                        JOIN r_standards ON r_standards.Id = sv_st_standars_groups.Standard_Id 
                        WHERE `sv_st_questions`.`survey_id` = '" . $group . "'")->result_array();
                        // $data['results_groups'] = $this->db->get_where("sv_st_standars_groups" , ["serv_id" => $group ])->result_array();
                        $data['results_groups'] = $this->db->query("SELECT sv_st_standars_groups.title_en , sv_dedicated_surveys_answers.Id ,
                        SUM(sv_dedicated_surveys_answers_values.answer_value) AS Counter , sv_dedicated_surveys_answers_values.question_id
                        FROM `sv_st_standars_groups`
                        JOIN `sv_dedicated_surveys_answers` ON `sv_dedicated_surveys_answers`.`Student_id` = '" . $tageteduser . "' 
                        AND `sv_dedicated_surveys_answers`.`User_type` = '" . $pt_user[0] . "'  AND  `sv_dedicated_surveys_answers`.`User_id` = '" . $pt_user[1] . "' 
                        JOIN `sv_standard_questions_groups` ON `sv_standard_questions_groups`.`results_standard_group` = `sv_st_standars_groups`.`Id`
                        JOIN `sv_dedicated_surveys_answers_values` ON `sv_dedicated_surveys_answers_values`.`answers_data_id` = `sv_dedicated_surveys_answers`.`Id`
                        AND `sv_dedicated_surveys_answers_values`.`question_id` = `sv_standard_questions_groups`.`Question_id`
                        WHERE `sv_st_standars_groups`.`serv_id` = '" . $group . "' GROUP BY `sv_st_standars_groups`.`Id` ")->result_array();
                        // $this->response->dd($data['results_groups']);
                    } else {
                        header("Refresh:0");
                    }
                } else {
                    $data['errors'] = validation_errors();
                }
            }
            $this->show('EN/schools/wellnessTwo', $data);
        } else {
            $dataDes['to'] = "EN/schools/wellness";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function doneSurveysForUser()
    {
        if ($this->input->method() == "post") {
            $user = explode(':', $this->input->post('userData'));
            if (sizeof($user) == 2) {
                $this->load->model('schools/sv_school_reports');
                $id = $user[1];
                $type = $user[0];
                $data = $this->db->query("SELECT 
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
                WHERE `sv_dedicated_surveys`.`completed` = '1' AND `sv_st1_surveys`.`Status` = '1' 
                AND `sv_dedicated_surveys`.`User_id` = '" . $id . "' AND `sv_dedicated_surveys`.`usertype`  = '" . $type . "' GROUP BY `sv_dedicated_surveys`.`Id` ")->result_array();
                $this->response->json($data);
            }
        }
    }

    public function resultsUsersForDedicatedSurvey()
    {
        // this functions returns the students on a dedicated survey , get : survey_id , returns json data of students list
        // method : post only
        if ($this->input->method() == "post" && $this->input->post('survey_id')) {
            $survey_id = $this->input->post('survey_id');
            $list = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name 
            FROM l2_student
            WHERE EXISTS (SELECT Id FROM sv_dedicated_surveys_students 
            WHERE sv_dedicated_surveys_students.student_id = l2_student.Id AND survey_request = '" . $survey_id . "' ) ")->result_array();
            $this->response->json($list);
        }
    }

    public function DedicatedSurveys()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "Qlick Health | Dedicated Surveys ";
        $schooltype = $this->db->query(" SELECT `Type_Of_School` FROM `l1_school` WHERE `Id` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $getedType = $schooltype[0]['Type_Of_School'];
        if ($getedType == "Government") {
            $schoolType = '2';
        } else {
            $schoolType = '3';
        }
        if ($this->uri->segment(4)) {
            // when the user chooses a type
            $type = strtolower($this->uri->segment(4));
            if ($type == "teachers" || $type == "parents") {
                // for teachers
                if ($type == "teachers") {
                    if ($this->input->method() == "get") {
                        $this->load->model('schools/sv_school_reports');
                        $data['surveys'] = $this->sv_school_reports->Get_surveys($schoolType);
                        // $this->response->dd($data['surveys']);
                        $data['teachers'] = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
                        $data['classes'] = $this->schoolHelper->getActiveSchoolClassesByStudents();
                        // loading
                        $this->show('EN/schools/DedicatedSurveys/teachers', $data);
                    } else if ($this->input->method() == "post") {
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('teacher', 'teacher', 'trim|required|numeric');
                        $this->form_validation->set_rules('survey', 'survey', 'trim|required|numeric');
                        $this->form_validation->set_rules('students[]', 'students', 'trim|required|multiple_select');
                        $this->form_validation->set_rules('message', 'message', 'trim|required');
                        if ($this->form_validation->run()) {
                            $students = $this->input->post('students');
                            $students_data = array();
                            $survey_insert = array(
                                "user_id" => $this->input->post("teacher"),
                                "survey_id" => $this->input->post("survey"),
                                "message" => $this->input->post("message"),
                                "usertype" => "teacher",
                            );
                            if ($this->db->insert('sv_dedicated_surveys', $survey_insert)) {
                                $insert_id = $this->db->insert_id();
                                foreach ($students as $student) {
                                    $students_data[] = array(
                                        "survey_request" => $insert_id,
                                        "student_id" => $student,
                                    );
                                }
                                if ($this->db->insert_batch("sv_dedicated_surveys_students", $students_data)) {
                                    $this->session->set_flashdata('inserted', 'Your survey has been sent successfully');
                                    redirect('/EN/schools/DedicatedSurveys/success', 'refresh');
                                }
                            }
                        } else {
                            $this->load->model('schools/sv_school_reports');
                            $data['errors'] = validation_errors();
                            $data['surveys'] = $this->sv_school_reports->Get_surveys($schoolType);
                            $data['teachers'] = $this->db->query("SELECT Id , CONCAT( F_name_EN , ' ' , L_name_EN ) AS name FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
                            $data['classes'] = $this->schoolHelper->getActiveSchoolClassesByStudents();
                            // loading
                            $this->show('EN/schools/DedicatedSurveys/teachers', $data);
                        }
                    }
                } elseif ($type == "parents") {
                    if ($this->input->method() == "get") {
                        $this->load->model('schools/sv_school_reports');
                        $data['surveys'] = $this->sv_school_reports->Get_surveys($schoolType);
                        $data['parents'] = $this->db->query(" SELECT * FROM l2_parents 
                        WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                        JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                        OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                        JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                        WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "')  ")->result_array();
                        $this->show('EN/schools/DedicatedSurveys/parents', $data);
                    } elseif ($this->input->method() == "post") {
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('Parent', 'Parent', 'trim|required|numeric');
                        $this->form_validation->set_rules('survey', 'survey', 'trim|required|numeric');
                        $this->form_validation->set_rules('students[]', 'students', 'trim|required|multiple_select');
                        $this->form_validation->set_rules('message', 'message', 'trim|required');
                        if ($this->form_validation->run()) {
                            $students = $this->input->post('students');
                            $students_data = array();
                            $survey_insert = array(
                                "user_id" => $this->input->post("Parent"),
                                "survey_id" => $this->input->post("survey"),
                                "message" => $this->input->post("message"),
                                "usertype" => "Parent",
                            );
                            if ($this->db->insert('sv_dedicated_surveys', $survey_insert)) {
                                $insert_id = $this->db->insert_id();
                                foreach ($students as $student) {
                                    $students_data[] = array(
                                        "survey_request" => $insert_id,
                                        "student_id" => $student,
                                    );
                                }
                                if ($this->db->insert_batch("sv_dedicated_surveys_students", $students_data)) {
                                    $this->session->set_flashdata('inserted', 'Your survey has been sent successfully');
                                    redirect('/EN/schools/DedicatedSurveys/success', 'refresh');
                                }
                            }
                        } else {
                            $this->load->model('schools/sv_school_reports');
                            $data['surveys'] = $this->sv_school_reports->Get_surveys($schoolType);
                            $data['parents'] = $this->db->query(" SELECT * FROM l2_parents 
                            WHERE EXISTS (SELECT `l2_student`.`Id` FROM  `l2_student` 
                            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
                            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
                            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
                            WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "')  ")->result_array();
                            $this->show('EN/schools/DedicatedSurveys/parents', $data);
                        }
                    }
                }
            } elseif ($type == "success") {
                $this->show('EN/schools/DedicatedSurveys/success', $data);
            } else {
                redirect('/EN/schools/DedicatedSurveys', 'refresh');
            }
        } else {
            $this->show('EN/schools/DedicatedSurveysType', $data);
        }
    }

    public function av_students_in_class()
    {
        if ($this->input->method() == "post" && $this->input->post('classId')) {
            $students = $this->schoolHelper->stydentsInclass($this->input->post('classId'));
            $data = array();
            foreach ($students as $row) {
                $data[] = array("id" => $row['Id'], "text" => $row['name']);
            }
            $this->response->json($data);
        } else {
            $this->response->json(["status" => "error"]);
        }
    }

    public function av_students_for_parent()
    {
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "post" && $this->input->post('parent_id')) {
            $parent_id = $this->input->post('parent_id');
            $students = $this->db->query("SELECT l2_student.Id, CONCAT( F_name_EN , ' ' , L_name_EN ) AS name FROM  `l2_student` 
            JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
            OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
            JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id`
            WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "' AND `l2_parents`.`Id` = '" . $parent_id . "' ")->result_array();
            $data = array();
            foreach ($students as $row) {
                $data[] = array("id" => $row['Id'], "text" => $row['name']);
            }
            $this->response->json($data);
        } else {
            $this->response->json(["status" => "error"]);
        }
    }

    public function smartqrcode()
    {
        if (!$this->permissions->smart_qr_code()) {
            $this->load->view('EN/Global/disabledPerm', [
                'to' => "EN/schools"
            ]);
            return;
        }
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | smart qr code ";
        if ($this->input->method() == "get") {
            $data['staffs'] = $this->db->get_where("l2_staff", ["Added_By" => $sessiondata['admin_id']])->result_array();
            $data['teachers'] = $this->db->get_where("l2_teacher", ["Added_By" => $sessiondata['admin_id']])->result_array();
            $data['students'] = $this->db->get_where("l2_student", ["Added_By" => $sessiondata['admin_id']])->result_array();
            $this->show('EN/schools/smart_qr_code', $data);
        } else {
            if ($this->input->post("users")) {
                foreach ($this->input->post("users") as $sn => $user) {
                    $user = explode(":", $user);
                    $type = $user[0];
                    $user_id = $user[1];
                    // getteing data based on the user type
                    if ($type == "staff") {
                        $userdata = $this->db->get_where("l2_staff", ["Id" => $user_id])->result_array()[0];
                    } elseif ($type == "teacher") {
                        $userdata = $this->db->get_where("l2_teacher", ["Id" => $user_id])->result_array()[0];
                    } else {
                        $userdata = $this->db->get_where("l2_student", ["Id" => $user_id])->result_array()[0];
                    }
                    $this->load->view('EN/schools/inc/smart_qr_card', ['userdata' => $userdata, "sn" => $sn]);
                }
            } elseif ($this->input->post("classes")) {
                $users = $this->db->query("SELECT * FROM l2_student WHERE Class IN (" . implode(',', $this->input->post("classes")) . ") AND Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array();
                foreach ($users as $sn => $userdata) {
                    $this->load->view('EN/schools/inc/smart_qr_card', ['userdata' => $userdata, "sn" => $sn]);
                }
            }
        }
    }

    public function attendees_reports()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Attendees reports ";
        $data['data'] = array();
        $data['messages'] = $this->db->get("r_messages")->result_array();
        //$data['Vehicles'] = $this->db->where("Added_By", $sessiondata['admin_id'])->get("l2_vehicle")->result_array();
        // Retrieve vehicles where Added_By matches admin_id
        $vehiclesWithDriversHelpers = $this->db
            ->select('l2_vehicle.*, COUNT(l2_vehicle_drivers.Id) AS driver_count, COUNT(l2_vehicle_helpers.Id) AS helper_count')
            ->from('l2_vehicle')
            ->join('l2_vehicle_drivers', 'l2_vehicle_drivers.car_id = l2_vehicle.Id', 'left')
            ->join('l2_vehicle_helpers', 'l2_vehicle_helpers.car_id = l2_vehicle.Id', 'left')
            ->where('l2_vehicle.Added_By', $sessiondata['admin_id'])
            ->group_by('l2_vehicle.Id')
            ->get()
            ->result_array();

        $data['Vehicles'] = [];
        foreach ($vehiclesWithDriversHelpers as $vehicle) {
            // Check if both driver_count and helper_count are 0
            if ($vehicle['driver_count'] == 0 && $vehicle['helper_count'] == 0) {
                // Add font color for no related data
                $vehicle['font_color'] = 'red'; // For example, setting the font color to red
            } else {
                $vehicle['font_color'] = 'black'; // Default font color if data is found
            }
            $data['Vehicles'][] = $vehicle;
        }
        // end update
        if ($this->input->method() == "get") {
            $data['activevichel'] = "--";
            $attendees_date = date("Y-m-d");
        } else {
            $attendees_date = $this->input->post("attendees_date");
            $vichelid = $this->input->post("vichelid");
            $data['activevichel'] = $vichelid;
            $data['Vehicle_data'] = $this->db->query("SELECT *  , (SELECT D_Id FROM `l2_devices` WHERE `l2_devices`.`car_id` = `l2_vehicle`.`Id` AND `l2_devices`.`Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY Id DESC LIMIT 1 ) AS `watch_mac`
            FROM  `l2_vehicle`
            WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND (EXISTS (SELECT Id FROM l2_vehicle_drivers WHERE `car_id` = `l2_vehicle`.`Id`) 
            OR EXISTS (SELECT Id FROM l2_vehicle_helpers WHERE `car_id` = `l2_vehicle`.`Id`) ) AND `l2_vehicle`.`Id` = '" . $vichelid . "' ")->result_array();
            $data['data']['Student'] = $this->db->query("SELECT CONCAT( `l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN` ) AS username ,
            IF((SELECT Id FROM `l2_attendance_result` WHERE `UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student'
            AND `l2_attendance_result`.`Created` = '" . $attendees_date . "'  LIMIT 1 ) IS NULL , 'absent', 'present') as Attendees_status ,
            `l2_attendance_result`.`Created` AS date , l2_avatars.Link AS avatar , `l2_attendance_result`.`Device_first` AS Device , `l2_student`.`Id` AS userid  ,
            (SELECT MIN(`l2_attendance_result`.`TimeStamp`) FROM `l2_attendance_result` 
            WHERE `UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student' AND `l2_attendance_result`.`Created` = '" . $attendees_date . "' LIMIT 1 ) AS datetime 
            FROM `l2_vehicle`
            JOIN `l2_vehicle_students` ON `l2_vehicle_students`.`car_id` = `l2_vehicle`.`Id` 
            JOIN `l2_student` ON `l2_student`.`Id` = `l2_vehicle_students`.`student_id`
            LEFT JOIN `l2_attendance_result` ON `l2_attendance_result`.`UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student'
            LEFT JOIN l2_avatars ON `l2_avatars`.`For_User` = l2_student.Id AND Type_Of_User = 'Student'
            WHERE `l2_vehicle`.`Id` = '" . $vichelid . "' AND `l2_vehicle`.`Added_By` =  '" . $sessiondata['admin_id'] . "' GROUP BY `l2_student`.`Id` ")->result_array();
            $data['countall'] = sizeof($data["data"]['Student']);
        }
        $data['attendees_date'] = $attendees_date;
        // views
        $this->show('EN/schools/Attendees_reports', $data);
    }

    public function Attendees_By_class_reports()
    {
        $this->load->library('form_validation');
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data['page_title'] = "QlickSystems | Attendees reports ";
        $data['data'] = array();
        if ($this->input->method() == "get") {
            $data['activeclass'] = "--";
            $attendees_date = date("Y-m-d");
        } else {
            $attendees_date = $this->input->post("attendees_date");
            $class = $this->input->post("class");
            $grade = $this->input->post("grade");
            $data['classdata'] = $this->db->query("SELECT * , `r_levels`.`Class` AS Class , `r_levels`.`Id` AS Id  FROM l2_school_classes
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_school_classes`.`class_key`
            WHERE `l2_school_classes`.`school_id` = '" . $sessiondata['admin_id'] . "' AND `r_levels`.`Id` = '" . $class . "' ORDER BY `r_levels`.`Id` ASC ")->result_array();
            $data['activeclass'] = $class;
            $data['Vehicle_data'] = $this->db->query("SELECT *  , (SELECT D_Id FROM `l2_devices` WHERE `l2_devices`.`car_id` = `l2_vehicle`.`Id` AND `l2_devices`.`Added_By` = '" . $sessiondata['admin_id'] . "' ORDER BY Id DESC LIMIT 1 ) AS `watch_mac`
            FROM  `l2_vehicle`
            WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' 
            AND (EXISTS (SELECT Id FROM l2_vehicle_drivers WHERE `car_id` = `l2_vehicle`.`Id`) 
            OR EXISTS (SELECT Id FROM l2_vehicle_helpers WHERE `car_id` = `l2_vehicle`.`Id`) ) ")->result_array();
            $data['data']['Student'] = $this->db->query("SELECT CONCAT( `l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN` ) AS username , `l2_student`.`Id` AS userid ,
            IF((SELECT Id FROM `l2_attendance_result` WHERE `UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student'
            AND `l2_attendance_result`.`Created` = '" . $attendees_date . "' LIMIT 1 ) IS NULL , 'absent', 'present') as Attendees_status  ,  l2_avatars.Link AS avatar ,
            (SELECT MIN(`l2_attendance_result`.`TimeStamp`) FROM `l2_attendance_result` 
            WHERE `UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student' AND `l2_attendance_result`.`Created` = '" . $attendees_date . "' LIMIT 1 ) AS datetime 
            FROM `l2_student` 
            LEFT JOIN `l2_attendance_result` ON `l2_attendance_result`.`UserId` = `l2_student`.`Id` AND `l2_attendance_result`.`UserType` = 'Student'
            LEFT JOIN l2_avatars ON `l2_avatars`.`For_User` = l2_student.Id AND Type_Of_User = 'Student'
            WHERE `l2_student`.`Added_by` = '" . $sessiondata['admin_id'] . "' AND `l2_student`.`Class` = '" . $class . "' AND `l2_student`.`Grades` = '" . $grade . "' GROUP BY `l2_student`.`Id` ")->result_array();
            $data['countall'] = sizeof($data["data"]['Student']);
        }
        $data['attendees_date'] = $attendees_date;
        // views
        $this->show('EN/schools/Attendees_reports_by_class', $data);
    }

    public function attendees_actions()
    {
        if ($this->uri->segment(4) == "present") {
            if ($this->input->post('userId') && $this->input->post('device')) {
                $data = [
                    "UserId" => $this->input->post('userId'),
                    "UserType" => "Student",
                    "Device" => $this->input->post('device'),
                    "Added_By" => "Smart GateWay",
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s")
                ];
                if ($this->db->insert("l2_gateway_result", $data)) {
                    echo "ok";
                }
            }
        } else if ($this->uri->segment(4) == "absent") {
            if ($this->input->post('userId') && $this->input->post('device')) {
                $userdata = $this->db->get_where("l2_student", ["Id" => $this->input->post('userId')])->result_array();
                $message = $this->db->get_where("r_messages", ["Id" => '11'])->result_array();
                if (!empty($userdata) && !empty($message)) {
                    $userdata = $userdata[0];
                    $data = [
                        "UserId" => $this->input->post('userId'),
                        "UserType" => "Student",
                        "DeviceType" => "Manual",
                        "Added_By" => "Manual",
                        "National_Id" => $userdata['National_Id'],
                        "Parent_NID_1" => $userdata['Parent_NID'],
                        "Parent_NID_2" => $userdata['Parent_NID_2'],
                        "Device" => $this->input->post('device'),
                        "Result" => 0,
                        "Humidity" => 0,
                        "Created" => date("Y-m-d"),
                        "Time" => date("H:i:s"),
                        "Message_EN" => $userdata['F_name_EN'] . " " . $userdata['M_name_EN'] . " " . $userdata['L_name_EN'] . " " . $message[0]["message_en"],
                        "Message_AR" => $userdata['F_name_AR'] . " " . $userdata['M_name_AR'] . " " . $userdata['L_name_AR'] . " " . $message[0]["message_ar"],
                        "Message_code" => '11',
                        "Status" => '1'
                    ];
                    if ($this->db->insert("v_notification_for_Mobile_app", $data)) {
                        echo "ok";
                    }
                } else {
                    echo "error";
                }
            }
        } else if ($this->uri->segment(4) == "late") {
            if ($this->input->post('userId') && $this->input->post('device')) {
                $data = [
                    "UserId" => $this->input->post('userId'),
                    "UserType" => "Student",
                    "Device" => $this->input->post('device'),
                    "Added_By" => "Smart GateWay",
                    "Created" => date("Y-m-d"),
                    "Time" => date("H:i:s")
                ];
                if ($this->db->insert("l2_gateway_result", $data)) {
                    echo "ok";
                }
            }
        }
    }

    public function l3_config()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | L3 config';
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        if (!$this->uri->segment(4)) {
            $this->load->view('EN/schools/l3_config');
        } elseif ($this->uri->segment(4) && in_array($this->uri->segment(4), ['Student', 'Teacher', 'Parent', 'Staff'])) {
            $data['usertype'] = $this->uri->segment(4);
            $this->load->view('EN/schools/l3_config/choose_configtype', $data);
        }
        $this->load->view('EN/inc/footer');
    }

    public function manage_about_us()
    {
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = 'Qlick Health | manage articles';
            $data['sessiondata'] = $sessiondata;
            $data['data'] = $this->db->get_where("l3_about_us", ["school_id" => $sessiondata['admin_id'], "targeted_users" => $this->uri->segment(4)])->result_array();
            $data["classes"] = $this->schoolHelper->school_classes();
            $data["type"] = $this->uri->segment(4);
            $this->show('EN/schools/l3_config/manage_about_us', $data);
        } elseif ($this->input->method() == "post") {
            if ($this->input->post("add")) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('en_title', 'English Title', 'trim|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('en_article', 'English article', 'trim|min_length[15]');
                $this->form_validation->set_rules('ar_title', 'Arabic Title', 'trim|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('ar_article', 'Arabic article', 'trim|min_length[15]');
                if ($this->form_validation->run()) {
                    // Set preference
                    $config['upload_path'] = './uploads/l3_about_us/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = '51200'; // max_size in kb
                    $config['encrypt_name'] = true;
                    //Load upload library
                    $this->load->library('upload', $config);
                    // File upload
                    $filesnames = [];
                    if (isset($_FILES["en_image"]) && !empty($_FILES['en_image']['tmp_name'][0])) {
                        if ($this->upload->do_upload('en_image')) {
                            $filesnames["en"] = $this->upload->data()['file_name'];
                        } else {
                            echo $this->upload->display_errors();
                            exit();
                        }
                    }
                    if (isset($_FILES["ar_image"]) && !empty($_FILES['ar_image']['tmp_name'][0])) {
                        if ($this->upload->do_upload('ar_image')) {
                            $filesnames["ar"] = $this->upload->data()['file_name'];
                        } else {
                            echo $this->upload->display_errors();
                            exit();
                        }
                    }
                    // for students
                    $classes = "";
                    $grades = "";
                    $t = $this->uri->segment(4);
                    if (strtolower(empty($t) ? '' : $t) == "students") {
                        if ($this->input->post("classes") && !empty($this->input->post("classes"))) {
                            $classes = implode(",", $this->input->post("classes"));
                        }
                        if ($this->input->post("grades") && !empty($this->input->post("grades"))) {
                            $grades = implode(",", $this->input->post("grades"));
                        }
                    }
                    // data saving
                    $save_data = [
                        "En_title" => $this->input->post('en_title') ?? "",
                        "Ar_title" => $this->input->post('ar_title') ?? "",
                        "En_article" => $this->input->post('en_article') ?? "",
                        "Ar_article" => $this->input->post('ar_article') ?? "",
                        "targeted_users" => $this->uri->segment(4),
                        "school_id" => $sessiondata['admin_id'],
                        "en_image" => $filesnames["en"] ?? "",
                        "ar_image" => $filesnames["ar"] ?? "",
                        "classes" => $classes,
                        "grades" => $grades,
                    ];
                    if ($this->db->insert("l3_about_us", $save_data)) {
                        echo "ok";
                    } else {
                        echo "sorry !! we have an error";
                    }
                } else {
                    echo validation_errors();
                }
            } else if ($this->input->post("article") && $this->input->post("lang")) {
                $response = $this->db->get_where("l3_about_us", ["Id" => $this->input->post("article")])->result_array();
                if (!empty($response)) {
                    if ($this->input->post("lang") == "en") {
                        echo $response[0]["En_article"];
                    } else {
                        echo $response[0]["Ar_article"];
                    }
                } else {
                    echo "sorry !! we can't find any data ";
                }
            }
        } elseif ($this->input->method() == "delete") {
            if ($this->input->input_stream('id')) {
                $id = $this->input->input_stream('id');
                $this->db->where('Id', $id);
                if ($this->db->delete('l3_about_us')) {
                    echo 'ok';
                } else {
                    echo $this->db->last_query();
                }
            }
        } elseif ($this->input->method() == "put") {
            try {
                $title = $this->input->input_stream('title');
                $id = $this->input->input_stream('id');
                $this->db->where("Id", $id)->set("En_title", $title)->update("l3_about_us");
                echo "ok";
            } catch (Throwable $th) {
                echo "error";
            }
        }
    }

    public function about_us_date()
    {
        try {
            $data = [
                'datefrom' => $this->input->post("from"),
                'dateto' => $this->input->post("to"),
            ];
            $this->db->where("Id", $this->input->post("target"))->set($data)->update("l3_about_us");
            $this->response->json(['status' => "ok"]);
        } catch (Throwable $th) {
            $this->response->json(['status' => "error"]);
        }
    }

    public function about_us_status()
    {
        try {
            $this->db->where("Id", $this->input->post("target"))->set(['status' => $this->input->post("status") == "true" ? 1 : 0])->update("l3_about_us");
            $this->response->json(['status' => "ok"]);
        } catch (Throwable $th) {
            $this->response->json(['status' => "error"]);
        }
    }

    public function edit_about_us()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['id'] = $this->uri->segment(4);
        if ($this->input->method() == "get") {
            $data['page_title'] = 'Qlick Health | Edit articles';
            $data['sessiondata'] = $sessiondata;
            $data['data'] = $this->db->get_where("l3_about_us", ["school_id" => $sessiondata['admin_id'], "Id" => $data['id']])->result_array();
            if (!empty($data['data'])) {
                $data['data'] = $data['data'][0];
                $this->show('EN/schools/l3_config/edit_about_us', $data);
            } else {
                redirect("EN/schools/L3_config");
            }
        } elseif ($this->input->method() == "post") {
            if ($this->input->post("action")) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('en_title', 'English Title', 'trim|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('en_article', 'English article', 'trim|min_length[15]');
                $this->form_validation->set_rules('ar_title', 'Arabic Title', 'trim|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('ar_article', 'Arabic article', 'trim|min_length[15]');
                if ($this->form_validation->run()) {
                    // Set preference
                    $config['upload_path'] = './uploads/l3_about_us/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = '51200'; // max_size in kb
                    $config['encrypt_name'] = true;
                    //Load upload library
                    $this->load->library('upload', $config);
                    // File upload
                    $filesnames = [];
                    if (isset($_FILES["en_image"]) && !empty($_FILES['en_image']['tmp_name'][0])) {
                        if ($this->upload->do_upload('en_image')) {
                            $filesnames["en"] = $this->upload->data()['file_name'];
                        } else {
                            echo $this->upload->display_errors();
                            exit();
                        }
                    }
                    if (isset($_FILES["ar_image"]) && !empty($_FILES['ar_image']['tmp_name'][0])) {
                        if ($this->upload->do_upload('ar_image')) {
                            $filesnames["ar"] = $this->upload->data()['file_name'];
                        } else {
                            echo $this->upload->display_errors();
                            exit();
                        }
                    }
                    $save_data = [
                        "En_title" => $this->input->post('en_title') ?? "",
                        "Ar_title" => $this->input->post('ar_title') ?? "",
                        "En_article" => $this->input->post('en_article') ?? "",
                        "Ar_article" => $this->input->post('ar_article') ?? "",
                        "school_id" => $sessiondata['admin_id'],
                        "en_image" => $filesnames["en"] ?? "" ?? "",
                        "ar_image" => $filesnames["ar"] ?? "",
                    ];
                    // check if any image updated
                    if (isset($filesnames["en"])) {
                        $save_data['en_image'] = $filesnames["en"];
                    }
                    if (isset($filesnames["ar"])) {
                        $save_data['ar_image'] = $filesnames["ar"];
                    }
                    // updating data
                    $this->db->set($save_data);
                    $this->db->where('Id', $data['id']);
                    if ($this->db->update("l3_about_us", $save_data)) {
                        echo "ok";
                    } else {
                        echo "sorry !! we have an error";
                    }
                } else {
                    echo validation_errors();
                }
            }
        }
    }

    public function Attendees_times_manage()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('m_from', 'Morning start time', 'trim');
        $this->form_validation->set_rules('m_to', 'Morning out time', 'trim');
        $this->form_validation->set_rules('a_from', 'afertnoon start time', 'trim');
        $this->form_validation->set_rules('a_to', 'afertnoon out time', 'trim');
        $this->form_validation->set_rules('n_from', 'night start time', 'trim');
        $this->form_validation->set_rules('n_to', 'night out time', 'trim');
        $this->form_validation->set_rules('graceperiod', 'grace period time', 'trim');
        if ($this->form_validation->run()) {
            $old = $this->db->get_where("r_attendance_rule", ["Added_By" => $sessiondata['admin_id'], "Action" => "School"])->result_array();
            if (!empty($old)) {
                $old_id = $old[0]['Id'];
                $data = [
                    "rule_a_in" => $this->input->post('m_from') ?? "",
                    "rule_a_out" => $this->input->post('m_to') ?? "",
                    "rule_b_in" => $this->input->post('a_from') ?? "",
                    "rule_b_out" => $this->input->post('a_to') ?? "",
                    "rule_c_in" => $this->input->post('n_from') ?? "",
                    "rule_c_out" => $this->input->post('n_to') ?? "",
                    "grace_period" => $this->input->post('graceperiod') ?? "",
                ];
                $this->db->set($data);
                $this->db->where('Id', $old_id);
                if ($this->db->update("r_attendance_rule")) {
                    echo "ok";
                }
            } else {
                $data = [
                    "rule_a_in" => $this->input->post('m_from'),
                    "rule_a_out" => $this->input->post('m_to'),
                    "rule_b_in" => $this->input->post('a_from'),
                    "rule_b_out" => $this->input->post('a_to'),
                    "rule_c_in" => $this->input->post('n_from'),
                    "rule_c_out" => $this->input->post('n_to'),
                    "grace_period" => $this->input->post('graceperiod'),
                    "Action" => "School",
                    "Added_By" => $sessiondata['admin_id']
                ];
                if ($this->db->insert('r_attendance_rule', $data)) {
                    echo "ok";
                }
            }
        } else {
            echo validation_errors();
        }
    }

    public function monitor_2()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Monitor 2';
        $data['sessiondata'] = $sessiondata;
        $data['results']['staff'] = $this->db->query("SELECT CONCAT(`l2_staff`.`F_name_EN` , ' ' , `l2_staff`.`L_name_EN`) AS username ,  `l2_staff`.`Id` AS userid , `l2_staff`.`Action` AS useraction , `l2_avatars`.`Link` AS useravatar , `l2_result`.* 
        FROM `l2_staff` 
        JOIN `l2_result` ON `l2_result`.`UserType` = 'Staff' AND `l2_result`.`UserId` = `l2_staff`.`Id`
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_staff`.`Id` AND `l2_avatars`.`Type_Of_User` = 'staff'
        WHERE `l2_staff`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `l2_result`.`Id` ")->result_array();
        $data['results']['teachers'] = $this->db->query("SELECT CONCAT(`l2_teacher`.`F_name_EN` , ' ' , `l2_teacher`.`L_name_EN`) AS username ,  `l2_teacher`.`Id` AS userid , `l2_teacher`.`Action` AS useraction , `l2_avatars`.`Link` AS useravatar , `l2_result`.* 
        FROM `l2_teacher` 
        JOIN `l2_result` ON `l2_result`.`UserType` = 'Teacher' AND `l2_result`.`UserId` = `l2_teacher`.`Id`
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_teacher`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Teacher'
        WHERE `l2_teacher`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `l2_result`.`Id` ")->result_array();
        $data['results']['students'] = $this->db->query("SELECT CONCAT(`l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN`) AS username ,  `l2_student`.`Id` AS userid , `l2_student`.`Action` AS useraction , `l2_avatars`.`Link` AS useravatar , `l2_result`.* 
        FROM `l2_student` 
        JOIN `l2_result` ON `l2_result`.`UserType` = 'Student' AND `l2_result`.`UserId` = `l2_student`.`Id`
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_student`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Student'
        WHERE `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `l2_result`.`Id` ")->result_array();
        $this->show('EN/schools/monitor_2', $data);
    }

    public function health_record()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            $data['id'] = $this->uri->segment(4);
            $data['health_record'] = $this->db->get_where('student_health_record', ["UserId" => $data['id']])->result_array();
            if ($this->input->method() == "post" && $this->input->post('date') && $this->input->post('type')) {
                if (in_array($this->input->post('type'), ["Elementary", "Intermediate", "High", "Seniorhighschool"])) {
                    $action = array($this->input->post('type') => $this->input->post('date'));
                    if (!empty($data['health_record'])) {
                        $this->db->set($action);
                        $this->db->where('Id', $data['health_record'][0]["Id"]);
                        if ($this->db->update('student_health_record')) {
                            $this->response->json(['status' => "ok"]);
                        } else {
                            $this->response->json(['status' => "error"]);
                        }
                    } else {
                        $action['UserId'] = $data['id'];
                        if ($this->db->insert('student_health_record', $action)) {
                            $this->response->json(['status' => "ok"]);
                        } else {
                            $this->response->json(['status' => "error"]);
                        }
                    }
                } else {
                    $this->response->json(['status' => "error"]);
                }
            } else {
                $data['page_title'] = 'Qlick Health | health record';
                $data['student'] = $this->db->query("SELECT l2_student.* ,  `l2_avatars`.`Link` AS useravatar  , `r_levels`.`Class` as className , 
                `l2_student`.`DOP` ,`l2_student`.`Gender` 
                FROM `l2_student`
                LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_student`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Student'
                JOIN r_levels ON r_levels.id = l2_student.Class
                WHERE `l2_student`.`Id` = '" . $data['id'] . "' AND `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $data['medical_status'] = $this->db->get_where('student_medical_status', ["UserId" => $data['id']])->result_array();
                $data['examination_code'] = $this->db->get_where('student_physicians_examination_code', ["UserId" => $data['id']])->result_array();
                $data['dental_examinations'] = $this->db->get_where('student_dental_examination', ["UserId" => $data['id']])->result_array();
                $data['vaccines'] = $this->db->query("SELECT * FROM `student_vaccines` 
                JOIN `r_vaccines` ON `r_vaccines`.`Id` = `student_vaccines`.`VaccinesId`
                WHERE `student_vaccines`.`UserId` = '" . $data['id'] . "' ")->result_array();
                $data['Signatures'] = $this->db->get_where('student_health_history_comments', ["UserId" => $data['id']])->result_array();
                if (!empty($data['student'])) {
                    $data['student'] = $data['student'][0];
                    if (!empty($data['medical_status'])) {
                        $data['medical_status'] = $data['medical_status'][0];
                    } else {
                        $data['medical_status'] = array(
                            "Allergy" => 0,
                            "Asthma" => 0,
                            "Behavioral_Problems" => 0,
                            "Cancer_Leukemia" => 0,
                            "Chronic_Cough_Wheezing" => 0,
                            "Diabetes" => 0,
                            "Hearing_Problems" => 0,
                            "Heart_Disease" => 0,
                            "Hemophilia" => 0,
                            "Hypertension" => 0,
                            "JRA_Arthritis" => 0,
                            "Rheumatic_Heart" => 0,
                            "Seizures" => 0,
                            "Sickle_Cell_Anemia" => 0,
                            "Skin_Problems" => 0,
                            "Vision_Problem" => 0
                        );
                    }
                    if (!empty($data['health_record'])) {
                        $data['health_record'] = $data['health_record'][0];
                    } else {
                        $data['health_record'] = array();
                    }
                    $data['hearing_tests'] = $this->db->where("UserId", $data['id'])->where("UserType", 'Student')->get("student_hearing_test")->result();
                    $data['vision_tests'] = $this->db->where("UserId", $data['id'])->where("UserType", 'Student')->get("student_visions_test")->result();
                    $data['visions_color'] = $this->db->get("r_visions_color")->result_array();
                    $this->show('EN/schools/health_record', $data);
                } else {
                    redirect('/EN/schools/listOfStudents');
                }
            }
        } else {
            redirect('/EN/schools/listOfStudents');
        }
    }

    public function Public_Visitors()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $prms = $this->db->query(" SELECT `v0_permissions`.`visitors` , `v0_permissions`.`Created`
        FROM `l1_school` 
        JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
        JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
        AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
        WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
        if (!empty($prms)) {
            $permission = $prms[0];
        } else {
            $permission = "";
        }
        $data['visitors'] = $this->db->query(" SELECT 
        `l2_visitors`.`Id` AS user_id,
        `l2_visitors`.`F_name_EN` AS full_name,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`Added_By` AS Added_By,
        `l2_visitors`.`watch_mac` AS watch_mac,
        `l2_visitors`.`machine_mac` AS machine_mac
        FROM `l2_visitors`  ")->result_array();
        if (!empty($permission) && $permission['visitors'] == '1') {
            $this->show('EN/schools/Public_Visitors', $data);
        } else {
            $dataDes['to'] = "EN/schools";
            $this->load->view('EN/Global/disabledPerm', $dataDes);
        }
    }

    public function Visitors()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['visitors'] = $this->db->query(" SELECT 
        `l2_visitors`.`Id` AS user_id,
        `l2_visitors`.`F_name_EN` AS full_name,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`National_Id` AS National_Id,
        `l2_visitors`.`Added_By` AS Added_By,
        `l2_visitors`.`watch_mac` AS watch_mac,
        `l2_visitors`.`machine_mac` AS machine_mac
        FROM `l2_visitors` 
        JOIN `l2_devices` ON `l2_devices`.`D_Id` = `l2_visitors`.`machine_mac`
        AND `l2_devices`.`Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        $this->show('EN/schools/Visitors', $data);
    }

    public function visitor_report()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        $data['visitors_results'] = $this->db->query(" SELECT * ,
        `l2_visitors_result`.`TimeStamp` AS result_time
        FROM `l2_visitors` 
        RIGHT JOIN `l2_visitors_result`  ON `l2_visitors`.`Id` = `l2_visitors_result`.`UserId` ")->result_array();
        $data['start'] = date('Y-m-d');
        $data['end'] = date('Y-m-d');
        $this->show('EN/schools/visitors_reports', $data);
    }

    public function add_visitor()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Add Members";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $id = $this->uri->segment(4);
                $valid = false;
                $exist = false;
                $data['user_data'] = $this->db->query(" SELECT 
                `Id` AS user_id,
                `F_name_EN` AS full_name,
                `National_Id` AS National_Id,
                `Added_By` AS Added_By,
                `watch_mac` AS watch_mac,
                `machine_mac` AS machine_mac,
                `phone`,
                `DOP`
                FROM `l2_visitors` WHERE `Id` = '" . $id . "' ")->row();
                if (!empty($data['user_data'])) {
                    $valid = true;
                    $data['dop'] = date("d-m-Y", strtotime($data['user_data']->DOP));
                }
            }
            if ($valid) {
                $data['added_areas'] = $this->db->query("SELECT 
                `air_areas`.`mac_adress` ,
                `air_areas`.`Description` ,
                `air_areas`.`TimeStamp`  AS Added_in ,
                CONCAT(`r_sites`.`Site_Name`,' - ',`r_sites`.`Site_Code`) AS Site_name
                FROM `air_areas` 
                JOIN `r_sites` ON `r_sites`.`Id` = `air_areas`.`Site_Id` 
                WHERE `air_areas`.`source_id` = '" . $sessiondata['admin_id'] . "' AND `air_areas`.`user_type` = 'school' ")->result_array();
                $data['sites'] = $this->db->query("SELECT * FROM `l2_site` WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $data['vehicles'] = $this->db->query("SELECT `l2_vehicle`.* , `l2_vehicle_type`.`type` AS type_vehicle FROM `l2_vehicle` 
                LEFT JOIN `l2_vehicle_type` ON `l2_vehicle_type`.`Id` = `l2_vehicle`.`type_vehicle`
                WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
                $data['av_relationships'] = $this->db->query("SELECT * FROM `l2_martial_status`")->result_array();
                $data["vehicle_types"] = $this->db->get('l2_vehicle_type')->result_array();
                $data['Positions'] = $this->db->query("SELECT * FROM `r_positions_sch`")->result_array();
                $data['Positions_tech'] = $this->db->query("SELECT * FROM `r_positions_tech`")->result_array();
                $data['prms'] = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
                FROM `l1_school` 
                JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
                JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
                AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
                AND  `v0_permissions`.`Air_quality` = '1'
                WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                $data['cars_permissions'] = $this->db->query(" SELECT `v0_permissions`.`Air_quality` , `v0_permissions`.`Created`
                FROM `l1_school` 
                JOIN `l0_organization` ON `l1_school`.`Added_By` = `l0_organization`.`Id` 
                JOIN `v0_permissions` ON `v0_permissions`.`user_id` = `l0_organization`.`id`
                AND  `v0_permissions`.`user_type` = `l0_organization`.`Type`
                AND  `v0_permissions`.`cars` = '1'
                WHERE  `l1_school`.`Id` = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                $data['classes'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
                $data["vehicle_types"] = $this->db->get('l2_vehicle_type')->result_array();
                $this->load->view('EN/inc/header', $data);
                if ($this->uri->segment(5) && in_array($this->uri->segment(5), ['staff', 'teacher', 'Student'])) {
                    $this->load->view('EN/schools/add_Visitor_forms/' . $this->uri->segment(5));
                } else {
                    $this->load->view('EN/schools/add_Visitor', ["id" => $this->uri->segment(4)]);
                }
                $this->load->view('EN/inc/footer');
            } else {
                redirect('EN/schools/Visitors');
            }
        } else if ($this->input->method() == "delete") {
            $id = $this->uri->segment(4);
            $this->db->delete("l2_visitors", ['Id' => $id]);
        }
    }

    public function update_visitor()
    { // this function creted for cobtroling not added visitors -- link from visitor_report -- for all
        $sessiondata = $this->session->userdata('admin_details');
        if ($this->input->method() == "get") {
            $data['page_title'] = "Qlick Health | update data ";
            $data['sessiondata'] = $sessiondata;
            if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
                $id = $this->uri->segment(4);
                $valid = false;
                $exist = false;
                $data['user_data'] = $this->db->query(" SELECT 
                    `Id` AS user_id,
                    `F_name_EN` AS full_name,
                    `National_Id` AS National_Id,
                    `Added_By` AS Added_By,
                    `watch_mac` AS watch_mac,
                    `machine_mac` AS machine_mac,
                    `phone`,
                    `DOP`
                    FROM `l2_visitors` WHERE `Id` = '" . $id . "' ")->result_array();
                if (!empty($data['user_data'])) {
                    $valid = true;
                    $data['dop'] = date("d-m-Y", strtotime($data['user_data'][0]['DOP']));
                }
            }
            $this->show('EN/schools/update_visitor', $data);
        } elseif ($this->input->method() == "post") {
            $this->load->library('form_validation');
            $sessiondata = $this->session->userdata('admin_details');
            if ($this->input->get('visitor_key')) {
                $is_req = "trim|required|is_unique[v_nationalids.National_Id]";
                $request_type = "update";
                $user_id = $this->input->get('visitor_key');
            } else {
                $is_req = "trim|is_unique[v_nationalids.National_Id]|is_unique[l2_visitors.National_Id]";
                $request_type = "add";
            }
            $this->form_validation->set_rules('Name', 'Name', $is_req);
            $this->form_validation->set_rules('National_Id', 'National Id', $is_req);
            $this->form_validation->set_rules('DOP', 'DOP', $is_req);
            if ($this->form_validation->run()) {
                $name = empty($this->input->post('Name')) ? "" : $this->input->post('Name');
                $National_Id = empty($this->input->post('National_Id')) ? "" : $this->input->post('National_Id');
                $DOP = empty($this->input->post('DOP')) ? "" : $this->input->post('DOP');
                if ($request_type == "add") {
                    $isert_data = array(
                        "F_name_EN" => $name,
                        "National_Id" => $National_Id,
                        "DOP" => $DOP,
                    );
                    if ($this->db->insert('l2_visitors', $isert_data)) {
                        echo "ok";
                    }
                } else {
                    $this->db->set('F_name_EN', $name);
                    $this->db->set('National_Id', $National_Id);
                    $this->db->set('DOP', $DOP);
                    $this->db->where('Id', $user_id);
                    if ($this->db->update('l2_visitors')) {
                        echo "ok";
                    }
                }
            } else {
                echo validation_errors();
            }
        }
    }

    public function studentscards()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | STUDENTS CARDS';
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "post") {
            $data['activeclass'] = $this->input->post("class");
            $data['students'] = $this->db->query("SELECT CONCAT(`l2_student`.`F_name_EN`,' ',`l2_student`.`L_name_EN`) AS `name` ,  `l2_avatars`.`Link` AS useravatar  ,
            `l2_student`.`DOP` ,`l2_student`.`Gender` , `l2_result`.* 
            FROM `l2_result`
            JOIN `l2_student` ON `l2_result`.`UserId` = `l2_student`.`Id` AND `l2_result`.`UserType` = 'Student' 
            LEFT JOIN `l2_avatars` ON `l2_avatars`.`For_User` = `l2_student`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Student'
            WHERE `l2_student`.`Class` = '" . $data['activeclass'] . "' AND `l2_student`.`Added_By` = '" . $sessiondata['admin_id'] . "' GROUP BY `l2_student`.`Id` ORDER BY `l2_student`.`F_name_EN` DESC  ")->result();
            // $this->response->dd($data['students']);
        } else {
            $data['activeclass'] = 0;
        }
        $this->show('EN/schools/studentscardsreport', $data);
    }

    public function Category_pdf()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Categories PDF';
        $data['sessiondata'] = $sessiondata;
        $data['categories'] = $this->db->query("SELECT sv_st_category.* ,
        `sv_st_categories_reports_files`.`Staff_file_en` , `sv_st_categories_reports_files`.`Staff_file_ar` ,
        `sv_st_categories_reports_files`.`Teacher_file_en`,`sv_st_categories_reports_files`.`Teacher_file_ar`,
        `sv_st_categories_reports_files`.`Parent_file_en` , `sv_st_categories_reports_files`.`Parent_file_ar`  ,
        `sv_st_categories_reports_files`.`Student_file_en` ,`sv_st_categories_reports_files`.`Student_file_ar` ,( SELECT COUNT(`sv_st_surveys`.`Id`) FROM `sv_st_surveys` WHERE `sv_st_surveys`.`category` = `sv_st_category`.`Id` ) AS counter_of_using 
        FROM `sv_st_category` 
        LEFT JOIN `sv_st_categories_reports_files` ON `sv_st_categories_reports_files`.`Category_id` = `sv_st_category`.`Id`
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
        AND `sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'
        GROUP BY `sv_school_published_surveys`.`Id` )
        /* end exist condition */
        ORDER BY Id ASC")->result_array();
        $this->show('EN/schools/Categories_pdf', $data);
    }

    public function PdfReportGenerator()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | PDF Report';
        $data['sessiondata'] = $sessiondata;
        $data['reports'] = array(
            [
                "preview" => "testpdf.pdf",
                "title" => "Surveys Reports",
            ],
        );
        $this->show('EN/schools/Pdf_Reports_Generator/choose', $data);
    }

    public function Message()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Messages ";
        $data['sessiondata'] = $sessiondata;
        $this->show('EN/Component/Message', $data);
    }

    public function Consultant()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        $this->load->view('EN/inc/header', $data);
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4)) { // show a page
                $Request = $this->uri->segment(4);
                switch ($Request) {
                    case 'chat':
                        $this->ConsultantChat();
                        break;
                    case 'Reports':
                        $this->ConsultantReports();
                        break;
                    case 'Education':
                        $this->ConsultantEducation();
                        break;
                    case 'Plans':
                        $this->ConsultantActionPlans();
                        break;
                    case 'Gallery':
                        $this->ConsultantGallery();
                        break;
                    case 'EducationReports':
                        $this->ConsultantEducationReports();
                        break;
                    default:
                        return redirect('EN/schools/Consultant');
                        break;
                }
            } else { // show routes
                $baseurl = base_url('EN/schools/Consultant/');
                $links = array();
                $links[] = array(
                    "title" => "CH P011: Consultant Reports",
                    "links" => [
                        array(
                            'name' => "Research Articles", "link" => ($baseurl . "Reports"),
                            "desc" => "", "icon" => "con_reports.png"
                        ),
                        array(
                            'name' => "Media Gallery", "link" => ($baseurl . "Gallery"),
                            "desc" => "", "icon" => "con_media.png"
                        ),
//                        array(
//                            'name' => "Education Resources", "link" => ($baseurl . "Education"),
//                            "desc" => "", "icon" => "con_edu.png"
//                        ),
                        array(
                            'name' => "Action Plans", "link" => ($baseurl . "Plans"),
                            "desc" => "", "icon" => "con_action.png"
                        ),
                        array(
                            'name' => "Detailed Reports", "link" => ($baseurl . "EducationReports"),
                            "desc" => "", "icon" => "coneducationr.png"
                        )
                    ]
                );
                $data['links'] = $links;
                $data['page_title'] = "QlickSystems | List all ";
                $this->load->view('EN/Global/Links/Lists', $data);
            }
        }
        $this->load->view('EN/inc/footer');
    }

    private function ConsultantChat()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        if ($this->uri->segment(4) && $this->uri->segment(4) == "chat" && is_numeric($this->uri->segment(5))) {
            // for chat
            $body['fileid'] = $this->uri->segment(5);
            $Consultantdata = $this->db->where('Id', $body['fileid'])->get("l1_consultant_reports")->row();
            if (empty($Consultantdata)) {
                return redirect('EN/schools/Consultant');
            }
            $body['target'] = $Consultantdata->UploadedBy;
            $this->load->view('EN/Component/Consultant/chat', $body);
        } else {
            $body['files'] = $this->db->select('FileName AS link , Created AS UploadedAt , Comments , l1_consultant_reports.Id')
                ->select('(SELECT COUNT(Id) 
                            FROM l0_consultant_chat 
                            WHERE l0_consultant_chat.about = l1_consultant_reports.Id 
                            AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                            AND sender_usertype = "consultant" AND read_at IS NULL) AS UnreadMessages')
                ->from('l1_consultant_reports')
                ->where('AccountId', $sessiondata['admin_id'])
                ->where('AccountType', "S")
                ->get()->result_array();
            $this->load->view('EN/Component/Consultant/list', $body);
        }
    }

    private function ConsultantReports()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            if ($this->uri->segment(4) && $this->uri->segment(4) == "chat" && is_numeric($this->uri->segment(5))) {
                // for chat
                $body['fileid'] = $this->uri->segment(5);
                $Consultantdata = $this->db->where('Id', $body['fileid'])->get("l1_consultant_reports")->row();
                if (empty($Consultantdata)) {
                    return redirect('EN/schools/Consultant');
                }
                $body['target'] = $Consultantdata->UploadedBy;
                $this->load->view('EN/Component/Consultant/chat', $body);
            } else {
                $body['files'] = $this->db->select('FileName AS link , Created AS UploadedAt , Comments , l1_consultant_reports.Id')
                    ->select('(SELECT COUNT(Id) 
                                FROM l0_consultant_chat 
                                WHERE l0_consultant_chat.about = l1_consultant_reports.Id 
                                AND receiver_id = "' . $sessiondata['admin_id'] . '" AND receiver_usertype = "' . $sessiondata['type'] . '"
                                AND sender_usertype = "consultant" AND read_at IS NULL) AS UnreadMessages')
                    ->from('l1_consultant_reports')
                    ->where('AccountId', $sessiondata['admin_id'])
                    ->where('AccountType', "S")
                    ->get()->result_array();
                $this->load->view('EN/Component/Consultant/list', $body);
            }
        }
    }

    private function ConsultantEducation()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['files'] = $this->db->where('AccountId', $sessiondata['admin_id'])->where('AccountType', 'schools')->get('st_sv_categorys_resources')->result_array();
        $data['articles'] = $this->db->where('AccountId', $sessiondata['admin_id'])->where('AccountType', 'schools')->get('st_sv_categorys_articles')->result_array();
        $this->load->view('EN/Component/Consultant/Education', $data);
    }

    private function ConsultantActionPlans()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['files'] = $this->db->where('AccountId', $sessiondata['admin_id'])->where("file_type", "1")->where('AccountType', 'schools')->where("file_language", "EN")->get('l1_category_resources')->result_array();
        $this->load->view('EN/Component/Consultant/ActionPlans', $data);
    }

    private function ConsultantGallery()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['files'] = $this->db->where('AccountId', $sessiondata['admin_id'])->where("langauge", "EN")->where('AccountType', 'schools')->get('sv_st_consultant_media_links')->result_array();
        $this->load->view('EN/Component/Consultant/MediaGallery', $data);
    }

    private function ConsultantEducationReports()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['files'] = $this->db->where('AccountId', $sessiondata['admin_id'])->where("file_language", "EN")->where("file_type", "2")->where('AccountType', 'schools')->get('l1_category_resources')->result_array();
        $this->load->view('EN/Component/Consultant/EducationReports', $data);
    }

    public function Publish_Claimate()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        // source
        $source['levels'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
        $source['genders'] = [
            [
                'name' => 'Male',
                'code' => '1'
            ],
            [
                'name' => 'Female',
                'code' => '2'
            ],
        ];
        if ($this->input->method() == "get") {
            // Stopping the script when the ids isn't defined
            if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
                return redirect('EN/schools/ClaimateSurveys');
            }
            $data['id'] = $this->uri->segment(4);
            if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && in_array($this->uri->segment(5), ['1', '2', '3', '4'])) { // type
                $data['type'] = $this->uri->segment(5);
                $data['show'] = 2;
                $unavalaible['genders'] = $this->db->select('Gender_code')
                    ->from('scl_published_claimate_genders')
                    ->join('scl_published_claimate', 'scl_published_claimate.climate_id = ' . $data['id'] . '')
                    ->join('scl_published_claimate_types', 'scl_published_claimate.Id = scl_published_claimate_types.Climate_id')
                    ->where('By_school', $sessiondata['admin_id'])
                    ->where('scl_published_claimate_genders.Climate_id', 'scl_published_claimate.Id', false)
                    ->where('scl_published_claimate_types.Type_code', $data['type'])
                    ->get()->result_array();
                if (in_array($data['type'], ['2', '3']) && !empty($source['levels'])) {
                    $unavalaible['levels'] = $this->db->select('Level_code')
                        ->from('scl_published_claimate_levels')
                        ->join('scl_published_claimate', 'scl_published_claimate.climate_id = ' . $data['id'] . '')
                        ->join('scl_published_claimate_types', 'scl_published_claimate.Id = scl_published_claimate_types.Climate_id')
                        ->where('By_school', $sessiondata['admin_id'])
                        ->where_in('scl_published_claimate_levels.Level_code', array_column($source['levels'], "Id"))
                        ->where('scl_published_claimate_types.Type_code', $data['type'])
                        ->where('scl_published_claimate_levels.Claimate_id', 'scl_published_claimate.Id', false)
                        ->get()->result_array();
                    $data['levels'] = array_values(array_filter($source['levels'], function ($k) use ($unavalaible) {
                        return !in_array($k['class_key'], array_column($unavalaible['levels'], "Level_code"));
                    }));
                }
                // Filtring
                $data['genders'] = array_filter($source['genders'], function ($k) use ($unavalaible) {
                    return !in_array($k['code'], array_column($unavalaible['genders'], "Gender_code"));
                });
            } else {
                $data['show'] = 1;
                $data['types'] = [
                    [
                        'type' => 'Staff',
                        'code' => '1'
                    ],
                    [
                        'type' => 'Students',
                        'code' => '2'
                    ],
                    [
                        'type' => 'Teachers',
                        'code' => '3'
                    ],
                    [
                        'type' => 'Parents',
                        'code' => '4'
                    ],
                ];
                foreach ($data['types'] as $key => $type) {
                    $d['genders'] = $this->db->select('Gender_code')
                        ->from('scl_published_claimate_genders')
                        ->join('scl_published_claimate', 'scl_published_claimate.climate_id = ' . $data['id'] . '')
                        ->join('scl_published_claimate_types', 'scl_published_claimate.Id = scl_published_claimate_types.Climate_id')
                        ->where('By_school', $sessiondata['admin_id'])
                        ->where('scl_published_claimate_genders.Climate_id', 'scl_published_claimate.Id', false)
                        ->where('scl_published_claimate_types.Type_code', $type['code'])
                        ->get()->result_array();
                    // Filtring
                    $data['genders'] = array_filter($source['genders'], function ($k) use ($d) {
                        return !in_array($k['code'], array_column($d['genders'], "Gender_code"));
                    });
                    if (empty($data['genders'])) {
                        unset($data['types'][$key]);
                    } else if (in_array($type['code'], ['2', '3'])) {
                        $unavalaible['levels'] = $this->db->select('Level_code')
                            ->from('scl_published_claimate_levels')
                            ->join('scl_published_claimate', 'scl_published_claimate.climate_id = ' . $data['id'] . '')
                            ->join('scl_published_claimate_types', 'scl_published_claimate.Id = scl_published_claimate_types.Climate_id')
                            ->where('By_school', $sessiondata['admin_id'])
                            ->where_in('scl_published_claimate_levels.Level_code', array_column($source['levels'], "Id"))
                            ->where('scl_published_claimate_types.Type_code', $type['code'])
                            ->where('scl_published_claimate_levels.Claimate_id', 'scl_published_claimate.Id', false)
                            ->get()->result_array();
                        $data['levels'] = array_values(array_filter($source['levels'], function ($k) use ($unavalaible) {
                            return !in_array($k['class_key'], array_column($unavalaible['levels'], "Level_code"));
                        }));
                        if (empty($data['levels'])) {
                            unset($data['types'][$key]);
                        }
                    }
                }
            }
            $this->show('EN/schools/Publish-Claimate', $data);
        }
    }

    public function climate_dashboard()
    {
        $this->load->model('helper');
        $data['userstypes'] = $this->helper->get();
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = "Qlick Health | Consultant ";
        $data['sessiondata'] = $sessiondata;
        // source
        $data['t'] = 1;
        $data['c'] = 'd';
        $cond = "";
        $today = "'" . date('Y-m-d');
        if ($this->input->method() == "post") {
            $data['t'] = $this->input->post('t');
            $data['c'] = $this->input->post('c');
            $cond = "";
            switch ($data['c']) {
                case 'd':
                    $date = "'" . date('Y-m-d');
                    break;
                case 'y':
                    $date = "'" . date('Y-01-01');
                    break;
                case 'm':
                    $date = "'" . date('Y-m-01');
                    break;
                default:
                    $date = "'" . date('Y-m-d');
                    break;
            }
        } else {
            $date = "'" . date('Y-m-d');
        }
        $cond .= $date ? "AND sca.TimeStamp >=" . $date . " 00:00:00'" . " AND sca.TimeStamp <=" . $today . " 23:59:59'" : "";
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
        $this->show('EN/schools/climate-dashboard', $data);
    }

    public function Climate_Details()
    {
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = 'Qlick Health | Chart survey';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $data["fullpage"] = true;
        $data['published_surveys'] = $this->sv_school_reports->getClimateSurveysList();
        $data['colors'] = self::COLORS;
        $data['hideStatus'] = true;
        $data['hasAction'] = true;
        foreach ($data['published_surveys'] as $k => $published_survey) {
            $data['published_surveys'][$k]['action'] = "climate-results/" . $published_survey['survey_id'];
        }
        $this->show('EN/schools/climate/school-climates-list', $data);
    }

    public function climate_results()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $this->load->model('schools/sv_school_reports');
        $week = "DATE_FORMAT(scl_climate_answers.TimeStamp, '%Y-%m-%d') >= '" . date("Y-m-d", strtotime('sunday this week')) . "' AND DATE_FORMAT(scl_climate_answers . TimeStamp, '%Y-%m-%d') <= '" . date("Y-m-d") . "'";
        $month = "DATE_FORMAT(scl_climate_answers.TimeStamp, '%Y-%m-%d') >= '" . date("Y-m-d", strtotime('Y-m-1')) . "' AND DATE_FORMAT(scl_climate_answers . TimeStamp, '%Y-%m-%d') <= '" . date("Y-m-d") . "'";
        $day = date('w');
        $dailyCond = ['from' => date('Y-m-d'), 'to' => date('Y-m-d')];
        $weeklyCond = ['from' => date('Y-m-d', strtotime('-' . $day . ' days')), 'to' => date('Y-m-d')];
        $monthlyCond = ['from' => date("2022-m-01"), 'to' => date('Y-m-d')]; // TODO : roll it back
        if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
            $this->output->set_status_header('404');
            return;
        }
        $surveyId = $this->uri->segment(4);
        $survey = $this->sv_school_reports->getClimateSurveysList($surveyId);
        if (empty($survey)) {
            $this->output->set_status_header('404');
            return;
        }
        $data['page_title'] = 'Qlick Health | Chart survey';
        $data['sessiondata'] = $sessiondata;
        $data['survey'] = $survey[0];
        $data['today'] = [
            "staff" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "staff", 'between' => $dailyCond]) ?? 0),
            "students" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "students", 'between' => $dailyCond]) ?? 0),
            "teachers" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "teachers", 'between' => $dailyCond]) ?? 0),
            "parents" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "parents", 'between' => $dailyCond]) ?? 0),
        ];
        $data['week'] = [
            "staff" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "staff", 'between' => $weeklyCond]) ?? 0),
            "students" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "students", 'between' => $weeklyCond]) ?? 0),
            "teachers" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "teachers", 'between' => $weeklyCond]) ?? 0),
            "parents" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "parents", 'between' => $weeklyCond]) ?? 0),
        ];
        $data['month'] = [
            "staff" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "staff", 'between' => $monthlyCond]) ?? 0),
            "students" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "students", 'between' => $monthlyCond]) ?? 0),
            "teachers" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "teachers", 'between' => $monthlyCond]) ?? 0),
            "parents" => ($this->sv_school_reports->getClimateCounters($surveyId, ["type" => "parents", 'between' => $monthlyCond]) ?? 0),
        ];
        $data['choices'] = [
            'daily' => $this->sv_school_reports->ClimateChoices(['surveyid' => $surveyId, 'between' => $dailyCond]),
            'weekly' => $this->sv_school_reports->ClimateChoices(['surveyid' => $surveyId, 'between' => $weeklyCond]),
            'monthly' => $this->sv_school_reports->ClimateChoices(['surveyid' => $surveyId, 'between' => $monthlyCond]),
        ];
        $data['choicesTotals'] = [
            'daily' => $this->getResultsTotals($data['choices']['daily']),
            'weekly' => $this->getResultsTotals($data['choices']['weekly']),
            'monthly' => $this->getResultsTotals($data['choices']['monthly']),
        ];
        $data['colors'] = self::COLORS;
        // $week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
        $data['backgrounds'] = [
            'assets/images/schoolDashboard/staff01.png',
            'assets/images/schoolDashboard/teacher02.png',
            'assets/images/schoolDashboard/students03.png',
            'assets/images/schoolDashboard/sites04.png',
        ];
        $this->show('EN/schools/climate/school-climate-results', $data);
    }

    private function getResultsTotals($data)
    {
        $formattedResults = array_map(function ($item) {
            return intval($item);
        }, array_column($data, 'ChooseingTimes'));
        return array_sum($formattedResults);
    }

    public function climate_results_chart()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->db->Is_existInTable($this->uri->segment(4), 'scl_published_claimate') && !$this->uri->segment(5)) {
            $this->load->model('schools/sv_school_reports');
            $data['page_title'] = 'Qlick Health | Chart survey';
            $sessiondata = $this->session->userdata('admin_details');
            $data['sessiondata'] = $sessiondata;
            $data['surveyId'] = $this->uri->segment(4);
            $data['survey_data'] = $this->sv_school_reports->GetClimatesurveys([], $data['surveyId']);
            if (empty($data['survey_data'])) {
                echo "can't find any data sorry !";
                exit();
            }
            $data['colors'] = self::COLORS;
            $data['choices'] = $this->db
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
                ->join('scl_climate_answers', 'scl_climate_answers.climate_id = ' . $data['surveyId'] . ' AND  scl_climate_answers.answer_id = `scl_st_choices`.`id` ', 'left')
                ->where('servey_id', $data['survey_data']->main_survey_id)
                ->order_by('position', 'ASC')
                ->group_by('scl_st_choices.Id')
                ->get()->result_array();
            $data['users_passed_survey'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId']);
            $data['Staffs'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["ByType" => '1']);
            $data['Students'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["ByType" => '2']);
            $data['Teachers'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["ByType" => '3']);
            $data['Parents'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["ByType" => '4']);
            $data['Males'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["gender" => 'M']);
            $data['Females'] = $this->sv_school_reports->GetClimateAnswers($data['surveyId'], ["gender" => 'F']);
            $this->show('EN/schools/climate_results_chart', $data);
        } else {
            echo "survey not found...";
            exit();
        }
    }

    public function Climate_Report()
    {
        $this->load->model('helper');
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = 'Qlick Health | Chart survey';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        // filters data provider
        $data["filterssource"]['classes'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
        $data["filterssource"]['genders'] = [
            [
                "name" => "M",
                "display" => "Male"
            ],
            [
                "name" => "F",
                "display" => "Female"
            ]
        ];
        $data["filterssource"]['category'] = $this->sv_school_reports->getclimatesurveyslibrary(true);
        $data["filterssource"]['userstypes'] = $this->helper->get();
        // showing old filters values
        $data['filters'] = [
            'class' => ($this->input->post("class[]") == null || in_array("all", $this->input->post("class[]"))) ? [] : $this->input->post("class[]"),
            'gender' => [],
            'category' => ($this->input->post("category[]") == null || in_array("all", $this->input->post("category[]"))) ? [] : $this->input->post("category[]"),
            'usertype' => ($this->input->post("usertype[]") == null || in_array("all", $this->input->post("usertype[]"))) ? [] : $this->input->post("usertype[]"),
            "from" => $this->input->post("start") ?? date("Y-m-d"),
            "to" => $this->input->post("end") ?? date("Y-m-d"),
        ];
        // values transforming
        if (!empty($this->input->post("gender"))) {
            foreach ($this->input->post("gender") as $filter) {
                $data["filters"]["gender"][] = "'" . $filter . "'";
            }
        }
        // building the conditions
        $cond = $this->ClimateConditionsBuilder($data["filters"]);
        // getting the data
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
            AND spc.By_school = '" . $sessiondata['admin_id'] . "'
            $cond
        GROUP BY ss0c.`Id` ")->result_array();
        $data["hidefilters"] = true;
        $this->show('EN/schools/climate-dashboard', $data);
    }

    private function ClimateConditionsBuilder($filters = [])
    {
        $cond = "";
        if (!empty($filters["class"])) {
            $cond .= " AND (CASE
                WHEN sca.`user_type` = '2' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_student` WHERE `l2_student`.`Id` = sca.`user_id` AND `l2_student`.`Class` IN (" . implode(",", $filters['class']) . ") LIMIT  1 )
            ELSE NULL
            END) IS NOT NULL";
        }
        if (!empty($filters['usertype'])) {
            $cond .= ' AND sca.user_type IN (' . implode(",", $filters['usertype']) . ")";
        }
        if (!empty($filters['gender'])) {
            $cond .= " AND (CASE
                WHEN sca.`user_type` = '1' THEN (SELECT Id FROM `l2_staff` WHERE `l2_staff`.`Id` = sca.`user_id` AND `l2_staff`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                WHEN sca.`user_type` = '2' THEN (SELECT Id FROM `l2_student` WHERE `l2_student`.`Id` = sca.`user_id` AND `l2_student`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT  1 )
                WHEN sca.`user_type` = '3' THEN (SELECT Id FROM `l2_teacher` WHERE `l2_teacher`.`Id` = sca.`user_id` AND `l2_teacher`.`Gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                WHEN sca.`user_type` = '4' THEN (SELECT Id FROM `l2_parents` WHERE `l2_parents`.`Id` = sca.`user_id` AND `l2_parents`.`gender` IN (" . implode(",", $filters['gender']) . ") LIMIT 1 )
                ELSE NULL
            END) IS NOT NULL";
        }
        if (!empty($filters['category'])) {
            $cond .= " AND ss0c.category IN (" . implode(",", $filters['category']) . ") ";
        }
        if (!isset($filters['disableTime'])) {
            $cond .= " AND sca.TimeStamp >= '" . $filters["from"] . " 00:00:00'" . " AND sca.TimeStamp <= '" . $filters["to"] . " 23:59:59'";
        }
        return $cond;
    }

    public function Climate_Report_2()
    {
        $this->load->model('helper');
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = 'Qlick Health | Chart survey';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        // filters data provider
        $data["filterssource"]['classes'] = $this->schoolHelper->school_classes($sessiondata['admin_id']);
        $data["filterssource"]['genders'] = [
            [
                "name" => "M",
                "display" => "Male"
            ],
            [
                "name" => "F",
                "display" => "Female"
            ]
        ];
        $data["filterssource"]['category'] = $this->sv_school_reports->getclimatesurveyslibrary(true);
        $data["filterssource"]['userstypes'] = $this->helper->get();
        // showing old filters values
        $data['filters'] = [
            'class' => ($this->input->post("class[]") == null || in_array("all", $this->input->post("class[]"))) ? [] : $this->input->post("class[]"),
            'gender' => [],
            'category' => ($this->input->post("category[]") == null || in_array("all", $this->input->post("category[]"))) ? [] : $this->input->post("category[]"),
            'usertype' => ($this->input->post("usertype[]") == null || in_array("all", $this->input->post("usertype[]"))) ? [] : $this->input->post("usertype[]"),
            "from" => $this->input->post("start") ?? date("Y-m-d"),
            "to" => $this->input->post("end") ?? date("Y-m-d"),
        ];
        // values transforming
        if (!empty($this->input->post("gender"))) {
            foreach ($this->input->post("gender") as $filter) {
                $data["filters"]["gender"][] = "'" . $filter . "'";
            }
        }
        // building the conditions
        $cond = $this->ClimateConditionsBuilder($data["filters"]);
        // getting the data
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
        $this->show('EN/schools/climate/reports-1', $data);
    }

    public function school_reports_climate()
    {
        $this->load->model('helper');
        $data['page_title'] = 'Qlick Health | report climate';
        $sessiondata = $this->session->userdata('admin_details');
        $data['sessiondata'] = $sessiondata;
        $this->load->model('ministry/sv_ministry_reports'); // loading the model
        $data['categorys'] = $this->sv_ministry_reports->usedcategorys(); // return categorys used in this school
        $data['surveys'] = $this->sv_ministry_reports->our_surveys($sessiondata['admin_id']); // return categorys used in this school
        $data['schools'] = $this->sv_ministry_reports->schoolsBySurveys();
        $this->show('EN/schools/schools-climates', $data);
    }

    public function air_quality()
    {
        if ($this->uri->segment(4) && is_numeric($this->uri->segment(4))) {
            try {
                $this->db->delete('air_areas', array('Id' => $this->uri->segment(4)));
                $this->response->json(['status' => "ok"]);
            } catch (Throwable $th) {
                $this->response->json(['status' => "error", "message" => "Sorry We Had An Error Please Try Again Later"]);
            }
        } else {
            $this->response->json(['status' => "error", "message" => "Sorry We Had An Error Please Try Again Later"]);
        }
    }

    public function assistance_accounts()
    {
        $sessiondata = $this->session->userdata('admin_details');
        $id = $this->uri->segment(4) ?? null;
        $this->load->library('Subaccounts');
        $subAccounts = $this->subaccounts;
        $method = $this->input->method();
        if ($method == 'post') {
            $this->load->library('form_validation');
            $account = null;
            if ($this->input->post('_activeAccount') && !empty($this->input->post('_activeAccount')) && is_numeric($this->input->post('_activeAccount'))) {
                $account = $this->input->post('_activeAccount');
            }
            // status update
            if (!empty($id)) {
                $account = $this->db->select('status')->where("id", $id)->where("parentAccount", $sessiondata['admin_id'])->where("parentAccountType", $subAccounts::SCHOOL)->limit(1)->get("v_sub_accounts")->row();
                if (!isset($account)) {
                    $this->response->json(['status' => 'error', 'message' => "invalid account"]);
                }
                try {
                    $to = intval($account->status) == 1 ? 0 : 1;
                    $this->db->where("id", $id)->set("status", $to)->update("v_sub_accounts");
                    $this->response->json(['status' => 'ok', 'to' => $to]);
                } catch (Throwable $th) {
                    $this->response->json(['status' => 'error', 'message' => $th->getMessage()]);
                }
            }
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('username', 'username', 'required|min_length[3]|max_length[16]');
            $this->form_validation->set_rules('role', 'Role', 'max_length[200]');
            if (!$this->form_validation->run()) {
                $this->response->json(['status' => 'error', 'message' => validation_errors()]);
            }
            if (!empty($account)) {
                $account = $this->db->select('loginKey')->where("id", $account)->where("parentAccount", $sessiondata['admin_id'])->where("parentAccountType", $subAccounts::SCHOOL)->limit(1)->get("v_sub_accounts")->row();
                if (!isset($account)) {
                    $this->response->json(['status' => 'error', 'message' => "invalid account"]);
                }
            }
            $this->db->select("v_login.id")->where("Username", $this->input->post("username"));
            if (!empty($account)) {
                $this->db->where("v_login.id", "!=", $account->loginKey);
            }
            $usernameRecords = $this->db->limit(1)->get("v_login")->result_array();
            if (!empty($usernameRecords)) {
                $this->response->json(['status' => 'error', 'message' => "This username is already taken , suggested username : " . $this->input->post('username') . "_" . rand(100, 99999)]);
            }
            $dbValues = [
                'name' => $this->input->post('name'),
                'role' => $this->input->post('role'),
                'parentAccount' => $sessiondata['admin_id'],
                'parentAccountType' => $subAccounts::SCHOOL,
                'username' => $this->input->post('username')
            ];
            if (!empty($_FILES['avatar']['name'])) {
                $config['upload_path'] = './uploads/avatars';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 10000; // 10 MB
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('avatar')) {
                    $this->response->json(['status' => 'error', 'message' => $this->upload->display_errors() ?? "avatar upload error"]);
                } else {
                    $uploadData = $this->upload->data();
                    $dbValues['avatar'] = base_url("uploads/avatars/" . $uploadData['file_name']);
                }
            }
            $status = $subAccounts->assistanceAccount($dbValues, !empty($account) ? $account->loginKey : null);
            $this->response->json(['status' => 'ok', 'key' => $status]);
        }
        if ($method == 'delete') {
            if (empty($id)) {
                $this->response->json(['status' => 'error', 'message' => "invalid account"]);
            }
            $account = $this->db->select('loginKey')->where("id", $id)->where("parentAccount", $sessiondata['admin_id'])->where("parentAccountType", $subAccounts::SCHOOL)->limit(1)->get("v_sub_accounts")->row();
            if (!isset($account)) {
                $this->response->json(['status' => 'error', 'message' => "invalid account"]);
            }
            try {
                $this->db->trans_start();
                $this->db->where("Id", $account->loginKey)->delete("v_login");
                $this->db->where("id", $id)->delete("v_sub_accounts");
                $this->db->trans_complete();
                $this->response->json(['status' => 'ok']);
            } catch (Throwable $th) {
                $this->response->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
        $this->load->model('helper');
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = 'Qlick Health | Accounts';
        $data['accounts'] = $this->db
            ->select('v_sub_accounts.* , v_login.Username as username')
            ->join("v_login", "v_sub_accounts.loginKey = v_login.Id")
            ->where("parentAccount", $sessiondata['admin_id'])->where("parentAccountType", $subAccounts::SCHOOL)
            ->order_by("id", "DESC")
            ->get("v_sub_accounts")
            ->result_array();
        $data['password'] = $subAccounts::DEFAULT_PASSWORD;
        $this->show('EN/assistance/accounts', $data);
    }

    public function assistance_account()
    {
        $sessionData = $this->session->userdata('admin_details');
        $this->load->library('Subaccounts');
        $subAccounts = $this->subaccounts;
        $id = $this->uri->segment(4) ?? null;
        $type = $this->uri->segment(5) ?? null;
        if (empty($id) || empty($type) || !in_array(strtolower($type), ['profile', 'permissions'])) {
            $this->response->json(['status' => 'error', 'message' => 'sorry we had an error please refresh and try again']);
        }
        $account = $this->db
            ->select('v_sub_accounts.name, v_sub_accounts.role , v_login.Username as username , v_sub_accounts.permissions')
            ->join("v_login", "v_sub_accounts.loginKey = v_login.Id")
            ->where("parentAccount", $sessionData['admin_id'])
            ->where("parentAccountType", $subAccounts::SCHOOL)
            ->where("v_sub_accounts.id", $id)
            ->limit(1)
            ->get("v_sub_accounts")
            ->result_array();
        if (empty($account)) {
            $type == 'profile'
                ? $this->response->json(['status' => 'error', 'message' => 'sorry we could not find this account'])
                : $this->output->set_status_header('404');
        }
        if ($type == 'profile') {
            $this->response->json(['status' => 'ok', 'data' => $account[0]]);
        }
        $data['account'] = array_replace($account[0], ['permissions' => $subAccounts::getPermissions($account[0]['permissions'])]);
        $data['sessiondata'] = $sessionData;
        $data['permissions'] = $subAccounts->getPermissionsList();
        if ($this->input->method() == 'post') {
            $inputs = array_keys($this->input->post());
            $newPermissions = array_filter(array_keys($data['permissions']), function ($item) use ($inputs) {
                return in_array($item, $inputs);
            });
            try {
                $this->db->set('permissions', json_encode($newPermissions))->where('id', $id)->update('v_sub_accounts');
                $this->response->json(['status' => 'ok']);
            } catch (Throwable $th) {
                $this->response->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
        $data['page_title'] = 'Qlick Health | Permissions';
        $this->show('EN/assistance/permissions', $data);
    }

    public function change_user_status()
    {
        $type = strtolower($this->uri->segment(4));
        $tables = [
            'staff' => 'l2_staff',
            'teachers' => 'l2_teacher',
            'students' => 'l2_student',
        ];
        if (!in_array($type, array_keys($tables)) || !$this->input->post('id') || !is_numeric($this->input->post('id'))) {
            $this->response->json(['status' => 'error', 'message' => "invalid data"]);
        }
        try {
            $id = $this->input->post('id');
            $table = $tables[$type];
            $this->db->query("UPDATE " . $table . " SET Status = IF(Status=1, 0, 1) WHERE Id = " . $id . " ");
            $this->response->json(['status' => 'ok']);
        } catch (Throwable $th) {
            $this->response->json(['status' => 'error', 'message' => "sorry we had an unexpected error"]);
        }
    }

    // permissions

    public function courses_category()
    {
        $this->coursesHelper->courses();
    }

    public function courses()
    {
        $this->coursesHelper->categories();
    }

    public function publish_course()
    {
        $this->coursesHelper->course();
    }

    public function course()
    {
        $this->coursesHelper->coursePreview();
    }

    public function published_courses()
    {
        $this->coursesHelper->published_courses();
    }

    public function speak_out()
    {
        $this->load->helper('text');
        $sessiondata = $this->session->userdata('admin_details');
        $data['page_title'] = 'Qlick Health | Speak out';
        $data['sessiondata'] = $sessiondata;
        if ($this->input->method() == "get") {
            $this->showSpeakOutReports();
        } else if ($this->input->method() == "post") {
            if ($this->input->post('id') && $this->input->post('for') == "media") {
                $id = $this->input->post('id');
                $medias = $this->db->get_where("l3_mylifereportsmedia", ["report_id" => $id])->result_array();
                $this->response->json(['status' => "ok", "data" => $medias]);
            } else if ($this->input->post('id') && $this->input->post('for') == "description") {
                $id = $this->input->post('id');
                $lang = $this->input->post('lang');
                $data = $this->db->get_where("l3_mylifereports", ["Id" => $id])->result_array();
                $this->response->json(['status' => "ok", "description" => $data[0]['description_' . $lang] ?? "No description found"]);
            } elseif ($this->input->post('for') == "close" && $this->input->post('id')) {
                $id = $this->input->post('id');
                $this->db->set('closed', '1');
                $this->db->set('status', '3');
                $this->db->where('Id', $this->input->post('id'));
                if ($this->db->update('l3_mylifereports')) {
                    $this->response->json(['status' => "ok"]);
                } else {
                    $this->response->json(['status' => "error"]);
                }
            }
        }
    }

    public function speak_out_comments()
    {
        $sessiondata = $this->session->userdata('admin_details');
        if (!$this->uri->segment(4) || !is_numeric($this->uri->segment(4))) {
            redirect('EN/schools/speak_out');
        }
        if ($this->input->method() == "get") {
            $this->showSpeakOutComments();
        } else if ($this->input->method() == "post" && $this->input->post('type')) {
            if ($this->input->post('type') == "new") {
                $this->load->library('form_validation');
                $id = $this->uri->segment(4);

                //                $user = explode(":", $this->input->post("user"));
                //                if (sizeof($user) == 2) {
                //                    $this->response->json(["status" => "error", "errors" => "select an user"]);
                //                }
                //                $userid = $user[1];
                //                $usertype = $user[0];
                $this->form_validation->set_rules('text_en', 'text en', 'trim|required|min_length[10]');
                $this->form_validation->set_rules('text_ar', 'text ar', 'trim|required|min_length[10]');
                if ($this->form_validation->run()) {
                    $data = [
                        //                        "userid" => $userid,
                        //                        "usertype" => $usertype,
                        "report_id" => $id,
                        "text_en" => $this->input->post('text_en'),
                        "text_ar" => $this->input->post('text_ar'),
                    ];
                    if ($this->db->insert("l3_mylifereports_actions", $data)) {
                        $data['report'] = $this->getSpeakOutReport($id);
                        if ($data['report']->status == 1) {
                            $this->db->set('status', '2');
                            $this->db->where('Id', $id);
                            $this->db->update('l3_mylifereports');
                        }
                        $this->response->json(["status" => "ok"]);
                    } else {
                        $this->response->json(["status" => "error", "errors" => "unexpected error !! please try again later !"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "errors" => validation_errors()]);
                }
            } else if ($this->input->post('type') == "olddata") {
                $id = $this->input->post('id');
                $data = $this->db->get_where('l3_mylifereports_actions', ["Id" => $id])->row();
                $this->response->json(["status" => "ok", "data" => $data]);
            } else if ($this->input->post('type') == "update") {
                $id = $this->input->post('id');
                $this->load->library('form_validation');
                $user = explode(":", $this->input->post("user"));
                if (sizeof($user) !== 2) {
                    $this->response->json(["status" => "error", "errors" => "select an user"]);
                }
                $userid = $user[1];
                $usertype = $user[0];
                $this->form_validation->set_rules('text_en', 'text en', 'trim|required|min_length[10]');
                $this->form_validation->set_rules('text_ar', 'text ar', 'trim|required|min_length[10]');
                if ($this->form_validation->run()) {
                    $data = [
                        "userid" => $userid,
                        "usertype" => $usertype,
                        "report_id" => $this->uri->segment(4),
                        "text_en" => $this->input->post('text_en'),
                        "text_ar" => $this->input->post('text_ar'),
                    ];
                    $this->db->where("Id", $id);
                    if ($this->db->update("l3_mylifereports_actions", $data)) {
                        $this->response->json(["status" => "ok"]);
                    } else {
                        $this->response->json(["status" => "error", "errors" => "unexpected error !! please try again later !"]);
                    }
                } else {
                    $this->response->json(["status" => "error", "errors" => validation_errors()]);
                }
            } else if ($this->input->post('type') == "priority") {
                $this->db->set('priority', $this->input->post('Priority'));
                $this->db->where('Id', $this->uri->segment(4));
                if ($this->db->update('l3_mylifereports')) {
                    $this->response->json(['status' => "ok"]);
                } else {
                    $this->response->json(['status' => "error"]);
                }
            }
        } else if ($this->input->method() == "delete") {
            $id = $this->input->input_stream("id");
            if ($this->db->delete('l3_mylifereports_actions', array('Id' => $id))) {
                echo "ok";
            } else {
                echo "error";
            }
        }
    }

    public function getSpeakOutModel()
    {
        $this->load->model('schools/speak_out');
        return $this->speak_out->setId($this->sessionData['admin_id'])->setLanguage(self::LANGUAGE);
    }

    public function getAccountSupportedIds(): array
    {
        return [$this->sessionData['admin_id']];
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

    private function Temp_GetTotal_Not($action = "")
    {
        $counter = 0;
        //$this->load->library( 'session' );
        $sessiondata = $this->session->userdata('admin_details');
        $today = date("Y-m-d");
        $list = array();
        $Ourstaffs = $this->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            $ID = $staff['Id'];
            if (!empty($action)) {
                $getResults = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults_staff = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Staff' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResults_staff)) {
                $counter++;
            }
        }
        $OurTeachers = $this->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $T_ID = $Teacher['Id'];
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Teacher'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Teacher'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResultsT)) {
                $counter++;
            }
        }
        $OurStudents = $this->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $sessiondata['admin_id'] . "' ")->result_array();
        foreach ($OurStudents as $Student) {
            if (!empty($action)) {
                $getResultsT = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Student['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Student'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults_Stud = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Student['Id'] . "'
AND Result_Date = '" . $today . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            if (empty($getResults_Stud)) {
                $counter++;
            }
        }
        return ($counter);
    }

    private function The_Second_Database($natinal_id, $name)
    {
        $database_2 = $this->load->database('database2', TRUE);
        if ($this->db->query("INSERT INTO `tdx_person` (`person_no`,`name`)  VALUES ('" . $natinal_id . "','" . $name . "')")) {
            echo "Inserted successfuly !!!";
        } else {
            echo "Error Again";
        }
    }

    private function getSpeakOutUsersIds(): array
    {
        return [$this->sessionData['admin_id']];
    }
} //end extend
