<?php

namespace Cyberionsys\Countries\Validators;

use Cyberionsys\Countries\Models\Currency as CurrencyModel;
use Illuminate\Contracts\Validation\Validator;

class Currency
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @param  Validator  $validator
     * @return bool
     */
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        return empty($value) || CurrencyModel::whereId($value)->exists();
    }
}
