<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->city(),
            'img' => $this->getRandomImage(),
        ];
    }

    private function getRandomImage(): string
    {
        $allFilesInImagesDirectory = array_map(
            callback: static function (string $file) {
                if (! pathinfo($file, PATHINFO_EXTENSION)) {
                    return null;
                }

                return sprintf('%s/%s', 'images', $file);
            },
            array: scandir(public_path('images'))
        );

        $allFilesInImagesDirectory = array_values(array_filter($allFilesInImagesDirectory));

        return $allFilesInImagesDirectory[mt_rand(0, count($allFilesInImagesDirectory) - 1)];
    }
}
