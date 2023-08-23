<?php

namespace Commands;

use App\User\Model\User;
use Neoan\Model\Model;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'get:uuid', description: 'Retrieves the uuid of an entity')]
class GetUuid extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('Retrieves the uuid of an entity')
            ->addOption(
                'entity',
                'e',
                InputOption::VALUE_REQUIRED,
                'UUID capable model',
            )->addOption(
                'id',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Primary id of the record',
            )->addOption(
                'name',
                's',
                InputOption::VALUE_OPTIONAL,
                'Name/Title of the record',
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getOption('entity');
        $id = $input->getOption('id');
        $name = $input->getOption('name');

        $model = "App\\$entity\Models\\$entity";

        if(!$name && !$id){
            $output->writeln('No id or name provided');
            return Command::FAILURE;
        }


        try {
            if($id){
                $res = $model::get($id);
            } else if($name){
                $declaration = $model::declare();
                $fields = array_map(fn($props) => $props['name'], array_shift($declaration));
                $possible = ['name', 'title', 'lastName', 'firstName', 'email'];
                $found = false;
                foreach ($possible as $candidate){
                    if(in_array($candidate, $fields) && !$found){
                        $res = $model::retrieveOne([$candidate=> $name . '%']);
                        if($res){
                            $found = true;
                        }
                    }
                }
                if(!isset($res)){
                    $output->writeln('no suitable field or entry found');
                    return Command::FAILURE;
                }
            }
            $output->writeln($res->uuid);
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