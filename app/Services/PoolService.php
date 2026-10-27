<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PoolService
{
    public function __construct(
        private TmdbService $tmdb
    ) {
    }
    public function getInitialMoviesPool(): array
    {
        $response = $this->tmdb->getMovies();

        return array_slice($response['results'], 0, 10);
    }
}

