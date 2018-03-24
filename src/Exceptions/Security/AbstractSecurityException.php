<?php
declare(strict_types=1);

namespace App\Exceptions\Security;

use App\Exceptions\AbstractException;

abstract class AbstractSecurityException extends AbstractException
{
    /**
     * AbstractGamesException constructor.
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
        parent::__construct(
            $extendedMessage,
            $transParams,
            $previous,
            $transDomain ?? 'Security',
            $statusCode,
            $headers
        );
    }

    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    protected function initCode(): ?int
    {
        return 1400;
    }
}
