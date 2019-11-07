<?php

require __DIR__ . '/vendor/autoload.php';

use Zend\ServiceManager\ServiceManager;
use Interop\Container\ContainerInterface;

class TestAdapter
{
    public function __construct()
    {
        var_dump(TestAdapter::class.'::__construct()');
    }

    public function runTest($message)
    {
        var_dump($message);
    }
}

class Tester
{
    public function __construct(TestAdapter $adapter)
    {
        $adapter->runTest('Rodou um test');
    }
}

$serviceManager = new ServiceManager([
   'factories' => [
        'ta' => function(ContainerInterface $container) {
            return new TestAdapter();
        },
       'tester' => function(ContainerInterface $container) {
           return new Tester($container->get('ta'));
       }
   ]
]);

$tester = $serviceManager->get('tester');

var_dump($tester);
