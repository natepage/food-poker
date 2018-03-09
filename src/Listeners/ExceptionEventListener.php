<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Interfaces\ExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Translation\TranslatorInterface;

class ExceptionEventListener
{
    /**
     * @var string
     */
    private $env;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * ExceptionEventListener constructor.
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param string $env
     */
    public function __construct(TranslatorInterface $translator, string $env)
    {
        $this->env = \strtolower($env);
        $this->translator = $translator;
    }

    /**
     * Convert application exceptions to response.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     *
     * @return void
     *
     * @throws \Symfony\Component\Translation\Exception\InvalidArgumentException
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        if ($exception instanceof ExceptionInterface) {
            $data = [
                'code' => $exception->getCode(),
                'sub_code' => $exception->getSubCode(),
                'message' => $this->translator->trans(
                    $exception->getMessage(),
                    $exception->getTranslationParameters(),
                    $exception->getTranslationDomain()
                )
            ];

            // Extended information
            if ($this->showExtendedInfo()) {
                if (null !== $exception->getExtendedMessage()) {
                    $data['extended_message'] = $exception->getExtendedMessage();
                }

                $data['exception_class'] = \get_class($exception);
            }

            $event->setResponse(new JsonResponse($data, $exception->getStatusCode(), $exception->getHeaders()));
        }
    }

    /**
     * Check if we can show extended information.
     *
     * @return bool
     */
    private function showExtendedInfo(): bool
    {
        return $this->env !== 'prod';
    }
}
