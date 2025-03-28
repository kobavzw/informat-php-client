<?php

namespace Koba\Informat\Directories\Personnel;

use DateTime;
use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Directories\Personnel\CreateInterruption\CreateInterruptionCall;
use Koba\Informat\Directories\Personnel\CreateInterruptionAttachment\CreateInterruptionAttachmentCall;
use Koba\Informat\Directories\Personnel\DeleteInterruption\DeleteInterruptionCall;
use Koba\Informat\Directories\Personnel\DeleteInterruptionAttachment\DeleteInterruptionAttachmentCall;
use Koba\Informat\Directories\Personnel\GetDiplomas\GetDiplomasCall;
use Koba\Informat\Directories\Personnel\GetDiplomasForEmployee\GetDiplomasForEmployeeCall;
use Koba\Informat\Directories\Personnel\GetEmployee\GetEmployeeCall;
use Koba\Informat\Directories\Personnel\GetEmployees\GetEmployeesCall;
use Koba\Informat\Directories\Personnel\GetInterruptions\GetInterruptionsCall;
use Koba\Informat\Directories\Personnel\GetInterruptionsForEmployee\GetInterruptionsForEmployeeCall;
use Koba\Informat\Directories\Personnel\GetOwnFields\GetOwnFieldsCall;
use Koba\Informat\Directories\Personnel\GetPhotoForEmployee\GetPhotoForEmployeeCall;
use Koba\Informat\Directories\Personnel\GetPhotos\GetPhotosCall;
use Koba\Informat\Enums\BaseUrl;
use Koba\Informat\Enums\InterruptionCode;
use Koba\Informat\Helpers\File;

class PersonnelDirectory
extends AbstractDirectory
implements DirectoryInterface
{
    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::PERSONNEL;
    }

    /**
     * @inheritDoc
     */
    protected static function getErrorCodes(): ?string
    {
        return ErrorCode::class;
    }

    /**
     * Gets all the employees for the combination 
     * institute number, school year and structure.
     * 
     * @param null|int|string $schoolyear 
     * For current & future school years: It limits the output results 
     * to employees with an assignment within the given schoolyear
     * or which are marked as active for your instituteNo.
     * 
     * For passed school years: It limits the output results to employees
     * with an assignment within the given schoolyear (and instituteNo).
     * Also used to determine the instituteNo’s for the properties 
     * “EersteDienstScholengroep” and “EersteDienstScholengemeenschap”.
     * 
     * Pass null for current school year.
     */
    public function getEmployees(
        string $instituteNumber,
        null|int|string $schoolyear = null,
    ): GetEmployeesCall {
        return GetEmployeesCall::make(
            $this,
            $instituteNumber,
            $schoolyear
        );
    }

    /**
     * Gets an employee by it’s personId.
     * 
     * @param string $personId
     * Limits the output results to an employee with the provided personId.
     * Should contain a GUID.
     * @param null|int|string $schoolyear
     * Only used to determine the instituteNo’s for the properties 
     * “EersteDienstScholengroep” and “EersteDienstScholengemeenschap”.
     */
    public function getEmployee(
        string $instituteNumber,
        string $personId,
        null|int|string $schoolyear = null
    ): GetEmployeeCall {
        return GetEmployeeCall::make(
            $this,
            $instituteNumber,
            $personId,
            $schoolyear,
        );
    }

    public function getOwnFields(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetOwnFieldsCall {
        return GetOwnFieldsCall::make(
            $this,
            $instituteNumber,
            $schoolyear
        );
    }

    /** 
     * Gets all the interruptions for the combination institute number, 
     * school year and structure.   
     */
    public function getInterruptions(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetInterruptionsCall {
        return GetInterruptionsCall::make(
            $this,
            $instituteNumber,
            $schoolyear,
        );
    }

    /**
     * Gets an employee’s interruptions by personId and for the combination 
     * institute number, school year and structure.
     */
    public function getInterruptionsForEmployee(
        string $instituteNumber,
        string $personId,
        null|int|string $schoolyear = null
    ): GetInterruptionsForEmployeeCall {
        return GetInterruptionsForEmployeeCall::make(
            $this,
            $instituteNumber,
            $personId,
            $schoolyear,
        );
    }

    /**
     * This call can be used to:
     * - Add a new interruption into Informat for an employee (personId);
     * - Update an existing interruption based on the given interruptionId.
     */
    public function createInterruption(
        string $instituteNumber,
        string $personId,
        string $interruptionId,
        null|int|string $schoolyear,
        string $hoofdstructuur,
        string|InterruptionCode $code,
        string|DateTime $begindatum,
        string|DateTime $einddatum,
        string $afzender
    ): CreateInterruptionCall {
        return CreateInterruptionCall::make(
            $this,
            $instituteNumber,
            $personId,
            $interruptionId,
            $schoolyear,
            $hoofdstructuur,
            $code,
            $begindatum,
            $einddatum,
            $afzender
        );
    }

    /**
     * Remove the interruption based on the given interruptionId. Furthermore,
     * all attachments that are only attached to this interruptionId will also
     * be deleted.
     */
    public function deleteInterruption(
        string $instituteNumber,
        string $interruptionId
    ): DeleteInterruptionCall {
        return DeleteInterruptionCall::make(
            $this,
            $instituteNumber,
            $interruptionId
        );
    }

    /**
     * Gets all the diplomas for the combination institute number, school year
     * and structure.
     */
    public function getDiplomas(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetDiplomasCall {
        return GetDiplomasCall::make($this, $instituteNumber, $schoolyear);
    }

    /**
     * Gets all the diplomas for the combination institute number, school year
     * and structure.
     */
    public function getDiplomasForEmployee(
        string $instituteNumber,
        string $personId,
        null|int|string $schoolyear = null
    ): GetDiplomasForEmployeeCall {
        return GetDiplomasForEmployeeCall::make(
            $this,
            $instituteNumber,
            $personId,
            $schoolyear
        );
    }

    /**
     * This call can be used to:
     * - Add a new attachment into Informat linked to an interruption 
     *   (interruptionId);
     * - Update an existing interruption-attachment based on the given
     *   attachmentId. An attachment can be linked to multiple interruptions of 
     *   the same employee.
     */
    public function createInterruptionAttachment(
        string $instituteNumber,
        string $interruptionId,
        string $attachmentId,
        File $file,
    ): CreateInterruptionAttachmentCall {
        return CreateInterruptionAttachmentCall::make(
            $this,
            $instituteNumber,
            $interruptionId,
            $attachmentId,
            $file
        );
    }

    /**
     * Remove the link between an interruption and an attachment. If no other
     * interruption is linked to this attachment then the attachment itself 
     * will also be removed.
     */
    public function deleteInterruptionAttachment(
        string $instituteNumber,
        string $interruptionId,
        string $attachmentId,
    ): DeleteInterruptionAttachmentCall {
        return DeleteInterruptionAttachmentCall::make(
            $this,
            $instituteNumber,
            $interruptionId,
            $attachmentId
        );
    }

    /**
     * Gets all the photos for the combination institute number, school year 
     * and structure.
     */
    public function getPhotos(
        string $instituteNumber,
        null|int|string $schoolyear = null,
    ): GetPhotosCall {
        return GetPhotosCall::make($this, $instituteNumber, $schoolyear);
    }

    /**
     * Gets an employee’s photo by personId
     */
    public function getPhotoForEmployee(
        string $instituteNumber,
        string $personId,
    ): GetPhotoForEmployeeCall {
        return GetPhotoForEmployeeCall::make($this, $instituteNumber, $personId);
    }
}
