<?php

namespace PartnershipBundle\Command;


use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPointsCommand extends ContainerAwareCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'partnership:add-points';

    protected function configure()
    {
        $this->setName('partnership:add-points');

        $this->setDescription('Add points to all clients.') ;
        $this->addArgument('points', InputArgument::REQUIRED, "Combien de points ?");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Starting ...');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $all = $em  ->getRepository('PartnershipBundle:Client')->findAll();

        foreach ($all as $user) {
            if ($user->hasRole("ROLE_PARTENAIRE")) {
                $user->setPtFidelite($user->getPtFidelite() + $input->getArgument('points'));
                $em->flush();
                $output->write($user->getPtFidelite());
            }
        }

    }

    protected function getPartenaire() {
        $em = $this->getDoctrine()->getManager();
        $partenaires = array();

        $all = $em->getRepository('PartnershipBundle:Client')->findAll();

        foreach ($all as $user) {
            if ($user->hasRole("ROLE_PARTENAIRE")) {
                $partenaires[] = $user;
            }
        }

    }

}