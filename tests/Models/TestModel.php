<?php

namespace Cyberionsys\Countries\Tests\Models;

use Cyberionsys\Countries\Casts\AsCountry;
use Cyberionsys\Countries\Casts\AsCurrency;
use Cyberionsys\Countries\Casts\AsLanguage;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'country' => AsCountry::class,
        'currency' => AsCurrency::class,
        'language' => AsLanguage::class,
    ];
}
