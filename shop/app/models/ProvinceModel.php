<?php 
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;
class ProvinceModel extends Model{
    use ModelSetup;

    public function get_all_province() {
        $sql = "SELECT * FROM provinces";
        return $this->getAll($sql);
    }
}