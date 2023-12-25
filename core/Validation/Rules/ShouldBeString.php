<?php

namespace Core\Validation\Rules;

use Core\Validation\ValidationRule;

class ShouldBeString extends ValidationRule
{
    public function validate() : bool
    {
        $text = trim($this->value);

        return is_string($text) && strlen($text) > 0;
    }

    public function errorMessage() : string
    {
        return "The field " . $this->field . " should string";
    }
}
