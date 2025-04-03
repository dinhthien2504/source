<?php
namespace app\controllers\admin;
use app\controllers\Base;

class User extends Base
{
    public $data;
    private static $item_page = 10;
    private $UserModel;
    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->render_error("403");
            exit();
        }
        $this->UserModel = $this->model("UserModel");
    }
    public function index()
    {
        //Đặt số lượng phần tử cho trang
        $this->UserModel->__set('item_page', self::$item_page);

        //Lấy trang hiện tại nếu có
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->UserModel->__set('current_page', $current_page);

        //Lấy từ khóa tìm kiếm nếu có
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $this->UserModel->__set('keyword', $keyword);

        //Lấy tổng thành viên để tính số trang
        $total_user_handle_page = $this->UserModel->total_user_handle_page();
        $total_page = ceil($total_user_handle_page['total'] / self::$item_page);
        //Xử lý đường dẫn cho phân trang
        if ($total_page > 1) {
            $links = $this->handle_url_page($total_page, $current_page);
            $this->data['sub_content']['links'] = $links;
        }
        $user_id = $_SESSION['user']['id'] ?? 0;
        $this->UserModel->__set('id', $user_id);
        $users = $this->UserModel->get_all_user_admin();
        //Tổng số thành viên
        $total_user = $this->UserModel->total();
        $this->data['sub_content']['total_user'] = $total_user;
        $this->data['sub_content']['users'] = $users;
        $this->data['title_page'] = 'Quản Lý Thành Viên';
        $this->data['content'] = 'admin/users/index';
        $this->render('layouts/main_admin', $this->data);
    }

    public function handle_new()
    {
        if (isset($_POST)) {
            $this->handle_post_new($_POST);

            $check_last_id = $this->UserModel->insert_user_admin();

            $_SESSION['messager'] = [
                'title' => $check_last_id ? 'Thành công!' : 'Cảnh báo!',
                'mess' => $check_last_id ? 'Thêm thành viên thành công!' : 'Thêm thành viên thất bại!',
                'type' => $check_last_id ? 'success' : 'error'
            ];
            header("Location: " . _WEB_ROOT_ . "/admin/users");
        }
    }
    private function handle_post_new($post_data)
    {
        $user_name = trim($post_data['name_new']);
        $user_email = $post_data['email_new'] ?? '';
        $hashed_pwd = password_hash(trim($_POST['pwd_new']), PASSWORD_DEFAULT);
        $user_rore = $post_data['role_new'] ?? 0;
        $this->UserModel->__sets([$user_name, $user_email, $hashed_pwd, $user_rore]);
    }

    public function handle_edit()
    {
        if (isset($_POST)) {
            $data = [
                'name' => $_POST['name_edit'],
                'role' => $_POST['role_edit'],
                'id' => $_POST['id_edit']
            ];
            $this->UserModel->__sets($data);
            $check_row_update = $this->UserModel->update_user();
            $_SESSION['messager'] = [
                'title' => $check_row_update ? 'Thành công!' : 'Cảnh báo!',
                'mess' => $check_row_update ? 'Cập nhật thành viên thành công!' : 'Cập nhật không có gì thay đổi hoặc thất bại!',
                'type' => $check_row_update ? 'success' : 'warning'
            ];
            header('Location: ' . _WEB_ROOT_ . '/admin/users');
        }
    }
    public function handle_del($id)
    {
        if ($id > 0) {
            $this->UserModel->__set("id", $id);
            $check_row_del = $this->UserModel->delete_user();
            $_SESSION['messager'] = [
                'title' => $check_row_del ? 'Thành công!' : 'Cảnh báo!',
                'mess' => $check_row_del ? 'Xóa thành viên thành công!' : 'Xóa thành viên thất bại!',
                'type' => $check_row_del ? 'success' : 'error'
            ];
            header('Location: ' . _WEB_ROOT_ . '/admin/users');
        }
    }
    public function handle_del_groups()
    {
        if (isset($_POST['submit_del_groups'])) {
            $user_del_groups = $_POST['user_del_groups'] ?? [];
            if (!empty($user_del_groups)) {
                $this->UserModel->__sets($user_del_groups);
                $check_row_del = $this->UserModel->delete_user_groups();

                $_SESSION['messager'] = [
                    'title' => $check_row_del > 0 ? 'Thành công!' : 'Cảnh báo!',
                    'mess' => $check_row_del > 0 ? 'Xóa nhóm thành viên thành công!' : 'Không có thành viên nào được chọn để xóa!',
                    'type' => $check_row_del > 0 ? 'success' : 'warning'
                ];
            } else {
                $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Vui lòng chọn nhóm thành viên để xóa!', 'type' => 'error'];
            }
            header('Location: ' . _WEB_ROOT_ . '/admin/users');
        }
    }

}