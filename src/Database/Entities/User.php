<?php
declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Exceptions\NotFound\UserNotFoundException;
use App\Database\Exceptions\ValidationFailed\UserValidationFailedException;
use App\Services\Security\Interfaces\ApiUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"})
 *
 * @ORM\Entity()
 */
class User extends AbstractEntity implements ApiUserInterface
{
    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="api_key", type="string")
     *
     * @var string
     */
    private $apiKey;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @ORM\Column(name="email", type="string")
     *
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="password", type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @Assert\NotNull()
     *
     * @ORM\Column(name="roles", type="array")
     *
     * @var array
     */
    private $roles;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="salt", type="string")
     *
     * @var string
     */
    private $salt;

    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $userId;

    /**
     * User constructor.
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $this->roles = [];

        parent::__construct($data);
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        // Inherited from Symfony interface
    }

    /**
     * Get api key.
     *
     * @return null|string
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * Get email.
     *
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Get id.
     *
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->userId;
    }

    /**
     * Get not found exception class.
     *
     * @return string
     */
    public function getNotFoundException(): string
    {
        return UserNotFoundException::class;
    }

    /**
     * Get password.
     *
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array The user roles
     */
    public function getRoles(): array
    {
        return !empty($this->roles) ? $this->roles : ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Get validation failed exception class.
     *
     * @return string
     */
    public function getValidationFailedException(): string
    {
        return UserValidationFailedException::class;
    }

    /**
     * Set api key.
     *
     * @param string $apiKey
     *
     * @return User
     */
    public function setApiKey(string $apiKey): User
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set roles.
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt(string $salt): User
    {
        $this->salt = $salt;

        return $this;
    }
}
