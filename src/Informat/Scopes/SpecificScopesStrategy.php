<?php

namespace Koba\Informat\Scopes;

use Koba\Informat\Helpers\InstituteNumber;

class SpecificScopesStrategy implements ScopeStrategyInterface
{
    /** @var InstituteNumber[] $instituteNumbers */
    protected array $instituteNumbers;

    /** @var Scope[] $scopes */
    protected array $scopes;

    /**
     * @param Scope|Scope[] $scopes
     * @param string|string[] $instituteNumbers
     */
    public function __construct(Scope|array $scopes, string|array $instituteNumbers)
    {
        $this->instituteNumbers = array_map(
            fn (string $number) => new InstituteNumber($number),
            is_array($instituteNumbers) ? $instituteNumbers : [$instituteNumbers]
        );

        $this->scopes = is_array($scopes) ? $scopes : [$scopes];
    }

    public function getScopes(): array
    {
        $output = [];
        foreach ($this->scopes as $scope) {
            foreach ($this->instituteNumbers as $instituteNumber) {
                $output[] = "{$scope->value}.$instituteNumber";
            }
        }

        return $output;
    }
}
