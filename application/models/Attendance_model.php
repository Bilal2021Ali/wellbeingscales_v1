<?php
require_once __DIR__ . "/../Enums/AttendanceStatuses.php";
require_once __DIR__ . "/../DTOs/Attendance/AttendanceByStudentDTO.php";

use App\DTOs\Attendance\AttendanceByStudentDTO;
use Carbon\Carbon;
use Enums\AttendanceStatuses;
use Illuminate\Support\Collection;

/**
 * @property CI_DB_query_builder $db
 */
class Attendance_model extends CI_Model
{
    public array $schools = [];
    protected string $language;

    public function setSchools($schools): self
    {
        $this->schools = is_array($schools) ? $schools : [$schools];
        return $this;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;
        return $this;
    }

    public function get_attendance_by_vehicles(): array
    {
        return $this->db->select("Student_Detail_Vehicle.* , l2_vehicle.No_vehicle as vehicleNo , l2_vehicle_type.type , l2_vehicle_type.type_ar")
            ->select("SUM(Student_Detail_Vehicle.Day_absent) as absentTotal")
            ->select("(SELECT COUNT(*) FROM l2_vehicle_students WHERE l2_vehicle_students.car_id = Student_Detail_Vehicle.car_id AND l2_vehicle_students.Added_by IN (" . implode(',', $this->schools) . ") ) AS students")
            ->join("l2_vehicle", "Student_Detail_Vehicle.car_id = l2_vehicle.Id")
            ->join("l2_vehicle_type", "l2_vehicle_type.Id = l2_vehicle.type_vehicle")
            ->where_in("Student_Detail_Vehicle.Added_By", $this->schools)
            ->group_by("Student_Detail_Vehicle.car_id")
            ->get("Student_Detail_Vehicle")
            ->result_array();
    }

    public function get_attendance_for_vehicle(int $carId, string $status): array
    {
        $isPresent = $status === AttendanceStatuses::PRESENT;
        return $this->db->select("CONCAT(l2_student.`F_name_EN`,' ',l2_student.`L_name_EN`) AS name_en,CONCAT(l2_student.`F_name_AR`,' ',l2_student.`L_name_AR`) AS name_ar , l2_avatars.Link as avatar, l2_student.Id as id , l2_student.Phone , Student_Detail_Vehicle.Day_absent as isAbsent")
            ->select(", (SELECT D_Id FROM `l2_devices` WHERE `l2_devices`.`car_id` = `l2_vehicle`.`Id` AND `l2_devices`.`Added_By` IN  (" . implode(',', $this->schools) . ") ORDER BY Id DESC LIMIT 1 ) AS `watch_mac`")
            ->from("l2_vehicle_students")
            ->join("l2_student", "l2_student.Id = l2_vehicle_students.student_id")
            ->join("l2_vehicle", "l2_vehicle.Id = l2_vehicle_students.car_id")
            ->join("l2_vehicle_type", "l2_vehicle_type.Id = l2_vehicle.type_vehicle")
            ->join("Student_Detail_Vehicle", "Student_Detail_Vehicle.Id = l2_student.Id")
            ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
            ->where_in("l2_student.Added_By", $this->schools)
            ->where_in("l2_vehicle_students.Added_By", $this->schools)
            ->where("l2_vehicle_students.car_id", $carId)
            ->where("Day_absent", $isPresent ? 0 : 1)
            ->group_by("l2_student.Id")
            ->get()
            ->result_array();
    }

    public function get_attendance_for_classes(): array
    {
        return $this->db->select('r_levels.Class AS class_en , r_levels.Class_ar AS class_ar , r_levels.Id AS id')
            ->select('get_absent_fnc(l2_school_classes.school_id,r_levels.Id,1,1) as absent')
            ->select('(SELECT COUNT(*) FROM l2_student WHERE Added_By IN (' . implode(',', $this->schools) . ') AND l2_student.Class = r_levels.Id) AS students')
            ->from('l2_school_classes')
            ->join('r_levels', 'r_levels.Id = l2_school_classes.class_key')
            ->where_in('l2_school_classes.school_id', $this->schools)
            ->order_by('r_levels.Id', 'ASC')->get()->result_array();
    }

    public function get_attendance_for_grades(int $classId): array
    {
        $results = $this->db->select("school_class_grades_v.*")
            ->select('(SELECT COUNT(*) FROM l2_student WHERE Added_By IN (' . implode(',', $this->schools) . ')
             AND l2_student.Class = school_class_grades_v.class_id AND l2_student.Grades = school_class_grades_v.Grades) AS students')
            ->where("class_id", $classId)
            ->where_in("Added_By", $this->schools)
            ->group_by("Grades")
            ->get("school_class_grades_v")
            ->result_array();
        //  echo $this->db->last_query();
        return array_reduce($results, function ($carry, $item) {
            $key = $item['Grades'];
            $carry[$key][] = $item;
            return $carry;
        }, []);
    }

    public function grade_attendance(int $class, string $grade, string $status): array
    {
        $isPresent = $status === AttendanceStatuses::PRESENT;
        $this->db->select("CONCAT(l2_student.`F_name_EN`,' ',l2_student.`L_name_EN`) AS name_en,CONCAT(l2_student.`F_name_AR`,' ',l2_student.`L_name_AR`) AS name_ar , l2_avatars.Link as avatar, l2_student.Id as id , l2_student.Phone , l2_student.watch_mac , (attendance_date IS NULL OR attendance_date != CURDATE()) as isAbsent")
            ->from('l2_student')
            ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
            ->where_in("l2_student.Added_By", $this->schools)
            ->where("Class", $class)
            ->where("Grades", $grade);
        if ($isPresent) {
            $this->db->where("attendance_date = CURDATE()");
        } else {
            $this->db->where("(attendance_date IS NULL OR attendance_date != CURDATE())");
        }
        return $this->db->get()->result_array();
    }

    public function get_students_attendance(Carbon $date, array $vehicles = []): Collection
    {
        $isAr = strtolower($this->language) === 'ar';
        $classColumn = $isAr ? 'Class_ar' : 'Class';
        $schoolName = $isAr ? 'School_Name_AR' : 'School_Name_EN';

        $subQueryColumns = [
            'P_Buss_t_am' => 'time_in_am',
            'Off_Buss_t_am' => 'time_out_am',
            'P_Buss_t_pm' => 'time_in_pm',
            'Off_Buss_t_pm' => 'time_out_pm'
        ];
        $subQueryBuilder = clone $this->db;

        $this->db->select([
            'lvs.student_id',
            'lvs.car_id',
            'lvs.Added_by',
            'l2_vehicle.No_vehicle as bus_name',
            'l2_student.Grades as grade',
            'l2_student.Gender as gender',
            'CONCAT(l2_student.`F_name_' . $this->language . '`," ",l2_student.`L_name_' . $this->language . '`) AS student_name',
            "r_levels.{$classColumn} as class",
            "l1_school.{$schoolName} as school_name",
            "'{$date->format('Y-m-d')}' as date"
        ]);

        foreach ($subQueryColumns as $key => $column) {
            $subQuery = $subQueryBuilder->select("lvss.$key as $column")
                ->from('l2_vehicle_students_status lvss')
                ->where('lvs.student_id = lvss.student_id')
                ->where('created', $date->format('Y-m-d'))
                ->limit(1)
                ->get_compiled_select();

            $this->db->select("($subQuery) as $column");
        }

        $this->db->from('l2_vehicle_students lvs')
            ->join("l2_student", 'l2_student.id = lvs.student_id')
            ->join("l2_vehicle", 'l2_vehicle.id = lvs.car_id')
            ->join('r_levels', 'r_levels.Id = l2_student.Class')
            ->join('l1_school', 'l1_school.Id = l2_student.Added_By')
            ->where_in('l1_school.Id', $this->schools)
            ->where_in('l2_vehicle.Added_By', $this->schools);

        if (!empty($vehicles)) {
            $this->db->where_in('l2_vehicle.Id', $vehicles);
        }

        $results = $this->db->get()->result_array();
        return collect($results)->mapInto(AttendanceByStudentDTO::class);
    }
}