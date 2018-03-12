<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractRepository;
use App\Services\Restaurants\Interfaces\RestaurantSearchDataInterface;

class RestaurantSearchData extends AbstractRepository implements RestaurantSearchDataInterface
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
     * Get radius.
     *
     * @return null|int|string
     */
    public function getRadius()
    {
        return $this->get('radius');
    }
}
