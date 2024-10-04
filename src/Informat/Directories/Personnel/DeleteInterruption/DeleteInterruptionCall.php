<?php

namespace Koba\Informat\Directories\Personnel\DeleteInterruption;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\Personnel\PersonnelDirectory;
use Koba\Informat\Enums\HttpMethod;
use Psr\Http\Message\ResponseInterface;

class DeleteInterruptionCall extends AbstractCall
{
    protected string $interruptionId;

    public static function make(
        PersonnelDirectory $directory,
        string $instituteNumber,
        string $interruptionId
    ): self {
        return (new self($directory, $instituteNumber))
            ->setInterruptionId($interruptionId);
    }

    /**
     * The mandatory unique identifier of an existing interruption, to which the
     * attachment is linked.
     */
    public function setInterruptionId(string $interruptionId): self
    {
        $this->interruptionId = $interruptionId;
        return $this;
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    protected function getEndpoint(): string
    {
        return "/employees/interruptions/{$this->interruptionId}";
    }

    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
