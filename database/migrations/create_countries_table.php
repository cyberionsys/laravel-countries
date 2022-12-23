<?php

use Cyberionsys\Countries\Models\Country;
use Cyberionsys\Countries\Traits\HasJsonData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use HasJsonData;

    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->string('id', 2)->comment('ISO 3166-1 alpha-2')->primary();
            $table->smallInteger('numeric')->index();
            $table->string('alpha3', 3)->index();
            $table->json('name');
            $table->string('native_name')->nullable();
            $table->string('capital')->nullable();
            $table->string('top_level_domain')->nullable();
            $table->string('calling_code')->nullable();
            $table->string('region')->nullable();
            $table->string('subregion')->nullable();
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->string('demonym')->nullable();
            $table->float('area')->nullable();
            $table->unsignedInteger('population')->nullable();
            $table->string('emoji_flag')->nullable();
            $table->boolean('is_independent')->nullable();
            $table->boolean('is_un_member')->nullable();
            $table->boolean('is_eu_member')->nullable();
            $table->string('ioc', 3)->index()->nullable();
            $table->string('fifa', 3)->index()->nullable();
            $table->string('start_of_week')->nullable();
        });

        // Now seed it
        Country::unguard();

        $countries = $this->get_json_data('countries-v2.json');
        $locales = collect(config('app.locale'))
            ->merge(config('app.fallback_locale'))
            ->merge(config('countries.locales'))
            ->unique();

        foreach ($countries as $country) {
            $c = Country::create([
                'id' => $country['alpha2Code'],
                'alpha3' => $country['alpha3Code'],
                'numeric' => $country['numericCode'],
                'name' => $country['name'],
                'native_name' => $country['nativeName'],
                'capital' => $country['capital'] ?? null,
                'top_level_domain' => $country['topLevelDomain'][0] ?? null,
                'calling_code' => $country['callingCodes'][0] ?? null,
                'region' => $country['region'],
                'subregion' => $country['subregion'],
                'lat' => $country['latlng'][0] ?? null,
                'lon' => $country['latlng'][1] ?? null,
                'demonym' => $country['demonym'],
                'area' => (($country['area'] ?? null) < 0) ? null : ($country['area'] ?? null),
                'population' => $country['population'],
                'is_independent' => $country['independent'],
                'is_eu_member' => collect($country['regionalBlocs'] ?? [])->where('acronym', 'EU')->count(),
            ]);

            // Translations
            foreach ($locales as $locale) {
                $translation = empty($country['translations'][$locale]) ? null : $country['translations'][$locale];
                if (! empty($translation)) {
                    $c->setTranslation('name', $locale, $translation)->saveQuietly();
                }
            }
        }

        $countries = $this->get_json_data('countries-v3.1.json');

        foreach ($countries as $country) {
            Country::find($country['cca2'])->update([
                'population' => $country['population'],
                'emoji_flag' => $country['flag'] ?? null,
                'is_un_member' => $country['unMember'],
                'fifa' => $country['fifa'] ?? null,
                'ioc' => $country['cioc'] ?? null,
                'start_of_week' => $country['startOfWeek'] ?? null,
            ]);
        }

        Country::reguard();
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
