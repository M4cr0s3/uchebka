<?php

namespace App\Http\Controllers\API\Flight;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlightController extends Controller
{
    public function index(): JsonResponse
    {
        $flights = Flight::with('departureAirport', 'arrivalAirport', 'plane')->get();

        return response()->json($flights);
    }

    public function search(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'departure_city_id' => ['required', 'exists:cities,id', 'different:arrival_city_id'],
            'arrival_city_id' => ['required', 'exists:cities,id', 'different:departure_city_id'],
            'arrival_date' => ['required', 'date'],
        ]);

        $flights = Flight::query()
            ->with(['departureAirport.city', 'arrivalAirport.city', 'plane'])
            ->whereHas('departureAirport', function ($query) use ($validatedData) {
                $query->where('city_id', $validatedData['departure_city_id']);
            })
            ->whereHas('arrivalAirport', function ($query) use ($validatedData) {
                $query->where('city_id', $validatedData['arrival_city_id']);
            })
            ->get();

        return response()->json([
            'success' => true,
            'flights' => $flights,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'departure_airport_id' => ['required', 'exists:airports,id'],
            'arrival_airport_id' => ['required', 'exists:airports,id'],
            'departure_time' => ['required', 'before:' . Carbon::now()->format('Y-m-d H:i:s')],
            'arrival_time' => ['required', 'after:departure_time'],
            'additional_price' => ['required', 'decimal:0'],
            'plane_id' => ['required', 'exists:planes,id'],
            'status' => [Rule::in(['Готов', 'Прибыл', 'В полете', 'ТО'])],
        ]);

        Flight::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Рейс успешно создан.',
        ]);
    }

    public function show(Flight $flight): JsonResponse
    {
        $flight->load(['departureAirport.city', 'arrivalAirport.city', 'plane.seats']);

        return response()->json([
            'success' => true,
            'flight' => $flight,
        ]);
    }

    public function update(Request $request, Flight $flight): JsonResponse
    {
        $validatedData = $request->validate([
            'departure_airport_id' => ['nullable', 'exists:airports,id', 'different:arrival_airport_id'],
            'arrival_airport_id' => ['nullable', 'exists:airports,id', 'different:departure_airport_id'],
            'departure_time' => ['date', 'before:' . Carbon::now()->format('Y-m-d H:i:s')],
            'arrival_time' => ['date', 'after:departure_time'],
            'additional_price' => ['decimal:0'],
            'plane_id' => ['exists:planes,id'],
            'status' => [Rule::in(['Готов', 'Прибыл', 'В полете', 'ТО'])],
        ]);

        $flight->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Рейс успешно обновлен.',
        ]);
    }

    public function destroy(Flight $flight): JsonResponse
    {
        $flight->delete();

        return response()->json([
            'success' => true,
            'message' => 'Рейс успешно удален.',
        ]);
    }
}
