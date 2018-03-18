<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database\Entities\User;
use App\Services\Security\Interfaces\GeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users", name="users.")
 */
class UsersController extends AbstractController
{
    /**
     * @var \App\Services\Security\Interfaces\GeneratorInterface
     */
    private $generator;

    /**
     * UsersController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Services\Security\Interfaces\GeneratorInterface $generator
     */
    public function __construct(EntityManagerInterface $entityManager, GeneratorInterface $generator) {
        parent::__construct($entityManager);

        $this->generator = $generator;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     *
     * Create user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function store(Request $request): array
    {
        $user = new User($request->request->all());
        $user
            ->setSalt($this->generator->generateSalt())
            ->setApiKey($this->generator->generateApiKey($user));

        $this->saveEntity($user);

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'api_key' => $user->getApiKey()
        ];
    }

    /**
     * @Route("", name="update", methods={"PUT"})
     *
     * Update current user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     *
     * @throws \LogicException
     */
    public function update(Request $request): array
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->fill($request->request->all());

        $this->saveEntity($user);

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'api_key' => $user->getApiKey()
        ];
    }
}
