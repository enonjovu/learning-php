<?php

namespace Core\Validation\Rules;

use Core\Validation\ValidationRule;

class ShouldBeEmail extends ValidationRule
{
    public function validate() : bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }

    public function errorMessage() : string
    {
        return "The field " . $this->field . " should a valid email";
    }
}
