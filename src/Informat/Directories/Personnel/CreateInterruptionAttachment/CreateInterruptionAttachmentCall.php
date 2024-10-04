<?php

namespace Koba\Informat\Directories\Personnel\CreateInterruptionAttachment;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\Personnel\PersonnelDirectory;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\File;
use Psr\Http\Message\ResponseInterface;

class CreateInterruptionAttachmentCall extends AbstractCall
{
    protected string $interruptionId;
    protected string $attachmentId;
    protected File $file;

    public static function make(
        PersonnelDirectory $directory,
        string $instituteNumber,
        string $interruptionId,
        string $attachmentId,
        File $file,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setInterruptionId($interruptionId)
            ->setAttachmentId($attachmentId)
            ->setFile($file);
    }

    /**
     * The mandatory unique identifier of an existing interruption, to which the
     * attachment will be linked.
     */
    public function setInterruptionId(string $interruptionId): self
    {
        $this->interruptionId = $interruptionId;
        return $this;
    }

    /**
     * A mandatory unique identifier which is used to identify the attachment. 
     * Based on this Id the decision will be made to add a new attachment or
     * update an existing one.
     */
    public function setAttachmentId(string $attachmentId): self
    {
        $this->attachmentId = $attachmentId;
        return $this;
    }

    /**
     * Sets the file contents as the attachment.
     */
    public function setFile(File $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * The method of the API call.
     */
    protected function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    /**
     * The endpoint to which the API call should be sent.
     */
    protected function getEndpoint(): string
    {
        return "/employees/interruptions/{$this->interruptionId}/attachments/{$this->attachmentId}";
    }

    /**
     * The contents of the API call.
     * 
     * @return array<string,mixed>
     */
    protected function getBody(): array
    {
        return [
            'filename' => $this->file->getName(),
            'file' => $this->file->getContents()
        ];
    }

    /**
     * Perform the API call.
     */
    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
