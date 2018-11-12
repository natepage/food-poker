<?php
declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * Index for new views.
     *
     * @Route("/new-views", name="web.new.views", methods={"GET"})
     *
     * @param string $googleMapApiKey
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(string $googleMapApiKey): Response
    {
        return $this->render('index.html.twig', \compact('googleMapApiKey'));
    }
}