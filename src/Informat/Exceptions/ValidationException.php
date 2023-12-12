<?php

namespace Koba\Informat\Exceptions;

class ValidationException
extends InformatException
implements HasErrorsExceptionInterface
{
    /** @var string[] $errors */
    protected $errors = [];

    /**
     * @param string[]|string $errors 
     */
    public function __construct(array|string $errors)
    {
        $this->errors = is_string($errors) ? [$errors] : $errors;
        parent::__construct(implode(' ', $this->errors));
    }

    public function getErrorString(): string
    {
        return $this->getMessage();
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
