<?php

use App\Services\TmdbService;
use Illuminate\Support\Facades\Http;

it('can authenticate with TMDB', function () {
    Http::fake([
        'https://api.themoviedb.org/3/authentication' => Http::response([
            'success' => true,
            'status_code' => 1,
            'status_message' => 'Success.',
        ], 200),
    ]);

    $service = new TmdbService();

    $response = $service->testConnection();

    expect($response['success'])->toBeTrue();

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.themoviedb.org/3/authentication'
            && $request->hasHeader('Authorization');
    });
});

it('can retrieve movies from TMDB', function () {

    Http::fake([
        '*' => Http::response([
            'results' => [
                [
                    'id' => 1,
                    'title' => 'Movie One',
                ],
                [
                    'id' => 2,
                    'title' => 'Movie Two',
                ],
            ],
        ], 200),
    ]);

    $service = new TmdbService();
    $response = $service->getMovies();

    expect($response['results'])->toHaveCount(2);
});