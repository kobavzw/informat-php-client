<?php

namespace Koba\Informat\Directories\Students\GetStudents;

use DateTime;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Students\Student;

class GetStudentsCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public function __construct(
        CallProcessor $callProcessor,
        string $instituteNumber,
        int|string|null $schoolyear,
    ) {
        $this->setCallProcessor($callProcessor);
        $this->setInstituteNumber($instituteNumber);
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
    }

    protected function getMethod(): HttpMethod
    {
        return  HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return '1/students';
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
     * Limits the output results to those students whose data has been changed since a certain date.
     * 
     * Our internal “changedSince” date is determined based on a collection of 
     * change dates at different levels (depending on the content of the response).
     */
    public function setChangedSince(DateTime $date): self
    {
        $this->setQueryParam('changedSince', $date->format('c'));
        return $this;
    }

    /**
     * Perform the API call.
     * @return Student[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapPropertyArray(
            $this->performRequest(),
            'students',
            Student::class
        );
    }
}
