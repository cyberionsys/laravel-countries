<?php

namespace Cyberionsys\Countries\Casts;

use Cyberionsys\Countries\Models\Country;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsCountry implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Country
     */
    public function get($model, string $key, $value, array $attributes): Country
    {
        return Country::find(strtoupper($value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return strtoupper($value instanceof Country ? $value->id : $value);
    }
}
