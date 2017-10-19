<?php

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

define('APPLICATION_ENV', $_SERVER['APPLICATION_ENV']);

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

$application = new \Lemonado\Application();

var_dump($application); die;

