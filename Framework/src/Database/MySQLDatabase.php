<?php

namespace Framework\Database;

use PDO;
use PDOException;
use Exception;
use Framework\ConfigReader\IConfigReader;
use Framework\ConfigReader\PHPConfigReader;

class MySQLDatabase extends AbstractDatabase {
    public function __construct(
        IConfigReader $configReader,
    )
    {
        $config = $configReader->getDatabaseFile();

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        } 
    }
}
