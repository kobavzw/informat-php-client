<?php

namespace Koba\Informat\Directories\Personnel\GetDocuments;

use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\RlType;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\DocumentEdison;
use DateTimeInterface;

class GetDocumentsEdisonCall extends AbstractCall implements HasQueryParamsInterface
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
        return 'employees/documents/edsion';
    }

    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Filter by RL type. Allowed values:RL1, RL2, RL4.
     * May be repeated (e.g. rlType=RL1&rlType=RL4).
     * When omitted, all supported types are returned.
     *
     * @param RlType|array<int, RlType> $rlType
     */
    public function setRlType(RlType|array $rlType): self
    {
        $rlTypes = is_array($rlType) ? $rlType : [$rlType];

        foreach ($rlTypes as $type) {
            $this->setQueryParam('rlType', $type->value);
        }

        return $this;
    }

    /*
     * Watermark for incremental sync. Returns only documents whose edisonStatusGewijzigdOp
     * is greater than or equal to  this value. Rows where edisonStatusGewijzigdOp
     * is null are not returned. Omit for a complete initial sync.
     */
    public function setReferenceDate(DateTimeInterface $date): self
    {
        $this->setQueryParam('referencedate', $date->format('c'));
        return $this;
    }

    /**
     * Perform the API call.
     *
     * @return DocumentEdison[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            DocumentEdison::class
        );
    }
}
