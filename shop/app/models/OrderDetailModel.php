<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;

class OrderDetailModel extends Model
{
    use ModelSetup;

    protected $table = 'order_details';
    public function insert_order_detail()
    {
        $order_details = $this->__gets();
        if (empty($order_details)) {
            return false;
        }
        // Tạo placeholders và values từ mảng dữ liệu
        $placeholders = array_fill(0, count($order_details), '(?, ?, ?, ?, ?, ?)');
        $values = array_merge(...$order_details);
        $placeholders_string = implode(', ', $placeholders);
        $sql = "INSERT INTO order_details (pro_id, pro_variant_id,  order_id, name_variant, quantity, price) VALUES $placeholders_string";
        return $this->insert($sql, $values);
    }
    public function get_order_detail_by_order_id()
    {
        $sql = "SELECT D_o.id, D_o.name_variant, D_o.quantity, D_o.price, p.name, D_o.pro_id, D_o.is_reviewed, ";
        $sql .= "(SELECT url_image FROM pro_images WHERE pro_id = p.id LIMIT 1) as url_image ";
        $sql .= "FROM order_details D_o ";
        $sql .= "LEFT JOIN products p ON p.id = D_o.pro_id ";
        $sql .= "WHERE order_id = ? ";
        return $this->getAll($sql, [$this->__get('order_id')]);
    }

    public function get_order_detail_by_id()
    {
        $sql = "SELECT D_o.id, D_o.name_variant, p.name, D_o.pro_id, ";
        $sql .= "(SELECT url_image FROM pro_images WHERE pro_id = p.id LIMIT 1) as url_image ";
        $sql .= "FROM order_details D_o ";
        $sql .= "LEFT JOIN products p ON p.id = D_o.pro_id ";
        $sql .= "WHERE D_o.id = ? ";
        return $this->getOne($sql, [$this->__get('id')]);
    }

    public function update_status_rate()
    {
        $data = $this->__gets();
        $data_update = array_values($data);
        unset($data['id']);
        $assignments = array_keys($data);
        // array_walk() dùng để thay đổi giá trị từng phần tử trong mảng.
        // &$value có dấu & (tham chiếu), giúp thay đổi giá trị gốc trong $assignments.
        // Mỗi phần tử sẽ được gán lại thành "column =?".
        array_walk($assignments, function (&$value) {
            $value = "$value =?";
        });
        $assignments = implode(',', $assignments);
        return $this->saveUpdate($assignments, $data_update);
    }

}