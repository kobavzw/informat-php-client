<?php

namespace Koba\Informat\Exceptions;

use Koba\Informat\Enums\BadRequestCode;
use Throwable;

class BadRequestException
extends InformatException
implements HasErrorsExceptionInterface
{
    protected BadRequestCode $internalCode;
    protected string $originalMessage;

    /**
     * Creates a new method not allowed exception.
     */
    public static function make(
        BadRequestCode $code,
        string $message,
        ?Throwable $previous = null
    ): self {
        return (new self($code->getDescription(), 405,  $previous))
            ->setInternalCode($code)
            ->setOriginalMessage($message);
    }

    /**
     * Sets the code for the exception.
     */
    protected function setInternalCode(BadRequestCode $code): self
    {
        $this->internalCode = $code;
        return $this;
    }

    /**
     * Sets the original message that came back from the API.
     */
    protected function setOriginalMessage(string $message): self
    {
        $this->originalMessage = $message;
        return $this;
    }

    /**
     * Returns the original error message that was returned from the API.
     */
    protected function getOriginalMessage(): string
    {
        return $this->originalMessage;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        $previous = $this->getPrevious();
        if ($previous instanceof HasErrorsExceptionInterface) {
            return [
                ...$previous->getErrors(),
                $this->getMessage(),
            ];
        }

        return [$this->getMessage()];
    }

    /**
     * @inheritDoc
     */
    public function getErrorString(): string
    {
        return implode(' ', $this->getErrors());
    }
}
