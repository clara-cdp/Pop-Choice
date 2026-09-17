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