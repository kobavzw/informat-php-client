<?php

namespace Koba\Informat\Directories\Preregistrations\CreatePreregistration;

use Koba\Informat\Enums\PreregistrationStatus;

class CreatePreregistrationResponse
{
    /** 
     * Unique identifier which identifies the pre-registration. 
     * Determined during the creation of the pre-registration 
     */
    public string $preRegistrationId;

    /**
     * Status of the pre-registration. 
     * The status will always be “open” after a creation.
     */
    public PreregistrationStatus $status;
}
