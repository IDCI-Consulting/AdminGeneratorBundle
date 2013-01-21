<?php

/**
 *
 * @author:  Baptiste BOUCHEREAU <baptiste.bouchereau@idci-consulting.fr> 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\AdminGeneratorBundle\Command;

use IDCI\Bundle\AdminGeneratorBundle\Generator\BootstrapDoctrineCrudGenerator;
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
        $generator = new BootstrapDoctrineCrudGenerator(
            $this->getContainer()->get('filesystem'),
            __DIR__.'/../Resources/skeleton/crud/bootstrap'
        );
        $this->setGenerator($generator);
        return parent::getGenerator();
    }
}
