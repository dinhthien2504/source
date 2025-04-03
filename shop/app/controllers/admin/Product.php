<?php
namespace app\controllers\admin;
use app\controllers\Base;
class Product extends Base
{
    public $data;
    private static $item_page = 5;
    private $ProductModel, $CategoryModel, $AttritubeModel, $AttriValueModel, $ProImageModel, $ProVariantModel;
    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->render_error("403");
            exit();
        }
        $this->ProductModel = $this->model('ProductModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->AttritubeModel = $this->model('AttritubeModel');
        $this->AttriValueModel = $this->model('AttriValueModel');
        $this->ProImageModel = $this->model('ProImageModel');
        $this->ProVariantModel = $this->model('ProVariantModel');
    }
    public function index()
    {
        //Đặt số lượng phần tử cho trang
        $this->ProductModel->__set('item_page', self::$item_page);

        //Lấy trang hiện tại nếu có
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->ProductModel->__set('current_page', $current_page);

        //Lấy từ khóa tìm kiếm nếu có
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $this->ProductModel->__set('keyword', $keyword);

        //Lấy tổng danh mục cha để tính số trang
        $total_pro_handle_page = $this->ProductModel->total_pro_handle_page();
        $total_page = ceil($total_pro_handle_page['total'] / self::$item_page);
        //Xử lý đường dẫn cho phân trang
        if ($total_page > 1) {
            $links = $this->handle_url_page($total_page, $current_page);
            $this->data['sub_content']['links'] = $links;
        }
        $data_all_pro = $this->ProductModel->get_all_pro_admin();
        //Tổng số sản Phẩm
        $total_pro = $this->ProductModel->total();
        $this->data['sub_content']['total_pro'] = $total_pro;
        $this->data['sub_content']['data_all_pro'] = $data_all_pro;

        $this->data['title_page'] = 'Quản Lý Sản Phẩm';
        $this->data['content'] = 'admin/products/index';
        $this->render('layouts/main_admin', $this->data);
    }
    public function new()
    {
        //Dữ liệu danh mục cha
        $data_cate_parent = $this->CategoryModel->get_all_cate_parent_admin();
        $this->data['sub_content']['data_cate_parent'] = $data_cate_parent;
        //Dữ liệu thuộc tính
        $data_attri = $this->AttritubeModel->get_all_attri();
        $this->data['sub_content']['data_attri'] = $data_attri;
        //Dữ liệu giá trị thuộc tính
        $this->AttriValueModel->__set('attri_id', 1);
        $data_attri_val_by_attri_cor = $this->AttriValueModel->get_all_attri_val_by_attri_id();
        $this->data['sub_content']['data_attri_val_by_attri_cor'] = $data_attri_val_by_attri_cor;

        $this->data['title_page'] = 'Thêm Sản Phẩm';
        $this->data['content'] = 'admin/products/add';
        $this->render('layouts/main_admin', $this->data);
    }
    public function edit($pro_id)
    {
        //Dữ liệu sản phẩm theo pro_id
        $this->ProductModel->__set('pro_id', $pro_id);
        $data_pro_id = $this->ProductModel->get_pro_by_id_admin();
        $this->data['sub_content']['data_pro_id'] = $data_pro_id;

        //Dữ liệu ảnh sản phẩm theo pro_id
        $this->ProImageModel->__set('pro_id', $pro_id);
        $data_img__main_pro_id = $this->ProImageModel->get_all_img_by_pro_id();
        $this->data['sub_content']['data_img_main_pro_id'] = $data_img__main_pro_id;

        //Dữ liệu cả danh mục cha và danh mục con
        $this->CategoryModel->__set('cate_id', $data_pro_id['cate_id']);
        $data_cate_by_id = $this->CategoryModel->get_cate_by_cate_id();
        $this->data['sub_content']['data_cate_by_id'] = $data_cate_by_id;

        //Dữ liệu danh mục cha
        $data_cate_parent = $this->CategoryModel->get_all_cate_parent_admin();
        $this->data['sub_content']['data_cate_parent'] = $data_cate_parent;

        //Dữ liệu thông tin danh mục theo parent_id
        $this->CategoryModel->__set('parent_id', $data_cate_by_id['parent_id']);
        $data_cate_by_parent = $this->CategoryModel->get_all_cate_by_parent_id();
        $this->data['sub_content']['data_cate_by_parent'] = $data_cate_by_parent;

        //Dữ liệu thuộc tính 
        $data_attri = $this->AttritubeModel->get_all_attri();
        $this->data['sub_content']['data_attri'] = $data_attri;

        //Xử lý phân loại
        $this->ProVariantModel->__set('pro_id', $pro_id);

        //Nếu sản phẩm đó có cả màu và size
        $data_variant_cor_and_size = $this->ProVariantModel->get_cor_size_by_pro_id();
        if (!empty($data_variant_cor_and_size)) {
            $this->data['sub_content']['data_variant_cor_and_size'] = $data_variant_cor_and_size;
            //Dữ liệu giá trị thuộc tính màu
            $this->AttriValueModel->__set('attri_id', 1);
            $data_attri_val_by_attri_cor = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            $this->data['sub_content']['data_attri_val_by_attri_cor'] = $data_attri_val_by_attri_cor;

            //Lấy size
            $this->ProVariantModel->__set('cor_id', $data_variant_cor_and_size[0]['cor_id']);
            $data_size_by_cor_id = $this->ProVariantModel->get_size_by_cor_id();
            $this->data['sub_content']['data_size_by_cor_id'] = $data_size_by_cor_id;

            //Dữ liệu giá trị thuộc tính size
            $this->AttriValueModel->__set('attri_id', 2);
            $data_attri_val_by_attri_size = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            $this->data['sub_content']['data_attri_val_by_attri_size'] = $data_attri_val_by_attri_size;

        }


        //Nếu sản phẩm đó chỉ có màu
        $data_variant_cor = $this->ProVariantModel->get_color_by_pro_id();
        if (!empty($data_variant_cor)) {
            $this->data['sub_content']['data_variant_cor'] = $data_variant_cor;
            //Dữ liệu giá trị thuộc tính màu
            $this->AttriValueModel->__set('attri_id', 1);
            $data_attri_val_by_attri_cor = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            $this->data['sub_content']['data_attri_val_by_attri_cor'] = $data_attri_val_by_attri_cor;
        }

        //Nếu sản phẩm chỉ có size
        $data_variant_size = $this->ProVariantModel->get_size_by_pro_id();
        if (!empty($data_variant_size)) {
            $this->data['sub_content']['data_variant_size'] = $data_variant_size;
            //Dữ liệu giá trị thuộc tính size
            $this->AttriValueModel->__set('attri_id', 2);
            $data_attri_val_by_attri_size = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            $this->data['sub_content']['data_attri_val_by_attri_size'] = $data_attri_val_by_attri_size;
        }


        //Dữ liệu tất cả thuộc tính của sản phẩm để check số lượng
        $data_variant_pro_id = $this->ProVariantModel->get_all_variant_pro_id();
        $this->data['sub_content']['data_variant_pro_id'] = $data_variant_pro_id;
        $this->data['title_page'] = 'Cập Nhật Sản Phẩm';
        $this->data['content'] = 'admin/products/edit';
        $this->render('layouts/main_admin', $this->data);
    }
    public function handle_new()
    {
        if (isset($_POST['submit__pro']) && $this->validate_pro_data($_POST)) {
            $this->handle_pro_data($_POST);
            $pro_id = $this->ProductModel->insert_pro();
            if ($pro_id) {
                $target_dir = dirname(__DIR__, 3) . "/public/assets/img/pro/";
                // Xử lý ảnh chính
                if (!empty($_FILES['pro_img__main']['name'])) {
                    $this->handle_upload_img_main($_FILES['pro_img__main'], $pro_id, $target_dir);
                }
                // Xử lý các tùy chọn màu và size
                $pro_stock = $_POST['pro_stock'] ?? [];
                $files_cor = $_FILES['pro_img__cor'] ?? null;
                $__data_one = $_POST['pro_one_option'] ?? [];
                $__data_two = $_POST['pro_two_option'] ?? [];

                if (!empty($__data_one) && !empty($__data_two)) {
                    $this->handle_double_options($pro_id, $__data_one, $__data_two, $pro_stock, $files_cor, $target_dir);
                } elseif (!empty($files_cor)) {
                    $this->handle_single_option($pro_id, $__data_one, $pro_stock, $files_cor, 'color', $target_dir);
                } elseif ($files_cor == null) {
                    $this->handle_single_option($pro_id, $__data_one, $pro_stock, $files_cor, 'size', $target_dir);
                }
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Thêm sản phẩm thành công!', 'type' => 'success'];
                header('Location: ' . _WEB_ROOT_ . '/admin/products');
            }
        }
    }
    public function handle_edit()
    {
        if (isset($_POST['submit__pro']) && $this->validate_pro_data($_POST)) {
            $this->handle_pro_data(post_data: $_POST);
            $this->ProductModel->update_pro();
            //Xử lý ảnh chính xem có bị xóa ảnh nào không
            $target_dir = dirname(__DIR__, 3) . "/public/assets/img/pro/";
            //Lấy dữ liệu ảnh có sẳn của sản phẩm
            $check_img__mains = $_POST['check_img__mains'] ?? [];
            $this->handle_img_main($_POST['pro__id'], $check_img__mains, $_FILES['pro_img__main'], $target_dir);
            // Xử lý các tùy chọn màu và size
            $pro_stock = $_POST['pro_stock'] ?? [];
            $files_cor = $_FILES['pro_img__cor'] ?? null;
            $__data_one = $_POST['pro_one_option'] ?? [];
            $__data_two = $_POST['pro_two_option'] ?? [];

            $this->ProVariantModel->__set('pro_id', $_POST['pro__id']);
            //Lấy id variant có sẳn của sản phẩm
            $pro_variant_olds = $_POST['check_variant_olds'] ?? [];
            if (!empty($pro_variant_olds)) {
                $__data_variant_img_olds = $_POST['check_variant_img_olds'] ?? [];
                if (!empty($__data_one) && !empty($__data_two)) {
                    $this->handle_update_double_options($__data_one, $__data_two, $__data_variant_img_olds, $files_cor, $pro_variant_olds, $pro_stock, $target_dir);
                } else {
                    $this->handle_update_single_option($pro_variant_olds, $__data_one, $__data_variant_img_olds, $pro_stock, $files_cor, $target_dir);
                }
            } else {
                //Xóa tất cả thuộc tính trước đó
                $this->ProVariantModel->delete_variant_by_pro_id();
                if (!empty($__data_one) && !empty($__data_two)) {
                    $this->handle_double_options($_POST['pro__id'], $__data_one, $__data_two, $pro_stock, $files_cor, $target_dir);
                } else if ($files_cor) {
                    $this->handle_single_option($_POST['pro__id'], $__data_one, $pro_stock, $files_cor, 'color', $target_dir);
                } else {
                    $this->handle_single_option($_POST['pro__id'], $__data_one, $pro_stock, $files_cor, 'size', $target_dir);
                }
            }
            $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Cập nhật sản phẩm thành công!', 'type' => 'success'];
            header('Location: ' . _WEB_ROOT_ . '/admin/products');
        }
    }
    private function validate_pro_data($data)
    {
        return !empty($data['pro__cate']) &&
            !empty($data['pro__name']) &&
            !empty($data['pro__price']);
    }
    private function handle_pro_data($post_data)
    {
        $pro_cate = trim($post_data['pro__cate']);
        $pro_name = trim($post_data['pro__name']);
        $pro_price = $post_data['pro__price'] ?? 0;
        $pro_discount_percent = $post_data['pro__discount'] ?? 0;
        $pro_description = $post_data['pro__description'] ?? '';
        $pro_status = $post_data['submit__pro'] ?? 0;
        if (!empty($post_data['pro__id'])) {
            $this->ProductModel->__sets([$pro_cate, $pro_name, $pro_price, $pro_discount_percent, $pro_description, $pro_status, $post_data['pro__id']]);
        } else {
            $this->ProductModel->__sets([$pro_cate, $pro_name, $pro_price, $pro_discount_percent, $pro_description, $pro_status]);
        }
    }
    private function save_variant($pro_id, $cor_id, $size_id, $url_image, $quantity)
    {
        $this->ProVariantModel->__sets([$pro_id, $cor_id, $size_id, $url_image, $quantity]);
        $this->ProVariantModel->insert_variant_pro();
    }
    private function handle_upload_img_main($files, $pro_id, $target_dir)
    {
        foreach ($files['name'] as $index => $file) {
            if (empty($file))
                continue;
            $this->ProImageModel->__sets([$pro_id, $file]);
            $this->ProImageModel->insert_image_pro();

            $tmp_name = $files['tmp_name'][$index];
            $address_img = $target_dir . $file;
            move_uploaded_file($tmp_name, $address_img);
        }
    }

    private function handle_double_options($pro_id, $data_cors, $data_sizes, $pro_stock, $files_cor, $target_dir)
    {
        $stok_index = 0;
        foreach ($data_cors as $index => $cor) {
            if (empty($cor))
                continue;
            foreach ($data_sizes as $size) {
                if (empty($size))
                    continue;
                $this->save_variant($pro_id, $cor, $size, $files_cor['name'][$index] ?? null, $pro_stock[$stok_index] ?? 0);
                if (!empty($files_cor['tmp_name'][$index])) {
                    $tmp_name = $files_cor['tmp_name'][$index];
                    $address_img = $target_dir . $files_cor['name'][$index];
                    move_uploaded_file($tmp_name, $address_img);
                }

                $stok_index++;
            }
        }
    }

    private function handle_single_option($pro_id, $data, $pro_stock, $files_cor, $type, $target_dir)
    {
        foreach ($data as $index => $value) {
            if (empty($value))
                continue;

            $cor_id = $type === 'color' ? $value : null;
            $size_id = $type === 'size' ? $value : null;
            $url_image = $files_cor['name'][$index] ?? null;
            $quantity = $pro_stock[$index] ?? 0;

            $this->save_variant($pro_id, $cor_id, $size_id, $url_image, $quantity);

            if ($url_image != null) {
                $tmp_name = $files_cor['tmp_name'][$index];
                $address_img = $target_dir . $files_cor['name'][$index];
                move_uploaded_file($tmp_name, $address_img);
            }
        }
    }
    private function update_variant($id, $quantity, $url_image)
    {
        $this->ProVariantModel->__sets([$id, $quantity, $url_image]);
        $this->ProVariantModel->update_variant_pro();
    }
    private function handle_update_double_options($__data_cors, $__data_size, $__data_variant_img_olds, $files_cor, $pro_variant_olds, $pro_stock, $target_dir)
    {
        $__index = 0;
        foreach ($__data_cors as $index => $cor) {
            if (empty($cor))
                continue;
            $__handle_file = empty($files_cor['name'][$index]) ? $__data_variant_img_olds[$__index] : $files_cor['name'][$index];
            foreach ($__data_size as $size) {
                if (empty($size))
                    continue;
                $this->update_variant($pro_variant_olds[$__index], $pro_stock[$__index], $__handle_file);
                $__index++;
            }
            if (!empty($files_cor['tmp_name'][$index])) {
                $tmp_name = $files_cor['tmp_name'][$index];
                $address_img = $target_dir . $files_cor['name'][$index];
                move_uploaded_file($tmp_name, $address_img);
            }
        }
    }
    private function handle_img_main($__pro_id, $check_img__mains, $file_pro_main, $target_dir)
    {
        //Dữ liệu ảnh sản phẩm theo pro_id
        $this->ProImageModel->__set('pro_id', $__pro_id);
        $__data_img__main_pro_id = $this->ProImageModel->get_all_img_by_pro_id();
        //Lấy tất cả id ảnh sản phẩm
        $id_pro__img = array_column($__data_img__main_pro_id, 'id');
        //Kiểm tra xem ảnh nào bị xóa thì xóa trên cơ sở dữ liệu
        $img__mains_to_delete = array_diff($id_pro__img, $check_img__mains);
        if (!empty($img__mains_to_delete)) {
            foreach ($img__mains_to_delete as $img_id) {
                $this->ProImageModel->__set('id', $img_id);
                $this->ProImageModel->delete_img_pro_by_id();
            }
        }
        //Xử lý hình ảnh
        if (!empty($file_pro_main['name'])) {
            //upload nếu có ảnh mới
            $this->handle_upload_img_main($file_pro_main, $__pro_id, $target_dir);
        }
    }
    private function handle_update_single_option($pro_variant_olds, $data, $__data_variant_img_olds, $pro_stock, $files_cor, $target_dir)
    {
        foreach ($data as $index => $value) {
            if (empty($value))
                continue;
            $__handle_file = empty($files_cor['name'][$index]) ? $__data_variant_img_olds[$index] : $files_cor['name'][$index];
            $quantity = $pro_stock[$index] ?? 0;
            $this->update_variant($pro_variant_olds[$index], $quantity, $__handle_file);
            if (!empty($files_cor['tmp_name'][$index])) {
                $tmp_name = $files_cor['tmp_name'][$index];
                $address_img = $target_dir . $files_cor['name'][$index];
                move_uploaded_file($tmp_name, $address_img);
            }
        }
    }

    //Xóa sản phẩm
    public function handle_del($__pro_id)
    {
        if ($__pro_id) {
            //Xóa tất cả ảnh sản phẩm
            $this->handle_del_img_main($__pro_id);
            //Xóa phân loại của sản phẩm
            $this->handle_del_variant_pro($__pro_id);

            //Xóa thông tin sản phẩm
            $this->ProductModel->__set('pro_id', $__pro_id);
            $__check_del_pro = $this->ProductModel->delete_pro();
            if ($__check_del_pro > 0) {
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xóa sản phẩm thành công!', 'type' => 'success'];
                header('Location: ' . _WEB_ROOT_ . '/admin/products');
            }
        }
    }
    private function handle_del_img_main($__pro_id)
    {
        $this->ProImageModel->__set('pro_id', $__pro_id);
        $__link_img = $this->ProImageModel->get_all_img_by_pro_id();
        if (!empty($__link_img)) {
            $this->handle_unlink_pro($__link_img);
        }
        return $this->ProImageModel->delete_img_pro_by_pro_id();
    }
    private function handle_del_variant_pro($__pro_id)
    {
        $this->ProVariantModel->__set('pro_id', $__pro_id);
        $__link_img = $this->ProVariantModel->get_all_img_variant_by_pro_id();
        if (!empty($__link_img)) {
            $this->handle_unlink_pro($__link_img);
        }
        return $this->ProVariantModel->delete_variant_by_pro_id();
    }
    private function handle_unlink_pro($__link_img)
    {
        foreach ($__link_img as $img) {
            $file_path = dirname(__DIR__, 3) . '/public/assets/img/pro/' . $img['url_image'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }
    public function handle_del_groups()
    {
        if (isset($_POST['pro__del_groups'])) {
            $__pro_del_groups = $_POST['pro__del_groups'] ?? [];
            if (!empty($__pro_del_groups)) {
                foreach ($__pro_del_groups as $pro_id) {
                    $this->handle_del($pro_id);
                }
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xóa nhóm sản phẩm thành công!', 'type' => 'success'];
            }
        } else {
            $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Vui lòng chọn sản phẩm để xóa!', 'type' => 'error'];
        }
        header('Location: ' . _WEB_ROOT_ . '/admin/products');
    }
}