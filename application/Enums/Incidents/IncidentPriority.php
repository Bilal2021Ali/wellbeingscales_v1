<?php

namespace Enums\Incidents;

require_once __DIR__ . "/../../Traits/Reusable/isSelected.php";

use Exception;
use Traits\Reusable\isSelected;
use Types\Label;

enum IncidentPriority: int
{
    use isSelected;

    case UNKNOWN = 0;
    case LOW = 1;
    case AVERAGE = 2;
    case HIGH = 3;

    public function text(): string
    {
        return match ($this) {
            self::UNKNOWN => __('unknown'),
            self::LOW => __('low'),
            self::AVERAGE => __('average'),
            self::HIGH => __('high')
        };
    }

    public function label(): Label
    {
        return match ($this) {
            self::UNKNOWN => new Label("#343a40 ", "#fff"),
            self::LOW => new Label("#34c38f", "#fff"),
            self::AVERAGE => new Label("#f1b44c", "#fff"),
            self::HIGH => new Label("#f46a6a", "#fff")
        };
    }
}
