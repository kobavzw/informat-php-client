<?php

namespace Koba\Informat\Call;

use Koba\Informat\Enums\BaseUrl;

class UrlBuilder implements UrlBuilderInterface
{
    public function __construct(protected BaseUrl $baseUrl)
    {
    }

    public function build(string $endpoint, ?string $queryParams = null): string
    {
        $url = rtrim($this->baseUrl->value, '/')
            . '/'
            . ltrim($endpoint, '/');

        return $queryParams === null
            ? $url
            : "$url?$queryParams";
    }
}
