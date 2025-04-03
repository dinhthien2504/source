<?php
class Database
{
    private $servername = DB_HOST;
    private $database = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = "utf8mb4";
    private $pdo;
    public function __construct()
    {
        try {
            $dsn = "mysql:host=$this->servername;dbname=$this->database;charset=$this->charset";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successfully.";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getPdo()
    {
        return $this->pdo;
    }
    public function query($sql, $param = [])
    {
        $stmt = $this->pdo->prepare($sql);
        if ($param) {
            $stmt->execute($param);
        } else {
            $stmt->execute();
        }
        return $stmt;
    }
    public function getAll($sql, $param = [])
    {
        $stmt = $this->query($sql, $param);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOne($sql, $param = [])
    {
        $stmt = $this->query($sql, $param);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insert($sql, $param = [])
    {
        $this->query($sql, $param);
        return $this->pdo->lastInsertId();
    }
    public function update($sql, $param = [])
    {
        $this->query($sql, $param);
    }
    public function delete($sql, $param = [])
    {
        $this->query($sql, $param);
    }
    public function returnPDOstmt($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollBack()
    {
        $this->pdo->rollBack();
    }

    public function rand_string($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        $str = '';

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
