<?php

namespace Koba\Informat\Directories\Preregistrations\CreatePreregistration;

use Koba\Informat\Exceptions\ValidationException;

class Relation
{
    protected int $type;
    protected string $lastName;
    protected string $firstName;
    protected ?string $phone = null;
    protected ?string $mobilePhone = null;
    protected ?string $email = null;
    protected ?string $insz = null;

    /** @var null|array<string,mixed> $address */
    protected ?array $address = null;

    public function __construct(
        int $type,
        string $lastName,
        string $firstName
    ) {
        $this->setType($type);
        $this->setLastName($lastName);
        $this->setFirstName($firstName);
    }

    /**
     * Type of relationship.
     * 
     * 13 = vader
     * 14 = moeder
     * 5 = plusvader
     * 6 = plusmoeder
     * 2 = voogd
     * 9 = grootvader
     * 10 = grootmoeder
     */
    public function setType(int $type): self
    {
        $validTypes = [13, 14, 5, 6, 2, 9, 10];
        if (false === in_array($type, $validTypes, true)) {
            throw new ValidationException('Ongeldig relatietype.');
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Relation's last name.
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /** 
     * Relation's first name.
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * The relation's address
     */
    public function setAddress(
        string $streetName,
        string $houseNo,
        ?string $houseBusNo,
        string $postalCode,
        string $city,
        string $countryCode,
        bool $isDomicileAddress,
        bool $isWritingAddress,
        bool $isResidenceAddress
    ): self {
        /** @var string[] $errors */
        $errors = [];

        if (strlen($streetName) > 50) {
            $errors[] = 'Straatnaam mag niet langer dan 50 karakters zijn.';
        }

        if (strlen($houseNo) > 10) {
            $errors[] = 'Huisnummer mag niet langer dan 10 karakters zijn.';
        }

        if ($houseBusNo !== null && strlen($houseBusNo) > 6) {
            $errors[] = 'Busnummer mag niet langer dan 6 karakters zijn.';
        }

        if (strlen($postalCode) > 8) {
            $errors[] = 'Postcode mag maximum 8 karakters bevatten';
        }

        if (strlen($city) > 30) {
            $errors[] = 'Gemeente mag maximum 30 karakters bevatten';
        }

        if (strlen($countryCode) !== 5) {
            $errors[] = 'Ongeldige landcode';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->address = [
            'streetName' => $streetName,
            'houseNo' => $houseNo,
            'houseBusNo' => $houseBusNo,
            'postalCode' => $postalCode,
            'city' => $city,
            'countryCode' => $countryCode,
            'isDomicileAddress' => $isDomicileAddress,
            'isWritingAddress' => $isWritingAddress,
            'isResidenceAddress' => $isResidenceAddress,
        ];
        return $this;
    }

    /**
     * Domicile phone number
     */
    public function setPhone(?string $phone): self
    {
        if ($phone !== null && strlen($phone) > 20) {
            throw new ValidationException('Telefoonnummer mag maximum 20 karakters bevatten.');
        }

        $this->phone = $phone;
        return $this;
    }

    /**
     * Own mobile number
     */
    public function setMobilePhone(?string $mobilePhone): self
    {
        if ($mobilePhone !== null && strlen($mobilePhone) > 20) {
            throw new ValidationException('GSM nummer mag maximum 20 karakters bevatten.');
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
     * The relation’s national registration number.
     * 
     * This is either the Bisnummer, for foreign pupil, or
     * Rijksregisternummer for Belgium residents.
     */
    public function setInsz(?string $insz): self
    {
        $this->insz = $insz;
        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'Address' => $this->address,
            'phone' => $this->phone,
            'mobilePhone' => $this->mobilePhone,
            'email' => $this->email,
            'insz' => $this->insz,
        ];
    }
}
