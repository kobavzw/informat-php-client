<?php

namespace Koba\Informat\Directories\Preregistrations\DeletePreregistration;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;

class DeletePreregistrationCall
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
        return HttpMethod::DELETE;
    }

    protected function getEndpoint(): string
    {
        return "1/preregistrations/{$this->preRegistrationId}";
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
     * Perform the API call.
     */
    public function send(): null
    {
        $this->performRequest();
        return null;
    }
}
