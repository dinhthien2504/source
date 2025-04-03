<?php
class RateModel
{
    private $id;
    private $user_id;
    private $product_id;
    private $review_text;
    private $name_size;
    private $rating = 0;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUser_id()
    {
        return $this->user_id;
    }
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }
    public function getProduct_id()
    {
        return $this->product_id;
    }
    public function setReview_text($review_text)
    {
        $this->review_text = $review_text;
    }
    public function getReview_text()
    {
        return $this->review_text;
    }
    public function setName_size($name_size)
    {
        $this->name_size = $name_size;
    }
    public function getName_size()
    {
        return $this->name_size;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function insertRate(RateMOdel $rate)
    {
        $sql = "INSERT INTO rates (user_id, product_id, review_text, name_size, rating) VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [$rate->getUser_id(), $rate->getProduct_id(), $rate->getReview_text(), $rate->getName_size(),$rate->getRating()]);
    }
    public function getRateByIdProAndIdUser(RateModel $rate): array
    {
        $sql = "SELECT r.rating as rating, r.review_text as review, u.name as userName, u.image as imgUser, r.name_size as name_size, r.date_rate as date, GROUP_CONCAT(rImg.img) as imgRate ";
        $sql .= "FROM rates r ";
        $sql .= "LEFT JOIN rateImages rImg ON rImg.rate_id = r.id ";
        $sql .= "LEFT JOIN products pro ON pro.id = r.product_id ";
        $sql .= "LEFT JOIN users u ON u.id = r.user_id ";
        $sql .= "WHERE r.product_id = ? ";
        if ($rate->getRating() > 0) {
            $sql .= "AND r.rating = " . $rate->getRating();
        }
        $sql .= " GROUP BY r.rating ,  r.review_text, r.date_rate ";
        $sql .= "ORDER BY r.id DESC";
        return $this->db->getAll($sql, [$rate->getProduct_id()]);
    }
    public function getAvgRate(RateModel $rate)
    {
        $sql = "SELECT SUM(rating) AS totalStars, COUNT(*) AS totalReviews ";
        $sql .= "FROM rates WHERE product_id = ?";
        return $this->db->getOne($sql, [$rate->getProduct_id()]);
    }
    public function countRate(RateModel $rate, $rating = 5)
    {
        $sql = "SELECT count(*) as totalRate FROM rates ";
        $sql .= "WHERE product_id = ?";
        $sql .= "AND rating = " . $rating;
        return $this->db->getOne($sql, [$rate->getProduct_id()]);
    }

    public function getRateByPro()
    {
        $sql = "
            SELECT 
                p.id AS product_id,
                p.name AS product_name,
                COUNT(r.id) AS total_comments,
                MAX(r.date_rate) AS latest_comment_date,
                MIN(r.date_rate) AS oldest_comment_date
            FROM 
                products p
            LEFT JOIN 
                rates r ON p.id = r.product_id
            GROUP BY 
                p.id, p.name
            HAVING 
                total_comments > 0
        ";

        return $this->db->getAll($sql);
    }

    public function getCommentsWithImagesByProductId(RateModel $rate)
    {
        $sql = "
        SELECT 
            r.id AS comment_id,
            r.user_id,
            u.name AS user_name,
            r.review_text,
            r.rating,
            r.date_rate,
            GROUP_CONCAT(rImg.img) AS comment_images
        FROM 
            rates r
        LEFT JOIN 
            rateimages rImg ON rImg.rate_id = r.id
        LEFT JOIN 
            users u ON u.id = r.user_id
        WHERE 
            r.product_id = ?
        GROUP BY 
            r.id, r.user_id, u.name, r.review_text, r.rating, r.date_rate
        ORDER BY 
            r.date_rate DESC
        ";

        return $this->db->getAll($sql, [$rate->getProduct_id()]);
    }

    public function deleteCommentAndImages(RateModel $rate)
    {
        // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
        $this->db->beginTransaction();

        try {
            // Lấy danh sách các ảnh liên quan đến bình luận từ cơ sở dữ liệu
            $getImagesSql = "SELECT img FROM rateimages WHERE rate_id = ?";
            $images = $this->db->getAll($getImagesSql, [$rate->getId()]);

            // Nếu không có ảnh nào, tiếp tục xóa bình luận
            if (empty($images)) {
                echo "Không có ảnh nào liên quan.";
            }

            // Xóa các tệp ảnh thực tế khỏi hệ thống tệp
            foreach ($images as $image) {
                $imagePath = _DIR_ROOT . '/' . $image['img'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa ảnh khỏi hệ thống tệp
                }
            }

            // Xóa tất cả các ảnh liên quan đến bình luận khỏi cơ sở dữ liệu
            $deleteImagesSql = "DELETE FROM rateimages WHERE rate_id = ?";
            $this->db->query($deleteImagesSql, [$rate->getId()]);

            // Xóa bình luận khỏi bảng rates
            $deleteCommentSql = "DELETE FROM rates WHERE id = ?";
            $this->db->query($deleteCommentSql, [$rate->getId()]);

            // Cam kết giao dịch nếu mọi thứ đều ổn
            $this->db->commit();

            return true; // Xóa thành công
        } catch (Exception $e) {
            // Rollback nếu có lỗi xảy ra
            $this->db->rollback();
            echo 'Lỗi: ' . $e->getMessage(); // In ra lỗi nếu có
            return false; // Thất bại
        }
    }

    public function getProductNameById(RateModel $rate)
    {
        $sql = "SELECT name FROM products WHERE id = ?";
        $result = $this->db->getOne($sql, [$rate->getProduct_id()]);  // Hàm getOne sẽ trả về một dòng duy nhất (tên sản phẩm)
        if (is_array($result)) {
            // Trường hợp trả về mảng, lấy tên sản phẩm từ mảng
            return $result['name'];  // Hoặc xử lý theo cách của bạn
        }
        
        return $result;  // Trả về tên sản phẩm nếu là chuỗi
    }
    public function countRateAdmin() {
        $sql = "SELECT count(*) as quantityRate FROM rates";
        return $this->db->getOne($sql);
    }
}
