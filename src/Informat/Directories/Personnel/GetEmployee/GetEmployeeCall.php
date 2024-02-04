<?php

namespace Koba\Informat\Directories\Personnel\GetEmployee;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Employee;

class GetEmployeeCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    protected string $personId;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $personId,
        null|int|string $schoolyear,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPersonId($personId)
            ->setSchoolyear($schoolyear);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "employees/{$this->personId}";
    }

    /**
     * Limits the output results to an employee with the provided personId.
     * The ID should contain a GUID.
     */
    public function setPersonId(string $personId): self
    {
        $this->personId = $personId;
        return $this;
    }

    /**
     * Only used to determine the instituteNo’s for the properties 
     * “EersteDienstScholengroep” and “EersteDienstScholengemeenschap”.
     */
    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Only used to determine the properties “HoofdAmbt”, “EersteDienstSchool”
     * and “IsActive” in a more detailed way, by means of the combination 
     * instituteNo & structure. Note: Only structures “311” & “312” are taken 
     * into account, the other structures are ignored.
     */
    public function setStructure(string $structure): self
    {
        $this->setQueryParam('structure', $structure);
        return $this;
    }

    /**
     * Perform the API call.
     */
    public function send(): Employee
    {
        return (new JsonMapper)->mapObject(
            $this->performRequest(),
            Employee::class
        );
    }
}
