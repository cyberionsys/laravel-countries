<?php

use Cyberionsys\Countries\Models\Country;
use Cyberionsys\Countries\Models\Currency;
use Cyberionsys\Countries\Models\Language;
use Cyberionsys\Countries\Tests\Models\TestModel;

it('casts a 2-letter ISO string as Country model', function () {
    $model = TestModel::make([
        'country' => 'LU',
    ]);

    expect($model->country)->toBeInstanceOf(Country::class);
});

it('casts a 2-letter ISO string as Language model', function () {
    $model = TestModel::make([
        'language' => 'en',
    ]);

    expect($model->language)->toBeInstanceOf(Language::class);
});

it('casts a 3-letter ISO string as Currency model', function () {
    $model = TestModel::make([
        'currency' => 'EUR',
    ]);

    expect($model->currency)->toBeInstanceOf(Currency::class);
});
