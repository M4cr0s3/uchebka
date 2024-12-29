<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Airport::query()->with('city')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'city_id' => ['required', 'exists:cities,id'],
        ]);

        Airport::query()
            ->create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Аэропорт успешно добавлен.',
        ]);
    }

    public function show(Airport $airport): JsonResponse
    {
        return response()->json([
            'success' => true,
            'airport' => $airport,
        ]);
    }

    public function update(Request $request, Airport $airport): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => ['string'],
            'city_id' => ['exists:cities,id'],
        ]);

        $airport->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Город обновлен успешно.',
        ]);
    }

    public function destroy(Airport $airport): JsonResponse
    {
        $airport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Аэропорт удален.',
        ]);
    }
}
