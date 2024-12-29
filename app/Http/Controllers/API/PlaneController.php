<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plane;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Plane::query()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'model' => ['required', 'string'],
            'capacity' => ['required', 'integer'],
        ]);

        $plane = Plane::query()
            ->create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Самолет создан',
            'plane' => $plane,
        ]);
    }

    public function show(Plane $plane): JsonResponse
    {
        return response()->json([
            'success' => true,
            'plane' => $plane,
        ]);
    }

    public function update(Request $request, Plane $plane): JsonResponse
    {
        $validatedData = $request->validate([
            'model' => ['string'],
            'capacity' => ['integer'],
        ]);

        $plane->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Самолет обновлен.',
        ]);
    }

    public function destroy(Plane $plane): JsonResponse
    {
        $plane->delete();

        return response()->json([
            'success' => true,
            'message' => 'Самолет удален.',
        ]);
    }
}
