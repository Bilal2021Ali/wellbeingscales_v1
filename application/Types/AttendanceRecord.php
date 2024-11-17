<?php

namespace Types;

class AttendanceRecord
{
    public $id;
    public $name;
    public $label;
    public $avatar;
    public $present;
    public $absent;
    public $late;
    public $device = "";

    /**
     * @param int $id
     * @param string $name
     * @param string $label
     * @param string $avatar
     * @param bool|int $present
     * @param bool|int $absent
     * @param bool $late
     */
    public function __construct(int $id, string $name, string $label, string $avatar, $present, $absent, bool $late, string $device = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->avatar = $avatar;
        $this->present = $present;
        $this->absent = $absent;
        $this->late = $late;
        $this->device = $device;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel($label): void
    {
        $this->label = $label;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getPresent(): bool
    {
        return $this->present;
    }

    public function setPresent($present): void
    {
        $this->present = $present;
    }

    public function getAbsent(): bool
    {
        return $this->absent;
    }

    public function setAbsent($absent): void
    {
        $this->absent = $absent;
    }

    public function getLate(): bool
    {
        return $this->late;
    }

    public function setLate($late): void
    {
        $this->late = $late;
    }


    public function presentStatus(): string
    {
        return $this->getPresent() ? "success" : "outline-success";
    }

    public function absentStatus(): string
    {
        return $this->getAbsent() ? "danger" : "outline-danger";
    }

    public function lateStatus(): string
    {
        return $this->getLate() ? "warning" : "outline-warning";
    }

}