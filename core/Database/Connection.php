<?php

namespace Core\Database;

use PDO;

class Connection
{
    public PDO $connection;
    private \PDOStatement $statement;

    private static ?Connection $instance = null;

    private function __construct(array $config)
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function create(array $config) : static
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($config);
        }

        return self::$instance;
    }

    public function query($query, $params = []) : static
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function get() : ?array
    {
        return $this->statement->fetchAll();
    }

    public function findOrFail() : mixed
    {
        $result = $this->find();

        if (! $result) {
            throw new \Exception("not found");
        }
        return $result;
    }

    public function find() : mixed
    {
        return $this->statement->fetch();
    }
}