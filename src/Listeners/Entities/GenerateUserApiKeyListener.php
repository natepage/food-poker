<?php
declare(strict_types=1);

namespace App\Listeners\Entities;

use App\Database\Entities\User;
use App\Services\Security\Interfaces\GeneratorInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events as DoctrineEvents;

class GenerateUserApiKeyListener implements EventSubscriber
{
    /**
     * @var \App\Services\Security\Interfaces\GeneratorInterface
     */
    private $generator;

    /**
     * GenerateUserApiKeyListener constructor.
     *
     * @param \App\Services\Security\Interfaces\GeneratorInterface $generator
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents():  array
    {
        return [
            DoctrineEvents::prePersist
        ];
    }

    /**
     * Generate salt and api key for user.
     *
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $eventArgs
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $user = $eventArgs->getObject();

        if (!$user instanceof User) {
            return;
        }

        $user
            ->setSalt($this->generator->generateSalt())
            ->setApiKey($this->generator->generateApiKey($user));
    }
}
