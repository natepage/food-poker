<?php
declare(strict_types=1);

namespace App\Database\Exceptions\ValidationFailed\GeoLocation;

use App\Database\Exceptions\ValidationFailed\AbstractEntityValidationFailedException;

class AddressValidationFailedException extends AbstractEntityValidationFailedException
{
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
