<?php
class OrderDetailModel{
    private $id;
    private $product_id;
    private $order_id;
    private $quantity;
    private $price;
    private $size;
    private $is_reviewed;

    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id){ return $this->id = $id;}
    public function getId(){ return $this->id;}
    public function setProduct_id($product_id){ return $this->product_id = $product_id;}
    public function getProduct_id(){ return $this->product_id;}
    public function setOrder_id($order_id){ return $this->order_id = $order_id;}
    public function getOrder_id(){ return $this->order_id;}
    public function setQuantity($quantity){ return $this->quantity = $quantity;}
    public function getQuantity(){ return $this->quantity;}
    public function setPrice($price){ return $this->price = $price;}
    public function getPirce(){ return $this->price;}
    public function setSize($size){ return $this->size = $size;}
    public function getSize(){ return $this->size;}
    public function setIs_reviewed($is_reviewed){ return $this->is_reviewed = $is_reviewed;}
    public function getIs_reviewed(){ return $this->is_reviewed;}

    public function addOrderDetail(OrderDetailModel $Dorder){
        $data = ['product_id'=>$Dorder->getProduct_id(), 'order_id'=>$Dorder->getOrder_id(), 'size'=>$Dorder->getSize(), 'quantity'=>$Dorder->getQuantity(), 'price'=>$Dorder->getPirce()];
        return $this->db->insertRecord("orderdetails", $data);
    }

    public function getD_orderForSendMail(OrderDetailModel $Dorder){
        $place_holders = rtrim(str_repeat('?,', count($Dorder->getId())), ',');
        $sql = "SELECT D_order.quantity AS quantity, D_order.price AS price, ";
        $sql .= "(SELECT pro.name FROM products pro WHERE pro.id = D_order.product_id) AS name, ";
        $sql .= "(SELECT S.name FROM sizes S WHERE S.id = D_order.size) AS size ";
        $sql .= "FROM orderdetails D_order ";
        $sql .= "WHERE id IN ($place_holders)";
        return $this->db->getAll($sql, $Dorder->getId());
    }
    
    public function getDorder(OrderDetailModel $Dorder){
        $sql = "SELECT Dord.*, ";
        $sql.= "(SELECT pro.name FROM products pro WHERE pro.id = Dord.product_id) AS name, ";
        $sql.= "(SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = Dord.product_id LIMIT 1) AS img ";
        $sql.= "FROM orderdetails Dord LEFT JOIN orders O ON Dord.order_id = O.id ";
        $sql.= "WHERE O.id = ? ";
        return $this->db->getAll($sql, [$Dorder->getOrder_id()]);
    }
    
    public function getAllOrder(){
        return $this->db->getAllRecord('orders');
    }

    public function getDorderAdmin(OrderDetailModel $Dorder){
        $sql = "SELECT Dord.*, O.total as total, O.by_date as day_time, O.phone as number, O.address as address, O.status as status, O.id as orderId, ";
        $sql.= "(SELECT pro.name FROM products pro WHERE pro.id = Dord.product_id) AS name, ";
        $sql.= "(SELECT U.name FROM users U WHERE U.id = O.user_id) AS user_name, ";
        $sql.= "(SELECT U.name FROM users U WHERE U.id = O.staff_id) AS staff_name, ";
        $sql.= "(SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = Dord.product_id LIMIT 1) AS img ";
        $sql.= "FROM orderdetails Dord LEFT JOIN orders O ON Dord.order_id = O.id ";
        $sql.= "WHERE O.id = ? ";
        return $this->db->getAll($sql, [$Dorder->getOrder_id()]);
    }
    public function getSizeRate(OrderDetailModel $or){
        $sql = "SELECT * ";
        $sql .= "FROM orderdetails ";
        $sql .= "WHERE product_id = ? ";
        $sql .= "ORDER BY id DESC";
        return $this->db->getOne($sql, [$or->getProduct_id()]);
    }
    public function updateRate(OrderDetailModel $or){
        $sql = "UPDATE orderdetails SET is_reviewed = ? WHERE orderdetails.id = ?";
        return $this->db->update($sql, [$or->getIs_reviewed(), $or->getId()]);
    }
}