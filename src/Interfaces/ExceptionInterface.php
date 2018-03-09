<?php
declare(strict_types=1);

namespace App\Interfaces;

interface ExceptionInterface
{
    /**
     * Get extended message for debug purposes.
     *
     * @return null|string
     */
    public function getExtendedMessage(): ?string;

    /**
     * Get HTTP headers.
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Get HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Get sub code.
     *
     * @return int
     */
    public function getSubCode(): int;

    /**
     * Get translation domain.
     *
     * @return string
     */
    public function getTranslationDomain(): string;

    /**
     * Get translation parameters.
     *
     * @return array
     */
    public function getTranslationParameters(): array;
}
