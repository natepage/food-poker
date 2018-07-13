<?php
declare(strict_types=1);

namespace App\Services\Repositories;

use App\Interfaces\EntityInterface;

class DefaultRepository extends AbstractRepository
{
    /**
     * Create entity for given data.
     *
     * @param array $data
     *
     * @return \App\Interfaces\EntityInterface
     */
    public function create(array $data): EntityInterface
    {
        $entity = $this->instantiateEntity($data);

        $this->saveEntity($entity);

        return $entity;
    }

    /**
     * Delete entity for given id.
     *
     * @param string $id
     *
     * @return void
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function delete(string $id): void
    {
        $this->removeEntity($this->find($id));
    }

    /**
     * Find entity for given id.
     *
     * @param string $id
     *
     * @return \App\Interfaces\EntityInterface
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function find(string $id): EntityInterface
    {
        $entity = $this->getRepository()->find($id);

        if (null === $entity) {
            $exceptionClass = $this->instantiateEntity([])->getNotFoundException();

            throw new $exceptionClass(\sprintf('%s for ID %s does not exist', $this->entity, $id));
        }

        /** @var EntityInterface $entity */
        return $entity;
    }

    /**
     * Find entity for given filters.
     *
     * @param array $filters
     *
     * @return \App\Interfaces\EntityInterface
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function findOneBy(array $filters): EntityInterface
    {
        $entity = $this->getRepository()->findOneBy($filters);

        if (null === $entity) {
            $exceptionClass = $this->instantiateEntity([])->getNotFoundException();

            throw new $exceptionClass(\sprintf(
                '%s for filters [%s] does not exist',
                $this->entity,
                $this->formatFiltersForException($filters)
            ));
        }

        /** @var EntityInterface $entity */
        return $entity;
    }

    /**
     * Update entity for given id and data.
     *
     * @param string $id
     * @param array $data
     *
     * @return \App\Interfaces\EntityInterface
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function update(string $id, array $data): EntityInterface
    {
        $entity = $this->find($id)->fill($data);

        $this->saveEntity($entity);

        return $entity;
    }
}
