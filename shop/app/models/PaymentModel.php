<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;
class PaymentModel extends Model
{
    use ModelSetup;
    protected $table = 'payment';
    public function insertPayment()
    {
        $data = $this->__gets();
        $columns = implode(',', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $data_insert = array_values($data);
        return $this->save($columns, $placeholders, $data_insert);
    }

    public function confirm_update_payment_success() {
        $data = $this->__gets();
        
        $sql = "UPDATE payment SET status =? WHERE order_id =?";
        return $this->update($sql, $data);
    }
}