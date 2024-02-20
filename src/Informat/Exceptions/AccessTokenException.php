<?php

namespace Koba\Informat\Exceptions;

class AccessTokenException extends InformatException
{
    /**
     * @param string[] $scopes
     */
    public function __construct(string $message, protected array $scopes)
    {
        parent::__construct($message);
    }

    /**
     * @return string[]
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }
}
