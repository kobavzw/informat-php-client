<?php

namespace Koba\Informat\Directories\Personnel\GetDocuments;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\MessageType;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\DocumentPersona;
use DateTimeInterface;

class GetDocumentsPersonaCall extends AbstractCall implements HasQueryParamsInterface
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
        return 'employees/documents/persona';
    }

    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Filter by Persona message type.
     * Multiple values allowed: messageType=1&messageType=5.
     *
     * @param MessageType|array<int, MessageType> $messageType
     */
    public function setMessageType(MessageType|array $messageType): self
    {
        $messageTypes = is_array($messageType) ? $messageType : [$messageType];

        foreach ($messageTypes as $type) {
            $this->setQueryParam('messageType', (string) $type->value);
        }

        return $this;
    }

    /*
     * Watermark for incremental sync. Returns only documents whose edisonStatusGewijzigdOp
     * is greater than or equal to  this value. Rows where edisonStatusGewijzigdOp
     * is null are not returned. Omit for a complete initial sync.
     */
    public function setReferenceDate(DateTimeInterface $date): self
    {
        $this->setQueryParam('referencedate', $date->format('c'));
        return $this;
    }

    /**
     * Perform the API call.
     *
     * @return DocumentPersona[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            DocumentPersona::class
        );
    }
}
