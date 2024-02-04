<?php

namespace Koba\Informat\Directories\Personnel\GetEmployees;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Employee;
use Throwable;

/**
 * Gets all the employees for the combination 
 * institute number, school year and structure.
 */
class GetEmployeesCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public function __construct(
        DirectoryInterface $directory,
        string $instituteNumber,
        null|int|string $schoolyear,
    ) {
        $this->setDirectory($directory);
        $this->setInstituteNumber($instituteNumber);
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return 'employees';
    }

    protected function getApiVersion(): ?string
    {
        return '2';
    }

    /**
     * This is an actually an additional restriction on the school year filter.
     * Also used to determine the properties “HoofdAmbt”, “EersteDienstSchool”
     * and “IsActive” in a more detailed way, by means of the combination
     * instituteNo & structure.
     * 
     * Note: Only structures “311” & “312” are taken into account. 
     */
    public function setStructure(string $structure): self
    {
        $this->setQueryParam('structure', $structure);
        return $this;
    }

    /**
     * @return Employee[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            Employee::class
        );
    }
}
