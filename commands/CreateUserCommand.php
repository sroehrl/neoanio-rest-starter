<?php

namespace Commands;

use App\User\Model\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'create:user', description: 'Creates a user')]
class CreateUserCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('Creates a valid login via cli')
            ->addOption(
                'email',
                'u',
                InputOption::VALUE_REQUIRED,
                'Email of the user',
            )->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'Password of the user',
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getOption('email');
        $password = $input->getOption('password');
        $user = new User();

        try {
            $user->email = $email;
            $user->password = $password;
            $user->store();
            $output->writeln("User $email created");
            return Command::SUCCESS;
        } catch (\TypeError $e){
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

    }
}