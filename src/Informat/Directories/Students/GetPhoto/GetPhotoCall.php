<?php

namespace Koba\Informat\Directories\Students\GetPhoto;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;

class GetPhotoCall
extends AbstractCall
{
    protected string $studentId;

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return "1/students/{$this->studentId}/photo";
    }

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        string $studentId,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setStudentId($studentId);
    }

    /**
     * Limits the output results to a student with the provided studentId.
     */
    public function setStudentId(string $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * Perform the API call.
     */
    public function send(): Photo
    {
        return (new JsonMapper)->mapProperty(
            $this->performRequest(),
            'photo',
            Photo::class
        );
    }
}
