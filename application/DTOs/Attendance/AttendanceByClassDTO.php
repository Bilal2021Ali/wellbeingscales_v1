<?php

namespace DTOs\Attendance;

use Types\AttendanceRecord;

class AttendanceByClassDTO implements \Interfaces\IAttendanceDTO
{

    public static function run(array $data): AttendanceRecord
    {
        $absent = intval($data['absent']);
        $present = intval($data['students']) - $absent;
        return new AttendanceRecord(
            $data['id'],
            $data['name'],
            '',
            '',
            $present,
            $absent,
            0
        );
    }
}