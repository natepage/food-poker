<?php
declare(strict_types=1);

namespace App\Exceptions\Games;

class NoLocationProvidedException extends AbstractGamesException
{
    /**
     * NoLocationProvidedException constructor.
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
            $transDomain,
            $statusCode ?? 400,
            $headers
        );
    }

    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'no_location_provided';
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
