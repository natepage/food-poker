<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Exceptions;

class RequestException extends AbstractGeoLocationException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'request.exception';
    }

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initSubCode(): ?int
    {
        return 3;
    }
}
