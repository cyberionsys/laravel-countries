<?php

namespace Cyberionsys\Countries\Casts;

use Cyberionsys\Countries\Models\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsCurrency implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  mixed  $value
     */
    public function get($model, string $key, $value, array $attributes): Currency
    {
        return Currency::find(strtoupper($value));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  array  $value
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return strtoupper($value instanceof Currency ? $value->id : $value);
    }
}
