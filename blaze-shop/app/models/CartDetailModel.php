<?php
class CartDetailModel{
    private $id;
    private $product_id;
    private $cart_id;
    private $quantity;
    private $size;

    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }
    public function setId($id){ return $this->id = $id; }
    public function getId(){ return $this->id; }
    public function setProductId($product_id){ return $this->product_id = $product_id; }
    public function getProductId(){ return $this->product_id; }
    public function setCartId($cart_id){ return $this->cart_id = $cart_id; }
    public function getCartId(){ return $this->cart_id; }
    public function setQuantity($quantity){ return $this->quantity = $quantity; }
    public function getQuantity(){ return $this->quantity;}
    public function setSize($size){ return $this->size = $size; }
    public function getSize(){ return $this->size; }

    public function addCartDetail(CartDetailModel $Dcart){
        $data = ['product_id' => $Dcart->getProductId(), 'cart_id' => $Dcart->getCartId(), 'quantity' => $Dcart->getQuantity(), 'size' => $Dcart->getSize()];
        $this->db->insertRecord('detailcarts',$data);
    }
    public function delCartDetail(CartDetailModel $Dcart){
        $this->db->deleteRecord('detailcarts', $Dcart->getId());
    }
    public function checkProCart(CartDetailModel $Dcart){
        $sql = "SELECT * FROM detailcarts ";
        $sql .= "WHERE product_id = ? AND cart_id = ? ";
        return $this->db->getAll($sql, [$Dcart->getProductId(), $Dcart->getCartId()]);
    }
    public function updateQuan(CartDetailModel $Dcart){
        $sql = "UPDATE detailcarts SET quantity = ? WHERE detailcarts.id = ? ";
        $this->db->update($sql, [ $Dcart->getQuantity(), $Dcart->getId()]);
    }
    public function getDcart(CartDetailModel $Dcart){
        return $this->db->getRecordById('detailcarts', $Dcart->getId());
    }
    public function getDcartForOrder(CartDetailModel $Dcart){
        $place_holders = rtrim(str_repeat('?,', count($Dcart->getId())), ','); // Tạo chuỗi placeholders
        $sql = "SELECT pro.name as name, pro.price as price, pro.discount_percent as discount_percent, Dcart.quantity, pro.id as id, Dcart.id as Dcart_id, ";
        $sql.= "(SELECT S.name as size FROM sizes S WHERE S.id = Dcart.size) as size_name, ";
        $sql.= "(SELECT S.id as size FROM sizes S WHERE S.id = Dcart.size) as size ";
        $sql.= "FROM detailcarts Dcart ";
        $sql.= "JOIN products pro ON pro.id = Dcart.product_id ";
        $sql.= "WHERE Dcart.id IN ($place_holders) ";
        return $this->db->getAll($sql, $Dcart->getId());
    }
}