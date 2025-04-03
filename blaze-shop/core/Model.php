<?php
class Model extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllRecord($tableName)
    {
        $sql = "SELECT * FROM " . $tableName;
        return $this->getAll($sql);
    }

    public function getRecordById($tableName, $id)
    {
        $sql = "SELECT * FROM " . $tableName . " WHERE id = ?";
        return $this->getOne($sql, [$id]);
    }

    public function getRecordByForId($tableName, $foreignKey, $foreignId)
    {
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $foreignKey . " = ?";
        return $this->getAll($sql, [$foreignId]);
    }

    public function insertRecord($tableName, $data)
    {
        $field = implode(',', array_keys($data));
        $placeHolder = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . $tableName . " ($field) VALUES ($placeHolder)";
        return $this->insert($sql, $data);
    }

    public function updateRecord($tableName, $data, $id)
    {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $tableName . " SET $fields WHERE id = :id";
        $data['id'] = $id;
        $this->update($sql, $data);
    }

    public function deleteRecord($tableName, $id)
    {
        $sql = "DELETE FROM " . $tableName . " WHERE id = :id";
        $this->delete($sql, ['id' => $id]);
    }

}
