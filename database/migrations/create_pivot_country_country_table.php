<?php

use Cyberionsys\Countries\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('country_country', function (Blueprint $table) {
            $table->string('country_id', 2)->index();
            $table->string('neighbour_id', 2)->index();

            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('neighbour_id')->references('id')->on('countries')->cascadeOnDelete();
        });

        // Seed
        $countries = collect(json_decode(file_get_contents(__DIR__.'/../../data/countries-v2.json'), true));

        foreach ($countries as $country) {
            Country::find($country['alpha2Code'])->neighbours()->syncWithoutDetaching(
                Country::whereIn('alpha3', $country['borders'] ?? [])->pluck('id')
            );
        }
    }

    public function down()
    {
        Schema::dropIfExists('country_country');
    }
};
