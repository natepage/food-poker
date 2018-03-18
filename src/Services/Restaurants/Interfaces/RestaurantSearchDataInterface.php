<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

use App\Helpers\Interfaces\DataTransferObjectHelperInterface;

interface RestaurantSearchDataInterface extends DataTransferObjectHelperInterface
{
    /**
     * Get latitude.
     *
     * @return null|string
     */
    public function getLatitude(): ?string;

    /**
     * Get limit.
     *
     * @return int|null
     */
    public function getLimit(): ?int;

    /**
     * Get longitude.
     *
     * @return null|string
     */
    public function getLongitude(): ?string;

    /**
     * Get open now.
     *
     * @return bool|null
     */
    public function getOpenNow(): ?bool;

    /**
     * Get query.
     *
     * @return null|string
     */
    public function getQuery(): ?string;

    /**
     * Get radius.
     *
     * @return null|int|string
     */
    public function getRadius();
}
