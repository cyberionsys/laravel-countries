<?php

namespace Cyberionsys\Countries\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;

trait HasJsonData
{
    /**
     * Get Json source Data
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function get_json_data(string $json_file): Collection
    {
        $file_path = __DIR__.'/../../data/'.$json_file;

        if (! file_exists($file_path)) {
            // In case installed in package
            $file_path = base_path('vendor/cyberionsys/laravel-countries/data/'.$json_file);
        }

        if (! file_exists($file_path)) {
            throw new FileNotFoundException();
        }

        return collect(json_decode(file_get_contents($file_path), true));
    }
}
