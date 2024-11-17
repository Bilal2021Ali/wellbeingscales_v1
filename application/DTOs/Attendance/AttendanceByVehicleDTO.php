<?php

namespace DTOs\Attendance;

use Interfaces\IAttendanceDTO;
use Types\AttendanceRecord;

class AttendanceByVehicleDTO implements IAttendanceDTO
{

    public static function run(array $data): AttendanceRecord
    {
        $absent = intval($data['absentTotal']);
        return new AttendanceRecord(
            $data['car_id'],
            $data['type'],
            $data['vehicleNo'],
            "",
            intval($data['students']) - $absent,
            $absent,
            0 // TODO : get the actual results
        );
    }
}