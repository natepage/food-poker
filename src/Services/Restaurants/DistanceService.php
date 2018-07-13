<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Services\Http\Interfaces\ClientInterface;
use App\Services\Restaurants\Exceptions\InvalidAvoidException;
use App\Services\Restaurants\Exceptions\InvalidModeException;
use App\Services\Restaurants\Interfaces\DistanceDataInterface;
use App\Services\Restaurants\Interfaces\DistanceServiceInterface;
use App\Services\Restaurants\Interfaces\ResultsCollectionInterface;
use App\Services\Restaurants\Interfaces\SearchDataInterface;

class DistanceService implements DistanceServiceInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json';

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
     * Update given results collection to confirm if results are really in radius based on distance matrix.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\ResultsCollectionInterface $resultsCollection
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return \App\Services\Restaurants\Interfaces\ResultsCollectionInterface
     *
     * @throws \App\Services\Http\Exceptions\RequestException
     * @throws \App\Services\Restaurants\Exceptions\InvalidModeException
     * @throws \App\Services\Restaurants\Exceptions\InvalidAvoidException
     */
    public function confirmInRadius(
        DistanceDataInterface $distanceData,
        ResultsCollectionInterface $resultsCollection,
        SearchDataInterface $searchData
    ): ResultsCollectionInterface {
        $results = $this->getResults($this->getRequestData($distanceData, $resultsCollection, $searchData));

        foreach ($results as $key => $distanceResult) {
            if (($distanceResult['status'] ?? null) !== 'OK') {
                continue;
            }

            /** @var \App\Services\Restaurants\Result $result */
            $result = $resultsCollection->offsetGet($key);

            // Set distance
            $result->set('distance_text', $distanceResult['distance']['text'] ?? null);
            $result->set('distance_value', $distanceResult['distance']['value'] ?? null);
            // Set duration
            $result->set('duration_text', $distanceResult['duration']['text'] ?? null);
            $result->set('duration_value', $distanceResult['duration']['value'] ?? null);
            // Set in radius
            $result->set('in_radius', $this->isInRadius($distanceResult, $searchData->getRadius()));
        }

        return $resultsCollection;
    }

    /**
     * Check if distance result is in given radius.
     *
     * @param array $distanceResult
     * @param int $radius
     *
     * @return bool
     */
    private function isInRadius(array $distanceResult, int $radius): bool
    {
        return isset($distanceResult['distance']['value']) && (int)$distanceResult['distance']['value'] <= $radius;
    }

    /**
     * Get request data.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\ResultsCollectionInterface $resultsCollection
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return array
     *
     * @throws \App\Services\Restaurants\Exceptions\InvalidModeException
     * @throws \App\Services\Restaurants\Exceptions\InvalidAvoidException
     */
    private function getRequestData(
        DistanceDataInterface $distanceData,
        ResultsCollectionInterface $resultsCollection,
        SearchDataInterface $searchData
    ): array {
        $query = [
            'origins' => \sprintf('%s,%s', $searchData->getLatitude(), $searchData->getLongitude()),
            'key' => $this->apiKey
        ];

        // Avoids
        if (empty($distanceData->getAvoid()) === false) {
            foreach ($distanceData->getAvoid() as $avoid) {
                if (\in_array($avoid, $this->getValidAvoids(), true)) {
                    continue;
                }

                throw new InvalidAvoidException(\sprintf(
                    'Avoid %s invalid. Valid avoids: %s',
                    $avoid,
                    \implode(',', $this->getValidAvoids())
                ));
            }

            $query['avoid'] = $distanceData->getAvoid();
        }

        // Destinations
        $placeIds = [];
        foreach ($resultsCollection as $result) {
            /** @var \App\Services\Restaurants\Interfaces\ResultInterface $result */
            $placeIds[] = \sprintf('place_id:%s', $result->getPlaceId());
        }
        $query['destinations'] = \implode('|', $placeIds);

        // Mode
        if (\in_array($distanceData->getMode(), $this->getValidModes(), true) === false) {
            throw new InvalidModeException(\sprintf(
                'Mode %s invalid. Valid modes: %s',
                $distanceData->getMode(),
                \implode(', ', $this->getValidModes())
            ));
        }
        $query['mode'] = $distanceData->getMode();

        // Units
        if (\in_array($distanceData->getUnits(), $this->getValidUnits(), true) === false) {
            throw new InvalidModeException(\sprintf(
                'Units %s invalid. Valid modes: %s',
                $distanceData->getUnits(),
                \implode(', ', $this->getValidUnits())
            ));
        }
        $query['units'] = $distanceData->getUnits();

        return ['query' => $query];
    }

    /**
     * Get results from Google Places API.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws \App\Services\Http\Exceptions\RequestException
     */
    private function getResults(array $parameters): array
    {
        $response = $this->client->request('GET', $this->baseUrl, $parameters);

        return $response['rows'][0]['elements'] ?? [];
    }

    /**
     * Get valid avoids.
     *
     * @return array
     */
    private function getValidAvoids(): array
    {
        return [
            self::AVOID_FERRIES,
            self::AVOID_HIGHWAYS,
            self::AVOID_INDOOR,
            self::AVOID_TOLLS
        ];
    }

    /**
     * Get valid modes.
     *
     * @return array
     */
    private function getValidModes(): array
    {
        return [
            self::MODE_DRIVING,
            self::MODE_BICYCLING,
            self::MODE_TRANSIT,
            self::MODE_WALKING
        ];
    }

    /**
     * Get valid units.
     *
     * @return array
     */
    private function getValidUnits(): array
    {
        return [
            self::UNITS_IMPERIAL,
            self::UNITS_METRIC
        ];
    }
}
