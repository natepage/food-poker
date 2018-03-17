<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Exceptions;

use App\Exceptions\AbstractServiceException;
use App\Services\Restaurants\Interfaces\RestaurantsExceptionInterface;

abstract class AbstractRestaurantsException extends AbstractServiceException implements RestaurantsExceptionInterface
{
    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1002;
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    protected function initServiceName(): string
    {
        return 'Restaurants';
    }
}
