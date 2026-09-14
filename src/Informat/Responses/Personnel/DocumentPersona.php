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
     * Persona message transaction number, unique per institute within a single school year and restarting at 1 each new school year.
     */
    public int $berichtnr;

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

    /**
     * Confirmation status: 0 = Not sent, 1 = Sent, 2 = Confirmed, 3 = Confirmed by secretariat.
     */
    public ?BevestigingStatus $bevestigingStatus;

    /**
     * Human-readable description of the confirmation status (bevestigingStatus). null when there is no confirmation status.
     */
    public ?BevestigingStatus $bevestigingStatusOmschrijving;

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
