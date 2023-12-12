<?php

namespace Koba\Informat\Call;

use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Message\ResponseInterface;

abstract class GenericCall
{
    protected InstituteNumber $instituteNumber;
    protected CallProcessor $callProcessor;

    abstract protected function getMethod(): string;
    abstract protected function getEndpoint(): string;

    /**
     * @return null|string|array<mixed>
     */
    protected function getBody(): null|string|array
    {
        return null;
    }

    protected function setCallProcessor(CallProcessor $callProcessor): void
    {
        $this->callProcessor = $callProcessor;
    }

    protected function setInstituteNumber(string $instituteNumber): void
    {
        $this->instituteNumber = new InstituteNumber($instituteNumber);
    }

    protected function performRequest(): ResponseInterface
    {
        return $this->callProcessor->send(
            $this->getMethod(),
            $this->getEndpoint(),
            $this->instituteNumber,
            $this->getBody()
        );
    }
}
