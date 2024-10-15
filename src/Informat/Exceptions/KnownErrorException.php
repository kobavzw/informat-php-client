<?php

namespace Koba\Informat\Exceptions;

use BackedEnum;
use Koba\Informat\Contracts\HasDescriptionInterface;
use Throwable;

class KnownErrorException
extends InformatException
implements HasErrorsExceptionInterface
{
    protected BackedEnum&HasDescriptionInterface $internalCode;
    protected string $originalMessage;

    /**
     * Creates a new method not allowed exception.
     */
    public static function make(
        BackedEnum&HasDescriptionInterface $code,
        string $message,
        int $responseCode,
        ?Throwable $previous = null
    ): self {
        return (new self($code->getDescription(), $responseCode, $previous))
            ->setInternalCode($code)
            ->setOriginalMessage($message);
    }

    /**
     * Sets the code for the exception.
     */
    protected function setInternalCode(
        BackedEnum&HasDescriptionInterface $code
    ): self {
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
