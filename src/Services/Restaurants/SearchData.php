<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractDataTransferObject;
use App\Services\Restaurants\Interfaces\SearchDataInterface;
use App\Services\Restaurants\Interfaces\SearchServiceInterface;

class SearchData extends AbstractDataTransferObject implements SearchDataInterface
{
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
     * @return int
     */
    public function getRadius(): int
    {
        return (int)$this->get('radius', SearchServiceInterface::DEFAULT_RADIUS);
    }

    /**
     * Initiate attributes.
     *
     * @return array
     */
    protected function initAttributes(): array
    {
        return [
            'latitude',
            'limit',
            'longitude',
            'open_now',
            'query',
            'radius'
        ];
    }
}
