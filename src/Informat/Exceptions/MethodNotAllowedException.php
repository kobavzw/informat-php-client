<?php

namespace Koba\Informat\Exceptions;

use Koba\Informat\Enums\MethodNotAllowedCode;
use Throwable;

class MethodNotAllowedException extends InformatException
{
    protected MethodNotAllowedCode $internalCode;
    protected string $originalMessage;

    /**
     * Creates a new method not allowed exception.
     */
    public static function make(
        MethodNotAllowedCode $code,
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
    protected function setInternalCode(MethodNotAllowedCode $code): self
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
}
