<?php

namespace Core\Database;

use Core\Application\Application;

class Model
{
    protected Connection $database;

    public function __construct(private readonly string $table)
    {
        $this->database = application()->get(Connection::class);
    }

    public static function find(string|int $id)
    {

    }

    public static function get()
    {

    }
}
