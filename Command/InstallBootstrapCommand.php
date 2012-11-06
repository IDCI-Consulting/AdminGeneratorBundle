<?php

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
            $output->writeln('<error>Unable to open zip file</error>');

            return false;
        }
        $dest_dir = dirname(realpath($zip_file));
        while(($zip_entry = zip_read($zip)) !== false) {
            $output->writeln('<info>Unpacking '.zip_entry_name($zip_entry).'</info>');
            $last = strrpos(zip_entry_name($zip_entry), '/');
            $file = substr(zip_entry_name($zip_entry), $last+1);

            if(strpos(zip_entry_name($zip_entry), '/') !== false) {
                $dir = $dest_dir.DIRECTORY_SEPARATOR.substr(zip_entry_name($zip_entry), 0, $last);
                if(!is_dir($dir)) {
                    if(!mkdir($dir, 0755, true)) {
                        $output->writeln('<error>Unable to create '.$dir.'</error>');

                        return false;
                    }
                }

                if(strlen(trim($file)) > 0) {
                    if(!file_put_contents($dir."/".$file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)))) {
                        $output->writeln('<error>Unable to unzip '.$dir."/".$file.'</error>');

                        return false;
                    }
                }
            }
            else {
                file_put_contents($file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
            }
        }
        
        return true;
    } 
}
