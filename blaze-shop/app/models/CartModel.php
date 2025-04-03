<?php
class CartModel{
    private $id;
    private $user_id;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }   
    public function setId ($id){ return $this->id = $id; }
    public function getId (){ return $this->id; }
    public function setUser_id ($user_id){ return $this->user_id = $user_id; }
    public function getUser_id (){ return $this->user_id; }

    public function getCart(CartModel $cart) {
        $sql = "SELECT D.quantity as quantity, pro.name as name, pro.price as price, pro.discount_percent, D.size as size, D.id as D_id, ";
        $sql .= "(SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = pro.id LIMIT 1) AS img, ";
        $sql .= "(SELECT Dsize.quantity FROM size_details Dsize WHERE Dsize.product_id = D.product_id AND Dsize.size_id = D.size) AS stock_quantity, ";
        $sql .= "(SELECT S.name FROM sizes S JOIN size_details Dsize ON S.id = Dsize.size_id WHERE S.id = D.size LIMIT 1) AS size_name ";
        $sql .= "FROM users U ";
        $sql .= "JOIN carts C ON C.user_id = U.id ";
        $sql .= "JOIN detailcarts D ON D.cart_id = C.id ";
        $sql .= "JOIN products pro ON pro.id = D.product_id ";
        $sql .= "WHERE U.id = ? ";
        return $this->db->getAll($sql, [$cart->getUser_id()]);
    }
    
    public function addCart(CartModel $cart){
        $data = ['user_id' => $cart->getUser_id()];
        $this->db->insertRecord('carts',$data);
    }
    public function checkCart(CartModel $cart){
        return $this->db->getRecordByForId('carts', 'user_id', $cart->getUser_id());
    }
    
}