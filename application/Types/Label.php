<?php

namespace Types;

class Label
{
    public string $background;
    public string $color;

    public function __construct(string $background, string $color)
    {
        $this->background = trim($background);
        $this->color = trim($color);
    }

    public function toStyle(): string
    {
        return "background-color: $this->background; color: $this->color";
    }

    public function __toString(): string
    {
        return $this->toStyle();
    }
}