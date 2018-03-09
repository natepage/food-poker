<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionEventListener
{
    /**
     * Convert application exceptions to response.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof BaseException) {
            $event->setResponse(new JsonResponse($exception->toArray()));
        }
    }
}
