<?php
declare(strict_types=1);

namespace App\Services\Http;

use App\Services\Http\Exceptions\RequestException;
use App\Services\Http\Interfaces\ClientInterface;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use function GuzzleHttp\Psr7\str;

class Client implements ClientInterface
{
    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * Client constructor.
     *
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(?Guzzle $client = null)
    {
        $this->guzzle = $client ?? new Guzzle();
    }

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
    public function request(string $method, string $url, ?array $parameters = null): array
    {
        try {
            $response = $this->guzzle->request($method, $url, $parameters);

            return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleRequestException | \RuntimeException $exception) {
            $message = null;

            if (null !== $exception->getResponse()) {
                $message = str($exception->getResponse());
            }

            throw new RequestException(\sprintf('Request error: %s', $message ?? $exception->getMessage()));
        }
    }
}
