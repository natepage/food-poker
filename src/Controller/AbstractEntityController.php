<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Repositories\Interfaces\RepositoryFactoryInterface;
use App\Services\Repositories\Interfaces\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractEntityController extends Controller
{
    /**
     * @var \App\Services\Repositories\Interfaces\RepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * AbstractEntityController constructor.
     *
     * @param \App\Services\Repositories\Interfaces\RepositoryFactoryInterface $repositoryFactory
     */
    public function __construct(RepositoryFactoryInterface $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * Get entity class.
     *
     * @return string
     */
    abstract protected function getEntity(): string;

    /**
     * Get repository.
     *
     * @return \App\Services\Repositories\Interfaces\RepositoryInterface
     *
     * @throws \App\Services\Repositories\Exceptions\InvalidEntityException
     * @throws \App\Services\Repositories\Exceptions\UnableCreateRepositoryException
     */
    protected function getRepository(): RepositoryInterface
    {
        return $this->repositoryFactory->create($this->getEntity());
    }
}
