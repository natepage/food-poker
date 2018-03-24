<?php
declare(strict_types=1);

namespace App\Database\Exceptions\NotFound;

use App\Exceptions\AbstractException;
use App\Interfaces\NotFoundExceptionInterface;

abstract class AbstractEntityNotFoundException extends AbstractException implements NotFoundExceptionInterface
{
    /**
     * AbstractEntityNotFoundException constructor.
     *
     * @param null|string $extendedMessage
     * @param array|null $transParams
     * @param null|\Throwable $previous
     * @param null|string $transDomain
     * @param int|null $statusCode
     * @param array|null $headers
     */
    public function __construct(
        ?string $extendedMessage = null,
        ?array $transParams = null,
        ?\Throwable $previous = null,
        ?string $transDomain = null,
        ?int $statusCode = null,
        ?array $headers = null
    ) {
        $transParams = \array_merge($transParams ?? [], ['entity' => $this->getEntity()]);

        parent::__construct($extendedMessage, $transParams, $previous, $transDomain, $statusCode, $headers);
    }

    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1200;
    }

    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'entity.not_found';
    }

    /**
     * Get entity name for
     *
     * @return string
     */
    abstract protected function getEntity(): string;
}
