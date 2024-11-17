<?php

namespace App\Enums;

enum UserTypeEnum: int
{
    case STAFF = 1;
    case STUDENT = 2;
    case TEACHER = 3;
    case PARENT = 4;
}
