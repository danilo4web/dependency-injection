<?php

// Dependency inversion Example
class Database
{
    private $driver;

    public function __construct(\PDO $pdo)
    {
        $this->driver = $pdo;
    }
}

$db_host = "0.0.0.0:3307";
$db_name = "symfony";
$db_user = "symfony";
$db_pass = "symfony";

$pdo = new \PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$database = new Database($pdo);
