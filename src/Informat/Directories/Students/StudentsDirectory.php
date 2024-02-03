<?php

namespace Koba\Informat\Directories\Students;

use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
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

    public function getStudent(
        string $instituteNumber,
        string $studentId,
        null|int|string $schoolyear = null
    ): GetStudentCall {
        return new GetStudentCall(
            $this,
            $instituteNumber,
            $studentId,
            $schoolyear,
        );
    }

    public function getStudents(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetStudentsCall {
        return new GetStudentsCall(
            $this,
            $instituteNumber,
            $schoolyear,
        );
    }

    public function getRegistrations(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetRegistrationsCall {
        return new GetRegistrationsCall(
            $this,
            $instituteNumber,
            $schoolyear
        );
    }
}
