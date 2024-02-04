<?php

namespace Koba\Informat\Call;

trait HasQueryParamsTrait
{
    /** @var array<string,string> $params */
    protected array $params = [];

    /**
     * Returns all query parameters as a string that can be used in a URL.
     */
    public function getQueryParamString(): string
    {
        return http_build_query($this->params);
    }

    /**
     * Sets a query parameter for the given key with the given value.
     */
    protected function setQueryParam(string $key, string $value): void
    {
        $this->params[$key] = $value;
    }
}