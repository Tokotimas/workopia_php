<?php

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database
{
    public $conn;

    /**
     * Constructor for Database class
     * 
     * @param array $config
     */

    public function __construct($config)
    {
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->conn = new PDO(dsn: $dsn, username: $config['username'], password: $config['password'], options: $options);
        } catch (PDOException $e) {
            throw new PDOException(message: "Database connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Query the database
     * 
     * @param string $query
     * 
     * @return PDOStatement
     * @throws PDOException
     */

    public function query($query, $params = []): bool|PDOStatement
    {
        try {
            $stmt = $this->conn->prepare(query: $query);

            // Bind named params
            foreach ($params as $param => $value) {
                $stmt->bindValue(param: ':' . $param, value: $value);
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException(message: "Query failed to execute {$e->getMessage()}");
        }
    }
}