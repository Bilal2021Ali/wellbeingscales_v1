<?php

namespace Enums;

class AttendanceStatuses
{
    public const PRESENT = "present";
    public const ABSENT = "absent";
    public const LATE = "late";

    public static function isPresent(array $record): bool
    {
        return intval($record['present']) > 0;
    }

    public static function isAbsent(array $record): bool
    {
        return intval($record['present']) === 0;
    }

    public static function isLate(array $record): bool
    {
        return false; // TODO : calculate the actual result
    }

    public static function getPresentClass(array $record): string
    {
        return self::isPresent($record) ? "success" : "outline-success";
    }

    public static function getAbsentClass(array $record): string
    {
        return self::isAbsent($record) ? "danger" : "outline-danger";
    }

    public static function getLateClass(array $record): string
    {
        return self::isLate($record) ? "warning" : "outline-warning";
    }
}