<?php

namespace Koba\Informat\Directories\Personnel\GetDocument;

use Koba\Informat\Directories\DirectoryInterface;

class GetDocumentPersonaCall extends AbstractGetDocumentCall
{
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

    protected function getType(): string
    {
        return 'persona';
    }
}
