<?php

namespace App\Http\Controllers\API;

use App\Client\DadataClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final readonly class GeoController
{
    public function __invoke(Request $request): JsonResponse
    {
        $dadataClient = new DadataClient(config('services.dadata.api_key'));
        try {
            return response()->json([
                'city' => $dadataClient->getLocation($request->ip()),
            ]);
        } catch (ConnectionException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
