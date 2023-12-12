<?php

namespace Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus;

use Koba\Informat\Enums\PreregistrationStatus;

class GetPreregistrationStatusResponse
{
    /**
     * Unique identifier which identifies the pre-registration. 
     * Determined during the creation of the pre-registration. 
     */
    public string $preRegistrationId;

    /** Status of the pre-registration/registration. */
    public PreregistrationStatus $status;
}
