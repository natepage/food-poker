<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TestsController extends Controller
{
    /**
     * @var \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface
     */
    private $geolocation;

    /**
     * TestsController constructor.
     *
     * @param \App\Services\GeoLocation\Interfaces\GeoLocationServiceInterface $geolocation
     */
    public function __construct(GeoLocationServiceInterface $geolocation)
    {
        $this->geolocation = $geolocation;
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

        $dateTime = new \DateTime();
        $array = [$dateTime];

        \var_dump(\in_array($dateTime, $array, true));

        return $this->json($address->toArray());
    }
}
