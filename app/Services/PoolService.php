<?php

namespace App\Services;

class PoolService
{
    public function __construct(
        private TmdbService $tmdb
    ) {
    }
    public function getInitialMoviesPool(): array
    {
        $response = $this->tmdb->getMovies();

        $movies = array_slice($response['results'], 0, 10);

        return array_map(function ($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'poster' => $movie['poster_path'],
                'year' => substr($movie['release_date'], 0, 4),
                'genre_ids' => $movie['genre_ids'],
            ];
        }, $movies);
    }
}

