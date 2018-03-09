<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Exceptions;

use App\Exceptions\AbstractServiceException;
use App\Services\GeoLocation\Interfaces\GeoLocationExceptionInterface;

abstract class AbstractGeoLocationException extends AbstractServiceException implements GeoLocationExceptionInterface
{
    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1000;
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    protected function initServiceName(): string
    {
        return 'GeoLocation';
    }
}
