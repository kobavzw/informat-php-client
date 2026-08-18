<?php

namespace Koba\Informat\Enums;

enum SendStatus: int
{
    case TE_VERSTUREN = 1;
    case BEZIG = 2;
    case VALIDATIE_FOUT = 3;
    case VERWERKT = 4;
    case AGODI_FOUT = 5;
    case SYSTEEMFOUT = 6;
}
