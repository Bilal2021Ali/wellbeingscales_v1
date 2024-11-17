<?php

namespace App\Enums\Refrigerator;

enum RefrigeratorDeviceStatus
{

    case LIVE;
    case ERROR;

    public function label(): string
    {
        return match ($this) {
            self::LIVE => __("live"),
            self::ERROR => __("error"),
        };
    }

    public function borderColor(): string
    {
        return match ($this) {
            self::LIVE => 'green',
            self::ERROR => 'black',
        };
    }

    public function backgroundColor(): string
    {
        return match ($this) {
            self::LIVE => 'green',
            self::ERROR => 'black',
        };
    }

}
