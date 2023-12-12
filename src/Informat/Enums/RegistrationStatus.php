<?php

namespace Koba\Informat\Enums;

enum RegistrationStatus: int
{
    case GEREALISEERD = 0;
    case NIET_GEREALISEERD = 1;
    case UITGESTELD = 2;
    case PARALLEL = 3;
    case AANMELDING = 4;
}
