<?php

namespace DTOs;

require_once __DIR__ . "/../Enums/DoctorProfileFlag.php";

use Carbon\Carbon;
use Enums\DoctorProfileFlag;
use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property string $school_name
 * @property string $student_name
 * @property string $profile_title
 * @property string $national_id
 * @property string $gender
 * @property Carbon $birthday
 * @property string $class_name
 * @property string $grade_name
 * @property Carbon $order_date
 * @property string $test_title
 * @property string $result
 */
class DoctorReportDTO extends SimpleDTO
{
    private const DATE_FORMAT = 'Y-m-d';
    private const TIME_FORMAT = 'H:i';

    protected string $school_name;
    protected string $student_name;
    protected string $national_id;
    protected string $gender;
    protected Carbon $birthday;
    protected string $class_name;
    protected string $flag;
    protected string $grade_name;
    protected string $profile_title;
    protected Carbon $order_date;
    protected string $test_title;
    protected string $result;

    public function __construct(array $input)
    {
        $config = new \CI_Config();
        $input['grade_name'] = collect($config->item('av_grades'))->first(fn($grade) => strtolower($grade['value']) == strtolower($input['grade']))['name'] ?? '--';

        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function getBirthday(): string
    {
        return $this->birthday->format(self::DATE_FORMAT);
    }

    public function getAge(): int
    {
        return $this->birthday->diffInYears(Carbon::now());
    }

    public function getOrderDate(): string
    {
        return $this->order_date->format(self::DATE_FORMAT);
    }


    public function getOrderTime(): string
    {
        return $this->order_date->format(self::TIME_FORMAT);
    }

    public function getFlag(): DoctorProfileFlag
    {
        return DoctorProfileFlag::from($this->flag);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }
}