<?php

namespace Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;

class GetPreregistrationStatusCall
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

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
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
