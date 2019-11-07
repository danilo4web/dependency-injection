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
        $pdo = new \PdoDriver($this->config['dns'], $this->config['user'], $this->config['passwd']);
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
    $pdo_driver->configure(['dns' => '0.0.0.0:3307', 'user' => 'symfony', 'passwd' => 'symfony']);

    return new Database($pdo_driver);
};

$ioc['db']();

