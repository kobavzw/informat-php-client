<?php

namespace Koba\Informat\Enums;

enum PreregistrationStatus: string
{
    case OPEN = 'open';
    case ACCEPTED = 'geaccepteerd';
    case REFUSED = 'geweigerd';
}
