<?php

namespace Commands;

use App\Auth\Support\GenerateJWT;
use App\User\Models\User;
use Neoan\Helper\Str;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'create:uuid', description: 'Creates a UUID')]
class CreateUUID extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('Creates a UUID');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = Uuid::uuid4();
        $output->writeln("UUID: $uuid");

        return Command::SUCCESS;

    }
}