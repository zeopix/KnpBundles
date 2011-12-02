<?php

namespace Knp\Bundle\KnpBundlesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Knp\Bundle\KnpBundlesBundle\Updater\Updater;

class KbUpdateBundlesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDefinition(array())
            ->setName('kb:update:bundles')
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException When the target directory does not exist
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $gitRepoDir = $this->getContainer()->getParameter('knp_bundles.bundles_dir');
        $gitBin = $this->getContainer()->getParameter('knp_bundles.git_bin');

        $em = $this->getContainer()->get('knp_bundles.entity_manager');

        $updater = new Updater($em, $gitRepoDir, $gitBin, $output);
        $updater->setUp();
        $updater->updateBundlesData();
        $em->flush();
    }
}