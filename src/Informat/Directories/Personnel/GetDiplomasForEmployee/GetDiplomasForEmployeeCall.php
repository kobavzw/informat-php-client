<?php

namespace Koba\Informat\Directories\Personnel\GetDiplomasForEmployee;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Diploma;

class GetDiplomasForEmployeeCall
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
        return "employees/{$this->personId}/diplomas";
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
     * For current & future school years: It limits the output results to 
     * diplomas for employees with an assignment within the given schoolyear 
     * (and instituteNo) or which are marked as active for your instituteNo.
     * 
     * For passed school years: It limits the output results to diplomas for 
     * employees with an assignment within the given schoolyear 
     * (and instituteNo).
     */
    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * This is an actually an additional restriction on the school year filter.
     */
    public function setStructure(string $structure): self
    {
        $this->setQueryParam('structure', $structure);
        return $this;
    }

    /**
     * Perform the API call.
     */
    public function send(): mixed
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            Diploma::class
        );
    }
}
