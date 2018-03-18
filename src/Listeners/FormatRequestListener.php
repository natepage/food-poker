<?php
declare(strict_types=1);

namespace App\Listeners;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class FormatRequestListener
{
    /**
     * Replace request by associative array from json content.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     *
     * @return void
     *
     * @throws \LogicException
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        $request->request->replace(\json_decode($content, true) ?? []);
    }
}
