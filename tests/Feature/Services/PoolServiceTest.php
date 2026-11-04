<?php

use App\Services\PoolService;
use App\Services\TmdbService;

it('returns 10 movies for the initial pool', function () {

    $movies = collect(range(1, 15))->map(function ($id) {
        return [
            'id' => $id,
            'title' => "Movie {$id}",
            'poster_path' => "/poster{$id}.jpg",
            'release_date' => '2024-05-10',
            'genre_ids' => [28, 12],
        ];
    })->toArray();

    $tmdb = Mockery::mock(TmdbService::class);

    $tmdb
        ->shouldReceive('getMovies')
        ->once()
        ->andReturn([
            'results' => $movies,
        ]);

    $poolService = new PoolService($tmdb);

    $pool = $poolService->getInitialMoviesPool();

    expect($pool)->toHaveCount(10);
});

it('returns 10 movies shaped for the initial pool', function () {

    $movies = collect(range(1, 15))->map(function ($id) {
        return [
            'id' => $id,
            'title' => "Movie {$id}",
            'poster_path' => "/poster{$id}.jpg",
            'release_date' => '2024-05-10',
            'genre_ids' => [28, 12],

            'overview' => 'Example overview',
            'popularity' => 123.45,
        ];
    })->toArray();

    $tmdb = Mockery::mock(TmdbService::class);

    $tmdb
        ->shouldReceive('getMovies')
        ->once()
        ->andReturn([
            'results' => $movies,
        ]);

    $poolService = new PoolService($tmdb);

    $pool = $poolService->getInitialMoviesPool();

    expect($pool)->toHaveCount(10);

    expect($pool[0])->toBe([
        'id' => 1,
        'title' => 'Movie 1',
        'poster' => '/poster1.jpg',
        'year' => 2024,
        'genre_ids' => [28, 12],
    ]);

});

it('returns one random movie from the initial pool', function () {

    $movies = collect(range(1, 10))->map(function ($id) {
        return [
            'id' => $id,
            'title' => "Movie {$id}",
            'poster_path' => "/poster{$id}.jpg",
            'release_date' => '2024-05-10',
            'genre_ids' => [28, 12],
        ];
    })->toArray();

    $tmdb = Mockery::mock(TmdbService::class);

    $tmdb
        ->shouldReceive('getMovies')
        ->once()
        ->andReturn([
            'results' => $movies,
        ]);

    $poolService = new PoolService($tmdb);

    $movie = $poolService->getRandomMovie();

    expect($movie)->toHaveKeys([
        'id',
        'title',
        'poster',
        'year',
        'genre_ids',
    ]);

    expect($movie['id'])->toBeGreaterThanOrEqual(1)
        ->and($movie['id'])->toBeLessThanOrEqual(10);
});