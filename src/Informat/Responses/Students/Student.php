<?php

namespace Koba\Informat\Responses\Students;

use DateTime;
use Koba\Informat\Enums\Sex;

class Student
{
    /** Unique integer-value for the student within the database. */
    public int $pPersoon;

    /** Unique identifier for the student. Contains a GUID. */
    public string $persoonId;

    /** Student’s last name. */
    public string $naam;

    /** Student’s first name. */
    public string $voornaam;

    /** Student’s date of birth. */
    public ?DateTime $geboortedatum;

    /** Student’s nickname. */
    public string $nickname;

    /** Student’s additional names. */
    public ?string $voornaam2;

    /** Student’s initials. */
    public ?string $initialen;

    /** Student’s country of birth. */
    public ?string $geboorteland;

    /** Student’s place of birth. */
    public ?string $geboorteplaats;

    /** Student’s official nationality codes. */
    public string $nationaliteitCode;

    /** Student’s national registration number for Belgium residents. */
    public ?string $rijksregisternr;

    /**
     * Students national registration number for a foreign person.
     * Format: 11 characters (digits) if provided
     */
    public ?string $bisnr;

    /** Students national registration number for a foreign person. */
    public Sex $geslacht;

    /** Name of the student’s doctor. */
    public ?string $huisdokter;

    /** Phone number of the student’s doctor. */
    public ?string $telefoonHuisdokter;

    /** Student’s place in line at school. */
    public ?int $llOpSchool;

    /**
     * Unique identifier of the actual registration.
     * 
     * The actual registration is determined by the provided InstituteNo, school year,
     * reference date (between registration’s begin & end date) and registration status =
     * 0 (gerealiseerd). If no such registration is found, inschrijvingsId will be null.
     */
    public ?string $inschrijvingsId;

    /** 
     * List of domicile addresses (usually one).
     * @var Address[] $adressen
     */
    public array $adressen;

    /** 
     * List of relationships.
     * @var Relation[] $relaties
     */
    public array $relaties;

    /** 
     * List of communication numbers not linked to a relationship.
     * @var CommunicationNumber[] $comnrs
     */
    public array $comnrs;

    /**
     * List of email addresses not linked to a relationship
     * @var Email[] $emails
     */
    public array $emails;
}
