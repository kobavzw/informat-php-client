<?php

namespace Koba\Informat\Call;

trait HasQueryParamsTrait
{
    /** @var array<string,string> $params */
    protected array $params = [];

    public function getQueryParamString(): string
    {
        return http_build_query($this->params);
    }

    public function setQueryParam(string $key, string $value): void
    {
        $this->params[$key] = $value;
    }
}