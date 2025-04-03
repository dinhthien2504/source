<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;

class ProductModel extends Model
{
    use ModelSetup;
    protected $table = 'products';
    public function get_all_home($key = 'id', $method = 'DESC')
    {
        $sql = "SELECT pro.id, pro.name, pro.cate_id, ";
        $sql .= "pro.price, pro.discount_percent, pro.sell, ";
        $sql .= "(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro_img.pro_id = pro.id LIMIT 1) AS url_image ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE 1 ";
        $sql .= "AND pro.status = 0 ";
        $sql .= "ORDER BY pro.{$key} {$method} ";
        $sql .= "LIMIT 10 ";
        return $this->getAll($sql);
    }

    public function get_one_pro_by_id()
    {
        $sql = "SELECT pro.id as id, pro.name as name, pro.cate_id as cate_id, ";
        $sql .= "pro.price as price, pro.discount_percent as discount_percent, ";
        $sql .= "pro.sell as sell, pro.description as description, SUM(pro_v.quantity) as total_quantity, ";
        $sql .= "(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro_img.pro_id = pro.id LIMIT 1) AS url_image ";
        $sql .= "FROM products pro ";
        $sql .= "LEFT JOIN pro_variants pro_v ON pro_v.pro_id = pro.id ";
        $sql .= "WHERE pro.id = ? ";
        $sql .= "AND pro.status = 0 ";
        return $this->getOne($sql, [$this->__get('id')]);
    }

    public function get_pro_relate_by_cate_id()
    {
        $sql = "SELECT pro.id, pro.name, pro.cate_id, ";
        $sql .= "pro.price, pro.discount_percent, pro.sell, ";
        $sql .= "(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro_img.pro_id = pro.id LIMIT 1) AS url_image ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE pro.cate_id = ? ";
        $sql .= "AND pro.status = 0 ";
        $sql .= "AND pro.id != ? ";
        $sql .= "ORDER BY pro.id DESC ";
        $sql .= "LIMIT 6";
        return $this->getAll($sql, [$this->__get('cate_id'), $this->__get('id')]);
    }
    public function count_all_pro_by_cate_id()
    {
        $cate_id = $this->__get('cate_id');
        $query = [$this->__get('parent_id')];

        $sql = "SELECT count(pro.id) as total_pro ";
        $sql .= "FROM products pro ";
        $sql .= "LEFT JOIN categories cate ON pro.cate_id = cate.id ";
        $sql .= "WHERE cate.parent = ? ";
        if (!empty($cate_id)) {
            $sql .= "AND pro.cate_id = ? ";
            $query[] = $cate_id;
        }
        $sql .= "AND pro.status = 0 ";
        if (!empty($this->__get('filter'))) {
            $sql .= implode(' ', $this->__get('filter'), );
        }
        return $this->getOne($sql, $query);
    }
    public function get_all_pro_by_cate_id()
    {
        $item_page = $this->__get('item_page');
        $offset = ($this->__get('current_page') - 1) * $item_page;
        $cate_id = $this->__get('cate_id');
        $query = [$this->__get('parent_id')];

        $sql = "SELECT pro.id, pro.name, pro.cate_id, ";
        $sql .= "pro.price, pro.discount_percent, pro.sell, ";
        $sql .= "(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro_img.pro_id = pro.id LIMIT 1) AS url_image ";
        $sql .= "FROM products pro ";
        $sql .= "LEFT JOIN categories cate ON pro.cate_id = cate.id ";
        $sql .= "WHERE cate.parent = ? ";
        if (!empty($cate_id)) {
            $sql .= "AND pro.cate_id = ? ";
            $query[] = $cate_id;
        }
        $sql .= "AND pro.status = 0 ";
        if (!empty($this->__get('filter'))) {
            $sql .= implode(' ', $this->__get('filter'), );
        }
        if ($this->__get('total_page') > 1) {
            $sql .= "LIMIT " . $item_page . " ";
            if ($offset >= 0) {
                $sql .= " OFFSET " . $offset;
            }
        }
        return $this->getAll($sql, $query);
    }

    public function get_all_pro_by_keyword()
    {
        $item_page = $this->__get('item_page');
        $offset = ($this->__get('current_page') - 1) * $item_page;
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = "SELECT pro.id, pro.name, pro.cate_id, ";
        $sql .= "pro.price, pro.discount_percent, pro.sell, ";
        $sql .= "(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro_img.pro_id = pro.id LIMIT 1) AS url_image ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE pro.name like ? ";
        $sql .= "AND pro.status = 0 ";
        if (!empty($this->__get('filter'))) {
            $sql .= implode(' ', $this->__get('filter'), );
        }
        if ($this->__get('total_page') > 1) {
            $sql .= "LIMIT " . $item_page . " ";
            if ($offset >= 0) {
                $sql .= " OFFSET " . $offset;
            }
        }
        return $this->getAll($sql, [$keyword]);
    }

    public function count_all_pro_by_keyword()
    {
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = "SELECT count(pro.id) as total_pro ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE pro.name like ? ";
        $sql .= "AND pro.status = 0 ";
        if (!empty($this->__get('filter'))) {
            $sql .= implode(' ', $this->__get('filter'), );
        }
        return $this->getOne($sql, [$keyword]);
    }


    //Xử lý bên admin
    public function get_all_pro_admin()
    {
        $item_page = $this->__get('item_page');
        $offset = ($this->__get('current_page') - 1) * $item_page;
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = 'SELECT pro.id, pro.name, pro.price, pro.discount_percent, pro.sell, IFNULL(SUM(p_v.quantity), 0) as total_quantity, pro.status, ';
        $sql .= '(SELECT pro_img.url_image FROM pro_images pro_img WHERE pro.id = pro_img.pro_id LIMIT 1) as url_image, ';
        $sql .= '(SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    "cor_name", a_v_c.name, 
                    "size_name", a_v_s.name,
                    "url_image", p_v.url_image,
                    "quantity", IFNULL(p_v.quantity, 0),
                    "sell", p_v.sell
                )
            )) as variants ';
        $sql .= 'FROM products pro ';
        $sql .= 'LEFT JOIN pro_variants p_v ON pro.id = p_v.pro_id ';
        $sql .= 'LEFT JOIN attri_values a_v_c ON a_v_c.id = p_v.cor_id ';
        $sql .= 'LEFT JOIN attri_values a_v_s ON a_v_s.id = p_v.size_id ';
        $sql .= 'WHERE 1 ';
        $sql .= 'AND pro.name LIKE ? ';
        $sql .= 'GROUP BY pro.id ';
        $sql .= 'ORDER BY id DESC ';
        $sql .= 'LIMIT ' . $item_page . ' OFFSET ' . $offset;
        return $this->getAll($sql, [$keyword]);
    }
    public function get_pro_by_id_admin()
    {
        $sql = 'SELECT pro.id, pro.cate_id, pro.name, pro.price, pro.discount_percent, pro.sell, pro.description ';
        $sql .= 'FROM products pro ';
        $sql .= 'WHERE 1 ';
        $sql .= 'AND pro.id = ? ';
        return $this->getOne($sql, [$this->__get('pro_id')]);
    }
    public function insert_pro()
    {
        $sql = 'INSERT INTO products (cate_id, name, price, discount_percent, description, status) ';
        $sql .= 'VALUES (?,?,?,?,?,?)';
        return $this->insert($sql, $this->__gets());
    }
    public function update_pro()
    {
        $sql = 'UPDATE products SET cate_id = ?, name = ?, price = ?, discount_percent = ?, description = ?, status = ? ';
        $sql .= 'WHERE id = ?';
        return $this->update($sql, $this->__gets());
    }
    public function delete_pro()
    {
        $sql = 'DELETE FROM products WHERE id = ?';
        return $this->delete($sql, [$this->__get('pro_id')]);
    }
    public function get_pro_by_cate_id()
    {
        $sql = 'SELECT id ';
        $sql .= 'FROM products ';
        $sql .= 'WHERE 1 ';
        $sql .= 'AND cate_id = ? ';
        return $this->getOne($sql, [$this->__get('cate_id')]);
    }

    public function total_pro_handle_page()
    {
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = "SELECT COUNT(*) as total FROM products ";
        $sql .= "WHERE 1 ";
        $sql .= "AND name LIKE ?";
        return $this->getOne($sql, [$keyword]);
    }
    public function total_pro_admin()
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        return $this->getOne($sql);
    }

    public function get_pro_by_cate_dashboard()
    {
        $sql = "SELECT cate.id as cate_id,  cate.name as cate_name, count(pro.id) as quantity FROM products pro ";
        $sql .= "LEFT JOIN categories cate ON cate.id = pro.cate_id ";
        $sql .= "GROUP BY cate.id ORDER BY cate.id DESC";
        return $this->getAll($sql);
    }
}