<?php
class Product extends Controller
{

    public $product_model;
    public $subCategory_model;
    public $category_model;
    public $image_model;
    public $data = [];
    public function __construct()
    {
        $this->product_model = $this->model('ProductModel');

        $this->subCategory_model = $this->model('SubCategoryModel');

        $this->category_model = $this->model('CategoryModel');

        $this->image_model = $this->model('ImageModel');
    }

    public function index()
    {
        if (isset($_POST['categoryIdDr'])) {
            $this->getSubcategoriesByCategoryId();
        }

        if (isset($_POST['subCategoryIdDr'])) {
            $this->getCategoryBySubCategoryId();
        }

        if (isset($_POST['nameAdd'])) {
            $this->addPro();
        }

        if (isset($_POST['idStatus'])) {
            $this->changeStatusPro();
        }

        if (isset($_POST['idDelete'])) {
            $this->deletePro();
        }

        if (isset($_POST['idShow'])) {
            $this->showEditModal();
        }

        if (isset($_POST['idEdit'])) {
            $this->updatePro();
        }

        if (isset($_POST['product_idS'])) {
            $this->showQuantityEdit();
        }

        if (isset($_POST['idSE'])) {
            $this->updateQuantity();
        }

        $listPro = $this->product_model->getProForSubCate();
        $listCate = $this->category_model->getAllCate();
        $listSubCate = $this->subCategory_model->getAllSubCate();
        $listSize = $this->product_model->getAllSize();
        $this->data['sub_content']['dataPro'] = $listPro;
        $this->data['sub_content']['dataCate'] = $listCate;
        $this->data['sub_content']['dataSubCate'] = $listSubCate;
        $this->data['sub_content']['dataSize'] = $listSize;
        $this->data['page_title'] = 'BLAZE-Admin - Sản Phẩm';
        $this->data['content'] = 'admin/products/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function getSubcategoriesByCategoryId()
    {

        $this->subCategory_model->setCateId($_POST['categoryIdDr']);
        $subCategories = $this->subCategory_model->getSubCateByIdCate($this->subCategory_model);
        echo json_encode($subCategories); // Trả về danh sách danh mục phụ dưới dạng JSON

    }

    public function getCategoryBySubCategoryId()
    {

        $this->subCategory_model->setId($_POST['subCategoryIdDr']);
        $category = $this->subCategory_model->getCateByIdSubCate($this->subCategory_model);
        echo json_encode($category); // Trả về danh mục chính dưới dạng JSON

    }

    public function addPro()
    {
        $name = $_POST['nameAdd'];
        $price = $_POST['priceAdd'];
        $discount = $_POST['discountAdd'];
        $subCate = $_POST['subCateAdd'];
        $detail = $_POST['detailAdd'];

        if (!$name || !$price || !$discount || !$subCate || !$detail) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->product_model->setName($name);
            $this->product_model->setPrice($price);
            $this->product_model->setDiscount_percent($discount);
            $this->product_model->setSubCategory_id($subCate);
            $this->product_model->setDetail($detail);
            $this->product_model->addPro($this->product_model);
            // Reload lại trang hiện tại
            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function changeStatusPro()
    {
        $this->product_model->setId($_POST['idStatus']);
        $this->product_model->setStatus($_POST['statusNew']);
        $this->product_model->changeStatusPro($this->product_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đổi trạng thái thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    private function deletePro()
    {
        $this->product_model->setId($_POST['idDelete']);
        $this->product_model->deletePro($this->product_model);

        // Reload lại trang hiện tại
        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Hàm hiển thị modal chỉnh sửa
    public function showEditModal()
    {

        $this->product_model->setId($_POST['idShow']); // Lấy ID danh mục
        $productShow = $this->product_model->getOnePro($this->product_model); // Lấy thông tin danh mục
        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($productShow) {
            echo json_encode($productShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy danh mục']);
        }
    }

    public function updatePro()
    {
        $id = $_POST['idEdit'];
        $name = $_POST['nameEdit'];
        $price = $_POST['priceEdit'];
        $discount = $_POST['discountEdit'];
        $subCate = $_POST['subCateEdit'];
        $detail = $_POST['detailEdit'];

        if (!$name || !$price || !$discount || !$subCate || !$detail) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->product_model->setId($id);
            $this->product_model->setName($name);
            $this->product_model->setPrice($price);
            $this->product_model->setDiscount_percent($discount);
            $this->product_model->setSubCategory_id($subCate);
            $this->product_model->setDetail($detail);
            $this->product_model->updatePro($this->product_model);
            // Reload lại trang hiện tại
            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function showQuantityEdit()
    {
        // Lấy giá trị từ POST
        $productId = $_POST['product_idS'];
        $sizeId = $_POST['size_idS'] ?? 1; // Mặc định là size 1 nếu không có giá trị

        // Thiết lập giá trị vào model
        $this->product_model->setId($productId);
        $this->product_model->setSizeId($sizeId);

        // Lấy thông tin số lượng từ model
        $quantity = $this->product_model->getQuantitySize($this->product_model);

        // Kiểm tra và trả về JSON
        if ($quantity !== null) {
            $data = [
                'success' => true,
                'quantity' => $quantity['quantity'] // Trả về số lượng từ bản ghi
            ];
        } else {
            $data = [
                'success' => false,
                'message' => 'Không tìm thấy số lượng.'
            ];
        }

        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($data);
    }

    public function updateQuantity()
    {
        $id = $_POST['idSE'];
        $size = $_POST['sizeSE'];
        $quantity = $_POST['quantitySE'];

        if (!$size || !$quantity) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->product_model->setId($id);
            $this->product_model->setSizeId($size);
            $this->product_model->setQuantity($quantity);
            $this->product_model->updateQuantity($this->product_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
    //Hàm xử lý thêm ảnh sản phẩm
    public function addImgPro()
    {
        if (isset($_POST['addImgPro'])) {
            $this->image_model->setProduct_id($_POST['product_id']);
            $dataImg = $this->image_model->getImgByIdPro($this->image_model);
            if ($dataImg) {
                $existing_images = $_POST['existing_images'] ?? [];
                $idImg = array_column($dataImg, 'id');
                // Tìm những ID ảnh bị xóa
                $deleted_images = array_diff($idImg, $existing_images);
                if (!empty($deleted_images)) {
                    foreach ($deleted_images as $idImgDel) {
                        $this->image_model->setId($idImgDel);
                        $this->image_model->deleteImg($this->image_model);
                    }
                }
            }
            if (isset($_FILES['img']) && count($_FILES['img']) > 0) {
                $files = $_FILES['img'];
                foreach ($files['name'] as $index => $file) {
                    if ($file != "") {
                        if (in_array($files['type'][$index], ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'])) {
                            $tmpName = $files['tmp_name'][$index];
                            $target_dir = dirname(__DIR__, 3) . "/public/assets/img/";
                            $addressImg = $target_dir . $file;
                            $this->image_model->setImage($file);
                            $this->image_model->insertImg($this->image_model);
                            if (move_uploaded_file($tmpName, $addressImg)) {
                                $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm ảnh thành công!', 'type' => 'success'];
                                header("Location: " . _WEB_ROOT_ . "/admin/san-pham");
                            }
                        } else {
                            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'File không phải dạng ảnh!', 'type' => 'error'];
                            header("Location: " . _WEB_ROOT_ . "/admin/san-pham");
                        }
                    } else {
                        $_SESSION['messger'] = ['title' => 'Thành công!', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
                        header("Location: " . _WEB_ROOT_ . "/admin/san-pham");
                    }
                }
            } else {
                $_SESSION['messger'] = ['title' => 'Lỗi', 'mess' => 'Không có dữ liệu ảnh!', 'type' => 'error'];
                header("Location: " . _WEB_ROOT_ . "/admin/san-pham");
            }
        }
    }
    public function getImgByIdPro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPro'])) {
            $idPro = $_POST['idPro'];
            $this->image_model->setProduct_id($idPro);
            $dataImg = $this->image_model->getImgByIdPro($this->image_model);
            if ($dataImg) {
                foreach ($dataImg as $img) {
                    echo '<div class="preview-item">
                        <input type="file" name="img[]" class="file-input" hidden="">
                        <img src="' . _WEB_ROOT_ . '/public/assets/img/' . $img['image'] . '" alt="Ảnh mới" class="image-preview">
                          <input type="hidden" name="existing_images[]" value="' . $img['id'] . '">
                        <div class="remove-btn">X</div>
                    </div>';
                }
            }
        }
    }
}

