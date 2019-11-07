<?php

require __DIR__ . '/vendor/autoload.php';

use Zend\ServiceManager\ServiceManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

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

class TesterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Tester($container->get('ta'));
    }
}

$serviceManager = new ServiceManager([
   'factories' => [
        'ta' => function(ContainerInterface $container) {
            return new TestAdapter();
        },
       'tester' => TesterFactory::class
   ]
]);

#build - create new instance
$tester_1 = $serviceManager->build('tester');
$tester_2 = $serviceManager->build('tester');

var_dump($tester_1, $tester_2);
