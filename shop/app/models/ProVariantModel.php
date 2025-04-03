<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;
class ProVariantModel extends Model
{
    use ModelSetup;
    public function get_cor_size_by_pro_id()
    {
        $sql = 'SELECT p_v.url_image, a_v.name, p_v.cor_id, p_v.pro_id ';
        $sql .= 'FROM pro_variants p_v ';
        $sql .= 'JOIN attri_values a_v ON p_v.cor_id = a_v.id ';
        $sql .= 'WHERE p_v.cor_id IS NOT NULL AND p_v.size_id IS NOT NULL ';
        $sql .= 'AND p_v.pro_id = ? ';
        $sql .= 'GROUP BY p_v.url_image, a_v.name, p_v.cor_id, p_v.pro_id ';
        $sql .= 'ORDER BY a_v.name DESC';
        return $this->getAll($sql, [$this->__get('pro_id')]);
    }


    public function get_size_by_cor_id()
    {
        $sql = 'SELECT a_v.name, p_v.pro_id, p_v.cor_id, p_v.size_id, p_v.quantity FROM pro_variants p_v ';
        $sql .= 'JOIN attri_values a_v ON a_v.id = p_v.size_id ';
        $sql .= 'WHERE p_v.cor_id = ? ';
        $sql .= 'AND p_v.pro_id = ?';
        return $this->getAll($sql, [$this->__get('cor_id'), $this->__get('pro_id')]);
    }
    public function get_color_by_pro_id()
    {
        $sql = 'SELECT p_v.url_image,  a_v.name , p_v.cor_id, p_v.pro_id ';
        $sql .= 'FROM pro_variants p_v ';
        $sql .= 'JOIN attri_values a_v ON p_v.cor_id = a_v.id ';
        $sql .= 'WHERE p_v.cor_id IS NOT NULL AND p_v.size_id IS NULL ';
        $sql .= 'AND p_v.pro_id = ?';
        $sql .= 'GROUP BY p_v.url_image, a_v.name, p_v.cor_id, p_v.pro_id ';
        $sql .= 'ORDER BY a_v.name DESC';
        return $this->getAll($sql, [$this->__get('pro_id')]);
    }
    public function get_size_by_pro_id()
    {
        $sql = 'SELECT p_v.url_image,  a_v.name , p_v.cor_id, p_v.pro_id, p_v.size_id ';
        $sql .= 'FROM pro_variants p_v ';
        $sql .= 'JOIN attri_values a_v ON p_v.size_id = a_v.id ';
        $sql .= 'WHERE p_v.cor_id IS NULL AND p_v.size_id IS NOT NULL ';
        $sql .= 'AND p_v.pro_id = ?';
        $sql .= 'GROUP BY p_v.url_image, a_v.name, p_v.cor_id, p_v.pro_id, p_v.size_id ';
        $sql .= 'ORDER BY a_v.name ASC';
        return $this->getAll($sql, [$this->__get('pro_id')]);
    }
    public function get_quantity()
    {
        $sql = 'SELECT id, quantity FROM pro_variants WHERE 1 ';
        $conditions = [];
        $query = [];

        // Thêm điều kiện vào câu lệnh SQL và giá trị vào mảng query nếu có
        if ($this->__get('pro_id') > 0) {
            $conditions[] = 'pro_id = ?';
            $query[] = $this->__get('pro_id');
        }
        if ($this->__get('cor_id') > 0) {
            $conditions[] = 'cor_id = ?';
            $query[] = $this->__get('cor_id');
        }
        if ($this->__get('size_id') > 0) {
            $conditions[] = 'size_id = ?';
            $query[] = $this->__get('size_id');
        }
        // Nối các điều kiện lại với nhau
        if (!empty($conditions)) {
            $sql .= ' AND ' . implode(' AND ', $conditions);
        }
        return $this->getOne($sql, $query);
    }


    // //Xử lý bên admin 
    public function insert_variant_pro()
    {
        $sql = 'INSERT INTO pro_variants (pro_id, cor_id, size_id, url_image, quantity) VALUES (?,?,?,?,?)';
        return $this->insert($sql, $this->__gets());
    }
    public function get_all_variant_pro_id()
    {
        $sql = 'SELECT p_v.id, a_v_c.name as cor_name, a_v_s.name as size_name, ';
        $sql .= 'p_v.quantity, p_v.url_image  ';
        $sql .= 'FROM pro_variants p_v ';
        $sql .= 'LEFT JOIN attri_values a_v_c ON a_v_c.id = p_v.cor_id ';
        $sql .= 'LEFT JOIN attri_values a_v_s ON a_v_s.id = p_v.size_id ';
        $sql .= ' WHERE pro_id = ? ';
        $sql .= 'ORDER BY a_v_c.name DESC, a_v_s.name ASC';
        return $this->getAll($sql, [$this->__get('pro_id')]);
    }
    public function update_variant_pro()
    {
        $sql = 'UPDATE pro_variants SET quantity = ?, url_image = ? ';
        $sql .= 'WHERE id = ?';
        return $this->update($sql, $this->__gets());
    }
    public function delete_variant_by_pro_id()
    {
        $sql = 'DELETE FROM pro_variants WHERE pro_id = ?';
        return $this->delete($sql, [$this->__get('pro_id')]);
    }
    public function get_all_img_variant_by_pro_id()
    {
        $sql = 'SELECT url_image FROM pro_variants WHERE pro_id = ?';
        return $this->getAll($sql, [$this->__get('pro_id')]);
    }
    public function get_quantity_by_id()
    {
        $sql = 'SELECT id, quantity FROM pro_variants WHERE id = ?';
        return $this->getOne($sql, [$this->__get('id')]);
    }
}