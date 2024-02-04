<?php

namespace Koba\Informat\Responses\Personnel;

class Address
{
    /** Unique identifier for the address. GUID. */
    public string $id;

    /** Addressable title. */
    public ?string $aanspreekTitel;

    /** Addressable name. */
    public ?string $aanspreekNaam;

    /** Street name. */
    public string $straat;

    /** House number & Alpha number. */
    public string $nummer;

    /** Bus number. */
    public ?string $bus;

    /** Main postal code. */
    public string $postcode;

    /** Submunicipality. */
    public string $gemeente;

    /** Official country code. */
    public string $landCode;

    /** Indicates whether this address is a domicile address. */
    public bool $isDomicilie;

    /** Indicates whether this address is a residence address. */
    public bool $isVerblijf;
}
