<?php
declare(strict_types=1);

namespace App\Database\Exceptions\NotFound\GeoLocation;

use App\Database\Entities\GeoLocation\Address;
use App\Database\Exceptions\NotFound\AbstractEntityNotFoundException;

class AddressNotFoundException extends AbstractEntityNotFoundException
{
    /**
     * Get entity name for
     *
     * @return string
     */
    protected function getEntity(): string
    {
        return Address::class;
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
