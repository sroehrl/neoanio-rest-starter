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

#[AsCommand(name: 'scaffold:request', description: 'Shortcut for creating CRUD request declarations')]
class ScaffoldRequest extends Command
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
                'component',
                InputArgument::REQUIRED,
                'Component/Entity name'
            )
            ->addArgument(
                'name',
                InputOption::VALUE_OPTIONAL,
                'set controller name',
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $createCommand = $this->getApplication()->find('create:request');

        $methodPascaled = Str::toPascalCase(lcfirst($input->getArgument('component')));

        $controllerName = $input->getArgument('name') ?? $methodPascaled . 'Request';

        if(is_array($controllerName)){
            $controllerName = $controllerName[0];
        }

        $namespaced = "App\\{$input->getArgument('component')}\\Requests\\{$controllerName}";
        $arguments = new ArrayInput([
            'name' => $namespaced
        ]);

        try{
            $createCommand->run($arguments, $output);
        } catch (ExceptionInterface $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;

    }
}