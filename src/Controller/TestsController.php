<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use App\Services\Restaurants\Interfaces\RestaurantsServiceInterface;
use App\Services\Restaurants\RestaurantSearchData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{
    /**
     * @var \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface
     */
    private $geolocation;

    /**
     * @var \App\Services\Restaurants\Interfaces\RestaurantsServiceInterface
     */
    private $restaurants;

    /**
     * TestsController constructor.
     *
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geolocation
     * @param \App\Services\Restaurants\Interfaces\RestaurantsServiceInterface $restaurants
     */
    public function __construct(GeoLocationServiceInterface $geolocation, RestaurantsServiceInterface $restaurants)
    {
        $this->geolocation = $geolocation;
        $this->restaurants = $restaurants;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @throws \App\Services\GeoLocation\Exceptions\InvalidResponseStructureException
     * @throws \App\Services\GeoLocation\Exceptions\NoResultsException
     * @throws \App\Services\GeoLocation\Exceptions\RequestException
     */
    public function test(Request $request): JsonResponse
    {
        $address = $this->geolocation->byAddress($request->get('address'));

        $restaurants = $this->restaurants->search(new RestaurantSearchData([
            'latitude' => $address->getLatitude(),
            'longitude' => $address->getLongitude(),
            'radius' => $request->get('radius')
        ]));

        return $this->json($restaurants->random(1)->toArray());
    }
}
