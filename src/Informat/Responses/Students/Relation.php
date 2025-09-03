<?php

namespace Koba\Informat\Responses\Students;

use DateTime;
use Koba\Informat\Enums\Sex;

class Relation
{
    /** Unique integer-value for the relationship within the database. */
    public int $pRelatie;

    /** Unique identifier for the relationship. Formatted as GUID. */
    public string $relatieId;

    /** 
     * Relationship type
     * Examples: Vader, Moeder, Plusvader, Plusmoeder, …
     */
    public string $type;

    /** Relation’s last name */
    public ?string $naam;

    /** Relation’s first name */
    public ?string $voornaam;

    /** 
     * Relation’s national registration number.
     * This is either the Bisnummer for foreign relations, or Rijksregisternummer for Belgium residents.
     */
    public ?string $insz;

    /** Relation’s date of birth. */
    public ?DateTime $geboortedatum;

    /** Relation’s sex. */
    public Sex $geslacht;

    /** Relation’s official nationality codes. */
    public ?string $nationaliteitCode;

    /** Relation’s profession. */
    public ?string $beroep;

    /** Relation’s civil status. */
    public ?string $burgerlijkeStand;

    /** Indicates if the relation is marked as a school attendance officer and defines if it’s the first or second one. */
    public int $lpv;

    /** Indicates if the relation picks up the student from school. */
    public bool $ophalen;

    /** Indicates if the relation is deceased. */
    public bool $isOverleden;

    /**
     * List of addresses linked to the relationship (usually one, and most likely a domicile address).
     * @var Address[] $adressen
     */
    public array $adressen;

    /** 
     * List of communication numbers linked to the relationship.
     * @var CommunicationNumber[] $comnrs
     */
    public array $comnrs;

    /**
     * List of email addresses linked to the relationship.
     * @var Email[] $emails
     */
    public array $emails;
}
