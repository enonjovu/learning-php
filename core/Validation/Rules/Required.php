<?php

namespace Core\Validation\Rules;

use Core\Validation\ValidationRule;

class Required extends ValidationRule
{
    public function validate() : bool
    {
        return ! is_null($this->field);
    }

    public function errorMessage() : string
    {
        return "The field " . $this->field . " is required";
    }
}
