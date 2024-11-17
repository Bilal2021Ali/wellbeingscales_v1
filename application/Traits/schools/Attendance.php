<?php

namespace Traits\schools;

require_once __DIR__ . "/../../Enums/AttendanceStatuses.php";
require_once __DIR__ . "/../Reusable/CanInitializeAttendance.php";

use App\Traits\Reusable\CanInitializeAttendance;
use Attendance_model;
use Carbon\Carbon;
use CI_Config;
use CI_DB_query_builder;
use CI_Lang;
use CI_URI;
use DTOs\Attendance\AttendanceByClassDTO;
use DTOs\Attendance\AttendanceByGradeDTO;
use DTOs\Attendance\AttendanceDetailedDTO;
use DTOs\Attendance\AttendanceByVehicleDTO;
use Enums\AttendanceStatuses;
use Response;
use Types\AttendanceRecord;

/**
 * @property Response $response
 * @property CI_Lang $lang
 * @property Attendance_model $Attendance_model
 * @property CI_URI $uri
 * @property CI_DB_query_builder $db
 * @property CI_Config $config
 */
trait Attendance
{
    use CanInitializeAttendance;

    private function getFullLanguageName(): string
    {
        return self::LANGUAGE === "EN" ? "English" : "Arabic";
    }

    public function attendance()
    {
        $this->initializeAttendance();

        // TODO : use better icons
        $data['links'] = [
            [
                'name' => __("attendance_by_vehicle"),
                "link" => base_url(self::LANGUAGE . '/schools/vehicle-attendance'),
                "desc" => "",
                "icon" => "LabReports.png"
            ],
            [
                'name' => __("attendance_by_class"),
                "link" => base_url(self::LANGUAGE . '/schools/class-attendance'),
                "desc" => "",
                "icon" => "LabReports.png"
            ],
        ];
        $data['page_title'] = "QlickSystems | List all ";
        $this->show('EN/Global/Links/Lists', $data);
    }

    private static function getAbsentsCount(array $records): int
    {
        return array_sum(array_map(function ($item) {
            return $item->absent;
        }, $records));
    }

    private function show_vehicle_report()
    {
        $model = $this->initializeAttendance();

        $data['page_title'] = "QlickSystems | Vehicle Attendance";
        $results = $model->get_attendance_by_vehicles();

        $data['total'] = count($results);

        $nameKey = $this->getFullLanguageName() . '_Name';
        $typeKey = 'type' . (self::LANGUAGE === "EN" ? "" : "_ar");
        $data['results'] = array_map(function ($item) use ($nameKey, $typeKey) {
            $item['name'] = $item[$nameKey];
            $item['type'] = $item[$typeKey];
            return AttendanceByVehicleDTO::run($item);
        }, $results);
        $data['absent'] = self::getAbsentsCount($data['results']);
        $data['present'] = $data['total'] - $data['absent'];
        $data['actionBuilder'] = function (int $id): string {
            return base_url(self::LANGUAGE . "/schools/vehicle-attendance/{$id}");
        };
        $data['isDetailedList'] = false;

        $this->show('Shared/Attendance/by-vehicle', $data);
    }

    private function isValidAttendanceStatus(string $status): bool
    {
        return in_array($status, [AttendanceStatuses::ABSENT, AttendanceStatuses::PRESENT]);
    }

    public function show_detailed_vehicle_report(int $carId)
    {
        $this->response->abort_if(404, !is_numeric($carId));

        $status = $this->uri->segment(5);
        $this->response->abort_if(404, !$this->isValidAttendanceStatus($status));

        $model = $this->initializeAttendance();

        $data['page_title'] = "QlickSystems | Vehicle Attendance";
        $results = $model->get_attendance_for_vehicle($carId, $status);
        $data = $this->mapDetailedStudentsReports($results);
        $data['isDetailedList'] = true;
        $data['activeStatus'] = $status;
        $data['messages'] = $this->db->get("r_messages")->result_array();

        $this->show('Shared/Attendance/students-list', $data);
    }

    public function vehicle_attendance()
    {
        $cardId = $this->uri->segment(4);
        if (empty($cardId)) {
            $this->show_vehicle_report();
        } else {
            $this->show_detailed_vehicle_report($cardId);
        }
    }

    public function class_attendance()
    {
        $model = $this->initializeAttendance();
        $data['page_title'] = "QlickSystems | Vehicle Attendance";

        $results = $model->get_attendance_for_classes();
        $data['total'] = array_sum(array_map(function ($item) {
            return intval($item['students']);
        }, $results));

        $data['results'] = array_map(function ($item) {
            $item['name'] = $item['class_' . strtolower(self::LANGUAGE)];
            return AttendanceByClassDTO::run($item);
        }, $results);

        $data['absent'] = self::getAbsentsCount($data['results']);
        $data['present'] = $data['total'] - $data['absent'];
        $data['actionBuilder'] = function (int $id): string {
            return base_url(self::LANGUAGE . "/schools/grades-attendance/{$id}");
        };

        $this->show('Shared/Attendance/by-classes', $data);
    }

    public function grades_attendance()
    {
        $classId = $this->uri->segment(4);
        $this->response->abort_if(404, empty($classId) || !is_numeric($classId));

        $model = $this->initializeAttendance();
        $data['page_title'] = "QlickSystems | Vehicle Attendance";

        $results = $model->get_attendance_for_grades($classId);
        $data['total'] = array_sum(array_map(function ($item) {
            $result = reset($item);
            return empty($result) ? 0 : intval($result['students']);
        }, $results));


        $data['results'] = array_map(function ($item) use ($results) {
            $record = $results[$item['value']] ?? null;
            $result = empty($record) ? null : reset($record);
            $data['total'] = empty($result) ? 0 : intval($result['students']);
            $data['absent'] = empty($result) ? 0 : intval($result['Absent']);
            $data['name'] = $item['name'];

            return AttendanceByGradeDTO::run($data);
        }, (array)$this->config->item('av_grades'));


        $data['absent'] = self::getAbsentsCount($data['results']);
        $data['present'] = $data['total'] - $data['absent'];
        $data['detailsBuilder'] = function (int $id) use ($classId): string {
            return base_url(self::LANGUAGE . "/schools/grade-reports/{$classId}/{$id}");
        };
        $this->show('Shared/Attendance/by-grades', $data);
    }

    public function grade_reports()
    {
        $class = $this->uri->segment(4);
        $this->response->abort_if(404, empty($class) || !is_numeric($class));

        $gradeKey = $this->uri->segment(5);
        $grades = $this->config->item('av_grades');
        $this->response->abort_if(404, !is_numeric($gradeKey) || !isset($grades[$gradeKey]));

        $status = $this->uri->segment(6);
        $this->response->abort_if(404, !$this->isValidAttendanceStatus($status));

        $model = $this->initializeAttendance();
        $grade = $grades[$gradeKey];

        $results = $model->grade_attendance($class, $grade['value'], $status);
        $data = $this->mapDetailedStudentsReports($results);

        $data['page_title'] = "QlickSystems | Vehicle Attendance";
        $data['isDetailedList'] = true;
        $data['activeStatus'] = $status;
        $data['messages'] = $this->db->get("r_messages")->result_array();

        $this->show('Shared/Attendance/students-list', $data);
    }

    public function vehicle_drivers()
    {
        $this->initializeAttendance();
        $carId = $this->uri->segment(4);
        $this->response->abort_if(404, empty($carId) || !is_numeric($carId));

        $drivers = $this->db->select("CONCAT(l2_teacher.F_name_" . self::LANGUAGE . ", ' ', l2_teacher.L_name_" . self::LANGUAGE . ") AS fullName, Gender , DOP, Nationality , National_Id ")
            ->from('l2_teacher')
            ->join('l2_vehicle_drivers', 'l2_vehicle_drivers.teacher_id = l2_teacher.Id and l2_vehicle_drivers.car_id = ' . $this->db->escape($carId))
            ->join('l2_avatars', 'l2_avatars.For_User = l2_teacher.Id and l2_avatars.Type_Of_User = "Teacher"', 'left')
            ->where('l2_teacher.Added_By', $this->sessionData['admin_id'])
            ->where('EXISTS(SELECT Id FROM l2_vehicle_drivers WHERE teacher_id = l2_teacher.Id and car_id = ' . $this->db->escape($carId) . ')')
            ->get()
            ->result_array();

        foreach ($drivers as $key => $driver) {
            $this->load->view("Shared/Attendance/driver", [
                'driver' => $driver,
                'key' => $key
            ]);
        }
    }

    public function vehicle_data()
    {
        $this->initializeAttendance();
        $carId = $this->uri->segment(4);
        $this->response->abort_if(404, empty($carId) || !is_numeric($carId));

        $language = self::LANGUAGE === "EN" ? "" : "_ar";
        $data = $this->db->select("l2_vehicle.No_vehicle as no , l2_vehicle_type.type" . $language . " as type , l2_vehicle.Color_vehicle as color , l2_vehicle.Model_vehicle as model")
            ->join("l2_vehicle_type", "l2_vehicle_type.Id = l2_vehicle.type_vehicle")
            ->where("l2_vehicle.Id", $carId)->where("Added_By", $this->sessionData['admin_id'])
            ->get("l2_vehicle")->row();
        if (empty($data)) {
            echo "No Data";
            return;
        }

        $this->load->view("Shared/Attendance/vehicle", [
            'data' => $data
        ]);
    }

    /**
     * @param array $results
     * @return array
     */
    private function mapDetailedStudentsReports(array $results): array
    {
        $data['results'] = array_map(function ($item) {
            $item['name'] = $item['name_' . strtolower(self::LANGUAGE)];
            return AttendanceDetailedDTO::run($item);
        }, $results);
        $data['total'] = count($results);
        $data['absent'] = self::getAbsentsCount($data['results']);
        $data['present'] = $data['total'] - $data['absent'];
        return $data;
    }
}