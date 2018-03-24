<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Interfaces\EntityInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events as DoctrineEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidationSubscriber implements EventSubscriber
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * EntityValidationSubscriber constructor.
     *
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            DoctrineEvents::prePersist,
            DoctrineEvents::preUpdate
        ];
    }

    /**
     * Validate entity before persist.
     *
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $eventArgs
     *
     * @throws \App\Interfaces\ValidationFailedExceptionInterface
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        /** @noinspection PhpParamsInspection Inherited from Doctrine */
        $this->validateEntity($eventArgs->getObject());
    }

    /**
     * Validate entity before update.
     *
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $eventArgs
     *
     * @throws \App\Interfaces\ValidationFailedExceptionInterface
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        /** @noinspection PhpParamsInspection Inherited from Doctrine */
        $this->validateEntity($eventArgs->getObject());
    }

    /**
     * Validates given entity and throws exception if errors.
     *
     * @param \App\Interfaces\EntityInterface $entity
     *
     * @throws \App\Interfaces\ValidationFailedExceptionInterface
     */
    private function validateEntity(EntityInterface $entity): void
    {
        $errors = $this->validator->validate($entity);

        if ($errors->count() > 0) {
            $exceptionClass = $entity->getValidationFailedException();
            /** @var \App\Interfaces\ValidationFailedExceptionInterface $exception */
            $exception = new $exceptionClass();

            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolationInterface $error */
                $exception->addError($error->getPropertyPath(), $error->getMessage());
            }

            throw $exception;
        }
    }
}
