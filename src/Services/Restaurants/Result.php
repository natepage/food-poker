<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractDataTransferObject;
use App\Services\Restaurants\Interfaces\ResultInterface;

class Result extends AbstractDataTransferObject implements ResultInterface
{
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

    /**
     * Check if result is in radius.
     *
     * @return bool
     */
    public function isInRadius(): bool
    {
        return (bool)$this->get('in_radius');
    }

    /**
     * Initiate attributes.
     *
     * @return array
     */
    protected function initAttributes(): array
    {
        return [
            'distance_text',
            'distance_value',
            'duration_text',
            'duration_value',
            'in_radius',
            'name',
            'place_id',
            'price_level',
            'rating'
        ];
    }
}
