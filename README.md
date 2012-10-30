AdminGeneratorBundle
====================

Add Symfony2 command to extends crud generator

Installation
===========

To install this bundle please follow the next steps:

First add the dependencie to your `composer.json` file:

    "require": {
        ...
        "idci/admin-generator-bundle": "dev-master"
    },

Then install the bundle with the command:

    php composer update

Enable the bundle in your application kernel:

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new IDCI\Bundle\AdminGeneratorBundle\IDCIAdminGeneratorBundle(),
        );
    }

Now, you have to install bootstrap. You can either: 

 * Download bootstrap at http://twitter.github.com/bootstrap/assets/bootstrap.zip
 * Then extract it into your /web directory which is at the root of the project.

Or
 * Add "bootstrap_source:  http://twitter.github.com/bootstrap/assets/bootstrap.zip" to your parameters.yml
 * Run the following command: php app/console admin-generator:install:bootstrap-files

Finally, go to Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator.php
You have to change the visibility from private to protected of theses functions :

 * generateIndexView
 * generateShowView
 * generateEditView
 * generateNewView
 * generateDeleteFormView
 * generateDeleteFormView
 * generateAdminBaseView
 * getRecordActions

For instance : 

    /**
     * Generates the show.html.twig template in the final bundle.
     *
     * @param string $dir The path to the folder that hosts templates in the bundle
     */
    protected function generateShowView($dir)
    {
        $this->renderFile($this->skeletonDir, 'views/show.html.twig', $dir.'/show.html.twig', array(
            'dir'               => $this->skeletonDir,
            'entity'            => $this->entity,
            'fields'            => $this->metadata->fieldMappings,
            'actions'           => $this->actions,
            'route_prefix'      => $this->routePrefix,
            'route_name_prefix' => $this->routeNamePrefix,
        ));
    }

Become

    /**
     * Generates the show.html.twig template in the final bundle.
     *
     * @param string $dir The path to the folder that hosts templates in the bundle
     */
    private function generateShowView($dir)
    {
        $this->renderFile($this->skeletonDir, 'views/show.html.twig', $dir.'/show.html.twig', array(
            'dir'               => $this->skeletonDir,
            'entity'            => $this->entity,
            'fields'            => $this->metadata->fieldMappings,
            'actions'           => $this->actions,
            'route_prefix'      => $this->routePrefix,
            'route_name_prefix' => $this->routeNamePrefix,
        ));
    }
    

The Bundle is installed.

Generate CRUD backoffice
========================

A CRUD interface, already stylized with bootstrap, can be easily generated with this command.

    php app/console doctrine:generate:crud:twitter-bootstrap

Then you have to:

 * Indicate for which entity you want to generate a CRUD.
   Exemple : IdciMyBundle:Entity
 * Indicate weather or not you want to generate "write actions" such as "new, update and delete"
 * Determine the format to use (annotation, yml, php, xml)
 * Determine the route prefix

Your CRUD entity is generated, as well as the layout.

You may want to be able to delete an entry directly from the index. You can choose which actions you want in the index view, among edit, delete and show action by editing IDCI\Bundle\AdminGeneratorBundle\Generator\BootstrapDoctrineCrudGenerator.php at line 181.
    
    return in_array($item, array('show', 'edit', 'delete'));