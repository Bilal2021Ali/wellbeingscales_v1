<?php

namespace Enums\Incidents;
require_once __DIR__ . "/../../Traits/Reusable/isSelected.php";

use Traits\Reusable\isSelected;

enum IncidentStatus: int
{
    use isSelected;

    case OPEN = 1;
    case IN_PROGRESS = 2;
    case ON_HOLD = 3;
    case COMPLETED = 4;

    public function text(): string
    {
        return match ($this) {
            self::OPEN => __("open"),
            self::IN_PROGRESS => __("in_progress"),
            self::ON_HOLD => __("on_hold"),
            self::COMPLETED => __("completed"),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN => "info",
            self::IN_PROGRESS => "warning",
            self::ON_HOLD => "gray",
            self::COMPLETED => "success",
        };
    }

    public function backgroundStyle(): string
    {
        $background = $this->background();
        return "background: url('" . base_url("assets/images/schoolDashboard/$background") . "');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-color: #ffffff";
    }

    public function background(): string
    {
        return match ($this) {
            self::OPEN => "students03.png",
            self::IN_PROGRESS => "teacher02.png",
            self::ON_HOLD => "staff01.png",
            self::COMPLETED => "sites04.png",
        };
    }
}
