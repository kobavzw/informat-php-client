<?php

namespace Koba\Informat\Directories\Preregistrations\DeletePreregistration;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;

class DeletePreregistrationCall
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
        return HttpMethod::DELETE;
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
