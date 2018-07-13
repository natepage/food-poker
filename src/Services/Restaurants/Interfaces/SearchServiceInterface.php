<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

interface SearchServiceInterface
{
    /**
     * Default radius.
     *
     * @var int
     */
    public const DEFAULT_RADIUS = 500;

    /**
     * Max radius.
     *
     * @var int
     */
    public const MAX_RADIUS = 50000;

    /**
     * Search restaurants for given data.
     *
     * @param \App\Services\Restaurants\Interfaces\SearchDataInterface $data
     *
     * @return \App\Services\Restaurants\Interfaces\ResultsCollectionInterface
     *
     * @throws \App\Services\Restaurants\Exceptions\RequestException
     * @throws \App\Services\Restaurants\Exceptions\NoResultsException
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     */
    public function search(SearchDataInterface $data): ResultsCollectionInterface;
}
