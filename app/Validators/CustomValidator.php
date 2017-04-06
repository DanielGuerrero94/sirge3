<?php

namespace App\Validators;

class CustomValidator extends Illuminate\Validation\Validator {

    public function validateNoNumeric($attribute, $value, $parameters)
    {
        return !is_numeric($value);
    }

}