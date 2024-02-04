<?php

namespace Koba\Informat\Enums;

enum BurgerlijkeStand: int
{
    case ONGEHUWD = 1;
    case GEHUWD_OF_WETTELIJK_SAMENWONEND = 2;
    case WEDUWNAAR = 3;
    case GESCHEIDEN = 4;
    case FEITELIJK_GESCHEIDEN = 5;
    case ONBEKEND = 6;
}
