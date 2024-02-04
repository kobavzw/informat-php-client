<?php

namespace Koba\Informat\Responses\Personnel;

use Koba\Informat\Enums\CommunicationNumberType;

class CommunicationNumber
{
    /** Unique identifier for the communication number. */
    public string $id;

    /**
     * Communication number type.
     * Examples: Domicilie, Verblijf, Alternatief nummer, 
     * Noodnummer, Privé nummer, Werk, Partner, …
     */
    public string $type;

    /** Communication number sort. */
    public CommunicationNumberType $soort;

    /** Communication number. */
    public string $nr;
}
