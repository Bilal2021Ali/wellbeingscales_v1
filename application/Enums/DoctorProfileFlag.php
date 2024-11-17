<?php

namespace Enums;

use Types\Label;

enum DoctorProfileFlag: string
{
    case L = "L";
    case N = "N";
    case H = "H";


    public function getLabel(): Label
    {
        return match ($this) {
            self::L => new Label("#0070c0", "#ffff"),
            self::N => new Label("#00b050", "#ffff"),
            self::H => new Label("#ff0000", "#ffff"),
        };
    }

}