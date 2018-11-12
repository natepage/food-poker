<?php
declare(strict_types=1);

namespace App\Services\Repositories;

use App\Services\Repositories\Exceptions\UnableCreateRepositoryException;
use App\Services\Repositories\Interfaces\RepositoryFactoryInterface;
use App\Services\Repositories\Interfaces\RepositoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $mapping;

    /**
     * @var array
     */
    private $repositories = [];

    /**
     * RepositoryFactory constructor.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param array|null $mapping
     */
    public function __construct(ContainerInterface $container, ?array $mapping = null)
    {
        $this->container = $container;
        $this->mapping = $mapping ?? [];
    }

    /**
     * Create repository for given entity.
     *
     * @param string $entity
     *
     * @return \App\Services\Repositories\Interfaces\RepositoryInterface
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    public function create(string $entity): RepositoryInterface
    {
        if (isset($this->repositories[$entity])) {
            return $this->repositories[$entity];
        }

        $repositoryClass = $this->getRepositoryClass($entity);

        try {
            $repository = $this->container->get($repositoryClass);
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $exception) {
            throw new UnableCreateRepositoryException(\sprintf('ResponsiveContainer.js error: %s', $exception->getMessage()));
        }

        if (!$repository instanceof RepositoryInterface) {
            throw new UnableCreateRepositoryException(\sprintf(
                'Repository %s for entity %s must implement %s',
                $repositoryClass,
                $entity,
                RepositoryInterface::class
            ));
        }

        return $this->repositories[$entity] = $repository->setEntity($entity);
    }

    /**
     * Get repository class for given entity.
     *
     * @param string $entity
     *
     * @return string
     */
    private function getRepositoryClass(string $entity): string
    {
        return $this->mapping[$entity] ?? RepositoryInterface::class;
    }
}
