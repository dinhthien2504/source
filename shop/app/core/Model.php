<?php
namespace app\core;
use app\core\Database;

abstract class Model extends Database
{
    protected $table;
    public function __construct()
    {
        parent::__construct("localhost", "shop", "root", "", "utf8mb4");
    }

    protected function findAll()
    {
        return $this->getAll("SELECT * FROM {$this->table} WHERE 1");
    }

    protected function find($id)
    {
        return $this->getOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }
    protected function save($columns, $placeholders, $data): bool|string
    {
        return $this->insert("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)", $data);
    }
    protected function saveUpdate($assignments, $data)
    {
        $sql = "UPDATE {$this->table} SET $assignments WHERE id = ?";
        return $this->update($sql, $data);
    }
    protected function remove($id)
    {
        return $this->delete("DELETE FROM {$this->table} WHERE id =?", [$id]);
    }
    public function total()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        return $this->getOne($sql);
    }
}