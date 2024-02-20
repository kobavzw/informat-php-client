<?php

namespace Koba\Informat\Responses\Personnel;

use DateTime;
use Koba\Informat\Enums\Income;

class Partner
{
    /** Unique identifier for the partner. (GUID) */
    public string $id;

    /** Partner’s last name. */
    public string $naam;

    /** Partner’s first name. */
    public ?string $voornaam;

    /** Partner’s date of birth. */
    public ?DateTime $geboortedatum;

    /** Partner’s official nationality code. */
    public ?string $nationaliteitCode;

    /** Indicates whether the partner is deceased. */
    public bool $isOverleden;

    /** Partner’s date of death. */
    public ?DateTime $datumOverleden;

    /** Partner’s Income. */
    public ?Income $inkomen;
}
