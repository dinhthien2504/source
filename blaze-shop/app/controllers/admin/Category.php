<?php
class Category extends Controller
{
    public $cate_model;
    public $subCate_model;
    public $data = [];


    public function __construct()
    {
        $this->cate_model = $this->model('CategoryModel');

        $this->subCate_model = $this->model('SubCategoryModel');
    }

    public function index()
    {
        // Xử lý thêm danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cateName'])) {
            $this->addCategory();
        }

        // Xử lý xóa danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $this->deleteCategory();
        }

        // Xử lý hiển thị chỉnh sửa danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idShow'])) {
            $this->showEditModal();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUpdate'])) {
            $this->updateCategory();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idStatus'])) {
            $this->changeStatusCate();
        }
 
        // Dữ liệu chính cho trang
        $Cate = $this->cate_model->getAllCate();
        $this->data['sub_content']['dataCate'] = $Cate;
        $this->data['page_title'] = 'BLAZE-Admin - Danh Mục';
        $this->data['content'] = 'admin/categories/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    // Hàm thêm danh mục
    private function addCategory()
    {
        $this->cate_model->setName($_POST['cateName']);
        $this->cate_model->addCate($this->cate_model);

        // Reload lại trang hiện tại
        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Hàm xóa danh mục
    private function deleteCategory()
    {
        $this->cate_model->setId($_POST['idDelete']);

        // Kiểm tra xem danh mục có danh mục con không
        if ($this->cate_model->countSubCate($this->cate_model) > 0) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Không thể xóa danh mục vì có danh mục phụ thuộc danh mục này!', 'type' => 'error'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            // Thực hiện xóa danh mục
            $this->cate_model->deleteCate($this->cate_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    private function updateCategory()
    {
        $this->cate_model->setId($_POST['idUpdate']);
        $this->cate_model->setName($_POST['nameUpdate']);
        $this->cate_model->updateCate($this->cate_model);


        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    public function changeStatusCate()
    {
        $this->cate_model->setId($_POST['idStatus']);
        $this->cate_model->setStatus($_POST['statusNew']);
        $this->cate_model->changeStatusCate($this->cate_model);


        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đổi trạng thái thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Hàm hiển thị modal chỉnh sửa
    public function showEditModal()
    {
        $this->cate_model->setId($_POST['idShow']); // Lấy ID danh mục
        $cateShow = $this->cate_model->getOneCate($this->cate_model); // Lấy thông tin danh mục
        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($cateShow) {
            echo json_encode($cateShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy danh mục']);
        }
    }





    public function subCategory()
    {
        // Xử lý thêm danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subCateName'])) {
            $this->addSubCategory();
        }

        // Xử lý xóa danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idSubDelete'])) {
            $this->deleteSubCategory();
        }

        // Xử lý hiển thị chỉnh sửa danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idSubShow'])) {
            $this->showSubEditModal();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subIdUpdate'])) {
            $this->updateSubCategory();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idStatus'])) {
            $this->changeStatusSubCate();
        }



        $subCate = $this->subCate_model->getSubCateForCate();
        $this->data['sub_content']['dataSubCate'] = $subCate;
        $Cate = $this->cate_model->getAllCate();
        $this->data['sub_content']['dataCate'] = $Cate;
        $this->data['page_title'] = 'BLAZE-Admin - Danh Mục';
        $this->data['content'] = 'admin/categories/subCategory';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function addSubCategory()
    {
        $this->subCate_model->setName($_POST['subCateName']);
        $this->subCate_model->setCateId($_POST['subCate_cate']);
        $this->subCate_model->addSubCate($this->subCate_model);


        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    private function deleteSubCategory()
    {
        $this->subCate_model->setId($_POST['idSubDelete']);

        // Kiểm tra xem danh mục có danh mục con không
        if ($this->subCate_model->countProductsBySubCate($this->subCate_model) > 0) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Không thể xóa danh mục vì có sản phẩm thuộc danh mục này!', 'type' => 'error'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            // Thực hiện xóa danh mục
            $this->subCate_model->deleteSubCate($this->subCate_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function changeStatusSubCate()
    {
        $this->subCate_model->setId($_POST['idStatus']);
        $this->subCate_model->setStatus($_POST['statusNew']);
        $this->subCate_model->changeStatusSubCate($this->subCate_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đổi trạng thái thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    public function showSubEditModal()
    {

        $this->subCate_model->setId($_POST['idSubShow']); // Lấy ID danh mục
        $subCateShow = $this->subCate_model->getOneSubCateForCate($this->subCate_model); // Lấy thông tin danh mục


        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($subCateShow) {
            echo json_encode($subCateShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy danh mục']);
        }
    }

    private function updateSubCategory()
    {
        $this->subCate_model->setId($_POST['subIdUpdate']);
        $this->subCate_model->setCateId($_POST['subCateUpdate']);
        $this->subCate_model->setName($_POST['subNameUpdate']);
        $this->subCate_model->updateSubCate($this->subCate_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
