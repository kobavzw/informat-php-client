<?php

namespace Koba\Informat\Helpers;

use DateTime;
use Koba\Informat\Exceptions\ValidationException;

class Schoolyear
{
    protected string $schoolyear;

    public function __construct(int|string|null $schoolyear)
    {
        // If null, is passed, determine the schoolyear based on the current date.
        if ($schoolyear === null) {
            $now = new DateTime;
            $schoolyear = $now->format('n') < 9
                ? (string)($now->format('Y') - 1)
                : (string)($now->format('Y'));
        }

        // If the schoolyear is an int, cast it to a string
        if (is_int($schoolyear)) {
            $schoolyear = (string)$schoolyear;
        }

        // If the schoolyear matches the dddd format, create the object.
        if (1 === preg_match('/^\d{4}$/', $schoolyear)) {
            $next = (int)substr($schoolyear, 2, 2) + 1;
            $this->schoolyear = "$schoolyear-$next";
            return;
        }

        // If the schoolyear matches the dddd-dd format, create the object.
        if (1 === preg_match('/^\d{4}-\d{2}$/', $schoolyear)) {
            $this->schoolyear = $schoolyear;
            return;
        }

        throw new ValidationException("Ongeldig schooljaar.");
    }

    public function __toString()
    {
        return $this->schoolyear;
    }
}
