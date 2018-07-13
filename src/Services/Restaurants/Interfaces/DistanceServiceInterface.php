<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

interface DistanceServiceInterface
{
    public const AVOID_TOLLS = 'tolls';
    public const AVOID_HIGHWAYS = 'highways';
    public const AVOID_FERRIES = 'ferries';
    public const AVOID_INDOOR = 'indoor';

    public const MODE_DRIVING = 'driving';
    public const MODE_WALKING = 'walking';
    public const MODE_BICYCLING = 'bicycling';
    public const MODE_TRANSIT = 'transit';

    public const UNITS_METRIC = 'metric';
    public const UNITS_IMPERIAL = 'imperial';

    /**
     * Update given results collection to confirm if results are really in radius based on distance matrix.
     *
     * @param \App\Services\Restaurants\Interfaces\DistanceDataInterface $distanceData
     * @param \App\Services\Restaurants\Interfaces\ResultsCollectionInterface $resultsCollection
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $searchData
     *
     * @return \App\Services\Restaurants\Interfaces\ResultsCollectionInterface
     */
    public function confirmInRadius(
        DistanceDataInterface $distanceData,
        ResultsCollectionInterface $resultsCollection,
        SearchDataInterface $searchData
    ): ResultsCollectionInterface;
}
