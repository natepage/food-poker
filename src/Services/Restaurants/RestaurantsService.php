<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Services\Http\Exceptions\RequestException as ClientRequestException;
use App\Services\Http\Interfaces\ClientInterface;
use App\Services\Restaurants\Exceptions\InvalidLocationException;
use App\Services\Restaurants\Exceptions\InvalidRadiusException;
use App\Services\Restaurants\Exceptions\NoResultsException;
use App\Services\Restaurants\Exceptions\RequestException;
use App\Services\Restaurants\Interfaces\RestaurantResultsCollectionInterface;
use App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface;
use App\Services\Restaurants\Interfaces\RestaurantsServiceInterface;

class RestaurantsService implements RestaurantsServiceInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

    /**
     * @var \App\Services\Http\Interfaces\ClientInterface
     */
    private $client;

    /**
     * RestaurantsService constructor.
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
     * Search restaurants for given data.
     *
     * @param \App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface $data
     *
     * @return \App\Services\Restaurants\Interfaces\RestaurantResultsCollectionInterface
     *
     * @throws \App\Services\Restaurants\Exceptions\RequestException
     * @throws \App\Services\Restaurants\Exceptions\NoResultsException
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     */
    public function search(RestaurantSearchDataInterface $data): RestaurantResultsCollectionInterface
    {
        try {
            $results = $this->getResults($data);
        } catch (ClientRequestException $exception) {
            throw new RequestException($exception->getExtendedMessage());
        }

        if (empty($results)) {
            throw new NoResultsException(\sprintf(
                'No results for given query: %s',
                \json_encode($data->toArray())
            ));
        }

        return new RestaurantResultsCollection($results);
    }

    /**
     * Get request data with user-key.
     *
     * @param \App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface $data
     *
     * @return array
     *
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     */
    private function getRequestData(RestaurantSearchDataInterface $data): array
    {
        $radius = $data->getRadius() ?? self::DEFAULT_RADIUS;

        // Validate radius
        if ($radius < 0 || self::MAX_RADIUS < $radius) {
            throw new InvalidRadiusException(\sprintf(
                'Radius must be between 0,%d (%d given)',
                self::MAX_RADIUS,
                $radius
            ));
        }
        // Validate location
        if (null === $data->getLatitude() || null === $data->getLongitude()) {
            throw new InvalidLocationException(\sprintf(
                'Invalid coordinates: [latitude: %s, longitude: %s]',
                $data->getLatitude() ?? 'null',
                $data->getLongitude() ?? 'null'
            ));
        }

        $requestData = [
            'key' => $this->apiKey,
            'location' => \sprintf('%s,%s', $data->getLatitude(), $data->getLongitude()),
            'radius' => $radius,
            'type' => 'restaurant',
            'keyword' => $data->getQuery()
        ];

        if ($data->getOpenNow() ?? false) {
            $requestData['opennow'] = true;
        }

        return ['query' => $requestData];
    }

    /**
     * Get results from Google Places API.
     *
     * @param \App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface $data
     *
     * @return array
     *
     * @throws \App\Services\Http\Exceptions\RequestException
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     */
    private function getResults(RestaurantSearchDataInterface $data): array
    {
        $response = $this->client->request('GET', $this->baseUrl, $this->getRequestData($data));

        return $response['results'] ?? [];
    }
}
