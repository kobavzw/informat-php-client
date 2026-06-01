<?php

namespace Koba\Informat\Responses\Personnel;

use Koba\Informat\Enums\RlTekenStatus;
use Koba\Informat\Enums\RlType;
use DateTime;

class Document
{
    /**
     * Unique id of the document. Use this value as {documentId} in the PDF and SignedDocument endpoints.
     */
    public int $documentId;

    /**
     * Identifier of the employee this document belongs to.
     */
    public string $personId;

    public RlType $rlType;

    /**
     * Current signing status.
     */
    public ?RlTekenStatus $tekenStatus;

    /**
     * Edison message id (from EdisonSend.MessageId).
     */
    public ?int $zendingnr;

    /**
     * External shipment reference (from EdisonSend.Reference).
     */
    public ?string $referentie;

    /**
     * When the document was created in Informat (UTC).
     */
    public DateTime $aangemaaktOp;

    /**
     * When the document was sent to  Edison (UTC). null while not yet sent.
     */
    public ?DateTime $verstuurdNaarEdisonOp;

    /**
     * When the Edison status of this shipment was last changed. Use max(edisonStatusGewijzigdOp)
     * from a response as the value of referencedate in the next call.
     */
    public ?DateTime $edisonStatusGewijzigdOp;

    /**
     * RL1 only. The RL1 effective date. Omitted from the response for RL2 documents.
     */
    public ?DateTime $rl1Ingangsdatum = null;
}
