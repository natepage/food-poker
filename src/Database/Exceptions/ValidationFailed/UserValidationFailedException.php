<?php
declare(strict_types=1);

namespace App\Database\Exceptions\ValidationFailed;

class UserValidationFailedException extends AbstractEntityValidationFailedException
{
    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    protected function initSubCode(): ?int
    {
        return 0;
    }
}
