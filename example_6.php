<?php

require __DIR__ . '/vendor/autoload.php';

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Factory\InvokableFactory;

$serviceManager = new ServiceManager([
   'factories' => [
        stdClass::class => InvokableFactory::class
   ]
]);

$object = $serviceManager->get(stdClass::class);

var_dump($object);
