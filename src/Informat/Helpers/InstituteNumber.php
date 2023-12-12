<?php

namespace Koba\Informat\Helpers;

use Koba\Informat\Exceptions\ValidationException;

class InstituteNumber
{
    protected string $number;

    public function __construct(string $number)
    {
        if (strlen($number) > 6) {
            throw new ValidationException('Instellingsnummer mag niet langer zijn dan 6 karakters.');
        }

        $this->number = str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function __toString()
    {
        return $this->number;
    }
}
