<?php

namespace App\Enums\Refrigerator;

enum RefrigeratorHumidity
{
    case NO_DATA;
    case HIGH;
    case LOW;
    case NORMAL;

    public function cssClass(): string
    {
        return match ($this) {
            self::NO_DATA => 'no-data',
            self::HIGH => 'high',
            self::LOW => 'low',
            self::NORMAL => 'normal',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::NO_DATA => __("no data"),
            self::HIGH => __("too humid"),
            self::LOW => __("too dry"),
            self::NORMAL => __("optimal")
        };
    }
}