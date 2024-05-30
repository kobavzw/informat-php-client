<?php

namespace Koba\Informat\Directories\Students;

use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Directories\Students\GetPhoto\GetPhotoCall;
use Koba\Informat\Directories\Students\GetRegistrations\GetRegistrationsCall;
use Koba\Informat\Directories\Students\GetStudent\GetStudentCall;
use Koba\Informat\Directories\Students\GetStudents\GetStudentsCall;
use Koba\Informat\Enums\BaseUrl;

class StudentsDirectory
extends AbstractDirectory
implements DirectoryInterface
{
    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::STUDENT;
    }

    /**
     * Gets a student by it’s studentId. The institute number, school year
     * and reference date are only used to determine the actual registration 
     * (inschrijvingsId property).
     */
    public function getStudent(
        string $instituteNumber,
        string $studentId,
        null|int|string $schoolyear = null
    ): GetStudentCall {
        return GetStudentCall::make(
            $this,
            $instituteNumber,
            $studentId,
            $schoolyear,
        );
    }

    /**
     * Gets all students with a registration for a given institute number, 
     * school year and reference date falling between registration’s 
     * begin & end date.
     */
    public function getStudents(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetStudentsCall {
        return GetStudentsCall::make(
            $this,
            $instituteNumber,
            $schoolyear,
        );
    }

    /**
     * Gets all the registrations for the combination 
     * institute number and school year.
     */
    public function getRegistrations(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetRegistrationsCall {
        return GetRegistrationsCall::make(
            $this,
            $instituteNumber,
            $schoolyear
        );
    }

    /** 
     * Gets a student’s photo by studentId.
     */
    public function getPhoto(
        string $instituteNumber,
        string $studentId,
    ): GetPhotoCall {
        return GetPhotoCall::make(
            $this,
            $instituteNumber,
            $studentId,
        );
    }
}
