<?php

namespace Koba\Informat\Directories\Students\GetStudent;

use DateTime;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Students\Student;

class GetStudentCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    protected string $studentId;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $studentId,
        null|int|string $schoolyear,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setStudentId($studentId)
            ->setSchoolyear($schoolyear);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "1/students/{$this->studentId}";
    }

    /**
     * Limits the output results to students which have a registration where
     * the reference date falls between registration’s begin & end date.
     * 
     * In any case the reference date will be overridden as follows if it falls
     * outside the boundaries of the provided school year:
     * - Reference date < beginning of school year => reference date will be overridden with begin date of school year;
     * - Reference date > end of school year => reference date will be overridden with end date of school year.
     */
    public function setReferenceDate(DateTime $date): self
    {
        $this->setQueryParam('refdate', $date->format('Y-m-d'));
        return $this;
    }

    /**
     * Limits the output results to a student with the provided studentId.
     */
    public function setStudentId(string $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * Is only used to determine the actual registration (inschrijvingsId 
     * property). So this parameter has no limiting effect on 
     * the output result.
     */
    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Perform the API call.
     */
    public function send(): Student
    {
        return (new JsonMapper)->mapProperty(
            $this->performRequest(),
            'student',
            Student::class
        );
    }
}
