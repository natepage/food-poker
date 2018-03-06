<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationExceptionInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;

class RetryGeoLocationService implements GeoLocationServiceInterface
{
    /**
     * @var GeoLocationServiceInterface
     */
    private $geolocation;

    /**
     * @var int
     */
    private $retries;

    /**
     * RetryGeoLocationService constructor.
     *
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geoLocationService
     * @param int|null $retries
     */
    public function __construct(GeoLocationServiceInterface $geoLocationService, ?int $retries = null)
    {
        $this->geolocation = $geoLocationService;
        $this->retries = $retries ?? 3;
    }

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
    public function byAddress(string $address): GeoLocationAddressInterface
    {
        return $this->callDecoratedWithRetry('byAddress', \compact('address'));
    }

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
    public function byCoordinates(string $latitude, string $longitude): GeoLocationAddressInterface
    {
        return $this->callDecoratedWithRetry('byCoordinates', \compact('latitude', 'longitude'));
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /** @noinspection PhpDocRedundantThrowsInspection */
    /**
     * Call geolocation with given method and parameters and retry if something goes wrong.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    private function callDecoratedWithRetry(string $method, array $parameters): GeoLocationAddressInterface
    {
        $retries = $this->retries;

        do {
            try {
                return \call_user_func_array([$this->geolocation, $method], $parameters);
            } /** @noinspection BadExceptionsProcessingInspection */ catch (GeoLocationExceptionInterface $exception) {
                // Exception will be thrown when we reach 0 retries
                $retries--;
            }
        } while ($retries > 0);

        /** @noinspection PhpUnhandledExceptionInspection Exception coming from decorated implement good interface */
        throw $exception;
    }
}
