<?php
declare(strict_types=1);

namespace App\Interfaces;

interface EntityInterface
{
    /**
     * Fill up entity with given data.
     *
     * @param array $data
     *
     * @return \App\Interfaces\EntityInterface
     */
    public function fill(array $data): self;

    /**
     * Get not found exception class.
     *
     * @return string
     */
    public function getNotFoundException(): string;

    /**
     * Get validation failed exception class.
     *
     * @return string
     */
    public function getValidationFailedException(): string;
}
