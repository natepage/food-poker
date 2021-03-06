<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Exceptions;

class NoResultsException extends AbstractGeoLocationException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'response.no_results';
    }

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initSubCode(): ?int
    {
        return 2;
    }
}
