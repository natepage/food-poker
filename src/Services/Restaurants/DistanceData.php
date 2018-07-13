<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractDataTransferObject;
use App\Services\Restaurants\Interfaces\DistanceDataInterface;
use App\Services\Restaurants\Interfaces\DistanceServiceInterface;

class DistanceData extends AbstractDataTransferObject implements DistanceDataInterface
{
    /**
     * Get avoid.
     *
     * @return null|array
     */
    public function getAvoid(): ?array
    {
        return $this->get('avoid') === null ? null : (array)$this->get('avoid');
    }

    /**
     * Get mode.
     *
     * @return string
     */
    public function getMode(): string
    {
        return (string)$this->get('mode', DistanceServiceInterface::MODE_DRIVING);
    }

    /**
     * Get units.
     *
     * @return string
     */
    public function getUnits(): string
    {
        return (string)$this->get('units', DistanceServiceInterface::UNITS_METRIC);
    }

    /**
     * Initiate attributes.
     *
     * @return array
     */
    protected function initAttributes(): array
    {
        return [
            'avoid',
            'mode',
            'units'
        ];
    }
}
