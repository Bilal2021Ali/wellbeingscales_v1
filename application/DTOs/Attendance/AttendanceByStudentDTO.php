<?php

namespace App\DTOs\Attendance;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property string $student_name
 * @property string $class
 * @property string $grade
 * @property string $gender
 * @property string $bus_name
 * @property string $bus_description
 * @property string $time_in_am
 * @property string $time_out_am
 * @property string $time_in_pm
 * @property string $time_out_pm
 * @property string $school_name
 */
class AttendanceByStudentDTO extends SimpleDTO
{

    protected string $student_name;
    protected string $class;
    protected string $grade;
    protected string $gender;
    protected string $bus_name;
    protected ?string $time_in_am;
    protected ?string $time_out_am;
    protected ?string $time_in_pm;
    protected ?string $time_out_pm;
    protected string $school_name;
    protected string $date;

    public const FULL_DATE_FORMAT = "Y-m-d H:i:s";

    public function __construct(array $input)
    {
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    private function convertTimeCarbon(string $time): Carbon
    {
        $date = $this->date . " " . $time;
        return Carbon::createFromFormat(self::FULL_DATE_FORMAT, $date);
    }

    public function getInDateAm(): ?Carbon
    {
        if (empty($this->time_in_am)) return null;
        return $this->convertTimeCarbon($this->time_in_am);
    }

    public function getOutDateAm(): ?Carbon
    {
        if (empty($this->time_out_am)) return null;
        return $this->convertTimeCarbon($this->time_out_am);
    }

    public function getInDatePm(): ?Carbon
    {
        if (empty($this->time_in_pm)) return null;
        return $this->convertTimeCarbon($this->time_in_pm);
    }

    public function getOutDatePm(): ?Carbon
    {
        if (empty($this->time_out_pm)) return null;
        return $this->convertTimeCarbon($this->time_out_pm);
    }

    public function getTripTimeAm(): string
    {
        $outDate = $this->getOutDateAm();
        $inDate = $this->getInDateAm();

        if (empty($inDate) || empty($outDate)) {
            return "--";
        }

        return $outDate->diffForHumans($inDate, CarbonInterface::DIFF_ABSOLUTE);
    }

    public function getTrimTimePm(): string
    {
        $outDate = $this->getOutDatePm();
        $inDate = $this->getInDatePm();

        if (empty($inDate) || empty($outDate)) {
            return "--";
        }

        return $outDate->diffForHumans($inDate, CarbonInterface::DIFF_ABSOLUTE);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }


    private function getDataWithFallback(?string $data): string
    {
        if (empty($data)) {
            return '--';
        }

        return $data;
    }

    public function getTimeInAm(): string
    {
        return $this->getDataWithFallback($this->time_in_am);
    }

    public function getTimeOutAm(): string
    {
        return $this->getDataWithFallback($this->time_out_am);
    }

    public function getTimeInPm(): string
    {
        return $this->getDataWithFallback($this->time_in_pm);
    }

    public function getTimeOutPm(): string
    {
        return $this->getDataWithFallback($this->time_out_pm);
    }
}
