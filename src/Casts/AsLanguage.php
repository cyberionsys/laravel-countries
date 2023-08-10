<?php

namespace Cyberionsys\Countries\Casts;

use Cyberionsys\Countries\Models\Language;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsLanguage implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  mixed  $value
     */
    public function get($model, string $key, $value, array $attributes): Language
    {
        return Language::find(strtolower($value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     */
    public function set($model, $key, $value, $attributes): string
    {
        return strtolower($value instanceof Language ? $value->id : $value);
    }
}
