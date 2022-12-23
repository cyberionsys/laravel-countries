<?php

use Cyberionsys\Countries\Models\Country;

// Check existence of certain countries and their relations

it('contains correct data for United States', function () {
    $attributes = [
        'id' => 'US',
        'alpha3' => 'USA',
        'name->en' => 'United States of America',
    ];

    $this->assertDatabaseHas('countries', $attributes);

    $model = Country::query()->where($attributes)->first();

    expect($model->currencies->pluck('id')->toArray())->toBe(['USD']);
    expect($model->languages->pluck('id')->toArray())->toBe(['en']);
    expect($model->neighbours->pluck('id')->toArray())->toBe(['CA', 'MX']);
});

it('contains correct data for UK', function () {
    $attributes = [
        'id' => 'GB',
        'alpha3' => 'GBR',
        'name->en' => 'United Kingdom of Great Britain and Northern Ireland',
    ];

    $this->assertDatabaseHas('countries', $attributes);

    $model = Country::query()->where($attributes)->first();

    expect($model->currencies->pluck('id')->toArray())->toBe(['GBP']);
    expect($model->languages->pluck('id')->toArray())->toBe(['en']);
    expect($model->neighbours->pluck('id')->toArray())->toBe(['IE']);
});

it('contains correct model relationships', function () {
    $country = Country::find('LU');

    $this->assertEqualsCanonicalizing($country->languages->pluck('id')->toArray(), ['lb', 'de', 'fr']);
    $this->assertEqualsCanonicalizing($country->currencies->pluck('id')->toArray(), ['EUR']);
    $this->assertEqualsCanonicalizing($country->neighbours->pluck('id')->toArray(), ['DE', 'FR', 'BE']);
});

it('has the expected amount of countries')->assertDatabaseCount('countries', 250);

it('has the expected amount of languages')->assertDatabaseCount('languages', 183);

it('has the expected amount of currencies')->assertDatabaseCount('currencies', 138);
