<?php
class SizeDetailModel{
    private $id;
    private $product_id;
    private $size_id;
    private $quantity;

    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id){$this->id = $id;}
    public function getId(){return $this->id;}
    public function setProId($product_id){return $this->product_id = $product_id;}
    public function getProId(){return $this->product_id;}
    public function setSizeId($size_id){return $this->size_id = $size_id;}
    public function getSizeId(){return $this->size_id;}
    public function setQuantity($quantity): mixed{return $this->quantity = $quantity;}
    public function getQuantity(){return $this->quantity;}

    function updateQuantitySize(SizeDetailModel $Dsize){
        $sql = "UPDATE size_details SET quantity = quantity - ? WHERE product_id = ? AND size_id = ? ";
        $this->db->update($sql, [$Dsize->getQuantity(), $Dsize->getProId(), $Dsize->getSizeId()]);
    }

    function getQuantityByTwoId(SizeDetailModel $Dsize){
        $sql = "SELECT quantity FROM size_details ";
        $sql.= "WHERE product_id = ? AND size_id = ?";
        return $this->db->getOne($sql,[$Dsize->getProId(), $Dsize->getSizeId()]);
    }
}