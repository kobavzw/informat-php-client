<?php

namespace Koba\Informat\Directories\Students\GetRegistrations;

use DateTime;
use Koba\Informat\Call\CallInterface;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\GenericCall;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Students\Registration;

class GetRegistrationsCall
extends GenericCall
implements CallInterface
{
    /** @var array<string,string> $queryParams */
    protected array $queryParams;

    public function __construct(
        CallProcessor $callProcessor,
        string $instituteNumber,
        null|int|string $schoolyear,
    ) {
        $this->setCallProcessor($callProcessor);
        $this->setInstituteNumber($instituteNumber);
        $this->queryParams['schoolYear'] = (string)(new Schoolyear($schoolyear));
    }

    protected function getMethod(): string
    {
        return 'GET';
    }

    protected function getEndpoint(): string
    {
        return '1/registrations?' . http_build_query($this->queryParams);
    }

    /**
     * Limits the output results to those students whose data has been changed since a certain date.
     * 
     * The internal “changedSince” date is determined based on a collection of change dates 
     * at different levels (depending on the content of the response).
     */
    public function setChangedSince(DateTime $date): self
    {
        $this->queryParams['changedSince'] = $date->format('Y-m-d');
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
