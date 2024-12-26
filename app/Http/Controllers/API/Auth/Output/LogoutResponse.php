<?php

namespace App\Http\Controllers\API\Auth\Output;


use Illuminate\Http\JsonResponse;

final class LogoutResponse extends JsonResponse
{
    private function __construct(mixed $data, int $status)
    {
        parent::__construct(data: $data, status: $status);
    }

    /**
     * @param array|object $data
     * @param positive-int $status
     * @return JsonResponse
     */

    public static function make(mixed $data, int $status = 200): JsonResponse
    {
        return new self($data, $status);
    }
}
