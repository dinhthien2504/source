<?php
class PaymentModel{
    private $id;
    private $order_id;
    private $payment_method_id;
    private $amount;

    public $db;
    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id){ return $this->id = $id;}
    public function getId(){ return $this->id;}
    public function setOrder_id($order){ return $this->order_id = $order;}
    public function getOrder_id(){ return $this->order_id;}
    public function setPayment_method_id($payment_method_id){ return $this->payment_method_id = $payment_method_id;}
    public function getPayment_method_id(){ return $this->payment_method_id;}
    public function setAmount($amount){ return $this->amount = $amount;}
    public function getAmount(){ return $this->amount;}

    public function addPayment(PaymentModel $payment){
        $data = [$payment->getOrder_id(), $payment->getPayment_method_id(), $payment->getAmount()];
        $this->db->insertRecord('payment',$data);
    }
}