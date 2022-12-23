<?php

namespace Cyberionsys\Countries;

use Cyberionsys\Countries\Validators\Country;
use Cyberionsys\Countries\Validators\Currency;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CountriesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-countries')
            ->hasConfigFile('countries')
            ->hasMigrations([
                'create_countries_table',
                'create_currencies_table',
                'create_languages_table',
                'create_pivot_country_country_table',
                'create_pivot_country_currency_table',
                'create_pivot_country_language_table',
            ]);
    }

    public function bootingPackage()
    {
        // Register validation rules
        Validator::extend('country', Country::class);
        Validator::extend('currency', Currency::class);
    }
}
