# Silex Simple Orm User Provider

An extension for the [Simple User Provider for Silex](https://github.com/jasongrimes/silex-simpleuser) made by [jasongrimes](https://github.com/jasongrimes). Instead of using [Doctrine DBAL](http://www.doctrine-project.org/projects/dbal.html) it uses the [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html). It automatically overwrites the User Class and User Manager of silex simple user provider.

## Dependencies

* [Silex](http://silex.sensiolabs.org)
* [Doctrine Orm Service Provider](https://github.com/dflydev/dflydev-doctrine-orm-service-provider)
* [Simple User Provider for Silex](https://github.com/jasongrimes/silex-simpleuser)
 
## Usage

Make sure that you have installed the [Simple User Provider for Silex](https://github.com/jasongrimes/silex-simpleuser) before beginning the installation of Silex Simple Orm User Provider!

First download the library via composer:

```
$ composer require "rootlogin/silex-simpleormuser: dev-master"
```

After downloading, you can activate the simple orm user provider in your bootstrap file:

```
<?php

use SimpleUser\UserServiceProvider;
use rootLogin\SimpleOrmUser\Provider\SimpleOrmUserServiceProvider;

// ...

$app['usp'] = new UserServiceProvider();
$app->register($app['usp']);

/**
 * IMPORTANT: The Simple Orm User Service Provider must be registered after the 
 * Simple User Provider for Silex!
 **/
$app->register(new SimpleOrmUserServiceProvider());

// ...

$app->mount($app['usp']);

// ...

```

Now you can create the needed tables via the doctrine orm provider and this should work. You don't need the original database tables anymore.
