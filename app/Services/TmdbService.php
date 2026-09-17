<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    public function testConnection(): array
    {
        $response = Http::withToken(config('services.tmdb.token'))
            ->acceptJson()
            ->get('https://api.themoviedb.org/3/authentication');

        $response->throw();

        return $response->json();
    }

    public function getMovies(): array
    {
        $response = Http::withToken(config('services.tmdb.token'))
            ->acceptJson()
            ->get('https://api.themoviedb.org/3/discover/movie'); //general-purpose movie-list endpoint.

        $response->throw();

        return $response->json();
    }
}