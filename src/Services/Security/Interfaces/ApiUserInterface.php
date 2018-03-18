<?php
declare(strict_types=1);

namespace App\Services\Security\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

interface ApiUserInterface extends UserInterface
{
    /**
     * Get user's api key.
     *
     * @return string
     */
    public function getApiKey(): ?string;

    /**
     * Get user's email address.
     *
     * @return null|string
     */
    public function getEmail(): ?string;
}
