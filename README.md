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

Now the Bundle is installed.

Generate CRUD backoffice
========================

A CRUD interface, already stylized with bootstrap, can be easily generated with this command.

    php app/console doctrine:generate:crud:twitter-bootstrap

Then you have to:

   * Indicate for which entity you want to generate a CRUD.
   Exemple : IdciBlogBundle:Article
   * Indicate weather or not you want to generate "write actions" such as "new, update and delete"
   * Determine the format to use (annotation, yml, php, xml)
   * Determine the route prefix

Before anything else, you should download bootstrap archive at http://twitter.github.com/bootstrap/assets/bootstrap.zip.
Then extract into your web directory which is at the root of the project.

Your CRUD entity is generated, as well as the layout.