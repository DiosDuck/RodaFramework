<?php

namespace Framework\Database;

use PDO;
use PDOException;
use Exception;
use Framework\ConfigReader\IConfigReader;

class MySQLDatabase extends AbstractDatabase {
    public function __construct(
        IConfigReader $configReader,
    )
    {
        $config = $configReader->getDatabaseFile();

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [];
        foreach ($config['options'] as $option) {
            $options[$option['key']] = $option['value'];
        }

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        } 
    }
}
