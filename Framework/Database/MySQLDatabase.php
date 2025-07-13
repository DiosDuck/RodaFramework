<?php

namespace Framework\Database;

use PDO;
use PDOException;
use Exception;
use Framework\ConfigReader\ConfigReader;

class MySQLDatabase extends AbstractDatabase {

    public function __construct()
    {
        $config = ConfigReader::getDatabasePHPFile();

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        } 
    }
}
