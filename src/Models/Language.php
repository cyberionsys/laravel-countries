<?php

namespace Cyberionsys\Countries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends BaseModel
{
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }

    public function resolveRouteBinding($value, $field = null): Model|null
    {
        return parent::resolveRouteBinding(strtolower($value), $field);
    }
}
