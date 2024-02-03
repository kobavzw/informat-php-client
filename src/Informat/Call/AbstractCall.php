<?php

namespace Koba\Informat\Call;

use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractCall implements CallInterface
{
    protected InstituteNumber $instituteNumber;
    protected CallProcessor $callProcessor;

    abstract protected function getMethod(): HttpMethod;
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

    protected function getApiVersion(): ?string
    {
        return null;
    }

    private function getEndpointWithQueryParams(): string
    {
        $endpoint = $this->getEndpoint();
        if ($this instanceof HasQueryParamsInterface) {
            $endpoint .= "?{$this->getQueryParamString()}";
        }

        return $endpoint;
    }

    protected function performRequest(): ResponseInterface
    {
        $request = $this->callProcessor->buildRequest(
            $this->getMethod()->value,
            $this->getEndpointWithQueryParams(),
            $this->instituteNumber
        );

        if ($this->getBody() !== null) {
            $request->withBody($this->getBody());
        }

        if ($this->getApiVersion() !== null) {
            $request->withVersion($this->getApiVersion());
        }

        return $this->callProcessor->send($request);
    }
}
