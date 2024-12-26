<?php

namespace Database\Seeders;

use App\Models\City;
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
        User::create([
            'fio' => fake()->name(),
            'birthday' => fake()->date(),
            'passport' => mt_rand(2200000000, 9999999999),
            'login' => fake()->userName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'password' => Hash::make('airlines'),
        ]);

        City::factory(10)->create();
    }
}
