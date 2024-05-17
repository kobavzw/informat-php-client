<?php

namespace Koba\Informat\Directories\Personnel\GetInterruptionsForEmployee;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Interruption;

class GetInterruptionsForEmployeeCall
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
        return "employees/{$this->personId}/interruptions";
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
     * Limits the output results to interruptions within the given schoolyear
     * (and instituteNo). Because an interruption can fall outside the school 
     * year boundaries, filtering is done like so:
     * Enddate interruption >= start school year && 
     * Begindate interruption <= end of school Year.
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

    public function send(): mixed
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            Interruption::class
        );
    }
}
