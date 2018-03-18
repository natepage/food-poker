<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database\Entities\User;
use App\Services\Security\Interfaces\GeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users", name="users.")
 */
class UsersController extends AbstractEntityController
{
    /**
     * @Route("", name="create", methods={"POST"})
     *
     * Create user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     *
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     */
    public function store(Request $request): array
    {
        /** @var User $user */
        $user = $this->getRepository()->create($request->request->all());

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
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \LogicException
     * @throws \App\Interfaces\NotFoundExceptionInterface
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    public function update(Request $request): array
    {
        /** @var User $user */
        $user = $this->getRepository()->update($this->getUser()->getId(), $request->request->all());

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'api_key' => $user->getApiKey()
        ];
    }

    /**
     * Get entity class.
     *
     * @return string
     */
    protected function getEntity(): string
    {
        return User::class;
    }
}
