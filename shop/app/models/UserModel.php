<?php
namespace app\models;
use app\core\Model;
use app\models\ModelSetup;
class UserModel extends Model
{
    use ModelSetup;
    protected $table = 'users';
    public function get_user_login()
    {
        $sql = 'SELECT * FROM users ';
        $sql .= 'WHERE email = ? ';
        $sql .= 'AND status = 0 ';
        return $this->getOne($sql, [$this->__get('email')]);
    }
    public function insert_register()
    {
        $sql = 'INSERT INTO users(name, email, password) VALUES (?, ?, ?)';
        return $this->insert($sql, $this->__gets());
    }
    public function update_order_user()
    {
        $sql = 'UPDATE users SET name = ?,phone = ?, address = ?, address_detail = ? ';
        $sql .= 'WHERE id = ?';
        return $this->update($sql, $this->__gets());
    }

    //Admin
    public function get_all_user_admin()
    {
        $item_page = $this->__get('item_page');
        $offset = ($this->__get('current_page') - 1) * $item_page;
        $keyword = "'%" . $this->__get('keyword') . "%' ";
        $user_id = $this->__get('id');
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE 1 ";
        $sql .= "AND name LIKE {$keyword} ";
        $sql .= "AND id != ? ";
        $sql .= "ORDER BY id DESC ";
        $sql .= "LIMIT {$item_page} OFFSET {$offset}";
        return $this->getAll($sql, [$user_id]);
    }
    public function insert_user_admin()
    {
        $sql = 'INSERT INTO users(name, email, password, role) VALUES (?,?,?,?)';
        return $this->insert($sql, $this->__gets());
    }
    public function get_user_by_id()
    {
        $sql = 'SELECT * FROM users WHERE id =?';
        return $this->getOne($sql, [$this->__get('id')]);
    }
    public function update_user()
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
        $sql = "UPDATE users SET $assignments WHERE id = ?";
        return $this->update($sql, $data_update);
    }
    public function delete_user()
    {
        $sql = 'DELETE FROM users WHERE id =?';
        return $this->delete($sql, [$this->__get('id')]);
    }

    public function delete_user_groups()
    {
        $data = $this->__gets();
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "DELETE FROM users WHERE id IN (" . $placeholders . ")";
        return $this->delete($sql, $data);
    }
    public function total_user_handle_page()
    {
        $keyword = '%' . $this->__get('keyword') . '%';
        $user_id = $this->__get('id');
        $sql = "SELECT COUNT(*) as total FROM users ";
        $sql .= "WHERE 1 ";
        $sql .= "AND name LIKE ?";
        $sql .= "AND id != ? ";
        return $this->getOne($sql, [$keyword, $user_id]);
    }
}