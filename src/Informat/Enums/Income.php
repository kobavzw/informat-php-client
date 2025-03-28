<?php

namespace Koba\Informat\Enums;

enum Income: int
{
    case UNKNOWN = -1;
    case NONE = 0;
    case NORMAL_INCOME = 1;
    case PENSION = 2;
    case LIMITED_INCOME = 3;
}
