<?php
declare(strict_types=1);

namespace App\Interfaces;

interface ValidationFailedExceptionInterface extends ExceptionInterface
{
    /**
     * Add validation error.
     *
     * @param string $key
     * @param string $message
     *
     * @return \App\Interfaces\ValidationFailedExceptionInterface
     */
    public function addError(string $key, string $message): self;

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * Set validation errors.
     *
     * @param array $errors
     *
     * @return \App\Interfaces\ValidationFailedExceptionInterface
     */
    public function setErrors(array $errors): self;
}
