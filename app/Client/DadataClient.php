<?php

namespace App\Client;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final readonly class DadataClient
{
    private const string URL = 'http://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address';

    public function __construct(
        private string $token,
    ) {}

    /**
     * @throws ConnectionException
     */
    public function getLocation(string $ip): ?string
    {
        $response = Http::withHeader(
            'Authorization',
            sprintf('Token %s', $this->token),
        )->post(self::URL, [
            'ip' => $ip,
        ]);

        if ($response->failed()) {
            return null;
        }

        $location = $response['location'];

        return explode('г ', $location['value'])[1];
    }
}
