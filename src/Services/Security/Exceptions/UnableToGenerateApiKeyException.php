<?php
declare(strict_types=1);

namespace App\Services\Security\Exceptions;

class UnableToGenerateApiKeyException extends AbstractSecurityException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'generator.unable_generate_api_key';
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
