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

#[AsCommand(name: 'scaffold:route', description: 'Shortcut for creating CRUD routes')]
class ScaffoldRoute extends Command
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
                'requestMethod',
                InputArgument::REQUIRED,
                'GET|POST|PUT|DELETE',
            )
            ->addArgument(
                'component',
                InputArgument::REQUIRED,
                'Component/Entity name'
            )
            ->addArgument(
                'custom-name',
                InputArgument::OPTIONAL,
                'set controller name',
            )
            ->addOption(
                'route',
                'r',
                InputOption::VALUE_OPTIONAL,
                'set api-route'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $createCommand = $this->getApplication()->find('create:controller');

        $methodPascaled = Str::toPascalCase(lcfirst($input->getArgument('requestMethod')));

        $controllerName = $input->getArgument('custom-name') ?? $methodPascaled . $input->getArgument('component');

        $namespaced = "App\\{$input->getArgument('component')}\\Routes\\{$controllerName}";
        $arguments = new ArrayInput([
            'name' => $namespaced
        ]);
        try{
            $createCommand->run($arguments, $output);
        } catch (ExceptionInterface $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
        $filePath = $this->neoanApp->appPath . '/' . $input->getArgument('component') . '/Routes/' . $controllerName . '.php';
        $generatedFile = file_get_contents($filePath);


        $useStatement = 'use Neoan\Routing\Attributes\\' .$methodPascaled . ';';
        $dashed = $input->getOption('route') ?? Str::toKebabCase($input->getArgument('component'));
        $attribute = '#[' . $methodPascaled . "('/api/$dashed')]";


        $generatedFile = str_replace('use Neoan\Routing\Interfaces\Routable;' , $useStatement ."\nuse Neoan\Routing\Interfaces\Routable;", $generatedFile);
        $generatedFile = str_replace('class ' . $controllerName, $attribute . "\nclass " . $controllerName, $generatedFile);
        file_put_contents($filePath, $generatedFile);


        return Command::SUCCESS;

    }
}