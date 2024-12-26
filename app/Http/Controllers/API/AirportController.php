<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AirportController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'city_id' => ['required', 'exists:city,id'],
        ]);

        Airport::query()
            ->create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Аэропорт успешно добавлен.'
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
            'city_id' => ['exists:city,id']
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
