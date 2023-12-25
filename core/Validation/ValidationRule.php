<?php

namespace Core\Validation;

abstract class ValidationRule
{
    public function __construct(
        protected readonly string $field,
        protected readonly ?string $value = null,
        protected readonly ?array $options = [],
    ) {
    }

    abstract public function validate() : bool;

    abstract public function errorMessage() : string;

}
