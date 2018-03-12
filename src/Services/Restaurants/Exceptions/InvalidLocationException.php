<?php
declare(strict_types=1);

namespace App\Services\Restaurants\Exceptions;

class InvalidLocationException extends AbstractRestaurantsException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'request.invalid_location';
    }

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initSubCode(): ?int
    {
        return 1;
    }
}
