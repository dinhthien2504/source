<?php
class OrderModel{
    private $id;
    private $user_id;
    private $voucher_id;
    private $staff_id;
    private $code_oder;
    private $note;
    private $total;
    private $status;
    private $phone;
    private $address;

    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id){ return $this->id = $id;}
    public function getId(){ return $this->id;}
    public function setUserId($user_id){return $this->user_id = $user_id;}
    public function getUserId(){ return $this->user_id;}
    public function setVoucherId($voucher_id ){ return $this->voucher_id = $voucher_id;}
    public function getVoucherId(){ return $this->voucher_id;}
    public function setStaffId($staff_id ){ return $this->staff_id = $staff_id;}
    public function getStaffId(){ return $this->staff_id;}
    public function setCodeOrder($code_oder ){ return $this->code_oder = $code_oder;}
    public function getCodeOrder(){ return $this->code_oder;}
    public function setNote($note ){ return $this->note = $note;}
    public function getNote(){ return $this->note;}
    public function setTotal($total ){ return $this->total = $total;}
    public function getTotal(){ return $this->total;}
    public function setStatus($status ){ return $this->status = $status;}
    public function getStatus(){ return $this->status;}
    public function setPhone($phone){ return $this->phone = $phone;}
    public function getPhone(){ return $this->phone;}
    public function setAddress($address){ return $this->address = $address;}
    public function getAddress(){ return $this->address;}

    public function generateCoderOrder(){
        return 'ORD'.time().rand(100,999);
    }

    public function addOrder(OrderModel $order){
        $data = ['user_id'=>$order->getUserId(), 'voucher_id'=>$order->getVoucherId(), 'code_order'=>$order->getCodeOrder(), 'note'=>$order->getNote(), 'total'=>$order->getTotal(), 'address' =>$order->getAddress(), 'phone'=>$order->getPhone(), 'status'=>1];
        return $this->db->insertRecord('orders',$data);
    }

    public function addOrderNoVoucher(OrderModel $order){
        $data = ['user_id'=>$order->getUserId(), 'code_order'=>$order->getCodeOrder(), 'note'=>$order->getNote(), 'total'=>$order->getTotal(), 'address' =>$order->getAddress(), 'phone'=>$order->getPhone(), 'status'=>1];
        return $this->db->insertRecord('orders',$data);
    }

    public function getAllOrderByIdUser(OrderModel $order){
        $sql = "SELECT *, (SELECT U.name FROM users U WHERE U.id = O.user_id) as name ";
        $sql.= "FROM orders O ";
        $sql.= "WHERE O.user_id = ? ";
        return $this->db->getAll($sql, [$order->getUserId()]);
    }

    public function getOrderByIdUserStatus(OrderModel $order){
        $sql = "SELECT * ";
        $sql.= "FROM orders ";
        $sql.= "WHERE user_id = ? AND status = ? ";
        return $this->db->getAll($sql, [$order->getUserId(), $order->getStatus()]);
    }

    public function updateStatusStaff(OrderModel $order){
        $place_holders = rtrim(str_replace('?', count($order->getId()), ','));
        $sql = "UPDATE orders SET status = status + 1, staff_id = ? ";
        $sql.= "WHERE id IN ($place_holders)";
        $this->db->update($sql, [$order->getStatus(), $order->getStaffId(), $order->getId()]);
    }
    public function countOrder(){
        $sql = "SELECT count(*) as quanityOd FROM orders ";
        return $this->db->getOne($sql);
    }
    public function getRevenue(){
        $sql = "SELECT DATE_FORMAT(by_date, '%Y-%m') AS month, SUM(total) AS monthly_total ";
        $sql .= "FROM orders ";
        $sql .= "WHERE by_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND status = 4 ";
        $sql .= "GROUP BY month ORDER BY month";
        return $this->db->getAll($sql);
    }
    public function updateStatus(OrderModel $order){
        $place_holders = rtrim(str_replace('?', count($order->getId()), '.'));
        $sql = "UPDATE orders SET status = status + 1 ";
        $sql.= "WHERE id IN ($place_holders)";
        $this->db->update($sql, [$order->getStatus(), $order->getId()]);
    }

    public function updateStatus1(OrderModel $order){
        $sql = "UPDATE orders SET status = status + 1 ";
        $sql.= "WHERE id = ? ";
        $this->db->update($sql, [$order->getId()]);
    }

    public function updateStatusStaff1(OrderModel $order){
        $sql = "UPDATE orders SET status = status + 1, staff_id = ? ";
        $sql.= "WHERE id = ? ";
        $this->db->update($sql, [$order->getStaffId(), $order->getId()]);
    }

    public function getOrderByStatus(OrderModel $order){
        $sql = "SELECT *, ";
        $sql.= "(SELECT U.name FROM users U WHERE U.id = O.user_id) as name ";
        $sql.= "FROM orders O ";
        $sql.= "WHERE status = ? "; 
        return $this->db->getAll($sql, [$order->getStatus()]);
    }

    public function cancelOrder(OrderModel $order){
        $sql = "UPDATE orders set status = 0 ";
        $sql.= "WHERE id = ?";
        return $this->db->delete($sql, [$order->getId()]);
    }
}
