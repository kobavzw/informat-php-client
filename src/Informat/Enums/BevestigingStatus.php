<?php

namespace Koba\Informat\Enums;

enum BevestigingStatus: int
{
    case NOT_SENT = 0;
    case SENT = 1;
    case CONFIRMED = 2;
    case CONFIRMED_BY_SECRETARIAT = 3;
}
