<?php

namespace Koba\Informat\Responses\Personnel;

use DateTime;

class Interruption
{
    public string $doId;

    public string $personId;

    public string $hfd;

    public DateTime $begindatum;

    public DateTime $einddatum;

    public string $code;

    public string $omschrijving;

    public string $soort;

    public bool $verstuurdAgODi;
}
