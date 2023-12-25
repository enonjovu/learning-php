<?php

namespace Core\Database;

class QueryBuilder
{
    private ?string $table = null;
    private array $fields = ["*"];
    private array $whereClauses = [];
    private array $orWhereClauses = [];

    public function __construct(private Connection $connection)
    {
    }

    public function select(array $fields = ["*"])
    {
        $this->fields = $fields;
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $column, string $operation, string $value)
    {
        $this->whereClauses[] = [
            'type' => 'AND',
            ...compact("column", "operation", "value")
        ];
        return $this;
    }

    public function orWhere(string $column, string $operation, string $value)
    {
        $this->whereClauses[] = [
            'type' => 'OR',
            ...compact("column", "operation", "value")
        ];
        return $this;
    }

    public function get()
    {
        $selectFields = implode($this->fields);

        $sql = str("SELECT :[FIELDS] FROM :[TABLE]")->replace([
            ":[FIELDS]" => $selectFields,
            ":[TABLE]" => $this->table
        ]);

        if (! empty($this->whereClauses)) {
            $whereStatement = " WHERE ";
            foreach ($this->whereClauses as $index => $clause) {
                if ($index > 0) {
                    $whereStatement .= $clause['type'] . ' ';
                }
                $whereStatement .= $clause['column'] . ' ' . $clause['operator'] . ' ?';
            }
            $sql .= $whereStatement;
        }

        $bindiValues = array_column($this->whereClauses, "values");

        return $this->connection->query($sql, $bindiValues)->get();
    }
}
