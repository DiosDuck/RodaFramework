<?php

namespace Framework\Database;

use PDOStatement;
use PDOException;
use PDO;
use Exception;

abstract class AbstractDatabase {
    protected readonly PDO $conn;

    /**
     * Query the database
     * 
     * @throws PDOException
     */
    public function query(string $query, array $params = []): PDOStatement 
    {
        try{
            $sth = $this->conn->prepare($query);
            foreach ($params as $param => $value) {
                $sth->bindValue(':' . $param, $value);
            }

            $sth->execute();
            return $sth;
        } catch (PDOException $e) {
            throw new Exception("Query failed to execute: {$e->getMessage()}");
        }
    }
}
