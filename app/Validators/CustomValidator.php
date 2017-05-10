<?php

namespace App\Validators;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator {

    public function validateNoNumeric($attribute, $value, $parameters)
    {
        return !is_numeric($value);
    }

    public function validateFullName($attribute, $value, $parameters)
    {
        return preg_match('/^[\pL\s\'\,\.']+$/u', $value);
    }

}