<?php

namespace Koba\Informat\Call;

interface UrlBuilderInterface
{
    public function build(string $endpoint, ?string $queryParams = null): string;
}