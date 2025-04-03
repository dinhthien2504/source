<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;

class WardModel extends Model {
    use ModelSetup;
    public function get_all_ward_by_district_id() {
        $sql = "SELECT * FROM wards WHERE district_id = ?";
        return $this->getAll($sql, [$this->__get('district_id')]);
    }
}