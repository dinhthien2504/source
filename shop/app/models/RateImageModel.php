<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;
class RateImageModel extends Model
{
    use ModelSetup;
    protected $table = 'rate_images';
    public function insert_img_rate()
    {
        $data = $this->__gets();
        $columns = implode(',', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $data_insert = array_values($data);
        return $this->save($columns, $placeholders, $data_insert);
    }

}