<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Interfaces;

interface GeoLocationServiceInterface
{
    /**
     * Get geolocation address by address.
     *
     * @param string $address
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    public function byAddress(string $address): GeoLocationAddressInterface;

    /**
     * Get geolocation address by coordinates.
     *
     * @param string $latitude
     * @param string $longitude
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    public function byCoordinates(string $latitude, string $longitude): GeoLocationAddressInterface;
}
