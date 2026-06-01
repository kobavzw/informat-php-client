<?php

namespace Koba\Informat\Directories\Personnel\GetDocument;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Psr\Http\Message\ResponseInterface;

class GetDocumentCall extends AbstractCall implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    protected string $personId;
    protected int $documentId;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $personId,
        int $documentId,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPersonId($personId)
            ->setDocumentId($documentId);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "employees/{$this->personId}/documents/{$this->documentId}/pdf";
    }

    public function setPersonId(string $personId): self
    {
        $this->personId = $personId;
        return $this;
    }

    public function setDocumentId(int $documentId): self
    {
        $this->documentId = $documentId;
        return $this;
    }

    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
