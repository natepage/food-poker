<?php
declare(strict_types=1);

namespace App\Exceptions;

abstract class AbstractServiceException extends AbstractException
{
    /**
     * AbstractServiceException constructor.
     *
     * @param null|string $extendedMessage
     * @param array|null $transParams
     * @param null|\Throwable $previous
     * @param int|null $statusCode
     * @param array|null $headers
     */
    public function __construct(
        ?string $extendedMessage = null,
        ?array $transParams = null,
        ?\Throwable $previous = null,
        ?int $statusCode = null,
        ?array $headers = null
    ) {
        parent::__construct($extendedMessage, $transParams, $previous, $this->initServiceName(), $statusCode, $headers);
    }

    /**
     * Init exception service name to be used as translation domain.
     *
     * @return string
     */
    abstract protected function initServiceName(): string;
}
