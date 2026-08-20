<?php

namespace Koba\Informat\Enums;

enum MessageType: int
{
    case IMMATRICULATIE = 1;
    case ONBEKEND_3 = 3;
    case BANKREKENING = 5;
    case FISCALE_TOESTAND = 6;
    case ONBEKEND_7 = 7;
    case MULTIMEDIA = 11;
    case BEDRIJFSWAGEN = 15;
    case MELDING_INKOMENSGARANTIE = 23;
    case MELDING_PLAGE = 24;
    case MELDING_FIETSLEASE = 26;
    case WIJZIG_FIETSLEASE = 27;
    case ANNULEER_FIETSLEASE = 28;
}
