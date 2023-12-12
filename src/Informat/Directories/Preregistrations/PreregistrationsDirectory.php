<?php

namespace Koba\Informat\Directories\Preregistrations;

use DateTime;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Directories\Preregistrations\CreatePreregistration\CreatePreregistrationCall;
use Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus\GetPreregistrationStatusCall;

class PreregistrationsDirectory
{
    public function __construct(protected CallProcessor $callProcessor)
    {
    }

    public function getPreregistrationStatus(
        string $instituteNumber,
        string $preRegistrationId
    ): GetPreregistrationStatusCall {
        return new GetPreregistrationStatusCall(
            $this->callProcessor,
            $instituteNumber,
            $preRegistrationId,
        );
    }

    public function deletePreregistration(
        string $instituteNumber,
        string $preRegistrationId
    ): DeletePreregistrationCall {
        return new DeletePreregistrationCall(
            $this->callProcessor,
            $instituteNumber,
            $preRegistrationId
        );
    }

    public function createPreregistration(
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
    ): CreatePreregistrationCall {
        return new CreatePreregistrationCall(
            $this->callProcessor,
            $instituteNumber,
            $lastName,
            $firstName,
            $dateOfBirth,
            $countryOfBirthCode,
            $nationalityCode,
            $sex,
            $isHomeless,
            $migrating,
            $isIndicatorPupil,
            $preRegistrationId,
            $schoolyear,
            $structure,
            $locationId,
            $admgrpId,
            $preRegistrationDate,
            $startDate,
            $registrationStatus,
        );
    }
}
