<?php

namespace App\Console\Commands;

use App\Client\DadataClient;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class TestCommand extends Command
{
    protected $signature = 'test:t';

    public function handle()
    {
    }

    private function getRandomImage(): string
    {
//        $allFilesInImagesDirectory = array_map(
//            callback: static function (string $file) {
//                if (!pathinfo($file, PATHINFO_EXTENSION)) return null;
//                return sprintf('%s/%s', 'images', $file);
//            },
//            array: scandir(public_path('images'))
//        );
//
//        return array_values(
//            array: array_filter($allFilesInImagesDirectory)
//        )[mt_rand(0, count($allFilesInImagesDirectory) - 1)];
    }
}
