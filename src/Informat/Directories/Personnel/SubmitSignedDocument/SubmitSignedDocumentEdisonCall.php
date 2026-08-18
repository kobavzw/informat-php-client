<?php

namespace Koba\Informat\Directories\Personnel\SubmitSignedDocument;

use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\RlTekenStatus;
use DateTimeInterface;
use SplFileObject;

class SubmitSignedDocumentEdisonCall extends AbstractSubmitSignedDocumentCall
{
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

    protected function getType(): string
    {
        return 'edison';
    }
}
