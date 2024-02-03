<?php

namespace Koba\Informat\Call;

use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractCall implements CallInterface
{
    protected InstituteNumber $instituteNumber;
    protected DirectoryInterface $directory;

    abstract protected function getMethod(): HttpMethod;
    abstract protected function getEndpoint(): string;

    /**
     * @return null|string|array<mixed>
     */
    protected function getBody(): null|string|array
    {
        return null;
    }

    protected function setDirectory(DirectoryInterface $directory): void
    {
        $this->directory = $directory;
    }

    protected function setInstituteNumber(string $instituteNumber): void
    {
        $this->instituteNumber = new InstituteNumber($instituteNumber);
    }

    protected function getApiVersion(): ?string
    {
        return null;
    }

    protected function performRequest(): ResponseInterface
    {
        $request = $this->directory->getCallProcessor()->buildRequest(
            $this->directory->getUrlBuilder()->build(
                $this->getEndpoint(),
                $this instanceof HasQueryParamsInterface
                    ? $this->getQueryParamString()
                    : null
            ),
            $this->getMethod(),
            $this->instituteNumber
        );

        if ($this->getBody() !== null) {
            $request->withBody($this->getBody());
        }

        if ($this->getApiVersion() !== null) {
            $request->withVersion($this->getApiVersion());
        }

        return $this->directory->getCallProcessor()->send($request);
    }
}
