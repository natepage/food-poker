<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

use App\Helpers\Interfaces\RepositoryHelperInterface;

interface RestaurantResultInterface extends RepositoryHelperInterface
{
    /**
     * Get restaurant vicinity.
     *
     * @return null|string
     */
    public function getVicinity(): ?string;

    /**
     * Get restaurant name.
     *
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * Get restaurant place id.
     *
     * @return null|string
     */
    public function getPlaceId(): ?string;

    /**
     * Get restaurant price level.
     *
     * @return null|string
     */
    public function getPriceLevel(): ?string;

    /**
     * Get restaurant rating.
     *
     * @return null|string
     */
    public function getRating(): ?string;
}
