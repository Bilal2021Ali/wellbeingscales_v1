<?php

namespace Interfaces;

use Types\AttendanceRecord;

interface IAttendanceDTO
{
    public static function run(array $data): AttendanceRecord;
}