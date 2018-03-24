<?php
declare(strict_types=1);

namespace App\Exceptions\Security;

class UnauthorisedException extends AbstractSecurityException
{
    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    protected function initMessage(): ?string
    {
        return 'unauthorised';
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
