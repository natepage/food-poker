<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractRepository;
use App\Services\Restaurants\Interfaces\RestaurantResultInterface;

class RestaurantResult extends AbstractRepository implements RestaurantResultInterface
{
    /**
     * RestaurantResult constructor.
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $this->attributes = [
            'formatted_address',
            'name',
            'place_id',
            'price_level',
            'rating'
        ];
        parent::__construct($data);
    }

    /**
     * Get restaurant formatted address.
     *
     * @return null|string
     */
    public function getFormattedAddress(): ?string
    {
        return $this->get('formatted_address');
    }

    /**
     * Get restaurant name.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    /**
     * Get restaurant place id.
     *
     * @return null|string
     */
    public function getPlaceId(): ?string
    {
        return $this->get('place_id');
    }

    /**
     * Get restaurant price level.
     *
     * @return null|string
     */
    public function getPriceLevel(): ?string
    {
        return $this->get('price_level');
    }

    /**
     * Get restaurant rating.
     *
     * @return null|string
     */
    public function getRating(): ?string
    {
        return $this->get('rating');
    }
}
