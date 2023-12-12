<?php

namespace Koba\Informat\Exceptions;

class CallException
extends InformatException
implements HasErrorsExceptionInterface
{
    /**
     * @param string $message 
     * @param string[] $errors 
     * @return void 
     */
    public function __construct(string $message, private array $errors)
    {
        parent::__construct($message);
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorString(): string
    {
        return implode(
            ', ',
            $this->errors,
        );
    }
}
