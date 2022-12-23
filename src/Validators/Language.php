<?php

namespace Cyberionsys\Countries\Validators;

use Cyberionsys\Countries\Models\Language as LanguageModel;
use Illuminate\Contracts\Validation\Validator;

class Language
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
        return empty($value) || LanguageModel::whereId($value)->exists();
    }
}
