<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Database\Entities\GeoLocation\Address;
use App\Interfaces\NotFoundExceptionInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use App\Services\Repositories\Interfaces\RepositoryFactoryInterface;
use Cocur\Slugify\SlugifyInterface;

class DatabaseGeoLocationService implements GeoLocationServiceInterface
{
    /**
     * @var GeoLocationServiceInterface
     */
    private $geoLocation;

    /**
     * @var \App\Services\Repositories\Interfaces\RepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * @var \Cocur\Slugify\SlugifyInterface
     */
    private $slugify;

    /**
     * DatabaseGeoLocationService constructor.
     *
     * @param \App\Services\Repositories\Interfaces\RepositoryFactoryInterface $repositoryFactory
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geoLocationService
     * @param \Cocur\Slugify\SlugifyInterface $slugify
     */
    public function __construct(
        RepositoryFactoryInterface $repositoryFactory,
        GeoLocationServiceInterface $geoLocationService,
        SlugifyInterface $slugify
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->geoLocation = $geoLocationService;
        $this->slugify = $slugify;
    }

    /**
     * Get geolocation address by address.
     *
     * @param string $address
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    public function byAddress(string $address): GeoLocationAddressInterface
    {
        $slug = $this->slugify->slugify($address);
        $cached = $this->findCached(\compact('slug'));

        if (null !== $cached) {
            return $this->toGeoLocationAddress($cached);
        }

        return $this->cache($slug, $this->geoLocation->byAddress($address));
    }

    /**
     * Get geolocation address by coordinates.
     *
     * @param string $latitude
     * @param string $longitude
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    public function byCoordinates(string $latitude, string $longitude): GeoLocationAddressInterface
    {
        $cached = $this->findCached(\compact('latitude', 'longitude'));

        if (null !== $cached) {
            return $this->toGeoLocationAddress($cached);
        }

        $geolocationAddress = $this->geoLocation->byCoordinates($latitude, $longitude);

        return $this->cache($this->slugify->slugify($geolocationAddress->getAddress()), $geolocationAddress);
    }

    /**
     * Cache geolocation address in database.
     *
     * @param string $slug
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface $geoLocationAddress
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    private function cache(string $slug, GeoLocationAddressInterface $geoLocationAddress): GeoLocationAddressInterface
    {
        $this->repositoryFactory->create(Address::class)->create([
            'slug' => $slug,
            'formatted_address' => $geoLocationAddress->getAddress(),
            'latitude' => $geoLocationAddress->getLatitude(),
            'longitude' => $geoLocationAddress->getLongitude()
        ]);

        return $geoLocationAddress;
    }

    /**
     * Find cached address for given parameters.
     *
     * @param array $parameters
     *
     * @return \App\Database\Entities\GeoLocation\Address|null
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    private function findCached(array $parameters): ?Address
    {
        try {
            /** @var Address $address */
            $address = $this->repositoryFactory->create(Address::class)->findOneBy($parameters);
        } catch (NotFoundExceptionInterface $exception) {
            return null;
        }

        return $address;
    }

    /**
     * Get geolocation address for given address.
     *
     * @param \App\Database\Entities\GeoLocation\Address $address
     *
     * @return \App\Services\GeoLocation\GeoLocationAddress
     */
    private function toGeoLocationAddress(Address $address): GeoLocationAddress
    {
        return new GeoLocationAddress(
            $address->getFormattedAddress(),
            $address->getLatitude(),
            $address->getLongitude()
        );
    }
}
