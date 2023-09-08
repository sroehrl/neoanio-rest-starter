<?php

namespace Commands;

use Neoan\Helper\Str;
use Neoan\NeoanApp;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'scaffold:model', description: 'Shortcut for creating Models')]
class ScaffoldModel extends Command
{
    private NeoanApp $neoanApp;
    public function __construct(NeoanApp $neoanApp, string $name = null)
    {
        $this->neoanApp = $neoanApp;
        parent::__construct($name);
    }
    protected function configure(): void
    {
        $this

            ->addArgument(
                'model',
                InputArgument::REQUIRED,
                'Model name'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        preg_match_all('/[A-Z][a-z0-9]+/', $input->getArgument('model'), $parts);


        $component = $parts[0][0];
        $controllerName = implode('', $parts[0]);

        $namespaced = "App\\{$component}\\Models\\{$controllerName}";
        $arguments = new ArrayInput([
            'name' => $namespaced
        ]);
        $createCommand = $this->getApplication()->find('create:model');

        try{
            $createCommand->run($arguments, $output);
        } catch (ExceptionInterface $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;

    }
}