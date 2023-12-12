<?php

namespace Koba\Informat\Scopes;

use Koba\Informat\Helpers\InstituteNumber;

class AllScopesStrategy implements ScopeStrategyInterface
{
    /** @var InstituteNumber[] $instituteNumbers */
    protected array $instituteNumbers;

    public function __construct(string ...$instituteNumber)
    {
        $this->instituteNumbers = array_map(
            fn (string $number) => new InstituteNumber($number),
            $instituteNumber
        );
    }

    public function getScopes(): array
    {
        $output = [];
        foreach (Scope::cases() as $scope) {
            foreach ($this->instituteNumbers as $instituteNumber) {
                $output[] = "{$scope->value}.$instituteNumber";
            }
        }

        return $output;
    }
}
