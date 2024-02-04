<?php

namespace Koba\Informat\Responses\Personnel;

use DateTime;
use Koba\Informat\Enums\Sex;

class Child
{
    /** Unique identifier for the child (as relationship). GUID. */
    public string $id;

    /** Child’s last name. */
    public string $naam;

    /** Child’s first name. */
    public string $voornaam;

    /** Child’s sex. */
    public Sex $geslacht;

    /** Child’s date of birth. */
    public string $geboortedatum;

    /** Indicates whether the child is deceased. */
    public bool $isOverleden;

    /** Child’s date of death. */
    public ?DateTime $datumOverleden;
}
