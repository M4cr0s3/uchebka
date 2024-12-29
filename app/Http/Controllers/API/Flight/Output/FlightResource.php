<?php

namespace App\Http\Controllers\API\Flight\Output;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'departure_time' => $this->departure_time,
            'arrival_time' => $this->arrival_time,
            'additional_price' => $this->additional_price,
            'status' => $this->status,
            'departure_airport' => $this->whenNotNull($this->departureAirport),
            'plane' => $this->whenNotNull($this->plane),
            'arrival_airport' => $this->whenNotNull($this->arrivalAirport),
        ];
    }
}
