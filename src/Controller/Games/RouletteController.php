<?php
declare(strict_types=1);

namespace App\Controller\Games;

use App\Exceptions\Games\NoLocationProvidedException;
use App\Services\GeoLocation\Interfaces\GeoLocationAddressInterface;
use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use App\Services\Restaurants\DistanceData;
use App\Services\Restaurants\Interfaces\DistanceDataInterface;
use App\Services\Restaurants\Interfaces\RestaurantsServiceInterface;
use App\Services\Restaurants\Interfaces\ResultInterface;
use App\Services\Restaurants\Interfaces\SearchDataInterface;
use App\Services\Restaurants\SearchData;
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
     */
    public function play(Request $request): array
    {
        $restaurants = $this->restaurants->findRestaurants(
            $this->getDistanceData($request),
            $this->getSearchData($request)
        );

        return $restaurants->random()->toArray();
    }

    /**
     * Get distance data for given request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Services\Restaurants\Interfaces\DistanceDataInterface
     */
    private function getDistanceData(Request $request): DistanceDataInterface
    {
        return new DistanceData([
            'avoid' => $request->get('avoid'),
            'mode' => $request->get('mode'),
            'units' => $request->get('units')
        ]);
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
        if (empty($request->get('address')) === false) {
            return $this->geoLocation->byAddress((string)$request->get('address'));
        }

        if (empty($request->get('latitude')) === false && empty($request->get('longitude')) === false) {
            return $this->geoLocation->byCoordinates(
                (string)$request->get('latitude'),
                (string)$request->get('longitude')
            );
        }

        throw new NoLocationProvidedException();
    }

    /**
     * Get search data for given request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Services\Restaurants\Interfaces\SearchDataInterface
     *
     * @throws \App\Exceptions\Games\NoLocationProvidedException
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     */
    private function getSearchData(Request $request): SearchDataInterface
    {
        $geoAddress = $this->getGeoLocationAddress($request);

        return new SearchData([
            'latitude' => $geoAddress->getLatitude(),
            'longitude' => $geoAddress->getLongitude(),
            'radius' => $request->get('radius'),
            'query' => $request->get('query')
        ]);
    }
}
