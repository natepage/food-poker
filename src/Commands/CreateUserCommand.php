<?php
declare(strict_types=1);

namespace App\Commands;

use App\Database\Entities\User;
use App\Services\Security\Interfaces\GeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \App\Services\Security\Interfaces\GeneratorInterface
     */
    private $generator;

    /**
     * CreateUserCommand constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Services\Security\Interfaces\GeneratorInterface $generator
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $entityManager, GeneratorInterface $generator)
    {
        parent::__construct(null);

        $this->entityManager = $entityManager;
        $this->generator = $generator;
    }

    /**
     * Configure command.
     *
     * @return void
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('app:create:user')
            ->setDescription('Create new user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'Password of the user')
            ->addArgument('roles', InputArgument::IS_ARRAY, 'Roles of the user');
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * Create new user.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user
            ->setEmail($input->getArgument('email'))
            ->setPassword($input->getArgument('password'))
            ->setRoles($input->getArgument('roles'))
            ->setSalt($this->generator->generateSalt())
            ->setApiKey($this->generator->generateApiKey($user));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->renderUser($user, $output);
    }

    /**
     * Render user into console output.
     *
     * @param \App\Database\Entities\User $user
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    private function renderUser(User $user, OutputInterface $output): void
    {
        $table = (new Table($output))
            ->setHeaders(['Id', 'Email', 'API Key', 'Roles'])
            ->setRows([[$user->getId(), $user->getEmail(), $user->getApiKey(), \implode(', ', $user->getRoles())]]);

        $table->render();
    }
}
