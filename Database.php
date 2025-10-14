<?php

class Database
{

    private $conn;


    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];


        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {

            throw new Exception("DB connection failed: " . $e->getMessage());
        }
    }

    public function query($query, $params = [])
    {
        $statement = $this->conn->prepare($query);

        foreach ($params as $param => $value) {

            $statement->bindValue(':' . $param, $value);
        }

        $statement->execute();
        return $statement;
    }
}
