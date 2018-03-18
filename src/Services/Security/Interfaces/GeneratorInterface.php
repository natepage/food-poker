<?php
declare(strict_types=1);

namespace App\Services\Security\Interfaces;

interface GeneratorInterface
{
    /**
     * Generate random api key based on given user.
     *
     * @param \App\Services\Security\Interfaces\ApiUserInterface $user
     *
     * @return string
     */
    public function generateApiKey(ApiUserInterface $user): string;

    /**
     * Generate random salt.
     *
     * @return string
     */
    public function generateSalt(): string;
}
