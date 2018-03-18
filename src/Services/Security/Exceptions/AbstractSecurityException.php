<?php
declare(strict_types=1);

namespace App\Services\Security\Exceptions;

use App\Exceptions\AbstractServiceException;
use App\Services\Security\Interfaces\SecurityExceptionInterface;

abstract class AbstractSecurityException extends AbstractServiceException implements SecurityExceptionInterface
{
    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1003;
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    protected function initServiceName(): string
    {
        return 'Security';
    }
}
