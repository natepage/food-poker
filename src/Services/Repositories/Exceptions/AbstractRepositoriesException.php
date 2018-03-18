<?php
declare(strict_types=1);

namespace App\Services\Repositories\Exceptions;

use App\Exceptions\AbstractServiceException;

abstract class AbstractRepositoriesException extends AbstractServiceException
{
    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1004;
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    protected function initServiceName(): string
    {
        return 'Repositories';
    }
}
