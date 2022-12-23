<?php

use Cyberionsys\Countries\Models\Language;
use Cyberionsys\Countries\Traits\HasJsonData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

return new class extends Migration
{
    use HasJsonData;

    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('id', 2)->comment('ISO 639-1')->primary();
            $table->string('iso639_2', 3)->index();
            $table->string('iso639_2b', 3)->nullable()->index();
            $table->string('name');
            $table->string('native_name')->nullable();
            $table->string('family')->nullable();
            $table->string('wiki_url')->nullable();
        });

        // Seed
        Language::unguard();

        $languages = $this->get_json_data('languages.json');
        $locales = collect(config('app.locale'))
            ->merge(config('app.fallback_locale'))
            ->merge(config('iso-countries.locales'))
            ->unique();

        foreach ($languages as $language) {
            $language = new Fluent($language);

            $l = Language::create([
                'id' => $language['639-1'],
                'iso639_2' => $language['639-2'],
                'iso639_2b' => $language['639-2/B'],
                'name' => $language['name'],
                'native_name' => $language['nativeName'],
                'family' => $language['family'],
                'wiki_url' => $language['wikiUrl'],
            ]);

            foreach ($locales as $locale) {
                $file = base_path("vendor/umpirsky/language-list/data/$locale/language.php");

                if (! file_exists($file)) {
                    continue;
                }

                $translations = require $file;

                foreach ($translations as $id => $name) {
                    $l->setTranslation('name', $locale, $name)->saveQuietly();
                }
            }
        }

        Language::reguard();
    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
