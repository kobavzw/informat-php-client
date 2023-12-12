<?php

namespace Koba\Informat\Exceptions;

interface HasErrorsExceptionInterface
{
    /** 
     * @return string[] 
     */
    public function getErrors(): array;
    public function getErrorString(): string;
}
