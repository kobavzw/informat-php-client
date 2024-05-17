<?php

namespace Koba\Informat\Directories\Personnel\GetInterruptions;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Interruption;

class GetInterruptionsCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        null|int|string $schoolyear,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setSchoolyear($schoolyear);
    }
    
    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return 'employees/interruptions';        
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
     * This is an actually an additional restriction on the school year filter.
     * It limits the output results to assignments for a given structure.
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