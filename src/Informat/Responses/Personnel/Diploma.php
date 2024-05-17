<?php

namespace Koba\Informat\Responses\Personnel;

use DateTime;

class Diploma
{
    public string $id;

    public string $personId;

    public string $omschrijving;

    public string $uitgereiktDoor;

    public ?DateTime $uitgereiktOp;

    public bool $isHoofddiploma;

    public bool $isBekwaamheidsbewijs;
}
