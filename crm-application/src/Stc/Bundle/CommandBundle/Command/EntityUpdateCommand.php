<?php

namespace Stc\Bundle\CommandBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Oro\Bundle\InstallerBundle\CommandExecutor;

class EntityUpdateCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('stc:entity:update')
            ->setDescription('Updates all entities using oro commands WITH --env=prod OPTION ON EACH.')
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Forces operation to be executed.'
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $force = $input->getOption('force');

        if ($force) {
            $commandExecutor = new CommandExecutor(
                'prod',
                $output,
                $this->getApplication(),
                $this->getContainer()->get('oro_cache.oro_data_cache_manager')
            );
            $commandExecutor->setDefaultTimeout(2500);

            $commandExecutor
                ->runCommand('oro:entity-extend:update-config', ['--env=prod'])
                ->runCommand('oro:entity-extend:update-schema', ['--env=prod'])
                ->runCommand('oro:entity-config:update', ['--env=prod'])
                ->runCommand('doctrine:schema:update', ['--force'])
                ->runCommand('cache:clear', ['--env=prod']);
        } else {
            $output->writeln(
                '<comment>ATTENTION</comment>: This will run all entity update / schema update commands for production.'
            );
            $output->writeln(
                '           To run this command, use the --force option.'
            );
            $output->writeln(sprintf('    <info>%s --force</info>', $this->getName()));
        }
    }
}
