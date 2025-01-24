<?php

namespace Koba\Informat\Responses\Students;

use DateTime;
use Koba\Informat\Enums\RegistrationStatus;
use Koba\Informat\Enums\Religion;

class Registration
{
    /** Unique identifier for the registration. Formatted as GUID. */
    public string $inschrijvingsId;

    /** 
     * Unique integer-value for the registration within the database
     * 
     * Note: This value may have changed after data migration. Therefore, the
     * inschrijvingsId is more suitable as a reference value.
     */
    public int $pInschr;

    /** Unique integer-value for the student within the database */
    public int $pPersoon;

    /** Unique identifier for the student */
    public string $persoonId;

    /** Official institute number of the school. 6 characters (digits) */
    public string $instelnr;

    /** Structure of the institute (111, 311,…) */
    public string $hfdstructuur;

    /** Descriptive name of the school */
    public string $school;

    /** Students’ stamnummer */
    public ?string $stamnr;

    /** Own defined location code */
    public string $vestcode;

    /** Own descriptive name of the location */
    public string $vestiging;

    /** Date the registration starts */
    public DateTime $begindatum;

    /** Date the registration ends */
    public ?DateTime $einddatum;

    /** Own defined department code */
    public string $afdCode;

    /** Official education number (Administratieve groep) */
    public string $nrAdmgrp;

    /** Department year */
    public string $afdelingsjaar;

    /** Registration status */
    public RegistrationStatus $status;

    /** Degree */
    public string $graad;

    /** Grade */
    public int $leerjaar;

    /** Choice of language-options */
    public ?string $taalkeuze;

    /**
     * Finance ability code
     * 
     * Possible values secundary education:
     * 01 = Vrije leerling
     * 02 = Regelmatig / financierbaar
     * 03 = Regelmatig / niet financierbaar
     * 11 = Vrije leerling in erkende privéschool
     * 13 = Regelmatige leerling in erkende privéschool
     * 20 = Financierbare GON-leerling
     * 22 = Niet-financierbare GON-leerling
     * 99 = Onder voorbehoud aanvaarde leerling
     * 
     * Possible values primary education:
     * 01 = Coëfficiënt 1 - 100% financierbaar
     * 02 = Coëfficiënt 1,5 - 150% financierbaar
     * 03 = Niet financierbaar, maar telt wel mee voor de leerplichtcontrole en de financieringswet
     * 11 = Vrije leerling in erkende privéschool
     * 13 = Regelmatige leerling in erkende privéschool
     * 20 = Financierbare GON-leerling
     * 22 = Niet-financierbare GON-leerling
     */
    public string $finCode;

    /** Religion code */
    public ?Religion $levensbeschouwingCode;

    /** Indicates whether it is a registration for a foreign-speaking new student */
    public bool $isOkan;

    /** 
     * Unique identifier for the pre-registration, linked to a registration.
     * 
     * This Id is provided by you when adding a new pre-registration via the CreatePregistration call.
     * The preRegistrationId can only be returned when the pre-registration is registered
     * via the API and accepted via the student administration module. *
     */
    public ?string $preRegistrationId;

    /**
     * List of class registrations
     * @var Group[] $inschrklassen
     */
    public array $inschrklassen;
}
