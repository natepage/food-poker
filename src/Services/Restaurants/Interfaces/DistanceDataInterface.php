<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Interfaces;

use App\Helpers\Interfaces\DataTransferObjectHelperInterface;

interface DistanceDataInterface extends DataTransferObjectHelperInterface
{
    /**
     * Get avoid.
     *
     * @return null|array
     */
    public function getAvoid(): ?array;

    /**
     * Get mode.
     *
     * @return string
     */
    public function getMode(): string;

    /**
     * Get units.
     *
     * @return string
     */
    public function getUnits(): string;
}
