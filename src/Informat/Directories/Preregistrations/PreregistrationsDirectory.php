<?php

namespace Koba\Informat\Directories\Preregistrations;

use DateTime;
use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Directories\Preregistrations\CreatePreregistration\CreatePreregistrationCall;
use Koba\Informat\Directories\Preregistrations\DeletePreregistration\DeletePreregistrationCall;
use Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus\GetPreregistrationStatusCall;
use Koba\Informat\Directories\Students\ErrorCode;
use Koba\Informat\Enums\BaseUrl;

class PreregistrationsDirectory
extends AbstractDirectory
implements DirectoryInterface
{
    /**
     * @inheritDoc
     */
    protected static function getErrorCodes(): ?string
    {
        return ErrorCode::class;
    }

    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::STUDENT;
    }

    /**
     * Gets the status of a pre-registration/registration 
     * by it's preRegistrationId.
     * 
     * @param string $preRegistrationId
     * The unique identifier of the pre-registration/registration. (GUID)
     */
    public function getPreregistrationStatus(
        string $instituteNumber,
        string $preRegistrationId
    ): GetPreregistrationStatusCall {
        return GetPreregistrationStatusCall::make(
            $this,
            $instituteNumber,
            $preRegistrationId,
        );
    }

    /**
     * Delete your online Pre-registration data.
     * @param string $preRegistrationId
     * The unique identifier of the pre-registration. (GUID)
     */
    public function deletePreregistration(
        string $instituteNumber,
        string $preRegistrationId
    ): DeletePreregistrationCall {
        return DeletePreregistrationCall::make(
            $this,
            $instituteNumber,
            $preRegistrationId
        );
    }

    /**
     * This call can be used to:
     * - Add your new online reservation into Informat as a Pre-registration;
     * - Update an existing pre-registration based on the preRegistrationId;
     * - Add an “update personal details”-registration by using “000000” 
     *   as admgrpId (means no admgrp), used when the original pre-registration
     *   is already accepted and can no longer be changed;
     * - Update an existing “update personal details”-registration based 
     *   on the preRegistrationId provided during addition.
     */
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
        return CreatePreregistrationCall::make(
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
