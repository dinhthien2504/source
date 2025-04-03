<?php
namespace app\core;
use PDO;
use PDOException;

class Database
{
  private $pdo;
  public function __construct(private $servername, private $database, private $username, private $password, private $charset)
  {
    try {
      $dsn = "mysql:host=$this->servername;dbname=$this->database;charset=$this->charset";
      $this->pdo = new PDO($dsn, $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  private function query($sql, $param = [])
  {
    $stmt = $this->pdo->prepare($sql);
    if ($param) {
      $stmt->execute($param);
    } else {
      $stmt->execute();
    }
    return $stmt;
  }
  protected function getAll($sql, $param = [])
  {
    $stmt = $this->query($sql, $param);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function getOne($sql, $param = [])
  {
    $stmt = $this->query($sql, $param);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  protected function insert($sql, $param = [])
  {
    $this->query($sql, $param);
    return $this->pdo->lastInsertId();
  }

  protected function update($sql, $param = [])
  {
    $stmt = $this->query($sql, $param);
    return $stmt->rowCount();
  }

  protected function delete($sql, $param = [])
  {
    $stmt = $this->query($sql, $param);
    return $stmt->rowCount();
  }

  public function __destruct()
  {
    unset($this->pdo);
  }
}
