<?php

namespace Koba\Informat\Responses\Personnel;

class EmailAddress
{
    /** Unique identifier for the email address. GUID. */
    public string $id;

    /** Email address type. */
    public string $type;

    /** Email address. */
    public string $email;
}
