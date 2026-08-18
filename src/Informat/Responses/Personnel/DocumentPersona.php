<?php

namespace Koba\Informat\Responses\Personnel;

use Koba\Informat\Enums\BevestigingStatus;
use Koba\Informat\Enums\MessageType;
use Koba\Informat\Enums\RlTekenStatus;
use Koba\Informat\Enums\SendStatus;
use DateTime;

class DocumentPersona
{
    /**
     * Unique id of the Persona document. Use this value as {documentId} in the PDF and signing calls
     */
    public int $documentId;

    /**
     * Identifier of the employee this document belongs to.
     */
    public string $personId;

    /**
     * Numeric Persona message type.
     */
    public MessageType $messageType;

    /**
     * description of the message type.
     */
    public string $messageTypeOmschrijving;

    /**
     * Current signing status.
     */
    public ?RlTekenStatus $tekenStatus;

    /**
     * Persona send status.
     */
    public SendStatus $sendStatus;

    /**
     * description of the send status.
     */
    public ?string $sendStatusOmschrijving;

    public ?BevestigingStatus $bevestigingStatus;

    /**
     * Creation timestamp (UTC)
     */
    public DateTime $aangemaaktOp;

    /**
     * Timestamp the message was sent to AgODi (UTC)
     */
    public ?DateTime $verstuurdOp;

    /**
     * Last status change. Use max(statusGewijzigdOp) as the watermark for the referencedate parameter.
     */
    public DateTime $statusGewijzigdOp;
}
