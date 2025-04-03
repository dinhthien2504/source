<?php
namespace app\models;

trait ModelSetup {
    private $setups = [];

    // __get để lấy giá trị thuộc tính
    public function __get($name) {
        return $this->setups[$name] ?? null;
    }

    // __set để thiết lập giá trị thuộc tính
    public function __set($name, $value) {
        $this->setups[$name] = $value;
    }

    // Lấy toàn bộ thuộc tính
    public function __gets(): array {
        return $this->setups;
    }

    // Thiết lập toàn bộ thuộc tính
    public function __sets(array $data) {
        $this->setups = $data;
    }
}
