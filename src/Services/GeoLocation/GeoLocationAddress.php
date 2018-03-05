<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;

class GeoLocationAddress implements GeoLocationAddressInterface
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * GeoLocationAddress constructor.
     *
     * @param string $address
     * @param string $latitude
     * @param string $longitude
     */
    public function __construct(string $address, string $latitude, string $longitude)
    {
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
