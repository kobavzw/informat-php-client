<?php

namespace Koba\Informat\Responses\Students;

use Koba\Informat\Enums\CommunicationNumberType;

class CommunicationNumber
{
    /** Unique integer-value for the communication number within the database. */
    public int $pComnr;

    /** Communication number. */
    public string $nr;

    /** Communication number type. */
    public string $type;

    /** Communication number sort. */
    public CommunicationNumberType $soort;
}
