<?php
namespace app\models;

use app\core\Model;
use app\models\ModelSetup;
class RateModel extends Model
{
    use ModelSetup;
    protected $table = 'rates';
    public function insert_rate()
    {
        $data = $this->__gets();
        $columns = implode(',', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $data_insert = array_values($data);
        return $this->save($columns, $placeholders, $data_insert);
    }

    public function get_rate_by_pro_id(): array
    {
        $params[] = $this->__get('pro_id');
        $item_page = (int) $this->__get('item_page');
        $offset = (int) (($this->__get('current_page') - 1) * $item_page);
        $rating = $this->__get('rating');

        $sql = "SELECT r.rating , r.review_text, u.name as name_user, r.name_variant, r.date_rate, GROUP_CONCAT(r_img.url_image) as url_images ";
        $sql .= "FROM rates r ";
        $sql .= "LEFT JOIN rate_images r_img ON r_img.rate_id = r.id ";
        $sql .= "LEFT JOIN users u ON u.id = r.user_id ";
        $sql .= "WHERE r.pro_id = ? ";
        if ($rating > 0) {
            $sql .= "AND r.rating = ? ";
            $params[] = $rating;
        }
        $sql .= "GROUP BY r.id ";
        $sql .= "ORDER BY r.id DESC ";

        // Áp dụng phân trang nếu có nhiều trang
        if ($this->__get('total_page') > 1) {
            $sql .= "LIMIT {$item_page} ";
            if ($offset >= 0) {
                $sql .= " OFFSET {$offset} ";
            }
        }
        return $this->getAll($sql, $params);
    }
    public function total_rate_handle_page()
    {
        $params[] = $this->__get('pro_id');
        $rating = (int) $this->__get('rating');
        $sql = "SELECT COUNT(*) as total FROM rates ";
        $sql .= "WHERE pro_id = ? ";
        if ($rating > 0) {
            $sql .= "AND rating = ?";
            $params[] = $rating;
        }
        return $this->getOne($sql, $params);
    }
    public function get_avg_rate_by_pro_id()
    {
        $sql = "SELECT SUM(rating) AS totalStars, COUNT(*) AS totalReviews ";
        $sql .= "FROM rates WHERE pro_id = ?";
        return $this->getOne($sql, [$this->__get('pro_id')]);
    }
}