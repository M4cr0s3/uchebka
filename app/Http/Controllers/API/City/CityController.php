<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\API\City\Output\CityResource;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\UploadedFile;

class CityController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CityResource::collection(City::query()->get());
    }

    public function getMostPopular(): AnonymousResourceCollection
    {
        $cities = City::query()->get();
        return CityResource::collection($cities);
    }


    public function store(Request $request): JsonResponse
    {
        $file = $request->file('image');

        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'image' => ['required', 'image']
        ]);

        $city = new City();

        if ($file) {
            $imagePath = \Storage::disk('public_uploads')->put('/images', $file);
            $city->img = $imagePath;
        }

        $city->title = $validatedData['title'];
        $city->save();

        return response()->json([
            'success' => true,
            'message' => 'Город успешно добавлен.'
        ]);
    }

    public function show(City $city): CityResource
    {
        return new CityResource($city);
    }

    public function update(Request $request, City $city): JsonResponse
    {
        /** @var UploadedFile $file */
        $file = $request->file('image');

        $validatedData = $request->validate([
            'title' => ['string'],
            'image' => ['nullable'],
        ]);

        if ($file && in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'webp', 'svg'], true)) {
            $imagePath = \Storage::disk('public_uploads')->put('/images', $file);
            $city->img = $imagePath;
        }

        $city->title = $validatedData['title'];
        $city->save();

        return response()->json([
            'success' => true,
            'message' => 'Город обновлен успешно.',
        ]);
    }

    public function destroy(City $city): JsonResponse
    {
        $city->delete();

        return response()->json([
            'success' => true,
            'message' => 'Город удален.',
        ]);
    }
}
