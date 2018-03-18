<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractDataTransferObject;
use App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface;

class RestaurantSearchData extends AbstractDataTransferObject implements RestaurantSearchDataInterface
{
    /**
     * RestaurantSearchData constructor.
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $this->attributes = [
            'latitude',
            'limit',
            'longitude',
            'open_now',
            'query',
            'radius'
        ];

        parent::__construct($data);
    }

    /**
     * Get latitude.
     *
     * @return null|string
     */
    public function getLatitude(): ?string
    {
        return $this->get('latitude');
    }

    /**
     * Get limit.
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->get('limit');
    }

    /**
     * Get longitude.
     *
     * @return null|string
     */
    public function getLongitude(): ?string
    {
        return $this->get('longitude');
    }

    /**
     * Get open now.
     *
     * @return bool|null
     */
    public function getOpenNow(): ?bool
    {
        return $this->get('open_now');
    }

    /**
     * Get query.
     *
     * @return null|string
     */
    public function getQuery(): ?string
    {
        return $this->get('query');
    }

    /**
     * Get radius.
     *
     * @return null|int|string
     */
    public function getRadius()
    {
        return $this->get('radius');
    }
}
