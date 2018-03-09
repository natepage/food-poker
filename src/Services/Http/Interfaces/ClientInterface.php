<?php
declare(strict_types=1);

namespace App\Services\Http\Interfaces;

interface ClientInterface
{
    /**
     * Send HTTP request and return content of response as an array.
     *
     * @param string $method
     * @param string $url
     * @param array|null $parameters
     *
     * @return array
     *
     * @throws \App\Services\Http\Exceptions\RequestException
     */
    public function request(string $method, string $url, ?array $parameters = null): array;
}
