<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;
class CartModel extends Model
{
    use ModelSetup;
    public function get_all_cart_by_user_id()
    {
        $sql = 'SELECT pro_v.pro_id, pro.name as name_pro, pro.price, pro.discount_percent, ';
        $sql .= '(SELECT url_image FROM pro_images WHERE pro_id = pro_v.pro_id LIMIT 1) as url_image, ';
        $sql .= 'GROUP_CONCAT( JSON_OBJECT( "cart_id", carts.id,"name_cor", a_v_c.name, "name_size", a_v_s.name, "url_image", pro_v.url_image, "quantity", carts.quantity, "quantity_stock", pro_v.quantity)) AS variants  ';
        $sql .= 'FROM carts ';
        $sql .= 'LEFT JOIN pro_variants pro_v ON pro_v.id = carts.pro_variant_id ';
        $sql .= 'LEFT JOIN attri_values a_v_c ON a_v_c.id = pro_v.cor_id ';
        $sql .= 'LEFT JOIN attri_values a_v_s ON a_v_s.id = pro_v.size_id ';
        $sql .= 'LEFT JOIN products pro ON pro.id = pro_v.pro_id ';
        $sql .= 'WHERE user_id = ? ';
        $sql .= 'GROUP BY pro_v.pro_id ';
        $sql .= 'ORDER BY MAX(carts.id) DESC';
        return $this->getAll($sql, [$this->__get('user_id')]);
    }
    public function get_all_cart_by_user_id_header()
    {
        $sql = 'SELECT pro_v.pro_id, MAX(pro.name) as name_pro, MAX(pro.price) as price, ';
        $sql .= '(SELECT url_image FROM pro_images WHERE pro_id = pro_v.pro_id LIMIT 1) as url_image ';
        $sql .= 'FROM carts ';
        $sql .= 'LEFT JOIN pro_variants pro_v ON pro_v.id = carts.pro_variant_id ';
        $sql .= 'LEFT JOIN products pro ON pro.id = pro_v.pro_id ';
        $sql .= 'WHERE user_id = ? ';
        $sql .= 'GROUP BY pro_v.pro_id ';
        $sql .= 'ORDER BY MAX(carts.id) DESC';
        return $this->getAll($sql, [$this->__get('user_id')]);

    }
    public function get_all_cart_by_cart_id()
    {
        $cart_ids = $this->__gets();
        // Chuyển mảng cart_id thành chuỗi các giá trị ngăn cách bằng dấu phẩy
        $placeholders = implode(',', array_fill(0, count($cart_ids), '?'));
        $sql = 'SELECT pro_v.pro_id, pro.name as name_pro, pro.price, pro.discount_percent, ';
        $sql .= '(SELECT url_image FROM pro_images WHERE pro_id = pro_v.pro_id LIMIT 1) as url_image, ';
        $sql .= 'GROUP_CONCAT( JSON_OBJECT( "cart_id", carts.id,"name_cor", a_v_c.name, "name_size", a_v_s.name, "url_image", pro_v.url_image, "quantity", carts.quantity, "quantity_stock", pro_v.quantity, "pro_variant_id", pro_v.id)) AS variants  ';
        $sql .= 'FROM carts ';
        $sql .= 'LEFT JOIN pro_variants pro_v ON pro_v.id = carts.pro_variant_id ';
        $sql .= 'LEFT JOIN attri_values a_v_c ON a_v_c.id = pro_v.cor_id ';
        $sql .= 'LEFT JOIN attri_values a_v_s ON a_v_s.id = pro_v.size_id ';
        $sql .= 'LEFT JOIN products pro ON pro.id = pro_v.pro_id ';
        $sql .= 'WHERE carts.id IN (' . $placeholders . ') ';
        $sql .= 'GROUP BY pro_v.pro_id';
        return $this->getAll($sql, $cart_ids);
    }

    public function insert_cart()
    {
        $sql = 'INSERT INTO carts (user_id, pro_variant_id, quantity) VALUES (?,?,?)';
        return $this->insert($sql, [$this->__get('user_id'), $this->__get('pro_variant_id'), $this->__get('quantity')]);
    }
    public function check_cart()
    {
        $sql = 'SELECT id, quantity FROM carts WHERE user_id = ? AND pro_variant_id = ?';
        return $this->getOne($sql, [$this->__get('user_id'), $this->__get('pro_variant_id')]);
    }
    public function update_cart()
    {
        $sql = 'UPDATE carts SET quantity =? WHERE id =?';
        return $this->update($sql, [$this->__get('quantity_new'), $this->__get('id')]);
    }
    public function delete_cart()
    {
        $ids = $this->__gets();
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "DELETE FROM carts WHERE id IN ($placeholders)";
            return $this->delete($sql, $ids);
        }
        return false;
    }

}