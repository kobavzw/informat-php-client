<?php

namespace Koba\Informat\Call;

interface HasQueryParamsInterface
{
    public function getQueryParamString(): string;
}