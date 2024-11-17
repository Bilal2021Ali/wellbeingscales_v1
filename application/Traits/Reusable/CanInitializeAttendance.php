<?php

namespace App\Traits\Reusable;

use Carbon\Carbon;
use Enums\AttendanceStatuses;
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
 */
trait CanInitializeAttendance
{
    private function initializeAttendance(): Attendance_model
    {
        if (self::TYPE === "school") {
            $this->response->permission_gate($this->permissions_array["attendance_permissions"], $this);
        }
        $this->lang->load('Attendance', self::LANGUAGE === "EN" ? "english" : "arabic");
        $this->load->model('Attendance_model');
        $this->load->vars([
            "attendanceStatuses" => new AttendanceStatuses(),
            "activeLanguage" => self::LANGUAGE
        ]);

        Carbon::setLocale(self::LANGUAGE);
        return $this->Attendance_model->setSchools($this->sessionData['admin_id'])->setLanguage(self::LANGUAGE);
    }
}