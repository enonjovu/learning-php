<?php

namespace Core\Validation;

use Core\Exceptions\Validation\ValidationException;

class Validation
{
    private array $errors = [];
    private array $valid_fields = [];
    private array $aliases = [
        "required" => \Core\Validation\Rules\Required::class,
        "string" => \Core\Validation\Rules\ShouldBeString::class,
        "email" => \Core\Validation\Rules\ShouldBeEmail::class,
    ];

    private function __construct(
        protected readonly array $fields,
        protected readonly array $rules,
    ) {
    }

    public static function create(array $fields, array $rules)
    {
        return new static($fields, $rules);
    }

    public function validate() : ?array
    {
        $fields_with_rules = array_filter($this->fields, fn (string $key) => array_key_exists($key, $this->rules), ARRAY_FILTER_USE_KEY);

        foreach ($fields_with_rules as $field => $value) {
            $rules = $this->rules[$field];
            $this->check($field, $value, $rules);
        }


        if (! empty($this->errors)) {
            ValidationException::create($this->errors, $fields_with_rules);
        }

        return $this->valid_fields;
    }

    private function check(string $field, mixed $value, array $rules)
    {
        foreach ($rules as $rule) {
            if (is_string($rule)) {
                if (array_key_exists($rule, $this->aliases)) {
                    $validationRule = new $this->aliases[$rule]($field, $value);
                    $this->validateRule($validationRule, $field, $value);
                }
            } else {
                if ($rule instanceof ValidationRule) {
                    $this->validateRule($rule, $field, $value);
                }
            }
        }
    }

    public function validateRule(ValidationRule $validationRule, $field, $value)
    {
        if ($validationRule->validate()) {
            $this->valid_fields[$field] = $value;
        } else {
            $this->errors[$field] = $validationRule->errorMessage();
        }
    }


}
