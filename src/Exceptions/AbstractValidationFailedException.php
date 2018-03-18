<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Interfaces\ValidationFailedExceptionInterface;

abstract class AbstractValidationFailedException extends AbstractException implements ValidationFailedExceptionInterface
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Add validation error.
     *
     * @param string $key
     * @param string $message
     *
     * @return \App\Exceptions\AbstractValidationFailedException
     */
    public function addError(string $key, string $message): ValidationFailedExceptionInterface
    {
        $this->errors[$key] = $message;

        return $this;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Set validation errors.
     *
     * @param array $errors
     *
     * @return \App\Exceptions\AbstractValidationFailedException
     */
    public function setErrors(array $errors): ValidationFailedExceptionInterface
    {
        $this->errors = $errors;

        return $this;
    }
}
