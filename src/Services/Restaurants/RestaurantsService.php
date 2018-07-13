<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Services\Restaurants\Exceptions\NoResultsException;
use App\Services\Restaurants\Interfaces\DistanceDataInterface;
use App\Services\Restaurants\Interfaces\DistanceServiceInterface;
use App\Services\Restaurants\Interfaces\RestaurantsServiceInterface;
use App\Services\Restaurants\Interfaces\ResultInterface;
use App\Services\Restaurants\Interfaces\ResultsCollectionInterface;
use App\Services\Restaurants\Interfaces\SearchDataInterface;
use App\Services\Restaurants\Interfaces\SearchServiceInterface;

class RestaurantsService implements RestaurantsServiceInterface
{
    /**
     * @var \App\Services\Restaurants\Interfaces\DistanceServiceInterface
     */
    private $distanceService;

    /**
     * @var \App\Services\Restaurants\Interfaces\SearchServiceInterface
     */
    private $searchService;

    /**
     * RestaurantsService constructor.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceServiceInterface $distanceService
     * @param \App\Services\Restaurants\Interfaces\SearchServiceInterface $searchService
     */
    public function __construct(DistanceServiceInterface $distanceService, SearchServiceInterface $searchService)
    {
        $this->distanceService = $distanceService;
        $this->searchService = $searchService;
    }

    /**
     * Find restaurants for given search and distance data.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return \App\Services\Restaurants\Interfaces\ResultsCollectionInterface
     *
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     * @throws \App\Services\Restaurants\Exceptions\NoResultsException
     * @throws \App\Services\Restaurants\Exceptions\RequestException
     */
    public function findRestaurants(
        DistanceDataInterface $distanceData,
        SearchDataInterface $searchData
    ): ResultsCollectionInterface {
        $results = $this->searchService->search($searchData);

        if ($results->isEmpty()) {
            throw $this->noResultsException($distanceData, $searchData);
        }

        $results = $this->distanceService
            ->confirmInRadius($distanceData, $results, $searchData)
            ->filter(function (ResultInterface $result): bool {
                return $result->isInRadius();
            });

        if ($results->isEmpty()) {
            throw $this->noResultsException($distanceData, $searchData);
        }

        /** @var ResultsCollectionInterface $results */
        return $results;
    }

    /**
     * Get no results exception.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return \App\Services\Restaurants\Exceptions\NoResultsException
     */
    private function noResultsException(
        DistanceDataInterface $distanceData,
        SearchDataInterface $searchData
    ): NoResultsException {
        return new NoResultsException(\sprintf(
            'No results for given query: %s',
            \json_encode(\array_merge($distanceData->toArray(), $searchData->toArray()))
        ));
    }
}
