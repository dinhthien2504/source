<?php
class ProductModel
{
    private $id = null;
    private $subCategory_id = null;
    private $name = "";
    private $price = 0;
    private $discount_percent = 0;
    private $detail = "";
    private $views = 0;
    private $sales = 0;
    private $status = 0;
    private $size_id;
    private $quantity;
    private $image;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSubCategory_id($subCategory_id)
    {
        return $this->subCategory_id = $subCategory_id;
    }
    public function getSubCategory_id()
    {
        return $this->subCategory_id;
    }
    public function setName($name)
    {
        return $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPrice($price)
    {
        return $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setDiscount_percent($discount_percent)
    {
        return $this->discount_percent = $discount_percent;
    }
    public function getDiscount_percent()
    {
        return $this->discount_percent;
    }
    public function setDetail($detail)
    {
        return $this->detail = $detail;
    }
    public function getDetail()
    {
        return $this->detail;
    }
    public function setViews($views)
    {
        return $this->views = $views;
    }
    public function getViews()
    {
        return $this->views;
    }
    public function setSales($sales)
    {
        return $this->sales = $sales;
    }
    public function getSales()
    {
        return $this->sales;
    }
    public function setStatus($status)
    {
        return $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setSizeId($size_id)
    {
        return $this->size_id = $size_id;
    }
    public function getSizeId()
    {
        return $this->size_id;
    }

    public function setQuantity($quantity)
    {
        return $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setImage($image)
    {
        return $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function getAllPro($method, $item_per_page, ProductModel $sp, $keyword = null, $current_page = null, $filter = 'DESC'): array
    {
        $offset = ($current_page - 1) * $item_per_page;
        $sql = "SELECT pro.*, (SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = pro.id LIMIT 1) AS img";
        $sql .= " FROM products pro";
        if ($keyword != null) {
            $sql .= " WHERE pro.name LIKE '%" . $keyword . "%'";
        } else {
            $sql .= " WHERE 1";
        }
        if ($sp->getSubCategory_id() != null) {
            $sql .= " AND pro.subcategory_id = " . $sp->getSubCategory_id();
        }
        $sql .= " AND pro.status = 0";
        $sql .= " ORDER BY pro." . $method . " " . $filter . "";
        $sql .= " LIMIT " . $item_per_page;
        if ($offset > 0) {
            $sql .= " OFFSET " . $offset;
        }
        return $this->db->getAll($sql);
    }
    public function getAllProRalate(ProductModel $sp)
    {
        $sql = "SELECT pro.*, (SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = pro.id LIMIT 1) AS img ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE subcategory_id = ? ";
        $sql .= "AND id != ? ";
        $sql .= "AND status = 0 ";
        $sql .= "ORDER BY id DESC ";
        $sql .= "LIMIT 4";
        return $this->db->getAll($sql, [$sp->getSubCategory_id(), $sp->getId()]);
    }
    public function countProByIdSubCate(ProductModel $sp)
    {
        $sql = "SELECT count(*) as total FROM products";
        $sql .= " WHERE products.subCategory_id = ?";
        return $this->db->getOne($sql, [$sp->getSubCategory_id()]);
    }
    public function getOnePro(ProductModel $sp)
    {
        $sql = "SELECT pro.*, Dsize.quantity as quantity, (SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = pro.id LIMIT 1) AS img ";
        $sql .= " FROM products pro JOIN size_details Dsize ON pro.id = Dsize.product_id ";
        $sql .= " WHERE pro.id = ?";
        return $this->db->getOne($sql, [$sp->getId()]);
    }
    public function getImgByIdPro(ProductModel $sp)
    {
        $sql = "SELECT image FROM productimages ";
        $sql .= "WHERE product_id = ?";
        return $this->db->getAll($sql, [$sp->getId()]);
    }
    public function getSize(ProductModel $sp)
    {
        $sql = "SELECT sizeD.*, S.name as name, S.id as id ";
        $sql .= "FROM size_details sizeD JOIN sizes S ON sizeD.size_id = S.id ";
        $sql .= "WHERE sizeD.product_id = ? ";

        return $this->db->getAll($sql, [$sp->getId()]);
    }

    // public function addPro(ProductModel $sp)
    // {
    //     $sql = "INSERT INTO products (name, subCategory_id, price, discount_percent, detail) VALUES (?, ?, ?, ?, ?)";
    //     return $this->db->insert($sql, [$sp->getName(), $sp->getSubCategory_id(), $sp->getPrice(), $sp->getDiscount_percent(), $sp->getDetail()]);
    // }

    public function addPro(ProductModel $sp)
    {
        // Thêm sản phẩm vào bảng `products`
        $sql = "INSERT INTO products (name, subcategory_id, price, discount_percent, detail) VALUES (?, ?, ?, ?, ?)";
        echo "Đang thêm sản phẩm...\n";
        $this->db->insert($sql, [
            $sp->getName(),
            $sp->getSubCategory_id(),
            $sp->getPrice(),
            $sp->getDiscount_percent(),
            $sp->getDetail()
        ]);
        echo "Sản phẩm đã được thêm.\n";

        // Lấy ID của sản phẩm vừa thêm
        $productId = $this->db->getLastInsertId();
        if (!$productId) {
            echo "Không lấy được ID sản phẩm vừa thêm!\n";
            die(); // Dừng chương trình nếu không lấy được ID
        }
        echo "Product ID: $productId\n";

        // Lấy danh sách các size từ bảng `sizes`
        $sqlSizes = "SELECT id FROM sizes";
        $sizes = $this->db->getAll($sqlSizes);
        echo "Danh sách sizes: " . print_r($sizes, true) . "\n";

        // Chèn mỗi size với số lượng mặc định là 0 vào bảng `size_details`
        $sqlInsertSizes = "INSERT INTO size_details (product_id, size_id, quantity) VALUES (?, ?, ?)";
        foreach ($sizes as $size) {
            echo "Đang thêm size_id: " . $size['id'] . " vào size_details.\n";
            $this->db->insert($sqlInsertSizes, [$productId, $size['id'], 0]);
            echo "Size " . $size['id'] . " đã được thêm.\n";
        }

        return $productId; // Trả về ID sản phẩm vừa tạo
    }


    public function updateQuantity(ProductModel $sp)
    {
        $sql = "UPDATE size_details SET quantity = ? WHERE product_id = ? AND size_id = ?";
        return $this->db->insert($sql, [$sp->getQuantity(), $sp->getId(), $sp->getSizeId()]);
    }


    public function uploadAndSaveImages(ProductModel $sp, $files)
    {
        // Đường dẫn thư mục lưu ảnh
        $uploadDir = '/public/assets/img/';

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Mảng lưu đường dẫn các ảnh đã tải lên
        $uploadedImages = [];

        try {
            // Duyệt qua từng ảnh trong mảng $_FILES
            foreach ($files['name'] as $index => $fileName) {
                // Lấy thông tin file
                $file = [
                    'name' => $fileName,
                    'type' => $files['type'][$index],
                    'tmp_name' => $files['tmp_name'][$index],
                    'error' => $files['error'][$index],
                    'size' => $files['size'][$index]
                ];

                // Tạo tên tệp duy nhất
                $uniqueFileName = uniqid() . '_' . basename($file['name']);
                $targetFile = $uploadDir . $uniqueFileName;

                // Kiểm tra kích thước file (Ví dụ giới hạn 5MB)
                $maxFileSize = 5 * 1024 * 1024; // 5MB
                if ($file['size'] > $maxFileSize) {
                    throw new Exception("Kích thước file " . $file['name'] . " vượt quá giới hạn (5MB).");
                }

                // Kiểm tra kiểu file (Ví dụ chỉ cho phép ảnh JPG, PNG, GIF)
                $allowedTypes = ['image/jpg', 'image/png', 'image/gif'];
                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception("Chỉ cho phép tải ảnh JPG, PNG, GIF. Ảnh " . $file['name'] . " không hợp lệ.");
                }

                // Di chuyển tệp
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    // Lưu đường dẫn ảnh vào cơ sở dữ liệu
                    $sql = "INSERT INTO productimages (product_id, image) VALUES (?, ?)";
                    $this->db->insert($sql, [$sp->getId(), $targetFile]);

                    // Thêm vào mảng các ảnh đã tải lên
                    $uploadedImages[] = $targetFile;
                } else {
                    throw new Exception("Không thể di chuyển tệp " . $file['name'] . ".");
                }
            }

            // Trả về mảng các ảnh đã tải lên
            return $uploadedImages;
        } catch (Exception $e) {
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }




    public function deletePro(ProductModel $sp)
    {
        $this->db->beginTransaction(); // Bắt đầu transaction để đảm bảo tính toàn vẹn

        try {
            // 1. Lấy danh sách hình ảnh liên quan và xóa khỏi thư mục
            $images = $this->getImgByIdPro($sp);
            foreach ($images as $image) {
                $imagePath = _DIR_ROOT . '/' . $image['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file khỏi hệ thống
                }
            }

            // Xóa hình ảnh trong database
            $sql = "DELETE FROM productimages WHERE product_id = ?";
            $this->db->delete($sql, [$sp->getId()]);

            // 2. Xóa size liên quan trong bảng size_details
            $sql = "DELETE FROM size_details WHERE product_id = ?";
            $this->db->delete($sql, [$sp->getId()]);

            // 3. Xóa sản phẩm trong bảng products
            $sql = "DELETE FROM products WHERE id = ?";
            $this->db->delete($sql, [$sp->getId()]);

            $this->db->commit(); // Hoàn tất transaction
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Quay lại trạng thái trước transaction nếu lỗi
            return false;
        }
    }

    public function updatePro(ProductModel $sp)
    {

        $sql = "UPDATE products SET 
                    name = ?, 
                    subcategory_id = ?, 
                    price = ?, 
                    discount_percent = ?, 
                    detail = ?
                WHERE id = ?";
        $this->db->update($sql, [
            $sp->getName(),
            $sp->getSubCategory_id(),
            $sp->getPrice(),
            $sp->getDiscount_percent(),
            $sp->getDetail(),
            $sp->getId()
        ]);
    }

    public function changeStatusPro(ProductModel $sp)
    {
        $sql = "UPDATE products SET status = ? WHERE id = ?";
        return $this->db->update($sql, [$sp->getStatus(), $sp->getId()]);
    }

    public function getProForSubCate()
    {
        $sql = "SELECT pro.*, sub.name as subCate_name, sub.id as subCate_id ";
        $sql .= "FROM products pro JOIN subcategories sub ";
        $sql .= "ON pro.subcategory_id = sub.id ";
        $sql .= "WHERE 1 ";
        $sql .= "ORDER BY pro.id DESC";
        return $this->db->getAll($sql);
    }

    public function getAllSize()
    {
        $sql = "SELECT * FROM sizes";
        return $this->db->getAll($sql);
    }

    public function getQuantitySize(ProductModel $sp)
    {
        $sql = "SELECT quantity FROM size_details WHERE product_id = ? AND size_id = ?";
        return $this->db->getOne($sql, [$sp->getId(), $sp->getSizeId()]);
    }

    public function getProByCateDashboard()
    {
        $sql = "SELECT cate.id as idCate,  cate.name as nameCate, count(pro.id) as quantity FROM products pro ";
        $sql .= "LEFT JOIN subcategories Scate ON Scate.id = pro.subcategory_id ";
        $sql .= "LEFT JOIN categories cate ON cate.id = Scate.category_id ";
        $sql .= "GROUP BY cate.id ORDER BY cate.id desc";
        return $this->db->getAll($sql);
    }

    public function updateSalePro(ProductModel $sp)
    {
        $sql = "UPDATE products SET sales = sales + ? ";
        $sql .= "WHERE id = ? ";
        $this->db->update($sql, [$sp->getSales(), $sp->getId()]);
    }

    public function getFavor(ProductModel $sp)
    {
        $sql = "SELECT pro.name as name, pro.id as id, ";
        $sql .= "(SELECT proImg.image FROM productimages proImg WHERE proImg.product_id = pro.id LIMIT 1) AS img ";
        $sql .= "FROM products pro ";
        $sql .= "WHERE pro.id = ? ";
        return $this->db->getOne($sql, [$sp->getId()]);
    }
    public function countPro()
    {
        $sql = "SELECT count(*) as quantityPro FROM products";
        return $this->db->getOne($sql);
    }
}
