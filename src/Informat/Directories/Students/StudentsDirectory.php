<?php

namespace Koba\Informat\Directories\Students;

use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Directories\Students\GetRegistrations\GetRegistrationsCall;
use Koba\Informat\Directories\Students\GetStudent\GetStudentCall;
use Koba\Informat\Directories\Students\GetStudents\GetStudentsCall;

class StudentsDirectory
{
    public function __construct(protected CallProcessor $callProcessor)
    {
    }

    public function getStudent(
        string $instituteNumber,
        string $studentId,
        null|int|string $schoolyear = null
    ): GetStudentCall {
        return new GetStudentCall(
            $this->callProcessor,
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
            $this->callProcessor,
            $instituteNumber,
            $schoolyear,
        );
    }

    public function getRegistrations(
        string $instituteNumber,
        null|int|string $schoolyear = null
    ): GetRegistrationsCall {
        return new GetRegistrationsCall(
            $this->callProcessor,
            $instituteNumber,
            $schoolyear
        );
    }
}
