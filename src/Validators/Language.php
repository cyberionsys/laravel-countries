<?php

namespace Cyberionsys\Countries\Validators;

use Cyberionsys\Countries\Models\Language as LanguageModel;
use Illuminate\Contracts\Validation\Validator;

class Language
{
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        return empty($value) || LanguageModel::whereId($value)->exists();
    }
}
