<?php

namespace Cyberionsys\Countries\Validators;

use Cyberionsys\Countries\Models\Country as CountryModel;
use Illuminate\Contracts\Validation\Validator;

class Country
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
        return empty($value) || CountryModel::whereId($value)->exists();
    }
}
