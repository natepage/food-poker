<?php
declare(strict_types=1);

namespace App\Services\Http\Exceptions;

use App\Exceptions\AbstractServiceException;
use App\Services\Http\Interfaces\HttpExceptionInterface;

abstract class AbstractHttpException extends AbstractServiceException implements HttpExceptionInterface
{
    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1001;
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    protected function initServiceName(): string
    {
        return 'Http';
    }
}
