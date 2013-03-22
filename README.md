AdminGeneratorBundle
====================

Add Symfony2 command to extends crud generator

Requirements:
=============

This bundle extends `Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator`
And need `php5-intl`.
The pagination is made with the pagerfanta bundle provide by white october

Installation
===========

To install this bundle please follow the next steps:

First add the dependencies to your `composer.json` file:

```json
"require": {
    ...
    "pagerfanta/pagerfanta":           "dev-master",
    "white-october/pagerfanta-bundle": "dev-master",
    "idci/admin-generator-bundle":     "2.1.*"
},
```

Then install the bundle with the command:

```sh
php composer update
```

Enable the bundle in your application kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
        new IDCI\Bundle\AdminGeneratorBundle\IDCIAdminGeneratorBundle(),
    );
}
```
As you can see, we use [WhiteOctoberPagerFantaBundle](https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle) to paginate list results.
So you have to define the `max_per_page` parameter in your `app/config/parameters.yml`

```yml
parameters:
    ...
    max_per_page:  25
```

Now, you have to install bootstrap. You can either: 

 * Download bootstrap at http://twitter.github.com/bootstrap/assets/bootstrap.zip
 * Then extract it into your /web directory which is at the root of the project.

Or

Add `bootstrap_source` to your `app/config/parameters.yml`

```yml
parameters:
    ...
    bootstrap_source:  http://twitter.github.com/bootstrap/assets/bootstrap.zip
```

Then run the following command to automatically install bootstrap assets in your web directory:

```sh
php app/console admin-generator:install:bootstrap-files
```


Fix DoctrineCrudGenerator function visibility
=============================================

Note: We hope this will be fixed soon !

Go to the vendor `Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator.php`
You have to change the visibility from private to protected of theses functions:

```php
// Before
private function generateIndexView($dir)
{
  ...
// After
protected function generateIndexView($dir)
{
  ...

// Before
private function generateShowView($dir)
{
  ...
// After
protected function generateShowView($dir)
{
  ...

// Before
private function generateNewView($dir)
{
  ...
// After
protected function generateNewView($dir)
{
  ...

// Before
private function generateEditView($dir)
{
  ...
// After
protected function generateEditView($dir)
{
  ...

// Before
private function getRecordActions($dir)
{
  ...
// After
protected function getRecordActions($dir)
{
  ...
```

Generate CRUD backoffice
========================

A CRUD interface, already stylized with bootstrap, can be easily generated with this command.

```sh
php app/console doctrine:generate:crud:twitter-bootstrap
```

Then you have to:

 * Indicate for which entity you want to generate a CRUD (Ex: MyBundle:Entity)
 * Indicate weather or not you want to generate "write actions" such as "new, update and delete"
 * Determine the format to use (annotation, yml, php, xml)
 * Determine the route prefix

Your CRUD entity is generated, as well as the layout.

Enjoy !
