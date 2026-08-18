<?php

namespace Koba\Informat\Directories\Personnel\GetDocument;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Enums\HttpMethod;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractGetDocumentCall extends AbstractCall implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    protected string $personId;
    protected int $documentId;

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    abstract protected function getType(): string;

    protected function getEndpoint(): string
    {
        return "employees/{$this->personId}/documents/{$this->documentId}/{$this->getType()}/pdf";
    }

    public function setPersonId(string $personId): static
    {
        $this->personId = $personId;
        return $this;
    }

    public function setDocumentId(int $documentId): static
    {
        $this->documentId = $documentId;
        return $this;
    }

    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
