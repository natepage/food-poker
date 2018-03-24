<?php
declare(strict_types=1);

namespace App\Services\Repositories\Interfaces;

interface RepositoryFactoryInterface
{
    /**
     * Create repository for given entity.
     *
     * @param string $entity
     *
     * @return \App\Services\Repositories\Interfaces\RepositoryInterface
     *
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    public function create(string $entity): RepositoryInterface;
}
