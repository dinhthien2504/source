<?php
namespace app\controllers\admin;

use app\controllers\Base;

class Category extends Base
{
    public $data;
    public static $item_page = 5;
    private $CategoryModel, $ProductModel;
    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->render_error("403");
            exit();
        }
        $this->CategoryModel = $this->model('CategoryModel');
        $this->ProductModel = $this->model('ProductModel');
    }
    public function index()
    {
        //Đặt số lượng phần tử cho trang
        $this->CategoryModel->__set('item_page', self::$item_page);

        //Lấy trang hiện tại nếu có
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->CategoryModel->__set('current_page', $current_page);

        //Lấy từ khóa tìm kiếm nếu có
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $this->CategoryModel->__set('keyword', $keyword);

        //Lấy danh mục cha
        $data_cate_parent = $this->CategoryModel->get_all_cate_parent_admin();
        $this->data['sub_content']['data_cate_parent'] = $data_cate_parent;
        //Lấy danh mục
        $data_cate_all = $this->CategoryModel->get_all_cate_show_admin();

        //Lấy tổng danh mục cha để tính số trang
        $total_cate_parent = $this->CategoryModel->total_cate_handle_page();
        $total_page = ceil($total_cate_parent['total'] / self::$item_page);
        //Xử lý đường dẫn cho phân trang
        if ($total_page > 1) {
            $links = $this->handle_url_page($total_page, $current_page);
            $this->data['sub_content']['links'] = $links;
        }
        //Tổng danh mục
        $total_cate = $this->CategoryModel->total();
        $this->data['sub_content']['total_cate'] = $total_cate;
        $this->data['sub_content']['data_cate_all'] = $data_cate_all;
        $this->data['title_page'] = 'Danh Mục Sản Phẩm';
        $this->data['content'] = 'admin/categories/index';
        $this->render('layouts/main_admin', $this->data);
    }
    public function handle_new()
    {
        if (isset($_POST['submit_cate'])) {
            $name = trim($_POST['name_cate']);
            $parent_id = $_POST['parent_id'];
            $file_name = $_FILES['img_cate']['name'] ?? null;
            if (!empty($_FILES['img_cate'])) {
                $this->handle_upload_img($_FILES['img_cate']);
            }
            $this->CategoryModel->__sets([$name, $parent_id, $file_name]);
            $check = $this->CategoryModel->save_cate();
            if ($check) {
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Thêm danh mục thành công!', 'type' => 'success'];
            } else {
                $_SESSION['messager'] = ['title' => 'Lỗi!', 'mess' => 'Có lỗi xảy ra khi thêm danh mục!', 'type' => 'error'];
            }
            header('Location: ' . _WEB_ROOT_ . '/admin/categories');
        }
    }
    public function handle_edit()
    {
        if (!isset($_POST['submit_edit'])) {
            return;
        }

        // Lấy dữ liệu từ form
        $cate_id = $_POST['cate_id'] ?? null;
        $name_cate = $_POST['name_cate'] ?? null;
        $parent_id = $_POST['parent_id'] ?? null;
        $parent_old = $_POST['parent_old'] ?? null;

        // Kiểm tra dữ liệu hợp lệ
        if (!$cate_id || !$name_cate || is_null($parent_id) || is_null($parent_old)) {
            $this->redirect_with_message('Lỗi!', 'Dữ liệu không hợp lệ!', 'error');
        }

        //Lấy ảnh của nếu có
        $img_cate_old = $this->CategoryModel->get_img_by_cate_id($cate_id);
        $file_name = !empty($_FILES['img_cate']['name']) ? $_FILES['img_cate']['name'] : $img_cate_old['url_image'];

        if (!empty($_FILES['img_cate']['name'])) {
            $this->handle_upload_img($_FILES['img_cate']);
            $file_path = dirname(__DIR__, 3) . '/public/assets/img/cate/' . $img_cate_old['url_image'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Xử lý danh mục cha / con
        if ($parent_old == 0 && $parent_id != 0) {
            // Chuyển từ danh mục cha thành con
            $this->CategoryModel->__set('parent_id', $cate_id);
            if (!empty($this->CategoryModel->get_all_cate_by_parent_id())) {
                $this->redirect_with_message('Cảnh báo!', 'Danh mục cha có danh mục con, không thể chuyển thành danh mục con!', 'error');
            }
        } elseif ($parent_old != 0 && $parent_id == 0) {
            // Chuyển từ danh mục con thành cha
            $this->ProductModel->__set('cate_id', $cate_id);
            if (!empty($this->ProductModel->get_pro_by_cate_id())) {
                $this->redirect_with_message('Cảnh báo!', 'Danh mục này có sản phẩm, không thể trở thành danh mục cha!', 'error');
            }
        }

        // Cập nhật danh mục
        $this->CategoryModel->__sets([$name_cate, $parent_id, $file_name, $cate_id]);
        $this->CategoryModel->update_cate();

        $this->redirect_with_message('Thành công!', 'Cập nhật danh mục thành công.', 'success');
    }
    private function redirect_with_message($title, $message, $type)
    {
        $_SESSION['messager'] = ['title' => $title, 'mess' => $message, 'type' => $type];
        header('Location: ' . _WEB_ROOT_ . '/admin/categories');
        exit;
    }


    private function handle_upload_img($file)
    {
        $target_dir = dirname(__DIR__, 3) . "/public/assets/img/cate/";
        $tmp_name = $file['tmp_name'];
        $address_img = $target_dir . $file['name'];
        move_uploaded_file($tmp_name, $address_img);
    }

    public function handle_del($id)
    {
        if ($id > 0) {
            $this->CategoryModel->__set('parent_id', $id);

            //Kiểm tra có danh mục con hay không
            $check_parent = $this->CategoryModel->get_all_cate_by_parent_id();
            if (!empty($check_parent)) {
                $_SESSION['messager'] = ['title' => 'Lỗi!', 'mess' => 'Danh mục này có danh mục con, bạn cần xóa danh mục con trước!', 'type' => 'error'];
                header('Location: ' . _WEB_ROOT_ . '/admin/categories');
                exit();
            }

            //Kiểm tra danh mục này có sản phẩm hay không
            $this->ProductModel->__set('cate_id', $id);
            $check_pro = $this->ProductModel->get_pro_by_cate_id();
            if (!empty($check_pro)) {
                $_SESSION['messager'] = ['title' => 'Lỗi!', 'mess' => 'Danh mục này có sản phẩm, bạn cần xóa sản phẩm trước!', 'type' => 'error'];
                header('Location: ' . _WEB_ROOT_ . '/admin/categories');
                exit();
            }

            $check_del = $this->CategoryModel->delete_cate();
            if ($check_del) {
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xóa danh mục thành công!', 'type' => 'success'];
                header('Location: ' . _WEB_ROOT_ . '/admin/categories');
            }
        }
    }
    public function handle_del_groups()
    {
        if (isset($_POST['submit_del_groups'])) {
            $cate_del_groups = $_POST['cate_del_groups'] ?? [];
            if (!empty($cate_del_groups)) {
                foreach ($cate_del_groups as $cate_id) {
                    $this->handle_del($cate_id);
                }
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xóa nhóm danh mục thành công!', 'type' => 'success'];
            } else {
                $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Vui lòng chọn danh mục để xóa!', 'type' => 'error'];
            }
        }
        header('Location: ' . _WEB_ROOT_ . '/admin/categories');
    }
}