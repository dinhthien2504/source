<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;
class CategoryModel extends Model
{
    use ModelSetup;
    protected $table = 'categories';
    public function get_all_parent()
    {
        $sql = "SELECT id, name, url_image ";
        $sql .= "FROM categories ";
        $sql .= "WHERE 1 ";
        $sql .= "AND parent = 0 ";
        $sql .= "AND status = 0";
        return $this->getAll($sql);
    }

    public function get_all_cate_by_parent_id()
    {
        $sql = "SELECT id, name, parent ";
        $sql .= "FROM categories ";
        $sql .= "WHERE 1 ";
        $sql .= "AND parent = ? ";
        return $this->getAll($sql, [$this->__get('parent_id')]);
    }

    public function get_one_cate_parent()
    {
        $sql = "SELECT cate.id as cate_id ,cate.name as chirld_name, cate.parent as parent_id, ";
        $sql .= "(SELECT name FROM categories WHERE id = cate.parent) as parent_name ";
        $sql .= "FROM categories cate ";
        $sql .= "WHERE 1 ";
        $sql .= "AND cate.id = ? ";
        $sql .= "AND cate.status = 0";
        return $this->getOne($sql, [$this->__get('cate_id')]);
    }

    //Xử lý bên admin
    public function get_all_cate_parent_admin()
    {
        $sql = 'SELECT id, name ';
        $sql .= 'FROM categories ';
        $sql .= 'WHERE 1 ';
        $sql .= 'AND parent = 0 ';
        $sql .= 'ORDER BY id DESC';
        return $this->getAll($sql);
    }
    public function get_all_cate_parent_edit()
    {
        $sql = 'SELECT id, name ';
        $sql .= 'FROM categories ';
        $sql .= 'WHERE id != ? ';
        $sql .= 'AND parent = 0 ';
        $sql .= 'ORDER BY id DESC';
        return $this->getAll($sql, [$this->__get('id')]);
    }
    public function get_cate_by_cate_id()
    {
        $sql = 'SELECT c.parent as parent_id, c.id as chirld_id, c.name as chirld_name, ';
        $sql .= '(SELECT name FROM categories WHERE id = c.parent ) as parent_name ';
        $sql .= 'FROM categories c ';
        $sql .= 'WHERE c.id = ?';
        return $this->getOne($sql, [$this->__get('cate_id')]);
    }
    public function get_all_cate_show_admin()
    {
        $item_page = $this->__get('item_page');
        $offset = ($this->__get('current_page') - 1) * $item_page;
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = "SELECT p.id, p.name, p.url_image, p.status, ";

        $sql .= "(SELECT CONCAT('[', GROUP_CONCAT(
                            JSON_OBJECT(
                                'id', c.id, 
                                'name', c.name, 
                                'url_image', c.url_image
                            )
                        ), ']') 
                FROM categories c WHERE c.parent = p.id) AS children ";
        $sql .= "FROM categories p ";
        $sql .= "WHERE p.parent = 0 ";
        $sql .= "AND p.name LIKE ? ";
        $sql .= "ORDER BY p.id DESC ";
        $sql .= "LIMIT {$item_page} OFFSET {$offset}";
        $rows = $this->getAll($sql, [$keyword]);
        // Chuyển chuỗi JSON thành mảng PHP
        foreach ($rows as &$row) {
            $row['children'] = !empty($row['children']) ? json_decode($row['children'], true) : [];
        }

        // Trả về dữ liệu JSON
        return $rows;

    }

    public function save_cate()
    {
        $sql = "INSERT INTO categories (name, parent, url_image) VALUES (?,?,?)";
        return $this->insert($sql, $this->__gets());
    }
    public function delete_cate()
    {
        $img = $this->get_img_by_cate_id($this->__get('parent_id'));
        $file_path = dirname(__DIR__, 2) . '/public/assets/img/cate/' . $img['url_image'];
        $sql = "DELETE FROM categories WHERE id =?";
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        return $this->delete($sql, [$this->__get('parent_id')]);
    }
    public function get_img_by_cate_id($cate_id)
    {
        $sql = "SELECT url_image FROM categories WHERE id =?";
        return $this->getOne($sql, [$cate_id]);
    }
    public function total_cate_handle_page()
    {
        $keyword = '%' . $this->__get('keyword') . '%';
        $sql = "SELECT COUNT(*) as total FROM categories ";
        $sql .= "WHERE parent = 0 ";
        $sql .= "AND name LIKE ?";
        return $this->getOne($sql, [$keyword]);
    }
    public function get_one_cate_by_id()
    {
        $sql = "SELECT * FROM categories WHERE id =?";
        return $this->getOne($sql, [$this->__get('id')]);
    }
    public function update_cate()
    {
        $sql = "UPDATE categories SET name =?, parent =?, url_image =? WHERE id =?";
        return $this->update($sql, $this->__gets());
    }

}