<?php
class VoucherModel {
    private $id;
    private $code_voucher;
    private $discount_percent;
    private $max_discount;
    private $expiration_date;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setCode($code_voucher)
    {
        return $this->code_voucher = $code_voucher;
    }
    public function getCode()
    {
        return $this->code_voucher;
    }

    public function setDiscount($discount_percent)
    {
        return $this->discount_percent = $discount_percent;
    }
    public function getDiscount()
    {
        return $this->discount_percent;
    }

    public function setMaxDis($max_discount)
    {
        return $this->max_discount = $max_discount;
    }
    public function getMaxDis()
    {
        return $this->max_discount;
    }

    public function setExpiration($expiration_date)
    {
        return $this->expiration_date = $expiration_date;
    }
    public function getExpiration()
    {
        return $this->expiration_date;
    }

    public function getAllVoucher() {
        $sql = "SELECT * FROM vouchers";
        return $this->db->getAll($sql);
    }

    public function getOneVoucher(VoucherModel $voucher) {
        $sql = "SELECT * FROM vouchers WHERE id = ?";
        return $this->db->getOne($sql, [$voucher->getId()]);
    }

    public function addVoucher(VoucherModel $voucher) {
        $sql = "INSERT INTO vouchers (code_voucher, discount_percent, max_discount, expiration_date) VALUES (?, ?, ?, ?)";
        return $this->db->insert($sql, [$voucher->getCode(), $voucher->getDiscount(),$voucher->getMaxDis() ,$voucher->getExpiration()]);
    }

    public function deleteVoucher(VoucherModel $voucher) {
        $sql = "DELETE FROM vouchers WHERE id = ?";
        return $this->db->delete($sql, [$voucher->getId()]);
    }

    public function updateVoucher(VoucherModel $voucher) {
        $sql = "UPDATE vouchers SET code_voucher = ?, discount_percent = ?, max_discount = ? ,expiration_date = ? WHERE id = ?";
        return $this->db->update($sql, [$voucher->getCode(), $voucher->getDiscount(),$voucher->getMaxDis() ,$voucher->getExpiration(), $voucher->getId()]);
    }
    
    public function checkVoucher(VoucherModel $voucher){
        $sql = "SELECT * FROM vouchers WHERE code_voucher =?";
        return $this->db->getOne($sql, [$voucher->getCode()]);
    }

}