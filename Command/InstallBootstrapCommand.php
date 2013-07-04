<?php

/**
 *
 * @author:  Baptiste BOUCHEREAU <baptiste.bouchereau@idci-consulting.fr> 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\AdminGeneratorBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Finder\Finder;

class InstallBootstrapCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('admin-generator:install:bootstrap-files')
            ->setDescription('Install bootstrap files')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command download and install the bootstrap files

To install Bootstrap:
<info>php %command.full_name% http://twitter.github.com/bootstrap/assets/bootstrap.zip</info>

more information here: http://twitter.github.com/bootstrap/

EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $this->getApplication()->getKernel()->getContainer()->getParameter('bootstrap_source');

        $webDir = $this->getApplication()->getKernel()->getRootDir() . '/../web';
        $destination = sprintf('%s/%s', $webDir, "bootstrap.zip");
        $output->writeln(sprintf('<info>Start downloading %s</info>', $source));
        $output->writeln('<info>...</info>');
        if (!copy($source, $destination)) {
            $output->writeln('<error>Error during file download occured</error>');

            return false;
        }
        $output->writeln('<comment>Download completed</comment>');
        $output->writeln('Unzip the downloading archive');
        $output->writeln('...');
        if (!$this->unzip($destination, $output)) {
            $output->writeln('<error>Unzip error</error>');
        }
        $output->writeln('<comment>Unzip success</comment>');
        $output->writeln('<info>Remove zip file</info>');
        unlink($destination);
        $output->writeln('<info>Done !</info>');

        return true;
    }

    protected function unzip($zip_file, $output)
    {
        $zip = zip_open($zip_file);
        if(!is_resource($zip)) {
            $output->writeln('<error>Unable to unzip'.pathinfo($zip_file, PATHINFO_FILENAME).' - Not a resource</error>');
        }

        $zip = new \ZipArchive();
        if (!$zip->open($zip_file)) {
            $output->writeln('<error>Unable to unzip'.pathinfo($zip_file, PATHINFO_FILENAME).'</error>');
        }

        $zip->extractTo(pathinfo($zip_file, PATHINFO_DIRNAME));
        $zip->close();

        return true;
    }
}
