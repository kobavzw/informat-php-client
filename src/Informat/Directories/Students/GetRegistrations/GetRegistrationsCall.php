<?php

namespace Koba\Informat\Directories\Students\GetRegistrations;

use DateTime;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\CallInterface;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Students\Registration;

class GetRegistrationsCall
extends AbstractCall
implements CallInterface, HasQueryParamsInterface
{
    use HasQueryParamsTrait;

    public function __construct(
        CallProcessor $callProcessor,
        string $instituteNumber,
        null|int|string $schoolyear,
    ) {
        $this->setCallProcessor($callProcessor);
        $this->setInstituteNumber($instituteNumber);
        $this->setQueryParam(
            'schoolYear',
            (string)(new Schoolyear($schoolyear))
        );
    }

    protected function getMethod(): string
    {
        return 'GET';
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
