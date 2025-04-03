<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;
class PaymentMethodModel extends Model
{
    use ModelSetup;
    protected $table = 'payment_method';
    public function get_all_payment_method()
    {
        return $this->findAll();
    }
}