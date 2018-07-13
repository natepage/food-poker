<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

interface RestaurantsServiceInterface
{
    /**
     * Find restaurants for given search and distance data.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return \App\Services\Restaurants\Interfaces\ResultsCollectionInterface
     */
    public function findRestaurants(
        DistanceDataInterface $distanceData,
        SearchDataInterface $searchData
    ): ResultsCollectionInterface;
}
