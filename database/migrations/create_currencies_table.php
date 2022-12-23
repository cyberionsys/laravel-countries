<?php

use Cyberionsys\Countries\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('id', 3)->comment('ISO 4217')->primary();
            $table->string('name');
            $table->string('name_plural');
            $table->string('symbol');
            $table->string('symbol_native');
            $table->unsignedTinyInteger('decimal_digits')->default(2);
            $table->float('rounding')->default(0);
        });

        // Seed it
        Currency::unguard();

        $currencies = collect(json_decode(file_get_contents(__DIR__.'/../../data/currencies.json'), true));
        $locales = collect(config('app.locale'))
            ->merge(config('app.fallback_locale'))
            ->merge(config('iso-countries.locales'))
            ->unique();

        foreach ($currencies as $code => $currency) {
            $c = Currency::create([
                'id' => $code,
                'name' => $currency['name'],
                'name_plural' => $currency['name_plural'],
                'symbol' => $currency['symbol'],
                'symbol_native' => $currency['symbol_native'],
                'decimal_digits' => $currency['decimal_digits'],
                'rounding' => $currency['rounding'],
            ]);

            foreach ($locales as $locale) {
                $file = base_path("vendor/umpirsky/currency-list/data/$locale/currency.php");

                if (! file_exists($file)) {
                    continue;
                }

                $translations = require $file;

                foreach ($translations as $id => $name) {
                    $c->setTranslation('name', $locale, $name)->saveQuietly();
                }
            }
        }

        Currency::reguard();
    }

    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
