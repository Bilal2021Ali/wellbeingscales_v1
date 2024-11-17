<?php

namespace Traits\Reusable;

trait isSelected
{
    public function isChecked(mixed $value): bool
    {
        return $this->value === $value;
    }

    public function isSelected(mixed $value): string
    {
        return $this->isChecked($value) ? "selected" : "";
    }

}