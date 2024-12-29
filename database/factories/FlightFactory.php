<?php

namespace Database\Factories;

use App\Models\Airport;
use App\Models\Plane;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'departure_airport_id' => Airport::query()->inRandomOrder()->first()->id,
            'arrival_airport_id' => Airport::query()->inRandomOrder()->first()->id,
            'departure_time' => fake()->dateTimeBetween('-20 days'),
            'arrival_time' => fake()->dateTimeBetween('-20 days'),
            'status' => fake()->randomElement(['Готов', 'В полете', 'Прибыл', 'ТО']),
            'plane_id' => Plane::query()->inRandomOrder()->first()->id,
            'additional_price' => mt_rand(10000, 50000)
        ];
    }
}
