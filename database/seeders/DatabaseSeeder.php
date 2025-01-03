<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\City;
use App\Models\Flight;
use App\Models\Plane;
use App\Models\Seat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        for ($i = 0; $i < 25; $i++) {
            User::create([
                'fio' => fake()->name(),
                'birthday' => fake()->date(),
                'passport' => mt_rand(2200000000, 9999999999),
                'login' => fake()->userName(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->email(),
                'password' => Hash::make('airlines'),
            ]);
        }

        //        City::factory(30)->create();
        //        Airport::factory(20)->create();
        //        Plane::factory(10)->create();
        //
        //        $planes = Plane::query()->get();
        //
        //        $planes->each(static function (Plane $plane) {
        //            for ($i = 0; $i < $plane->capacity; $i++) {
        //                Seat::create([
        //                    'plane_id' => $plane->id,
        //                    'seat_number' => mt_rand(1, $plane->capacity),
        //                    'class' => fake()->randomElement(['Эконом', 'Бизнес', 'Первый'])
        //                ]);
        //            }
        //        });
//        Flight::factory(20)->create();
    }
}
