<?php
declare(strict_types=1);

namespace App\Controller\Web\Games;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouletteController extends Controller
{
    /**
     * @Route("/games/roulette", name="web.games.roulette", methods={"GET"})
     *
     * Render roulette view.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->render('games/roulette.html.twig');
    }
}
