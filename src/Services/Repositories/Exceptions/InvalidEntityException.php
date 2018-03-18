<?php
declare(strict_types=1);

namespace App\Services\Repositories\Exceptions;

class InvalidEntityException extends AbstractRepositoriesException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'repository.invalid_entity';
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
