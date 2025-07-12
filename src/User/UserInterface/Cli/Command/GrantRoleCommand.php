<?php

namespace App\User\UserInterface\Cli\Command;

use App\Service\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:grant-role',
    description: 'Grant user role',
)]
class GrantRoleCommand extends Command
{
    public function __construct(
        public UserService $userService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('role', InputArgument::REQUIRED, 'User role');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');

        if (!$this->userService->grantRole($email, $role)) {
            $io->error('Could not grant new role');
            return Command::INVALID;
        }

        $io->success(sprintf('New role has been added: %s', $email));
        return Command::SUCCESS;
    }
}
