<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Services\GeoLocation\Exceptions\InvalidResponseStructureException;
use App\Services\GeoLocation\Exceptions\NoResultsException;
use App\Services\GeoLocation\Exceptions\RequestException;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use RuntimeException;

class GeoLocationService implements GeoLocationServiceInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * GeoLocationService constructor.
     *
     * @param string $apiKey
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct(string $apiKey, ?Client $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?? new Client();
    }

    /**
     * Get geolocation address by address.
     *
     * @param string $address
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \RuntimeException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    public function byAddress(string $address): GeoLocationAddressInterface
    {
        return $this->request(\compact('address'));
    }

    /**
     * Get geolocation address by coordinates.
     *
     * @param string $latitude
     * @param string $longitude
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \RuntimeException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    public function byCoordinates(string $latitude, string $longitude): GeoLocationAddressInterface
    {
        return $this->request(['latlng' => \sprintf('%s,%s', $latitude, $longitude)]);
    }

    /**
     * Send request to google web service.
     *
     * @param array $query
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \RuntimeException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    private function request(array $query): GeoLocationAddressInterface
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUrl,
                ['query' => \array_merge(['key' => $this->apiKey], $query)]
            );
            $contents = \json_decode($response->getBody()->getContents(), true);
            $result = \reset($contents['results']);
        } catch (GuzzleRequestException$exception) {
            $message = null;

            if (null !== $exception->getResponse()) {
                $message = $exception->getResponse()->getBody()->getContents();
            }

            throw new RequestException(\sprintf('Request error: %s', $message ?? $exception->getMessage()));
        }

        if (!$result) {
            throw new NoResultsException(\sprintf('No results for given query: %s', \json_encode($query)));
        }

        if (!$this->responseStructureIsValid($result)) {
            throw new InvalidResponseStructureException(\sprintf('Response structure invalid: %s',
                \json_encode($result)));
        }

        return new GeoLocationAddress(
            (string) $result['formatted_address'],
            (string) $result['geometry']['location']['lat'],
            (string) $result['geometry']['location']['lng']
        );
    }

    /**
     * Check if response structure is valid.
     *
     * @param array $response
     *
     * @return bool
     */
    private function responseStructureIsValid(array $response): bool
    {
        return isset($response['formatted_address'])
            && isset($response['geometry']['location']['lat'])
            && isset($response['geometry']['location']['lng']);
    }
}
