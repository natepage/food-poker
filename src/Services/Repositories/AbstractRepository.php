<?php
declare(strict_types=1);

namespace App\Services\Repositories;

use App\Database\Entities\GeoLocation\Address;
use App\Interfaces\EntityInterface;
use App\Services\Repositories\Exceptions\InvalidEntityException;
use App\Services\Repositories\Interfaces\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * AbstractRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set entity class.
     *
     * @param string $entity
     *
     * @return \App\Services\Repositories\Interfaces\RepositoryInterface
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     */
    public function setEntity(string $entity): RepositoryInterface
    {
        $this->checkEntityInterface($entity);

        $this->entity = $entity;

        return $this;
    }

    /**
     * Check given entity implement entity interface,
     *
     * @param string $entityClass
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     *
     * @return void
     */
    protected function checkEntityInterface(string $entityClass): void
    {
        $entity = new $entityClass();

        if (!$entity instanceof EntityInterface) {
            throw new InvalidEntityException(\sprintf(
                'Entity %s must implement %s',
                $entity,
                EntityInterface::class
            ));
        }
    }

    /**
     * Get inline string format for given filters.
     *
     * @param array $filters
     *
     * @return string
     */
    protected function formatFiltersForException(array $filters): string
    {
        $inline = [];

        foreach ($filters as $name => $value) {
            $inline[] = \sprintf('%s => %s', $name, $value);
        }

        return \implode(', ', $inline);
    }

    /**
     * Get repository for entity.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->entity);
    }

    /**
     * Returns filled entity instance.
     *
     * @param array $data
     *
     * @return \App\Interfaces\EntityInterface
     */
    protected function instantiateEntity(array $data): EntityInterface
    {
        /** @noinspection PhpUndefinedMethodInspection Entity interface checked when setting it */
        return (new $this->entity())->fill($data);
    }

    /**
     * Remove entity from database.
     *
     * @param \App\Interfaces\EntityInterface $entity
     *
     * @return void
     */
    protected function removeEntity(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Save entity into database.
     *
     * @param \App\Interfaces\EntityInterface $entity
     *
     * @return void
     */
    protected function saveEntity(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
