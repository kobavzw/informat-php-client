<?php

namespace Koba\Informat\Responses\Students;

use DateTime;
use Koba\Informat\Enums\GroupType;

class Group
{
    /** Own class code */
    public string $klasCode;

    /** Own class name */
    public string $klas;

    /** Class type */
    public GroupType $groepType;

    /** Student’s class number */
    public int $klasnummer;

    /** Date the class registration starts */
    public DateTime $begindatum;

    /** Date the class registration ends */
    public ?DateTime $einddatum;
}
