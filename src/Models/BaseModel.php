<?php

namespace Cyberionsys\Countries\Models;

use Cyberionsys\Countries\Models\Traits\ReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

abstract class BaseModel extends Model
{
    use ReadOnlyModel;
    use HasTranslations;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [];

    protected $hidden = ['pivot'];

    public $translatable = ['name'];

    /**
     * Gets the name of the model in slug format
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }
}
