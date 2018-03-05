<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Interfaces;

interface GeoLocationAddressInterface
{
    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress(): string;

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude(): string;

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude(): string;
}
