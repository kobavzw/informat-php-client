<?php

namespace Koba\Informat\Directories\Personnel\SubmitSignedDocument;

use DateTimeInterface;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\MultipartBody;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\RlTekenStatus;
use Koba\Informat\Exceptions\InternalErrorException;
use Psr\Http\Message\ResponseInterface;
use SplFileObject;

class SubmitSignedDocumentCall extends AbstractCall
{
    protected string $personId;
    protected int $documentId;
    protected RlTekenStatus $status;
    protected string $tijdstip;
    protected ?string $bestand = null;
    protected ?string $filename = null;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $personId,
        int $documentId,
        string|RlTekenStatus $status,
        string|DateTimeInterface $tijdstip,
        ?SplFileObject $bestand = null,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPersonId($personId)
            ->setDocumentId($documentId)
            ->setStatus($status)
            ->setTijdstip($tijdstip)
            ->setBestand($bestand);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    protected function getEndpoint(): string
    {
        return "employees/{$this->personId}/documents/{$this->documentId}/signeddocument";
    }

    protected function getBody(): MultipartBody
    {
        if ($this->status === RlTekenStatus::ONDERTEKEND && $this->bestand === null) {
            throw new InternalErrorException('PDF file is required when status is Ondertekend.');
        }

        $body = (new MultipartBody())
            ->addFieldPart('status', $this->status->value)
            ->addFieldPart('tijdstip', $this->tijdstip);

        if ($this->bestand !== null) {
            $body->addFilePart(
                'bestand',
                $this->bestand,
                $this->filename ?? 'signed.pdf',
                'application/pdf'
            );
        }

        return $body;
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

    public function setStatus(string|RlTekenStatus $status): self
    {
        $this->status = is_string($status)
            ? RlTekenStatus::from($status)
            : $status;

        return $this;
    }

    public function setTijdstip(string|DateTimeInterface $tijdstip): self
    {
        $this->tijdstip = is_string($tijdstip)
            ? $tijdstip
            : $tijdstip->format('Y-m-d\TH:i:s\Z');

        return $this;
    }

    /**
     * Sets the signed PDF file. Only use this when status is Ondertekend.
     */
    public function setBestand(?SplFileObject $bestand): self
    {
        if ($bestand === null) {
            $this->bestand = null;
            $this->filename = null;
            return $this;
        }

        $bestand->rewind();
        $contents = '';

        while (! $bestand->eof()) {
            $chunk = $bestand->fread(8192);
            if ($chunk === false) {
                throw new InternalErrorException('PDF file could not be read.');
            }

            $contents .= $chunk;
        }

        $this->bestand = $contents;
        $this->filename = $bestand->getFilename();
        return $this;
    }

    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
