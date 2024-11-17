<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_URI $uri
 * @property CI_Loader $load
 * @property CI_Session $session
 */
class Basic_functions extends CI_Model
{ // name schoolHelper
    public int $schoolId = 0;
    public ?array $account = [];

    public function __construct()
    {
        $this->load->library('session');
        $sessionData = $this->session->userdata('admin_details');

        if (!empty($sessionData) && $sessionData['type'] === 'school') {
            $this->schoolId = $sessionData['admin_id'];
        } else {
            $this->schoolId = 0;
        }

        $this->account = $this->db->where("Id", $this->schoolId)->limit(1)->get("l1_school")->result_array()[0] ?? null;
    }

    private function getColumnName(): string
    {
        $isAr = $this->uri->segment(1) == "AR";
        return $isAr ? "Class_ar" : "Class";
    }

    public function school_classes($schools = null): array
    {
        $ids = array_wrap($schools !== null ? $schools : $this->schoolId);
        return $this->db->select('*, r_levels.' . $this->getColumnName() . ' AS Class, r_levels.Id AS Id')
            ->from('l2_school_classes')
            ->join('r_levels', 'r_levels.Id = l2_school_classes.class_key')
            ->where_in('l2_school_classes.school_id', $ids)
            ->order_by('r_levels.Id', 'ASC')
            ->get()->result_array();
    }


    public function teacherClasses($user_id, $returnstring = false)
    {
        $col = $this->getColumnName();
        $classes = $this->db->query(" SELECT `r_levels`.`" . $col . "` AS class , `r_levels`.`Id` AS class_Key
        FROM `l2_teachers_classes` 
        JOIN `r_levels` ON `r_levels`.`Id` = `l2_teachers_classes`.`class_id`
        WHERE `l2_teachers_classes`.`teacher_id` = '" . $user_id . "' ")->result_array();
        if ($returnstring) {
            return implode(' ,', array_column($classes, "class"));
        } else {
            return $classes;
        }
    }


    public function getActiveSchoolClassesByStudents($returnAsString = false, array $schoolsIds = null): array|string
    {
        $ids = empty($schoolsIds) ? [$this->schoolId] : $schoolsIds;
        $col = $this->getColumnName();

        $subQuery = $this->db->select('COUNT(Id)')
            ->from('l2_student')
            ->where('Class = r_levels.Id')
            ->where_in('Added_By', $ids)
            ->get_compiled_select();

        $result = $this->db->select("DISTINCT r_levels.$col AS Class, r_levels.Id AS Id, ($subQuery) AS student_count", false)
            ->from('l2_student')
            ->join('r_levels', 'l2_student.Class = r_levels.Id')
            ->where_in('Added_By', $ids)
            ->order_by('r_levels.Id', 'ASC')
            ->get()
            ->result_array();

        if (!$returnAsString) {
            return $result;
        }

        return implode(', ', array_column($result, "Class"));
    }

    public function stydentsInclass($class)
    {
        $lang = $this->uri->segment(1);
        $query = $this->db->query("SELECT Id, CONCAT( F_name_" . $lang . " , ' ' , L_name_" . $lang . " ) AS name FROM l2_student 
        WHERE Added_By = '" . $this->schoolId . "' AND `Class` = '" . $class . "' ")->result_array();
        return $query;
    }

    public function getTeacherPosition($position_id)
    {
        if ($this->uri->segment(1) == "AR") {
            $col = "AR_Position";
        } else {
            $col = "Position";
        }

        $this->db->select($col);
        $this->db->where("Id", $position_id);
        $result = $this->db->get('r_positions_tech')->result_array();
        if (!empty($result)) {
            $name = $result[0][$col];
        } else {
            $name = "--";
        }
        return $name;
    }

    public function getStaffPosition($position_id)
    {
        if ($this->uri->segment(1) == "AR") {
            $col = "AR_Position";
        } else {
            $col = "Position";
        }

        $this->db->select($col);
        $this->db->where("Id", $position_id);
        $result = $this->db->get('r_positions_sch')->result_array();
        if (!empty($result)) {
            $name = $result[0][$col];
        } else {
            $name = "--";
        }
        return $name;
    }


    public function DashboardCards()
    {
        $cards = array(
            [
                "Title" => $this->uri->segment(1) == "EN" ? "Staff" : "موظف",
                "Data" => $this->db->query("SELECT COUNT(`l2_staff`.`Id`) AS allCounter ,
                MAX(`l2_staff`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_staff` ON `l1_school`.`Id` = `l2_staff`.`Added_by` 
                WHERE  `l1_school`.`Id` = '" . $this->schoolId . "' ")->result_array()[0],
                "last_title" => $this->uri->segment(1) == "EN" ? "Last registered staff" : "أخر موظف مسجل",
                "icons" => "staff.png",
                "bg" => "staff01.png",
                "border" => "#ffffff",
            ],
            [
                "Title" => $this->uri->segment(1) == "EN" ? "Teachers" : "المعلمين",
                "Data" => $this->db->query("SELECT COUNT(`l2_teacher`.`Id`) AS allCounter ,
                MAX(`l2_teacher`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_teacher` ON `l1_school`.`Id` = `l2_teacher`.`Added_by` 
                WHERE  `l1_school`.`Id` = '" . $this->schoolId . "' ")->result_array()[0],
                "last_title" => $this->uri->segment(1) == "EN" ? "Last registered teacher" : "أخر معلم مسجل",
                "icons" => "teachers.png",
                "bg" => "teacher02.png",
                "border" => "#ffffff",
            ],
            [
                "Title" => $this->uri->segment(1) == "EN" ? "Students" : "الطلاب",
                "Data" => $this->db->query("SELECT COUNT(`l2_student`.`Id`) AS allCounter ,
                MAX(`l2_student`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_student` ON `l1_school`.`Id` = `l2_student`.`Added_by` 
                WHERE  `l1_school`.`Id` = '" . $this->schoolId . "' ")->result_array()[0],
                "last_title" => $this->uri->segment(1) == "EN" ? "Last registered student" : "آخر طالب مسجل",
                "icons" => "students.png",
                "bg" => "students03.png",
                "border" => "#ffffff",
            ],
            [
                "Title" => $this->uri->segment(1) == "EN" ? "Sites" : "المواقع",
                "Data" => $this->db->query("SELECT COUNT(`l2_site`.`Id`) AS allCounter ,
                MAX(`l2_site`.`TimeStamp`) AS LastAdded
                FROM `l1_school` 
                JOIN `l2_site` ON `l1_school`.`Id` = `l2_site`.`Added_by` 
                WHERE  `l1_school`.`Id` = '" . $this->schoolId . "' ")->result_array()[0],
                "last_title" => $this->uri->segment(1) == "EN" ? "Last registered site" : "آخر موقع مسجل",
                "icons" => "sites.png",
                "bg" => "sites04.png",
                "border" => "#ffffff",
            ],
        );

        return $cards;
    }

    public function InsertNewTeacher($data)
    {
        $data_array = array();
        $classes = array();
        $first_teacher_classes = array();
        $r_levels = $this->db->get("r_levels")->result_array();
        $av_schoolClasses = array_column($this->school_classes($this->schoolId), "Id");

        $fist_teacher = [
            "Prefix" => $data[0]["Prefix"],
            "F_name_EN" => $data[0]["F_name_EN"],
            "M_name_EN" => $data[0]["M_name_EN"],
            "L_name_EN" => $data[0]["L_name_EN"],
            "F_name_AR" => $data[0]["F_name_AR"],
            "M_name_AR" => $data[0]["M_name_AR"],
            "L_name_AR" => $data[0]["L_name_AR"],
            "DOP" => $data[0]["DOP"],
            "Phone" => $data[0]["Phone"],
            "Gender" => $data[0]["Gender"],
            "Position" => $data[0]["Position"],
            "martial_status" => $data[0]["martial_status"],
            "National_Id" => $data[0]["National_Id"],
            "Nationality" => $data[0]["Nationality"],
            "Email" => $data[0]["Email"],
            "UserName" => $data[0]["UserName"],
            "Password" => $data[0]["Password"],
            "Added_By" => $data[0]["Added_By"],
        ];

//        $this->db->truncate('l2_temp_teacher');
        $this->db->insert('l2_temp_teacher', $fist_teacher);
        $last_id = $this->db->insert_id();

        foreach ($data[0]['classes'] as $class) {
            $class_key = str_replace(array_column($r_levels, "Class"), array_column($r_levels, "Id"), trim($class));
            if (in_array($class_key, $av_schoolClasses)) {
                $first_teacher_classes[] = [
                    "class_id" => $class_key,
                    "teacher_id" => $last_id
                ];
            }
        }
        if (!empty($first_teacher_classes)) {
            $this->db->insert_batch("l2_teachers_classes", $first_teacher_classes);
        }
        // unset saved values
        unset($data[0]);
        // set data 
        foreach ($data as $teacher) {
            $last_id++;
            foreach ($teacher['classes'] as $class) {
                $class_key = str_replace(array_column($r_levels, "Class"), array_column($r_levels, "Id"), trim($class));
                if (in_array($class_key, $av_schoolClasses)) {
                    $classes[] = [
                        "class_id" => $class_key,
                        "teacher_id" => $last_id
                    ];
                }
            }

            $data_array[] = [
                "Prefix" => $teacher["Prefix"],
                "F_name_EN" => $teacher["F_name_EN"],
                "M_name_EN" => $teacher["M_name_EN"],
                "L_name_EN" => $teacher["L_name_EN"],
                "F_name_AR" => $teacher["F_name_AR"],
                "M_name_AR" => $teacher["M_name_AR"],
                "L_name_AR" => $teacher["L_name_AR"],
                "DOP" => $teacher["DOP"],
                "Phone" => $teacher["Phone"],
                "Gender" => $teacher["Gender"],
                "Position" => $teacher["Position"],
                "martial_status" => $teacher["martial_status"],
                "National_Id" => $teacher["National_Id"],
                "Nationality" => $teacher["Nationality"],
                "Email" => $teacher["Email"],
                "UserName" => $teacher["UserName"],
                "Password" => $teacher["Password"],
                "Added_By" => $teacher["Added_By"],
            ];
        }
        if (!empty($data_array) && !empty($classes)) {
            if ($this->db->insert_batch("l2_teachers_classes", $classes)) {
                if ($this->db->insert_batch("l2_temp_teacher", $data_array)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

public function counters()
    {
        $data['staff'] = $this->db->where("Added_By", $this->schoolId)
        ->get("l2_staff")
        ->result_array();

        $data['teachers'] = $this->db->where("Added_By", $this->schoolId)
        ->get("l2_teacher")
        ->result_array();
       $data['students'] = $this->db->select('martial_status, Gender')
        ->where("Added_By", $this->schoolId)
        ->get("l2_student")
        ->result_array();
        $data['parents'] = $this->db->select('martial_status, gender as Gender')
        ->where("Added_By", $this->schoolId)
        ->get("l2_parents")
        ->result_array();
        // counter
        $data['all'] = sizeof($data['staff']) + sizeof($data['teachers']) + sizeof($data['students']) + sizeof($data['parents']);

        $allUsers = collect($data['staff'])->merge($data['teachers'])->merge($data['students'])->merge($data['parents']);
        $data['gendersCounters'] = [
            "M" => $allUsers->where("Gender", "M")->count(),
            "F" => $allUsers->where("Gender", "F")->count()
        ];

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

    public function calculateAge(string $birthdate)
    {
        $birthdate = date("Y-m-d", strtotime($birthdate));
        $today = new DateTime();
        $date = DateTime::createFromFormat('Y-m-d', $birthdate);
        $age = $today->diff($date);
        $years = $age->y;
        if ($age->m < 0 || ($age->m == 0 && $age->d < 0)) {
            $years--;
        }
        return $years;
    }
}
