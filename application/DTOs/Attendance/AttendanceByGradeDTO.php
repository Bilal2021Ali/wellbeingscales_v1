<?php

namespace DTOs\Attendance;

use Types\AttendanceRecord;

class AttendanceByGradeDTO implements \Interfaces\IAttendanceDTO
{

    public static function run(array $data): AttendanceRecord
    {
        $absent = intval($data['absent']);
        $present = intval($data['total']) - $absent;
        return new AttendanceRecord(
            0,
            $data['name'],
            '',
            '',
            $present,
            $absent,
            0
        );
    }
}