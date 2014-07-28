<?php

namespace Stc\Bundle\CommandBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Oro\Bundle\InstallerBundle\CommandExecutor;

class InstallTimeoutFixerCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('stc:install')
            ->setDescription('Runs the oro:install command with a greater time limit so it can finish executing.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('max_input_time', 0);
        ini_set('max_execution_time', 0); // Unlimited time! Scary!
        ini_set('memory_limit', '528M'); // Hog it
        set_time_limit(0);
        ignore_user_abort(1);


        $commandExecutor = new CommandExecutor(
            'prod',
            $output,
            $this->getApplication(),
            $this->getContainer()->get('oro_cache.oro_data_cache_manager')
        );
        $commandExecutor->setDefaultTimeout(15000);

        $commandExecutor
            ->runCommand('oro:install', ['--force']);
    }
}
