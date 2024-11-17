<?php
defined('BASEPATH') or exit('No direct script access allowed');

// from 6 To 374 created for serv_reports method in Controller of Schools
class schools_temperature extends CI_Model
{
    public $schoolId = null;
    public $school_data = array();
    public $type = null;

    public function __construct()
    {
        // session dealing
        $this->load->library('session');
        $sessiondata = $this->session->userdata('admin_details');
        if (!empty($sessiondata)) {
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
    }

    public function staff(): schools_temperature
    {
        $this->type = "staff";
        return $this;
    }

    public function students(): schools_temperature
    {
        $this->type = "students";
        return $this;
    }

    public function teachers(): schools_temperature
    {
        $this->type = "teachers";
        return $this;
    }

    private function staffTemperature(): array
    {
        $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS Name ,`l2_avatars`.`Link` AS avatar ,l2_staff.Id,l2_staff.Position, l2_staff.Action, `r_positions_sch`.`Position` AS Position")
            ->join("r_positions_sch", "`r_positions_sch`.`Id` = `l2_staff`.`Position`", "LEFT")
            ->join("l2_avatars", "`l2_avatars`.`For_User` = `l2_staff`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Staff'", "LEFT")
            ->where("l2_staff.Added_By", $this->schoolId)
            ->group_by("l2_staff.Id")
            ->get("l2_staff")
            ->result_array();
        $users = $this->group_by("Id", $users);

        // end the script if the school doesn't have any staff
        if (empty($users)) return [];
        // get results
        $today = date('Y-m-d');
        $this->db
            ->select("Id,Device_Test,UserId,Result,Result_Date,Time,Symptoms")
            ->where_in("UserId", array_column($users, "Id"))
            ->where("UserType", "Staff");
        $this->db->where("Created", $today)->order_by("Time", "ASC");
        // run result as array
        $temResults = $this->db->get("l2_result")->result_array();
        // merge the data
        $usersWithResults = [];
        foreach ($temResults as $key => $result) {
            $usersWithResults[$result['UserId']] = array_merge($users[$result['UserId']], $result);
        }
        // return result as array
        return array_values($usersWithResults);
    }

    private function studentsTemperature(): array
    {
        $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS Name ,`l2_avatars`.`Link` AS avatar ,l2_student.Id,l2_student.Grades, l2_student.Action,")
            ->join("l2_avatars", "`l2_avatars`.`For_User` = `l2_student`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Student'", "LEFT")
            ->where("l2_student.Added_By", $this->schoolId)
            ->group_by("l2_student.Id");
        if (isset($options['class'])) {
            $this->db->where("Class", $options['class']);
        }
        $users = $users->get("l2_student")->result_array();
        $users = $this->group_by("Id", $users);

        // end the script if the school doesn't have any staff
        if (empty($users)) return [];
        // get results
        $today = date('Y-m-d');
        $this->db
            ->select("Id,Device_Test,UserId,Result,Result_Date,Time,Symptoms")
            ->where_in("UserId", array_column($users, "Id"))
            ->where("UserType", "Student");
        $this->db->where("Created", $today)->order_by("Time", "ASC");
        // run result as array
        $temResults = $this->db->get("l2_result")->result_array();
        // merge the data
        $usersWithResults = [];
        foreach ($temResults as $key => $result) {
            $usersWithResults[$result['UserId']] = array_merge($users[$result['UserId']], $result);
        }
        // return result as array
        return array_values($usersWithResults);
    }

    private function teachersTemperature(): array
    {
        if ($this->uri->segment(1) == "AR") {
            $col = "Class_ar";
        } else {
            $col = "Class";
        }
        $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS Name ,`l2_avatars`.`Link` AS avatar ,l2_teacher.Id, l2_teacher.Action")
            ->select("(SELECT GROUP_CONCAT(`r_levels`.`" . $col . "`) FROM `l2_teachers_classes` 
                JOIN `r_levels` ON `r_levels`.`Id` = `l2_teachers_classes`.`class_id`
                WHERE `l2_teachers_classes`.`teacher_id` = l2_teacher.Id) AS classes")
            ->join("l2_avatars", "`l2_avatars`.`For_User` = `l2_teacher`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Teacher'", "LEFT")
            ->where("l2_teacher.Added_By", $this->schoolId)
            ->group_by("l2_teacher.Id")
            ->get("l2_teacher")
            ->result_array();
        $users = $this->group_by("Id", $users);

        // end the script if the school doesn't have any staff
        if (empty($users)) return [];
        // get results
        $today = date('Y-m-d');
        $this->db
            ->select("Id,Device_Test,UserId,Result,Result_Date,Time,Symptoms")
            ->where_in("UserId", array_column($users, "Id"))
            ->where("UserType", "Teacher");
        $this->db->where("Created", $today)->order_by("Time", "ASC");
        // run result as array
        $temResults = $this->db->get("l2_result")->result_array();
        // merge the data
        $usersWithResults = [];
        foreach ($temResults as $key => $result) {
            $usersWithResults[$result['UserId']] = array_merge($users[$result['UserId']], $result);
        }
        // return result as array
        return array_values($usersWithResults);
    }


    public function temperature($options = []): array
    {
        $result = [];
        switch ($this->type) {
            case 'staff':
                $result = $this->staffTemperature($options);
                break;
            case 'students':
                $result = $this->studentsTemperature($options);
                break;
            case 'teachers':
                $result = $this->teachersTemperature($options);
                break;
            default:
        }

        return $result;
    }

    private function group_by($key, $data, $unSingle = false)
    {
        $result = array();
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                if ($unSingle) {
                    $result[$val[$key]][] = $val;
                } else {
                    $result[$val[$key]] = $val;
                }
            } else {
                $result[""][] = $val;
            }
        }
        return $result;
    }
}