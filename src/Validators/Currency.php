<?php

namespace Cyberionsys\Countries\Validators;

use Cyberionsys\Countries\Models\Currency as CurrencyModel;
use Illuminate\Contracts\Validation\Validator;

class Currency
{
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        return empty($value) || CurrencyModel::whereId($value)->exists();
    }
}
