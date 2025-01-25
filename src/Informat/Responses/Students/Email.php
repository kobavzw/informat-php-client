<?php

namespace Koba\Informat\Responses\Students;

class Email
{
    /** Unique integer-value for the email address within the database. */
    public int $pEmail;

    /** Email address. */
    public string $email;

    /** Email address type. */
    public string $type;

    /** Indicates if this email address can be used for school communication purposes. */
    public bool $schoolcom;

    /** Indicates if this email address can be used to mail invoices. */
    public bool $factuurMailen;
}
