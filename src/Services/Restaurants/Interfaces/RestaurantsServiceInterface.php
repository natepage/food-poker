<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

interface RestaurantsServiceInterface
{
    public const DEFAULT_RADIUS = 500;

    public const MAX_RADIUS = 50000;

    /**
     * Search restaurants for given data.
     *
     * @param \App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface $data
     *
     * @return \App\Services\Restaurants\Interfaces\RestaurantResultsCollectionInterface
     */
    public function search(RestaurantSearchDataInterface $data): RestaurantResultsCollectionInterface;
}
