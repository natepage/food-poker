<?php
declare(strict_types=1);

namespace App\Controller\Games;

use App\Exceptions\Games\NoLocationProvidedException;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use App\Services\Restaurants\Interfaces\RestaurantsServiceInterface;
use App\Services\Restaurants\RestaurantSearchData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RouletteController extends Controller
{
    /**
     * @var \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface
     */
    private $geoLocation;

    /**
     * @var \App\Services\Restaurants\Interfaces\RestaurantsServiceInterface
     */
    private $restaurants;

    /**
     * RouletteController constructor.
     *
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geoLocation
     * @param \App\Services\Restaurants\Interfaces\RestaurantsServiceInterface $restaurants
     */
    public function __construct(GeoLocationServiceInterface $geoLocation, RestaurantsServiceInterface $restaurants)
    {
        $this->geoLocation = $geoLocation;
        $this->restaurants = $restaurants;
    }

    /**
     * @Route("/api/games/roulette", name="api.games.roulette", methods={"GET", "POST"})
     *
     * Play restaurants roulette.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     *
     * @throws \App\Exceptions\Games\NoLocationProvidedException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     * @throws \App\Services\Restaurants\Exceptions\InvalidLocationException
     * @throws \App\Services\Restaurants\Exceptions\InvalidRadiusException
     * @throws \App\Services\Restaurants\Exceptions\NoResultsException
     * @throws \App\Services\Restaurants\Exceptions\RequestException
     */
    public function play(Request $request): array
    {
        $geoAddress = $this->getGeoLocationAddress($request);

        $restaurant = $this->restaurants->search(new RestaurantSearchData([
            'latitude' => $geoAddress->getLatitude(),
            'longitude' => $geoAddress->getLongitude(),
            'radius' => $request->get('radius'),
            'query' => $request->get('query')
        ]))->random()->first();

        return $restaurant->toArray();
    }

    /**
     * Get geolocation address for given address.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface
     *
     * @throws \App\Exceptions\Games\NoLocationProvidedException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     */
    private function getGeoLocationAddress(Request $request): GeoLocationAddressInterface
    {
        $address = $request->get('address');

        if (!empty($address)) {
            return $this->geoLocation->byAddress($address);
        }

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        if (!empty($latitude) && !empty($longitude)) {
            return $this->geoLocation->byCoordinates($latitude, $longitude);
        }

        throw new NoLocationProvidedException();
    }
}
