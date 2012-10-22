<?php

namespace IDCI\Bundle\AdminGeneratorBundle\Command;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;

class DoctrineGenerateCrudTwitterBootstrapCommand extends GenerateDoctrineCrudCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('doctrine:generate:crud:twitter-bootstrap');
    }

    protected function getGenerator()
    {
        $generator = new DoctrineCrudGenerator(
            $this->getContainer()->get('filesystem'),
            __DIR__.'/../Resources/skeleton/crud/bootstrap'
        );
        $this->setGenerator($generator);
        return parent::getGenerator();
    }
}
