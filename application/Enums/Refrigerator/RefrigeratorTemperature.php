<?php

namespace App\Enums\Refrigerator;

enum RefrigeratorTemperature
{
    case HIGH;
    case LOW;
    case NORMAL;

    public function label(): string
    {
        return match ($this) {
            RefrigeratorTemperature::HIGH => __("high error"),
            RefrigeratorTemperature::LOW => __("freezing"),
            RefrigeratorTemperature::NORMAL => __("normal"),
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            RefrigeratorTemperature::HIGH => 'error',
            RefrigeratorTemperature::LOW => 'low',
            RefrigeratorTemperature::NORMAL => 'normal',
        };
    }

}