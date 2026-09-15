<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function testTmdb(TmdbService $tmdb): JsonResponse
    {
        return response()->json(
            $tmdb->testConnection()
        );
    }
}