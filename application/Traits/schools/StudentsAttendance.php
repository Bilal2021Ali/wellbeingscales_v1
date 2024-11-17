<?php

namespace App\Traits\schools;
require_once __DIR__ . "/../Reusable/CanInitializeAttendance.php";

use App\DTOs\Attendance\AttendanceByStudentDTO;
use App\Traits\Reusable\CanInitializeAttendance;
use Carbon\Carbon;

use CI_Input;
use CI_Loader;
use CI_Config;
use CI_DB_query_builder;
use CI_Lang;
use CI_URI;
use Response;
use Attendance_model;

/**
 * @property Response $response
 * @property CI_Lang $lang
 * @property Attendance_model $Attendance_model
 * @property CI_URI $uri
 * @property CI_DB_query_builder $db
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Loader $load
 * @method array getAccountSupportedIds
 */
trait StudentsAttendance
{
    use CanInitializeAttendance;

    private function getStudentAttendanceDateFilter(): Carbon
    {
        $date = $this->input->post('date');
        if (empty($date)) {
            return Carbon::now();
        }

        return Carbon::createFromFormat("Y-m-d", $date);
    }

    public function student_buss_attendance(): void
    {
        $model = $this->initializeAttendance();

        $data['date'] = $this->getStudentAttendanceDateFilter();
        $this->response->abort_if(400, $data['date']->isFuture());

        $selectedVehicles = $this->input->post('vehicles') ?? [];
        $accountsIds = $this->getAccountSupportedIds();
        $data['vehicles'] = $this->db->select('l2_vehicle.*, l2_vehicle_type.type AS type_vehicle')
            ->join('l2_vehicle_type', 'l2_vehicle_type.Id = l2_vehicle.type_vehicle', 'LEFT')
            ->where_in('Added_By', $accountsIds)
            ->get("l2_vehicle")
            ->result_array();
        $data['isMinistry'] = self::TYPE === "ministry";

        if ($this->input->method() === 'post') {
            $schoolsIds = $this->input->post('schools') ?? [];

            if ($data['isMinistry']) {
                $ids = collect($accountsIds);
                $model->setSchools($ids->toArray());
                if (!empty($schoolsIds)) {
                    $ids = $ids->filter(fn($id) => in_array($id, $schoolsIds))->unique()->toArray();
                    $model->setSchools($ids);
                }
            }

            $data['results'] = $model->get_students_attendance($data['date'], $selectedVehicles);
            $this->load->view('Shared/Attendance/inc/students-attendance-table', $data);
            return;
        }

        if ($data['isMinistry']) {
            $data['schools'] = collect($this->sv_ministry_reports->our_schools())->map(fn($school) => [
                'name' => $school['School_Name_' . self::LANGUAGE],
                'Id' => $school['Id']
            ]);
        }

        $data['page_title'] = "Reports";
        $this->show("Shared/Attendance/students-buss-attendance", $data);
    }
}