<?php

namespace Koba\Informat\Enums;

enum MessageType: int
{
    case IMMATRICULATIE = 1;
    case BANKREKENING = 5;
    case FISCALE_TOESTAND = 6;
    case MULTIMEDIA = 11;
    case BEDRIJFSWAGEN = 15;
    case MELDING_INKOMENSGARANTIE = 23;
    case MELDING_PLAGE = 24;
}
