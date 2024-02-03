<?php

namespace Koba\Informat\Directories\Preregistrations\CreatePreregistration;

use DateTime;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Exceptions\ValidationException;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;

class CreatePreregistrationCall
extends AbstractCall
{
    protected string $lastName;
    protected string $firstName;
    protected ?string $additionalNames = null;
    protected DateTime $dateOfBirth;
    protected string $countryOfBirthCode;
    protected ?string $placeOfBirthCode = null;
    protected ?string $placeOfBirth = null;
    protected string $nationalityCode;
    protected int $sex;
    protected ?string $insz = null;
    protected ?string $eIdNo = null;
    protected ?string $eIdPhoto = null;
    protected ?string $mobilePhone = null;
    protected ?string $email = null;
    protected ?string $nameOfDoctor = null;
    protected ?string $phoneOfDoctor = null;
    protected ?string $firstLanguage = null;
    protected bool $isHomeless;
    protected bool $migrating;
    protected bool $isIndicatorPupil;
    protected ?int $religion = null;
    protected ?int $priorityGroup = null;
    protected ?int $reasonForRefusal = null;
    protected string $preRegistrationId;
    protected string $schoolyear;
    protected string $structure;
    protected string $locationId;
    protected string $admgrpId;
    protected ?string $admgrpDetail = null;
    protected ?DateTime $preRegistrationDate = null;
    protected DateTime $startDate;
    protected int $registrationStatus;
    public ?string $remark = null;
    public bool $assignedViaRegistrationSystem = false;

    /** @var Relation[] $relations */
    protected array $relations = [];

    public function __construct(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $lastName,
        string $firstName,
        DateTime $dateOfBirth,
        string $countryOfBirthCode,
        string $nationalityCode,
        int $sex,
        bool $isHomeless,
        bool $migrating,
        bool $isIndicatorPupil,
        string $preRegistrationId,
        int|string $schoolyear,
        string $structure,
        string $locationId,
        string $admgrpId,
        ?DateTime $preRegistrationDate,
        DateTime $startDate,
        int $registrationStatus,
    ) {
        $this->setDirectory($directory);

        /** @var string[] $errors */
        $errors = [];

        foreach ([
            'setInstituteNumber' => $instituteNumber,
            'setLastName' => $lastName,
            'setFirstName' => $firstName,
            'setDateOfBirth' => $dateOfBirth,
            'setCountryOfBirthCode' => $countryOfBirthCode,
            'setNationalityCode' => $nationalityCode,
            'setSex' => $sex,
            'setIsHomeless' => $isHomeless,
            'setMigrating' => $migrating,
            'setIsIndicatorPupil' => $isIndicatorPupil,
            'setPreRegistrationId' => $preRegistrationId,
            'setSchoolyear' => $schoolyear,
            'setStructure' => $structure,
            'setLocationId' => $locationId,
            'setAdmgrpId' => $admgrpId,
            'setPreregistrationDate' => $preRegistrationDate,
            'setStartDate' => $startDate,
            'setRegistrationStatus' => $registrationStatus
        ] as $fn => $value) {
            try {
                call_user_func([$this, $fn], $value);
            } catch (ValidationException $e) {
                $errors = [...$errors, ...$e->getErrors()];
            }
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    /**
     * Pupil’s last name
     */
    public function setLastName(string $lastName): self
    {
        if (strlen($lastName) > 50) {
            throw new ValidationException('Achternaam mag maximum 50 karakters lang zijn.');
        }

        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Pupil’s first name
     */
    public function setFirstName(string $firstName): self
    {
        if (strlen($firstName) > 50) {
            throw new ValidationException('Voornaam mag maximum 50 karakters lang zijn.');
        }

        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Additional names of the pupil
     */
    public function setAdditionalNames(?string $additionalNames): self
    {
        if ($additionalNames !== null && strlen($additionalNames) > 160) {
            throw new ValidationException('Extra namen mogen maximum 160 karakters lang zijn.');
        }

        $this->additionalNames = $additionalNames;
        return $this;
    }

    /** 
     * Date of birth
     */
    public function setDateOfBirth(DateTime $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * Country of birth code must be one of the official country code.
     */
    public function setCountryOfBirthCode(string $countryOfBirthCode): self
    {
        if (strlen($countryOfBirthCode) !== 5) {
            throw new ValidationException('Land code moet exact 5 karakters bevatten.');
        }

        $this->countryOfBirthCode = $countryOfBirthCode;
        return $this;
    }

    /**
     * Place of birth code is a postal code. If the country of
     * birth is Belgium then it must be an official BE postal code.
     */
    public function setPlaceOfBirthCode(?string $placeOfBirthCode): self
    {
        if ($placeOfBirthCode !== null && strlen($placeOfBirthCode) > 10) {
            throw new ValidationException('Geboorteplaats code mag maximum 10 karakters bevatten.');
        }

        $this->placeOfBirthCode = $placeOfBirthCode;
        return $this;
    }

    /**
     * Place of birth.
     */
    public function setPlaceOfBirth(?string $placeOfBirth): self
    {
        if ($placeOfBirth !== null && strlen($placeOfBirth) > 50) {
            throw new ValidationException('Geboortplaats mag maximum 50 karakters lang zijn.');
        }

        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }

    /**
     * Nationality code must be one of the official nationality codes.
     */
    public function setNationalityCode(string $nationalityCode): self
    {
        if (strlen($nationalityCode) !== 5) {
            throw new ValidationException('Nationaliteit code moet exact 5 karakters lang zijn.');
        }

        $this->nationalityCode = $nationalityCode;
        return $this;
    }

    /**
     * Possible values for the sex are: 1 or 2
     * 
     * 1 = male
     * 2 = female
     */
    public function setSex(int $sex): self
    {
        if ($sex !== 1 && $sex !== 2) {
            throw new ValidationException('Geslacht moet 1 voor mannelijk of 2 voor vrouwelijk bevatten.');
        }

        $this->sex = $sex;
        return $this;
    }

    /**
     * The pupil’s identification number. This is either the Bisnummer
     * for foreign pupil, or Rijksregisternummer for Belgium residents.
     */
    public function setInsz(?string $insz): self
    {
        $this->insz = $insz;
        return $this;
    }

    /**
     * Some (electronic) residence documents provide/contain an Id number. 
     * This number can be stored by filling up this field.
     */
    public function setEIdNo(?string $eIdNo): self
    {
        if ($eIdNo !== null && strlen($eIdNo) > 12) {
            throw new ValidationException('Het eID-nummer mag maximum 12 karakters bevatten.');
        }

        $this->eIdNo = $eIdNo;
        return $this;
    }

    /**
     * Some electronic residence documents provide a photo of the owner. 
     * The data must be offered as a delimited string.
     */
    public function setEIdPhoto(?string $eIdPhoto): self
    {
        $this->eIdPhoto = $eIdPhoto;
        return $this;
    }

    /**
     * Own mobile number
     */
    public function setMobilePhone(?string $mobilePhone): self
    {
        if ($mobilePhone !== null && strlen($mobilePhone) > 20) {
            throw new ValidationException('GSM nummer mag niet langer zijn dan 20 karakters.');
        }

        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    /**
     * Private email address
     */
    public function setEmail(?string $email): self
    {
        if ($email !== null && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Ongeldig e-mailadres.');
        }

        $this->email = $email;
        return $this;
    }

    /**
     * Name of the pupil’s doctor
     */
    public function setNameOfDoctor(?string $nameOfDoctor): self
    {
        if ($nameOfDoctor !== null && strlen($nameOfDoctor) > 100) {
            throw new ValidationException('Naam van de dokter mag maximum 100 karakters lang zijn.');
        }

        $this->nameOfDoctor = $nameOfDoctor;
        return $this;
    }

    /**
     * Phone of the pupil’s doctor
     */
    public function setPhoneOfDoctor(?string $phoneOfDoctor): self
    {
        if ($phoneOfDoctor !== null && strlen($phoneOfDoctor) > 20) {
            throw new ValidationException('Het telefoonnummer van de dokter mag niet langer zijn dan 20 karakters.');
        }

        $this->phoneOfDoctor = $phoneOfDoctor;
        return $this;
    }

    /** 
     * The pupil's first language 
     */
    public function setFirstLanguage(?string $firstLanguage): self
    {
        if ($firstLanguage !== null && strlen($firstLanguage) > 100) {
            throw new ValidationException('De taal mag maximum 100 karakters bevatten.');
        }

        $this->firstLanguage = $firstLanguage;
        return $this;
    }

    /**
     * Indicates whether the pupil is someone who changes
     * shelter or place of residence frequently.
     */
    public function setIsHomeless(bool $isHomeless): self
    {
        $this->isHomeless = $isHomeless;
        return $this;
    }

    /**
     * Indicates whether the pupil belongs to the migratory 
     * (trekkende) population.
     */
    public function setMigrating(bool $migrating): self
    {
        $this->migrating = $migrating;
        return $this;
    }

    /**
     * Indicates whether the pupil is an indicator pupil.
     * A pupil who meets at least one of the official
     * indicators, will be assigned as an indicator pupil.
     */
    public function setIsIndicatorPupil(bool $isIndicatorPupil): self
    {
        $this->isIndicatorPupil = $isIndicatorPupil;
        return $this;
    }

    /**
     * Also known as 'levensbeschouwing'.
     */
    public function setReligion(?int $religion): self
    {
        $religions = [
            52,
            63,
            135,
            136,
            140,
            187,
            194,
            225,
            418,
            9999,
        ];

        if ($religion !== null && false === in_array($religion, $religions)) {
            throw new ValidationException('Ongeldige religie.');
        }

        $this->religion = $religion;
        return $this;
    }

    /**
     * Priority group, also known as voorrangsgroep
     */
    public function setPriorityGroup(?int $priorityGroup): self
    {
        $priorityGroups = [1, 2, 3, 4, 5, 6];

        if ($priorityGroup !== null && false === in_array($priorityGroup, $priorityGroups)) {
            throw new ValidationException('Ongeldige prioriteitsgroep.');
        }

        $this->priorityGroup = $priorityGroup;
        return $this;
    }

    /**
     * Reason for refusal of the registration.
     */
    public function setReasonForRefusal(?int $reasonForRefusal): self
    {
        if ($reasonForRefusal !== null && $reasonForRefusal !== 19) {
            throw new ValidationException('Ongeldige reden tot weigering.');
        }

        $this->reasonForRefusal = $reasonForRefusal;
        return $this;
    }

    /**
     * A mandatory unique identifier which will be used to
     * identify the pre-registration. Other calls like the
     * update, consult, … are based on this Id.
     */
    public function setPreRegistrationId(string $preRegistrationId): self
    {
        $this->preRegistrationId = $preRegistrationId;
        return $this;
    }

    /**
     * The school year in which the pupil’s registration takes place.
     */
    public function setSchoolyear(int|string $schoolyear): self
    {
        $this->schoolyear = (string)(new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * ‘Hoofdstructuur’ of the institute (111, 311,…)
     */
    public function setStructure(string $structure): self
    {
        if (strlen($structure) !== 3) {
            throw new ValidationException('Ongeldige structuur');
        }

        $this->structure = $structure;
        return $this;
    }

    /**
     * Official Discimus location number
     */
    public function setLocationId(string $locationId): self
    {
        if (1 !== preg_match('/^\d{3}$/', $locationId)) {
            throw new ValidationException('Ongeldige locatie ID.');
        }

        $this->locationId = $locationId;
        return $this;
    }

    /**
     * Official education number (Administratieve groep)
     */
    public function setAdmgrpId(string $admgrpId): self
    {
        if (1 !== preg_match('/^\d{6}$/', $admgrpId)) {
            throw new ValidationException('Ongeldige administratieve groep.');
        }

        $this->admgrpId = $admgrpId;
        return $this;
    }

    /**
     * Additional information about the education (1ste jaar kleuter, Latijn,…)
     */
    public function setAdmgrpDetail(?string $admgrpDetail): self
    {
        if ($admgrpDetail !== null && strlen($admgrpDetail) > 200) {
            throw new ValidationException('Het detail van de administratieve groep mag niet meer dan 200 karakters bevatten.');
        }

        $this->admgrpDetail = $admgrpDetail;
        return $this;
    }

    /**
     * Pre-registration date and time of the online 
     * reservation/pre-registration.
     */
    public function setPreregistrationDate(?DateTime $preRegistrationDate): self
    {
        $this->preRegistrationDate = $preRegistrationDate;
        return $this;
    }

    /**
     * The date the pupil starts the lessons. Startdate 
     * shouldn’t be Saturday or Sunday, except on September 1st.
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Possible values for the registration status: 0 or 1
     * 
     * 0 = Realized (gerealiseerd)
     * 1 = Not realized (niet-gerealiseerd)
     */
    public function setRegistrationStatus(int $registrationStatus): self
    {
        if ($registrationStatus !== 0 && $registrationStatus !== 1) {
            throw new ValidationException('Ongeldige registratie status.');
        }

        $this->registrationStatus = $registrationStatus;
        return $this;
    }

    /**
     * Remark on registration level
     */
    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;
        return $this;
    }

    /**
     * Indicates whether this pre-registration is assigned via
     * a registration system (aanmeldingssysteem).
     * 
     * The (default) value is false, if not provided.
     */
    public function setAssignedViaRegistrationSystem(bool $assignedViaRegistrationSystem): self
    {
        $this->assignedViaRegistrationSystem = $assignedViaRegistrationSystem;
        return $this;
    }

    /**
     * Adds a relation to the registration.
     */
    public function addRelation(Relation $relation): self
    {
        if (count($this->relations) >= 2) {
            throw new ValidationException('Je mag maximum 2 relaties per registratie doorgeven.');
        }

        $this->relations[] = $relation;
        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    protected function getBody(): array
    {
        return [
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'additionalNames' => $this->additionalNames,
            'dateOfBirth' => $this->dateOfBirth->format('Y-m-d'),
            'countryOfBirthCode' => $this->countryOfBirthCode,
            'placeOfBirthCode' => $this->placeOfBirthCode,
            'placeOfBirth' => $this->placeOfBirth,
            'nationalityCode' => $this->nationalityCode,
            'sex' => $this->sex,
            'insz' => $this->insz,
            'eIdNo' => $this->eIdNo,
            'eIdPhoto' => $this->eIdPhoto,
            'mobilePhone' => $this->mobilePhone,
            'email' => $this->email,
            'nameOfDoctor' => $this->nameOfDoctor,
            'phoneOfDoctor' => $this->phoneOfDoctor,
            'firstLanguage' => $this->firstLanguage,
            'isHomeless' => $this->isHomeless,
            'migrating' => $this->migrating,
            'isIndicatorPupil' => $this->isIndicatorPupil,
            'religion' => $this->religion,
            'priorityGroup' => $this->priorityGroup,
            'reasonForRefusal' => $this->reasonForRefusal,
            'Relationships' => array_map(
                fn (Relation $relation) => $relation->toArray(),
                $this->relations
            ),
            'preRegistrationId' => $this->preRegistrationId,
            'schoolyear' => $this->schoolyear,
            'institute' => (string)$this->instituteNumber,
            'structure' => $this->structure,
            'locationId' => $this->locationId,
            'admgrpId' => $this->admgrpId,
            'admgrpDetail' => $this->admgrpDetail,
            'preRegistrationDate' => $this->preRegistrationDate === null
                ? null
                : $this->preRegistrationDate->format('Y-m-d'),
            'startDate' => $this->startDate->format('Y-m-d'),
            'registrationStatus' => $this->registrationStatus,
            'remark' => $this->remark,
            'assignedViaRegistrationSystem' => $this->assignedViaRegistrationSystem,
        ];
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    protected function getEndpoint(): string
    {
        return '1/preregistrations/save';
    }

    public function send(): CreatePreregistrationResponse
    {
        return (new JsonMapper)->mapProperty(
            $this->performRequest(),
            'preRegistrationStatus',
            CreatePreregistrationResponse::class
        );
    }
}
