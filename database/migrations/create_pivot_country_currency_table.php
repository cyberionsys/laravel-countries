<?php

use Cyberionsys\Countries\Models\Country;
use Cyberionsys\Countries\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('country_currency', function (Blueprint $table) {
            $table->string('country_id', 2)->index();
            $table->string('currency_id', 3)->index();

            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnDelete();
        });

        // Seed
        $countries = collect(json_decode(file_get_contents(__DIR__.'/../../data/countries-v2.json'), true));

        foreach ($countries as $country) {
            $currency_codes = collect($country['currencies'] ?? [])->pluck('code')->toArray();
            Country::find($country['alpha2Code'])->currencies()->syncWithoutDetaching(
                Currency::findMany($currency_codes)->pluck('id')
            );
        }
    }

    public function down()
    {
        Schema::dropIfExists('country_currency');
    }
};
