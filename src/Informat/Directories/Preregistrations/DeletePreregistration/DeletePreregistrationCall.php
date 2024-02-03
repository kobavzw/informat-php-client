<?php

namespace Koba\Informat\Directories\Preregistrations\DeletePreregistration;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\CallProcessor;

class DeletePreregistrationCall
extends AbstractCall
{
    public function __construct(
        CallProcessor $callProcessor,
        string $instituteNumber,
        protected string $preRegistrationId
    ) {
        $this->setCallProcessor($callProcessor);
        $this->setInstituteNumber($instituteNumber);
    }

    protected function getMethod(): string
    {
        return 'DELETE';
    }

    protected function getEndpoint(): string
    {
        return "1/preregistrations/{$this->preRegistrationId}";
    }

    /**
     * Perform the API call.
     * @return null
     */
    public function send(): mixed
    {
        $this->performRequest();
        return null;
    }
}
