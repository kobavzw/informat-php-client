<?php

namespace Koba\Informat\Directories\Preregistrations;

use DateTime;
use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Directories\Preregistrations\CreatePreregistration\CreatePreregistrationCall;
use Koba\Informat\Directories\Preregistrations\DeletePreregistration\DeletePreregistrationCall;
use Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus\GetPreregistrationStatusCall;
use Koba\Informat\Enums\BaseUrl;

class PreregistrationsDirectory
extends AbstractDirectory
implements DirectoryInterface
{
    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::STUDENT;
    }
    
    public function getPreregistrationStatus(
        string $instituteNumber,
        string $preRegistrationId
    ): GetPreregistrationStatusCall {
        return new GetPreregistrationStatusCall(
            $this,
            $instituteNumber,
            $preRegistrationId,
        );
    }

    public function deletePreregistration(
        string $instituteNumber,
        string $preRegistrationId
    ): DeletePreregistrationCall {
        return new DeletePreregistrationCall(
            $this,
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
            $this,
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
