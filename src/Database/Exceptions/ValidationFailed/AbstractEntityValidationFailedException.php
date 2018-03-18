<?php
declare(strict_types=1);

namespace App\Database\Exceptions\ValidationFailed;

use App\Exceptions\AbstractValidationFailedException;

abstract class AbstractEntityValidationFailedException extends AbstractValidationFailedException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'entity.validation_failed';
    }

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1100;
    }
}
