<?php

// Dependency injection Example

interface DatabaseDriver
{
    public function configure(array $config);

    public function connect();
}

class PdoDriver implements DatabaseDriver
{
    public function configure(array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $pdo = new \PDO($this->config['dns'], $this->config['user'], $this->config['passwd']);

        echo "PDO connected" . PHP_EOL;
    }
}

class MongoDbDriver implements DatabaseDriver
{
    public function configure(array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $mongo = new \MongoClient($this->config['server']);

        echo "MongoDb connected" . PHP_EOL;
    }
}


class Database
{
    public function __construct(\DatabaseDriver $driver)
    {
        $this->driver = $driver;

        $this->driver->connect();
    }
}

$ioc = [];
$ioc['db'] = function () {
    $pdo_driver = new PdoDriver();
    $pdo_driver->configure(['dns' => 'mysql:host=0.0.0.0:3307;dbname=symfony', 'user' => 'symfony', 'passwd' => 'symfony']);

    return new Database($pdo_driver);
};

$ioc['db_mongo'] = function () {
    $mongo_driver = new MongoDbDriver();
    $mongo_driver->configure(['server' => 'mongodb://localhost:27017']);

    return new Database($mongo_driver);
};

$ioc['db']();
$ioc['db_mongo']();
