<?php

namespace Commands;

use App\User\Models\UserModel;
use Neoan\Helper\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'create:typescript-type', description: 'outputs typescript interface for a given model')]
class CreateTypescriptInterface extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('model');

    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!class_exists($input->getArgument('model'))){
            $output->writeln('No such model');
            return Command::FAILURE;
        }
        $model = $input->getArgument('model');
        $declaration = $model::declare();
        $interface = "export interface " . Str::toPascalCase(array_keys($declaration)[0]) . "{\n";
        foreach ($declaration[array_keys($declaration)[0]] as $property){
            $interface .= "\t" . $property['name']. ($property['nullable']?'?':'') . ':' . $this->returnType($property['type']) . ",\n";
        }
        $interface .= '}';
        $output->writeln($interface);
        return Command::SUCCESS;

    }
    private function returnType(string $type): string
    {
        return match ($type){
            'int' => 'Number',
            'Neoan\Model\Helper\DateTimeProperty' => 'LenkradDate',
            default => 'string'
        };
    }
}