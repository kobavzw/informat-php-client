<?php

namespace Koba\Informat\Responses\Students;

class Address
{
    /** Unique integer-value for the address within the database. */
    public int $pAdres;

    /** Unique identifier for the address. Formatted as GUID. */
    public string $adresId;

    /** Addressable title. */
    public string $aanspreekTitel;

    /** Addressable name. */
    public string $aanspreekNaam;

    /** Street name. */
    public string $straat;

    /** House number & Alpha number. */
    public string $nr;

    /** Bus number */
    public ?string $bus;

    /** Postal code (main) */
    public string $postcode;

    /** Town (main) */
    public string $gemeente;

    /** Indicates whether this address is a invoice address. */
    public bool $isFacturatie;

    /** Indicates whether this address is a writing address. */
    public bool $isAanschrijf;

    /** Indicates whether this address is a residence address. */
    public bool $isVerblijf;

    /** Indicates whether this address is of another type then the provided ones. */
    public bool $isOverige;

    /** Cost allocation percentage. */
    public float $percentage;
}
