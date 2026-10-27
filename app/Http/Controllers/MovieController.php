<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\JsonResponse;
use App\Services\PoolService;

class MovieController extends Controller
{
    public function testTmdb(TmdbService $tmdb): JsonResponse
    {
        return response()->json(
            $tmdb->testConnection()
        );
    }

    public function initialPool(PoolService $pool): JsonResponse
    {
        return response()->json(
            $pool->getInitialMoviesPool()
        );
    }
}