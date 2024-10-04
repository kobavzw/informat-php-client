<?php

namespace Koba\Informat\Directories\Personnel\DeleteInterruptionAttachment;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\Personnel\PersonnelDirectory;
use Koba\Informat\Enums\HttpMethod;
use Psr\Http\Message\ResponseInterface;

class DeleteInterruptionAttachmentCall extends AbstractCall
{
    protected string $interruptionId;
    protected string $attachmentId;

    public static function make(
        PersonnelDirectory $directory,
        string $instituteNumber,
        string $interruptionId,
        string $attachmentId,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setInterruptionId($interruptionId)
            ->setAttachmentId($attachmentId);
    }

    /**
     * The mandatory unique identifier of an existing interruption, to which the
     * attachment is linked.
     */
    public function setInterruptionId(string $interruptionId): self
    {
        $this->interruptionId = $interruptionId;
        return $this;
    }

    /**
     * A mandatory unique identifier of an existing attachment.
     */
    public function setAttachmentId(string $attachmentId): self
    {
        $this->attachmentId = $attachmentId;
        return $this;
    }

    /**
     * The method of the API call.
     */
    protected function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    /**
     * The endpoint of the API call.
     */
    protected function getEndpoint(): string
    {
        return "/employees/interruptions/{$this->interruptionId}/attachments/{$this->attachmentId}";
    }

    /**
     * Perform the API call.
     */
    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
