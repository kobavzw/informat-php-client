<?php

namespace Koba\Informat\Responses\Personnel;

use DateTime;
use Koba\Informat\Enums\BurgerlijkeStand;
use Koba\Informat\Enums\Sex;

class Employee
{
    /** Unique integer-value for the employee within the database. */
    public int $pPersoon;

    /** Unique identifier for the employee. Contains a GUID. */
    public string $personId;

    /** Unique identifier for the employee within the persona platform. Contains a GUID. */
    public ?string $personaId;

    /** Employee’s last name. */
    public string $naam;

    /** Employee’s first name. */
    public string $voornaam;

    /** Employee’s additional names. */
    public ?string $bijkomendeVoornamen;

    /**
     * Employee’s stamnummer.
     * Format: 11 characters (digits)
     */
    public ?string $stamnr;

    /** Employee’s sortable name. */
    public string $sortName;

    /** Employee’s nickname. */
    public string $nickName;

    /** Employee’s sex. */
    public Sex $geslacht;

    /** Employee’s initials. */
    public ?string $initialen;

    /** Employee’s date of birth. */
    public DateTime $geboortedatum;

    /** Employee’s place of birth. */
    public ?string $geboorteplaats;

    /** Employee’s official country of birth code. */
    public string $geboortelandCode;

    /** Employee’s official nationality code. */
    public ?string $nationaliteitCode;

    /** 
     * Employee’s national registration number for Belgium residents. 
     * Format: ”yymmddxxxxx” if provided
     */
    public ?string $rijksregisternr;

    /** 
     * Employee’s national registration number for a foreign person.
     * Format: 11 characters (digits) if provided
     */
    public ?string $bisnr;

    /** Single object representing employee’s private bank account. */
    public ?Bank $bank;

    /**
     * Single object representing employee’s main function within the provided
     * instituteNo and optional structure. Only “311” & “312” are taken 
     * into account. Returns a “null” if the value could not be determined.
     */
    public ?Ambt $hoofdAmbt;

    /**
     * Date of first employment within the school 
     * (provided instituteNo and optional structure).
     */
    public ?DateTime $eersteDienstSchool;

    /** Date of first employment within the school group. */
    public ?DateTime $eersteDienstScholengroep;

    /** Date of first employment within the school community. */
    public ?DateTime $eersteDienstScholengemeenschap;

    /**
     * Indicates whether this employee is marked as active 
     * for the provided instituteNo and optional structure.
     */
    public bool $isActive;

    /** mployee’s possible retirement date. */
    public ?DateTime $pensioendatum;

    /** Indicates whether this employee is a person with disabilities. */
    public bool $isMindervalide;

    /** Indicates whether this employee is deceased. */
    public bool $isOverleden;

    /** Employee’s date of death. */
    public ?DateTime $datumOverleden;

    /** Employee’s civil status. */
    public ?BurgerlijkeStand $burgStand;

    /** Single object representing employee’s partner. */
    public ?Partner $partner;

    /**
     * List of domicile or residence addresses.
     * @var Address[]
     */
    public array $adressen;

    /**
     * List of communication numbers.
     * @var CommunicationNumber[] $comnrs
     */
    public array $comnrs;

    /**
     * List of email addresses
     * @var EmailAddress[]
     */
    public array $emailadressen;

    /**
     * List of children.
     * @var Child[]
     */
    public array $kinderen;

    /**
     * List of staff groups to which the employee is a member.
     * @var Group[]
     */
    public array $personeelsgroepen;
}
