<?php

namespace Commands;

use App\Auth\Support\GenerateJWT;
use App\User\Models\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'create:jwt', description: 'Creates a JWT for a given user')]
class CreateJWTForUser extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('Creates a JWT for a given user')
            ->addOption(
                'email',
                'u',
                InputOption::VALUE_REQUIRED,
                'Email of the user',
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getOption('email');
        if(!defined('base')) {
            define('base', 'http://localhost:8080');
        }

        try {
            $jwt = GenerateJWT::generate(User::retrieveOne(['email'=>$email, '^deletedAt']));

            $output->writeln("JWT: {$jwt['token']} ");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

    }
}