<?php

namespace Koba\Informat\Enums;

enum Religion: string
{
    case BLANCO = '0000';
    case CULTUURBESCHOUWING = '0052';
    case EIGEN_CULTUUR_EN_RELIGIE = '0063';
    case ISLAMITISCH = '0135';
    case ISRAELISCH = '0136';
    case KATHOLIEK = '0140';
    case NIET_CONFESSIONELE_ZEDENLEER = '0187';
    case ORTHODOX = '0194';
    case PROTESTANTS_EVANGELISCH = '0225';
    case ANGLICAANS = '0418';
    case NIET_VAN_TOEPASSING = '9999';
}
