<?php

namespace Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;

class GetPreregistrationStatusCall
extends AbstractCall
{
    public function __construct(
        DirectoryInterface $directory,
        string $instituteNumber,
        protected string $preRegistrationId
    ) {
        $this->setDirectory($directory);
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
