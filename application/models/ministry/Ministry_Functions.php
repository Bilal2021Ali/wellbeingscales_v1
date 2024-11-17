<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ministry_Functions extends CI_Model
{ // name schoolHelper
    public $userid = 0;
    public $schoolsIds = [];

    public function __construct()
    {
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
            $this->userid = $sessiondata['admin_id'];
        } else {
            $this->userid = 0;
        }
    }


    public function setSchools(array $schoolsIds)
    {
        $this->schoolsIds = $schoolsIds;
    }

    public function DashboardCards(): array
    {
        $isEn = $this->uri->segment(1) == "EN";
        return [
            [
                "Title" => $isEn ? "Schools" : "المدارس",
                "Data" => $this->db->query("SELECT COUNT(`l1_school`.`Id`) AS allCounter ,
                MAX(`l1_school`.`TimeStamp`) AS LastAdded 
                FROM `l1_school`
                WHERE `status` = '1' AND `Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered school" : "آخر مدرسة مسجلة",
                "icons" => "counterschools.png",
                "bg_color" => "344267"
            ],
            [
                "Title" => $isEn ? "Departments" : "الإدارات",
                "Data" => $this->db->query("SELECT COUNT(`l1_department`.`Id`) AS allCounter ,
                MAX(`l1_department`.`TimeStamp`) AS LastAdded 
                FROM `l1_department`
                WHERE `status` = '1' AND `Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered department" : "آخر قسم مسجل",
                "icons" => "counterdepartments.png",
                "bg_color" => "605091"
            ],
            [
                "Title" => $isEn ? "Schools Devices" : "أجهزة المدارس",
                "Data" => $this->db->query("SELECT COUNT(`l2_devices`.`Id`) AS allCounter ,
                MAX(`l2_devices`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_devices` ON `l1_school`.`Id` = `l2_devices`.`Added_by` 
                WHERE  `l1_school`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered device" : "آخر جهاز مسجل",
                "icons" => "device.png",
                "bg_color" => "344267"
            ],
            [
                "Title" => $isEn ? "Departments Devices" : "أجهزة الأقسام",
                "Data" => $this->db->query("SELECT COUNT(`l2_co_devices`.`Id`) AS allCounter ,
                MAX(`l2_co_devices`.`TimeStamp`) AS LastAdded
                FROM `l1_department` 
                JOIN `l2_co_devices` ON `l1_department`.`Id` = `l2_co_devices`.`Added_by` 
                WHERE  `l1_department`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered device" : "آخر جهاز مسجل",
                "icons" => "device.png",
                "bg_color" => "605091"
            ],
            [
                "Title" => $isEn ? "Staff" : "موظف",
                "Data" => $this->db->query("SELECT COUNT(`l2_staff`.`Id`) AS allCounter ,
                MAX(`l2_staff`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_staff` ON `l1_school`.`Id` = `l2_staff`.`Added_by` 
                WHERE  `l1_school`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered staff" : "أخر موظف مسجل",
                "icons" => "staff.png",
                "bg_color" => "f25c69"
            ],
            [
                "Title" => $isEn ? "Teachers" : "المعلمين",
                "Data" => $this->db->query("SELECT COUNT(`l2_teacher`.`Id`) AS allCounter ,
                MAX(`l2_teacher`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_teacher` ON `l1_school`.`Id` = `l2_teacher`.`Added_by` 
                WHERE  `l1_school`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered teacher" : "أخر معلم مسجل",
                "icons" => "countersteachers.png",
                "bg_color" => "2e338c"
            ],
            [
                "Title" => $isEn ? "Students" : "الطلاب",
                "Data" => $this->db->query("SELECT COUNT(`l2_student`.`Id`) AS allCounter ,
                MAX(`l2_student`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_student` ON `l1_school`.`Id` = `l2_student`.`Added_by` 
                WHERE  `l1_school`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered student" : "آخر طالب مسجل",
                "icons" => "counterstudents.png",
                "bg_color" => "364692"
            ],
            [
                "Title" => $isEn ? "Sites" : "المواقع",
                "Data" => $this->db->query("SELECT COUNT(`l2_site`.`Id`) AS allCounter ,
                MAX(`l2_site`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_site` ON `l1_school`.`Id` = `l2_site`.`Added_by` 
                WHERE  `l1_school`.`Added_by` = '" . $this->userid . "' ")->result_array()[0],
                "last_title" => $isEn ? "Last registered site" : "آخر موقع مسجل",
                "icons" => "countersites.png",
                "bg_color" => "694811"
            ],
        ];
    }

    public function tempresults($filters = ['perSchool' => null, "UserType" => null, "only" => null])
    {
        $today = date('Y-m-d');
        $conditions = "";

        if (isset($filters['perSchool']) && $filters['perSchool'] !== null) {
            $conditions .= " AND `l1_school`.`Id` = " . $filters['perSchool'];
        }
        if (isset($filters['UserType']) && $filters['UserType'] !== null) {
            $conditions .= " AND `l2_result`.`UserType` = '" . $filters['UserType'] . "'";
        }

        $data = array();

        if (!isset($filters['only']) || $filters['only'] == null || $filters['only'] == "low") {
            $data['LOW'] = $this->db->query("SELECT COUNT(DISTINCT(`l2_result`.`Id`)) AS result 
            FROM `l2_result`
            JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
            WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
            EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` ) OR 
            EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` )) 
            AND `l2_result`.`Result` > 0 AND `l2_result`.`Result` < 36.200 AND `l2_result`.`Result_Date` =  '" . $today . "' $conditions ")->result_array()[0]['result'] ?? 0;
        }

        if (!isset($filters['only']) || $filters['only'] == null || $filters['only'] == "normal") {
            $data['NORMAL'] = $this->db->query("SELECT COUNT(DISTINCT(`l2_result`.`Id`)) AS result 
            FROM `l2_result`
            JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
            WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
            EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` ) OR 
            EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` )) 
            AND `l2_result`.`Result` >= 36.201 AND `l2_result`.`Result` <= 37.5 AND `l2_result`.`Result_Date` =  '" . $today . "' $conditions ")->result_array()[0]['result'] ?? 0;
        }

        if (!isset($filters['only']) || $filters['only'] == null || $filters['only'] == "moderate") {
            $data['MODERATE'] = $this->db->query("SELECT COUNT(DISTINCT(`l2_result`.`Id`)) AS result 
            FROM `l2_result`
            JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
            WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
            EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` ) OR 
            EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` )) 
            AND `l2_result`.`Result` >= 37.501 AND `l2_result`.`Result` <= 38.5 AND `l2_result`.`Result_Date` =  '" . $today . "' $conditions ")->result_array()[0]['result'] ?? 0;
        }

        if (!isset($filters['only']) || $filters['only'] == null || $filters['only'] == "high") {
            $data['HIGH'] = $this->db->query("SELECT COUNT(DISTINCT(`l2_result`.`Id`)) AS result 
            FROM `l2_result`
            JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
            WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' )  OR
            EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' ) OR 
            EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' )) 
            AND `l2_result`.`Result` >= 38.501 AND `l2_result`.`Result` <= 45 AND `l2_result`.`Result_Date` =  '" . $today . "' $conditions ")->result_array()[0]['result'] ?? 0;
        }

        return $data;
    }

    public function LabResults($filters = array('perSchool' => null, 'test' => null))
    {
        $conditions = "";

        if (isset($filters['perSchool']) && $filters['perSchool'] !== null) {
            $conditions .= "AND l1_school.Id = " . $filters['perSchool'];
        }

        if (isset($filters['test']) && $filters['test'] !== null) {
            $conditions .= "AND l2_labtests.Test_Description = '" . $filters['test'] . "'";
        }

        $today = date('Y-m-d');
        $data['all'] = $this->db->query("SELECT COUNT(`l2_labtests`.`Id`) AS result , `l1_school`.`Id` AS School , `l1_school`.`School_Name_EN` AS SchoolName , CONCAT('\"',`l2_labtests`.`Test_Description`,'\"') AS Test
        FROM `l2_labtests`
        JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id`) OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id`)) 
        $conditions  AND `l2_labtests`.`Created` =  '" . $today . "' GROUP BY `l2_labtests`.`Test_Description`")->result_array() ?? 0;
        $data['Negative'] = $this->db->query("SELECT COUNT(`l2_labtests`.`Id`) AS result, `l1_school`.`Id` AS School , `l1_school`.`School_Name_EN` AS SchoolName , CONCAT('\"',`l2_labtests`.`Test_Description`,'\"') AS Test
        FROM `l2_labtests`
        JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id`) OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id`)) 
        AND `l2_labtests`.`Result` = 0  $conditions  AND `l2_labtests`.`Created` =  '" . $today . "' GROUP BY `l2_labtests`.`Test_Description`")->result_array() ?? 0;
        $data['Positive'] = $this->db->query("SELECT COUNT(`l2_labtests`.`Id`) AS result , `l1_school`.`Id` AS School , `l1_school`.`School_Name_EN` AS SchoolName , CONCAT('\"',`l2_labtests`.`Test_Description`,'\"') AS Test
        FROM `l2_labtests`
        JOIN `l1_school` ON `l1_school`.`Added_By` = '" . $this->userid . "'
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` )  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id`) OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_labtests`.`UserId` AND `l2_labtests`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id`)) 
        AND `l2_labtests`.`Result` = 1 $conditions  AND `l2_labtests`.`Created` =  '" . $today . "' GROUP BY `l2_labtests`.`Test_Description`")->result_array() ?? 0;

        return $data;
    }


    public function SchoolsData($action = "")
    {
        $today = date('Y-m-d');
        $name = $this->uri->segment(1) == "EN" ? "School_Name_EN" : "School_Name_AR";
        $data = $this->db->query("SELECT `l1_school`.`" . $name . "` AS School_Name , 
        `l2_avatars`.`Link` AS avatar ,
        (SELECT COUNT(`l2_result`.`Id`) FROM `l2_result`
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "')  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "') OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "')) 
        AND `l2_result`.`Result` > 0 AND `l2_result`.`Result` < 36.2 AND `l2_result`.`Result_Date` =  '" . $today . "' ) AS low , (SELECT COUNT(`l2_result`.`Id`)
        FROM `l2_result` WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "')  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "') OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "')) 
        AND `l2_result`.`Result` >= 36.3 AND `l2_result`.`Result` <= 37.5 AND `l2_result`.`Result_Date` =  '" . $today . "' ) AS normal , (SELECT COUNT(`l2_result`.`Id`) AS result  FROM `l2_result`
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "')  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "') OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "')) 
        AND `l2_result`.`Result` >= 37.6 AND `l2_result`.`Result` <= 38.4 AND `l2_result`.`Result_Date` =  '" . $today . "') AS moderate , (SELECT COUNT(`l2_result`.`Id`) FROM `l2_result`
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "')  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "') OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "')) 
        AND `l2_result`.`Result` >= 38.5 AND `l2_result`.`Result` <= 45 AND `l2_result`.`Result_Date` =  '" . $today . "') AS high , (SELECT COUNT(`l2_result`.`Id`) FROM `l2_result`
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "' )  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "' ) OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "' )) 
        AND `l2_result`.`Result` >= 45.1 AND `l2_result`.`Result` <= 10000 AND `l2_result`.`Result_Date` =  '" . $today . "') AS error , (SELECT COUNT(`l2_result`.`Id`) FROM `l2_result`
        WHERE (EXISTS (SELECT `l2_staff`.`Id` FROM `l2_staff` WHERE `l2_staff`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Staff' AND `l2_staff`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_staff`.`Action` = '" . $action : "") . "' )  OR
        EXISTS (SELECT `l2_teacher`.`Id` FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Teacher' AND `l2_teacher`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_teacher`.`Action` = '" . $action : "") . "' ) OR 
        EXISTS (SELECT `l2_student`.`Id` FROM `l2_student` WHERE `l2_student`.`Id` = `l2_result`.`UserId` AND `l2_result`.`UserType` = 'Student' AND `l2_student`.`Added_By` = `l1_school`.`Id` " . ($action !== "" ? "AND `l2_student`.`Action` = '" . $action : "") . "' )) 
        AND `l2_result`.`Result_Date` =  '" . $today . "') AS total 
        FROM `l1_school`
        LEFT JOIN `l2_avatars` ON `l2_avatars`.`Type_Of_User` = 'school' AND `l2_avatars`.`For_User` = `l1_school`.`Id`
        WHERE `l1_school`.`Added_By` = '" . $this->userid . "' ")->result_array();
        return $data;
    }

    public function UsersInAction($action, $filter = ["school" => null])
    {
        $result = [];
        $types = [
            'l2_staff' => 'staff',
            'l2_teacher' => 'teachers',
            'l2_student' => 'students',
        ];

        foreach ($types as $table => $type) {
            $this->db->from($table)->select("CONCAT(`" . $table . "`.`F_name_EN` , ' ' , `" . $table . "`.`L_name_EN`) AS name , `" . $table . "`.`Id` as id , `l1_school`.`School_Name_EN`")
                ->join("l1_school", $table . ".Added_By = l1_school.Id");
            if (isset($filter['school']) && $filter['school'] !== null) {
                $this->db->where("l1_school.Id", $filter['school']);
            }
            $result[$type] = $this->db->where("Action", $action)->get()->result_array();
        }

        return $result;
    }


    public function counters()
    {
        if (empty($this->schoolsIds)) {
            return [
                'staff' => 0,
                'teachers' => 0,
                'students' => 0,
                'parents' => 0,
                'all' => 0
            ];
        }
        $data['staff'] = $this->db->select('COUNT(*) as count')->limit(1)->get("l2_staff")->row_array()['count'] ?? 0;
        $data['teachers'] = $this->db->select('COUNT(*) as count')->limit(1)->get("l2_teacher")->row_array()['count'] ?? 0;
        $data['students'] = $this->db->select('COUNT(*) as count')->limit(1)->get("l2_student")->row_array()['count'] ?? 0;
        $data['parents'] = $this->db->query("SELECT COUNT(*) as count, `l2_parents`.`martial_status`, `l2_parents`.`gender` FROM  `l2_student` 
        JOIN `v_login` ON (`v_login`.`Username` = `l2_student`.`Parent_NID` 
        OR `v_login`.`Username` = `l2_student`.`Parent_NID_2`) AND `v_login`.`Type` = 'Parent'
        JOIN `l2_parents` ON `l2_parents`.`login_key` = `v_login`.`Id` LIMIT 1")->row_array()['count'] ?? 0;

        $data['all'] = $data['staff'] + $data['teachers'] + $data['students'] + $data['parents'];
        return $data;
    }

    public function martialCounters($data)
    {
        $result = [];

        foreach ($data['staff'] as $key => $content) {
            $result[$content['martial_status']][] = $content;
        }

        foreach ($data['teachers'] as $key => $content) {
            $result[$content['martial_status']][] = $content;
        }

        foreach ($data['students'] as $key => $content) {
            $result[$content['martial_status']][] = $content;
        }

        foreach ($data['parents'] as $key => $content) {
            $result[$content['martial_status']][] = $content;
        }

        return $result;
    }

    public function countUsersByGender($gender): int
    {
        if (empty($this->schoolsIds)) return 0;

        $query = "SELECT SUM(cnt) as total_count FROM (
                SELECT COUNT(*) as cnt FROM l2_staff WHERE Gender = ? AND Added_By IN (" . implode(',', $this->schoolsIds) . ")
                UNION ALL 
                SELECT COUNT(*) as cnt FROM l2_teacher WHERE Gender = ? AND Added_By IN (" . implode(',', $this->schoolsIds) . ")
                UNION ALL 
                SELECT COUNT(*) as cnt FROM l2_student WHERE Gender = ? AND Added_By IN (" . implode(',', $this->schoolsIds) . ")
                UNION ALL 
                SELECT COUNT(*) as cnt FROM l2_parents 
                    JOIN v_login ON v_login.Id = l2_parents.login_key AND v_login.Type = 'Parent'
                    JOIN l2_student ON v_login.Username IN (l2_student.Parent_NID, l2_student.Parent_NID_2) 
                    WHERE l2_parents.gender = ? AND l2_student.Added_By IN (" . implode(',', $this->schoolsIds) . ")
            ) as counters";

        $result = $this->db->query($query, [$gender, $gender, $gender, $gender])->row_array();
        return intval($result['total_count']);
    }

    public function gendersCounters($data)
    {
        $result = [];

        foreach ($data['staff'] as $key => $content) {
            $result[$content['Gender']][] = $content;
        }

        foreach ($data['teachers'] as $key => $content) {
            $result[$content['Gender']][] = $content;
        }

        foreach ($data['students'] as $key => $content) {
            $result[$content['Gender']][] = $content;
        }

        foreach ($data['parents'] as $key => $content) {
            $result[($content['gender'] == 1 ? 'M' : 'F')][] = $content;
        }

        return $result;
    }
}