<?php

namespace Koba\Informat\Directories\Personnel\GetPhotoForEmployee;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Responses\Personnel\Photo;

class GetPhotoForEmployeeCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    protected string $personId;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $personId
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPersonId($personId);
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "employees/{$this->personId}/photos";
    }

    /**
     * Limits the output results to an employee with the provided personId.
     * The ID should contain a GUID.
     */
    public function setPersonId(string $personId): self
    {
        $this->personId = $personId;
        return $this;
    }


    /**
     * Perform the API call.
     */
    public function send(): mixed
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            Photo::class
        );
    }
}
