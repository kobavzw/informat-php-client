<?php

namespace Koba\Informat\Responses\Students;

use DateTime;
use Koba\Informat\Enums\GroupType;

class Group
{
    /** Unique identifier for the class registration */
    public string $inschrKlasId;

    /**
     * Unique integer-value for the class registration within the database.
     * 
     * Note: This value may have changed after data migration. Therefore, the
     * inschrKlasId is more suitable as a reference value
     */
    public int $pInschrKlas;

    /** Unique identifier for the class */
    public string $klasId;

    /** Unique integer-value for the class within the database. */
    public int $pKlas;

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
