<?php

namespace Koba\Informat\Directories\Personnel\GetPhotos;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Responses\Personnel\Photo;

class GetPhotos
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
    ): self {
        return (new self($directory, $instituteNumber));
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return 'employees/photos';
    }

    /**
     * This is an actually an additional restriction on the school year filter.
     */
    public function setStructure(string $structure): self
    {
        $this->setQueryParam('structure', $structure);
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
