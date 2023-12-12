<?php

namespace Koba\Informat\Directories\Preregistrations\CreatePreregistration;

use Koba\Informat\Exceptions\ValidationException;

class Relation
{
    protected int $type;
    protected string $lastName;
    protected string $firstName;

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
        ?string $houseBusNo = null,
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
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'Address' => $this->address,
        ];
    }
}
