<?php
declare(strict_types=1);

namespace App\Database\Exceptions\NotFound;

use App\Database\Entities\User;

class UserNotFoundException extends AbstractEntityNotFoundException
{
    /**
     * Get entity name for
     *
     * @return string
     */
    protected function getEntity(): string
    {
        return User::class;
    }

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
