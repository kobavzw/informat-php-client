<?php

namespace Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus;

use Koba\Informat\Call\CallInterface;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\GenericCall;
use Koba\Informat\Helpers\JsonMapper;

class GetPreregistrationStatusCall
extends GenericCall
implements CallInterface
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
        return 'GET';
    }

    protected function getEndpoint(): string
    {
        return "1/preregistrations/{$this->preRegistrationId}/status";
    }

    /** Perform the API call */
    public function send(): GetPreregistrationStatusResponse
    {
        return (new JsonMapper)->mapProperty(
            $this->performRequest(),
            'preRegistrationStatus',
            GetPreregistrationStatusResponse::class
        );
    }
}
