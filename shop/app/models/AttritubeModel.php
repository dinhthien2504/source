<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;
class AttritubeModel extends Model
{
    use ModelSetup;
    public function get_all_attri()
    {
        $sql = 'SELECT * FROM attritubes ';
        $sql .= 'WHERE 1 ';
        $sql .= 'ORDER BY id ASC';
        return $this->getAll($sql);
    }
}