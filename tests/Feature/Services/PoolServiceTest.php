<?php

use App\Services\PoolService;
use App\Services\TmdbService;

it('returns 10 movies for the initial pool', function () {

    $movies = collect(range(1, 15))->map(function ($id) {
        return [
            'id' => $id,
            'title' => "Movie {$id}",
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