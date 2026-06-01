<?php

namespace Koba\Informat\Enums;

enum RlTekenStatus: string
{
    case OPGEHAALD = 'Opgehaald';
    case BEKEKEN = 'Bekeken';
    case ONDERTEKEND = 'Ondertekend';
    case GEWEIGERD = 'Geweigerd';
    case MISLUKT = 'Mislukt';
}
