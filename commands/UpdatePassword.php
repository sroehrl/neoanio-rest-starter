<?php

namespace Commands;

use App\User\Models\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'update:password', description: 'Updates the password of a given user')]
class UpdatePassword extends Command
{
    protected function configure(): void
    {
        $this
            ->addOption(
                'id',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Primary id of the record',
            )->addOption(
                'password',
                'p',
                InputOption::VALUE_OPTIONAL,
                'new password to be encrypted',
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption('id');
        $password = $input->getOption('password');

        try {
            $user = User::get($id);
            $user->password = $password;
            $user->store();

            $output->writeln('updated');
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