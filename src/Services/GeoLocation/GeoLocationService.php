<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Services\GeoLocation\Exceptions\InvalidResponseStructureException;
use App\Services\GeoLocation\Exceptions\NoResultsException;
use App\Services\GeoLocation\Exceptions\RequestException;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use App\Services\Http\Interfaces\ClientInterface;
use App\Services\Http\Exceptions\RequestException as ClientRequestException;

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
     * @var \App\Services\Http\Interfaces\ClientInterface
     */
    private $client;

    /**
     * GeoLocationService constructor.
     *
     * @param string $apiKey
     * @param \App\Services\Http\Interfaces\ClientInterface $client
     */
    public function __construct(string $apiKey, ClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
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
                \array_merge(['key' => $this->apiKey], \compact('query'))
            );
        } catch (ClientRequestException $exception) {
            throw new RequestException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $result = $response['results'] ?? [];
        $result = \reset($result);

        if (!$result) {
            throw new NoResultsException(\sprintf('No results for given query: %s', \json_encode($query)));
        }

        if (!$this->responseStructureIsValid($result)) {
            throw new InvalidResponseStructureException(\sprintf(
                'Response structure invalid: %s',
                \json_encode($result)
            ));
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
