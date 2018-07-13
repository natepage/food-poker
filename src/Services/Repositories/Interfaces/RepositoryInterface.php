<?php
declare(strict_types=1);

namespace App\Services\Repositories\Interfaces;

use App\Interfaces\EntityInterface;

interface RepositoryInterface
{
    /**
     * Create entity for given data.
     *
     * @param array $data
     *
     * @return \App\Interfaces\EntityInterface
     */
    public function create(array $data): EntityInterface;

    /**
     * Delete entity for given id.
     *
     * @param string $id
     *
     * @return void
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function delete(string $id): void;

    /**
     * Find entity for given id.
     *
     * @param string $id
     *
     * @return \App\Interfaces\EntityInterface
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function find(string $id): EntityInterface;

    /**
     * Find entity for given filters.
     *
     * @param array $filters
     *
     * @return \App\Interfaces\EntityInterface
     *
     * @throws \App\Interfaces\NotFoundExceptionInterface
     */
    public function findOneBy(array $filters): EntityInterface;

    /**
     * Set entity class.
     *
     * @param string $entity
     *
     * @return \App\Services\Repositories\Interfaces\RepositoryInterface
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     */
    public function setEntity(string $entity): self;

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
    public function update(string $id, array $data): EntityInterface;
}
