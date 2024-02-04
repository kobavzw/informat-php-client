<?php

namespace Koba\Informat\Directories\Preregistrations\GetPreregistrationStatus;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;

class GetPreregistrationStatusCall
extends AbstractCall
{
    protected string $preRegistrationId;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $preRegistrationId
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPreRegistrationId($preRegistrationId);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "1/preregistrations/{$this->preRegistrationId}/status";
    }

    /**
     * The unique identifier of the pre-registration.
     */
    public function setPreRegistrationId(string $preRegistrationId): self
    {
        $this->preRegistrationId = $preRegistrationId;
        return $this;
    }

    /** 
     * Perform the API call 
     */
    public function send(): GetPreregistrationStatusResponse
    {
        return (new JsonMapper)->mapProperty(
            $this->performRequest(),
            'preRegistrationStatus',
            GetPreregistrationStatusResponse::class
        );
    }
}
