<?php

namespace Koba\Informat\Directories\Personnel\GetDocuments;

use DateTimeInterface;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Call\HasQueryParamsInterface;
use Koba\Informat\Call\HasQueryParamsTrait;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\RlType;
use Koba\Informat\Helpers\JsonMapper;
use Koba\Informat\Helpers\Schoolyear;
use Koba\Informat\Responses\Personnel\Document;

class GetDocumentsCall extends AbstractCall implements HasQueryParamsInterface
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
        return 'employees/documents';
    }

    public function setSchoolyear(null|int|string $schoolyear): self
    {
        $this->setQueryParam('schoolYear', new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * Filter by RL type. Allowed values: RL1, RL2. May be repeated to filter on multiple types
     * (e.g.b?rlType=RL1&rlType=RL2). If omitted, both RL1 and API Version 2 Document Version v2.12 64
     * RL2 are returned. An unsupported value returns HTTP 400 (BR_DOC_007)
     */
    public function setRlType(RlType $rlType): self
    {
        $this->setQueryParam('rlType', $rlType->value);
        return $this;
    }

    /*
     * Watermark for incremental sync. Returns only documents whose edisonStatusGewijzigdOp
     * is greater than or equal to  this value. Rows where edisonStatusGewijzigdOp
     * is null are not returned. Omit for a complete initial sync.
     */
    public function setReferenceDate(DateTimeInterface $date): self
    {
        $this->setQueryParam('referencedate', $date->format('Y-m-d'));
        return $this;
    }

    /**
     * Perform the API call. 
     * 
     * @return Document[]
     */
    public function send(): array
    {
        return (new JsonMapper)->mapArray(
            $this->performRequest(),
            Document::class
        );
    }
}
