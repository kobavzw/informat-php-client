<?php

namespace Koba\Informat\Directories\Students\GetRegistrations;

use DateTime;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Students\Registration;

class GetRegistrationsCall
extends AbstractCall
implements HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public static function make(
        DirectoryInterface $directory,
        string $instituteNumber,
        null|int|string $schoolyear,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setSchoolyear($schoolyear); 
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return '1/registrations';
    }

    /**
     * Limits the output results to those students whose data has been changed since a certain date.
     * 
     * The internal “changedSince” date is determined based on a collection of change dates 
     * at different levels (depending on the content of the response).
     */
    public function setChangedSince(DateTime $date): self
    {
        $this->setQueryParam('changedSince', $date->format('Y-m-d'));
        return $this;
    }

    /**
     * Limits the output results to registrations within the given schoolyear.
     */
    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Perform the API call.
     * @return Registration[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapPropertyArray(
            $this->performRequest(),
            "registrations",
            Registration::class
        );
    }
}
