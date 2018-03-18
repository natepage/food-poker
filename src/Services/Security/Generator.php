<?php
declare(strict_types=1);

namespace App\Services\Security;

use App\Services\Security\Exceptions\UnableToGenerateApiKeyException;
use App\Services\Security\Interfaces\ApiUserInterface;
use App\Services\Security\Interfaces\GeneratorInterface;

class Generator implements GeneratorInterface
{
    /**
     * Generate random api key based on given user.
     *
     * @param \App\Services\Security\Interfaces\ApiUserInterface $user
     *
     * @return string
     *
     * @throws \App\Services\Security\Exceptions\UnableToGenerateApiKeyException
     */
    public function generateApiKey(ApiUserInterface $user): string
    {
        if (null === $user->getEmail()) {
            throw new UnableToGenerateApiKeyException('User email cannot be null');
        }
        if (null === $user->getSalt()) {
            throw new UnableToGenerateApiKeyException('User salt cannot be null');
        }

        return \hash('md5', \sprintf('%s_%s_%d', $user->getEmail(), $user->getSalt(), \time()));
    }

    /**
     * Generate random salt.
     *
     * @return string
     */
    public function generateSalt(): string
    {
        return \uniqid('', true);
    }
}
