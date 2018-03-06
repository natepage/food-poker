<?php
declare(strict_types=1);

namespace App\Services\GeoLocation;

use App\Database\Entities\GeoLocation\Address;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseGeoLocationService implements GeoLocationServiceInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var GeoLocationServiceInterface
     */
    private $geoLocation;

    /**
     * @var \Cocur\Slugify\SlugifyInterface
     */
    private $slugify;

    /**
     * DatabaseGeoLocationService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geoLocationService
     * @param \Cocur\Slugify\SlugifyInterface $slugify
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        GeoLocationServiceInterface $geoLocationService,
        SlugifyInterface $slugify
    ) {
        $this->entityManager = $entityManager;
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
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     */
    public function byAddress(string $address): GeoLocationAddressInterface
    {
        $slug = $this->slugify->slugify($address);
        $cached = $this->findCached(\compact('slug'));

        if (null !== $cached) {
            return $this->toGeoLocationAddress($cached);
        }

        $geolocationAddress = $this->geoLocation->byAddress($address);

        $this->cache($slug, $geolocationAddress);

        return $geolocationAddress;
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
        $cached = $this->findCached(\compact('latitude', 'longitude'));

        if (null !== $cached) {
            return $this->toGeoLocationAddress($cached);
        }

        $geolocationAddress = $this->geoLocation->byCoordinates($latitude, $longitude);

        $this->cache($this->slugify->slugify($geolocationAddress->getAddress()), $geolocationAddress);

        return $geolocationAddress;
    }

    /**
     * Cache geolocation address in database.
     *
     * @param string $slug
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface $geoLocationAddress
     *
     * @return void
     */
    private function cache(string $slug, GeoLocationAddressInterface $geoLocationAddress): void
    {
        $this->entityManager->persist((new Address())
            ->setSlug($slug)
            ->setFormattedAddress($geoLocationAddress->getAddress())
            ->setLatitude($geoLocationAddress->getLatitude())
            ->setLongitude($geoLocationAddress->getLongitude())
        );
        $this->entityManager->flush();
    }

    /**
     * Find cached address for given parameters.
     *
     * @param array $parameters
     *
     * @return \App\Database\Entities\GeoLocation\Address|null
     */
    private function findCached(array $parameters): ?Address
    {
        return $this->entityManager->getRepository(Address::class)->findOneBy($parameters);
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
