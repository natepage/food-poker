<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Exceptions;

class InvalidRadiusException extends AbstractRestaurantsException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'request.invalid_radius';
    }

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initSubCode(): ?int
    {
        return 4;
    }
}
