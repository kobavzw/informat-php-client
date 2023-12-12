<?php

namespace Koba\Informat\Scopes;

interface ScopeStrategyInterface
{
    /**
     * @return string[]
     */
    public function getScopes(): array;
}
