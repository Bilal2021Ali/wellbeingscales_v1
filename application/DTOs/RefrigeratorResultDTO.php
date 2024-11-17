<?php

namespace App\DTOs;

require_once __DIR__ . "/../Enums/Refrigerator/RefrigeratorHumidity.php";
require_once __DIR__ . "/../Enums/Refrigerator/RefrigeratorTemperature.php";
require_once __DIR__ . "/../Enums/Refrigerator/RefrigeratorDeviceStatus.php";

use App\Enums\Refrigerator\RefrigeratorDeviceStatus;
use App\Enums\Refrigerator\RefrigeratorHumidity;
use App\Enums\Refrigerator\RefrigeratorTemperature;
use Carbon\Carbon;
use PHPExperts\SimpleDTO\SimpleDTO;
use Types\Label;

class RefrigeratorResultDTO extends SimpleDTO
{
    public const MAX_HUMIDITY = 60;
    public const MIN_HUMIDITY = 40;


    protected Carbon $result_date;
    protected string $temp;
    protected ?string $humidity;
    protected string $user_type;
    protected string $sensor_alive;
    protected string $device_mac;
    protected string $device_description;
    protected string $device_name;
    protected string $min;
    protected string $max;
    protected string $battery_life;

    public function __construct(array $input)
    {
        $input['result_date'] = Carbon::parse($input['result_date']);
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function getTime(): string
    {
        return $this->result_date->format('H:i:s');
    }

    public function getDate(): string
    {
        return $this->result_date->format('Y-m-d');
    }

    public function getTemperatureLabel(): RefrigeratorTemperature
    {
        if ($this->temp > $this->max) {
            return RefrigeratorTemperature::HIGH;
        }

        if ($this->temp < $this->min) {
            return RefrigeratorTemperature::LOW;
        }

        return RefrigeratorTemperature::NORMAL;
    }

    public function getHumidityLabel(): RefrigeratorHumidity
    {
        if (blank($this->humidity)) {
            return RefrigeratorHumidity::NO_DATA;
        }

        if ($this->humidity > self::MAX_HUMIDITY) {
            return RefrigeratorHumidity::HIGH;
        }

        if ($this->humidity < self::MIN_HUMIDITY) {
            return RefrigeratorHumidity::LOW;
        }

        return RefrigeratorHumidity::NORMAL;
    }

    public function getDeviceStatus() : RefrigeratorDeviceStatus
    {
        if (strtolower($this->sensor_alive) === 'live') {
            return RefrigeratorDeviceStatus::LIVE;
        }

        return RefrigeratorDeviceStatus::ERROR;
    }

    public function getDeviceType() : string
    {
        return $this->min . '/' . $this->max;
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }

    public function getHumidity()
    {
        if (blank($this->humidity)) {
            return __("no data");
        }

        return $this->humidity;
    }
}