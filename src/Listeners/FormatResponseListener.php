<?php
declare(strict_types=1);

namespace App\Listeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class FormatResponseListener
{
    /**
     * Convert controller result to JSON response.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
     *
     * @return void
     */
    public function onKernelView(GetResponseForControllerResultEvent $event): void
    {
        $event->setResponse(new JsonResponse((array) $event->getControllerResult()));
    }
}
