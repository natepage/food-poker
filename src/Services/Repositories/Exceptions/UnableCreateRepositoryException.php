<?php
declare(strict_types=1);

namespace App\Services\Repositories\Exceptions;

class UnableCreateRepositoryException extends AbstractRepositoriesException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'factory.unable_create_repository';
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
