<?php

use Cyberionsys\Countries\Models\Country;
use Cyberionsys\Countries\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('country_language', function (Blueprint $table) {
            $table->string('country_id', 2)->index();
            $table->string('language_id', 2)->index();

            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('language_id')->references('id')->on('languages')->cascadeOnDelete();
        });

        // Seed
        $countries = collect(json_decode(file_get_contents(__DIR__.'/../../data/countries-v2.json'), true));

        foreach ($countries as $country) {
            $language_codes = collect($country['languages'] ?? [])->pluck('iso639_2')->toArray();
            Country::find($country['alpha2Code'])->languages()->syncWithoutDetaching(
                Language::whereIn('iso639_2', $language_codes)->pluck('id')
            );
        }
    }

    public function down()
    {
        Schema::dropIfExists('country_language');
    }
};
