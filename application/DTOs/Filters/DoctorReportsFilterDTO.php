<?php

namespace DTOs\Filters;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class DoctorReportsFilterDTO
{
    private ?string $test = null;
    private ?Collection $classes = null;
    private ?Collection $grades = null;
    private ?Collection $genders = null;
    private ?Collection $profiles = null;
    private ?Carbon $from = null;
    private ?Carbon $to = null;

    public static function builder(): static
    {
        return new static();
    }

    public function getTest(): ?string
    {
        return $this->test;
    }

    public function setTest(?string $test): void
    {
        $this->test = $test;
    }

    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function setClasses(array $classes): void
    {
        $this->classes = collect($classes);
    }

    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function setGrades(array $grades): void
    {
        $this->grades = collect($grades);
    }

    public function getGenders(): Collection
    {
        return $this->genders;
    }

    public function setGenders(array $genders): void
    {
        $this->genders = collect($genders);
    }

    public function getFrom(): Carbon
    {
        return $this->from;
    }

    public function setFrom(string $from): void
    {
        $this->from = Carbon::parse($from);
    }

    public function getTo(): Carbon
    {
        return $this->to;
    }

    public function setTo(string $to): void
    {
        $this->to = Carbon::parse($to);
    }

    public function hasTest(): bool
    {
        return $this->test !== null;
    }

    public function hasClasses(): bool
    {
        return $this->classes !== null && !$this->classes->isEmpty();
    }

    public function hasGrades(): bool
    {
        return $this->grades !== null && !$this->grades->isEmpty();
    }

    public function hasGenders(): bool
    {
        return $this->genders !== null && !$this->genders->isEmpty();
    }

    public function hasFrom(): bool

    {
        return $this->from !== null;
    }

    public function hasTo(): bool
    {
        return $this->to !== null;
    }

    public function getProfiles(): ?Collection
    {
        return $this->profiles;
    }

    public function setProfiles(?array $profiles): void
    {
        $this->profiles = collect($profiles);
    }

    public function hasProfiles(): bool
    {
        return $this->profiles !== null && !$this->profiles->isEmpty();
    }
}