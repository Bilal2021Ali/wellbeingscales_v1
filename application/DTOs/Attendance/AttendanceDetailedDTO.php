<?php

namespace DTOs\Attendance;

use Interfaces\IAttendanceDTO;
use Types\AttendanceRecord;

class AttendanceDetailedDTO implements IAttendanceDTO
{

    public static function run(array $data): AttendanceRecord
    {
        $absent = intval($data['isAbsent']);
        $avatar = $data['avatar'] ?? "uploads/avatars/default_avatar.jpg";
        return new AttendanceRecord(
            $data['id'],
            $data['name'],
            $data['Phone'],
            base_url($avatar),
            $absent === 0,
            $absent === 1,
            0,// TODO : get the actual results
            $data['watch_mac'] ?? ""
        );
    }
}