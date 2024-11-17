<?php

namespace Enums\Incidents;

require_once __DIR__ . "/../../Traits/Reusable/isSelected.php";

use Traits\Reusable\isSelected;
use Types\Label;

enum IncidentCategory: int
{
    use isSelected;

    case UNKNOWN = 0;
    case REPAIR = 1;
    case TODO = 2;
    case ISSUE = 3;
    case MAINTENANCE = 4;


    public function text(): string
    {
        return match ($this) {
            self::REPAIR => __("repair"),
            self::TODO => __("todo"),
            self::ISSUE => __("issue"),
            self::MAINTENANCE => __("maintenance"),
            default => __("unknown"),
        };
    }

    public function label(): Label
    {
        return match ($this) {
            self::REPAIR => new Label("#9fd3c7", "#fff"),
            self::TODO => new Label("#f95959", "#fff"),
            self::ISSUE => new Label("#ff6f3c", "#fff"),
            self::MAINTENANCE => new Label("#005792", "#fff"),
            self::UNKNOWN => new Label("#222831", "#fff"),
        };
    }

}
