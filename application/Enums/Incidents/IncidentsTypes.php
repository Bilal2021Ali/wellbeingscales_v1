<?php

namespace Enums\Incidents;

enum IncidentsTypes: string
{
    case PASS = "Yes";
    case FAIL = "No";

    public function text(): string
    {
        return match ($this) {
            self::PASS => __("yes"),
            self::FAIL => __("no"),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PASS => "success",
            self::FAIL => "danger",
        };
    }

    public function isActive(): bool
    {
        return $this->value === self::PASS->value;
    }
}
