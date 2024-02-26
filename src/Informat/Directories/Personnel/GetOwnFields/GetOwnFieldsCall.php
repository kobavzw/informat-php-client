<?php

namespace Koba\Informat\Directories\Personnel\GetOwnFields;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;

class GetOwnFieldsCall
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

    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    protected function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    protected function getEndpoint(): string
    {
        return 'employees/OwnFields';
    }

    /**
     * @return OwnField[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            OwnField::class
        );
    }
}
