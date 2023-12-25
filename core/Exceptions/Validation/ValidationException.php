<?php

namespace Core\Exceptions\Validation;

class ValidationException extends \Exception
{
    private array $errors = [];
    private array $old = [];

    public static function create(array $errors = [], array $old = [])
    {
        $error = new ValidationException();
        $error->errors = $errors;
        $error->old = $old;

        throw $error;
    }

    public function getValidationErrors() : array
    {
        return $this->errors;
    }

    public function getOldValues() : array
    {
        return $this->old;
    }
}
