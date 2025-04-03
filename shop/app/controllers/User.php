<?php
namespace app\controllers;
use app\controllers\Base;
class User extends Base
{
    public $data;
    private $UserModel;
    private $OrderModel;
    private $PaymentModel;
    public function __construct()
    {
        $this->UserModel = $this->model('UserModel');
        $this->OrderModel = $this->model('OrderModel');
        $this->PaymentModel = $this->model('PaymentModel');
    }

    public function handle_login()
    {
        if (isset($_POST['submit__login'])) {
            $this->UserModel->__set('email', trim($_POST['login_email']));
            $user = $this->UserModel->get_user_login();
            if ($user && password_verify(trim($_POST['login_pwd']), $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Đăng nhập thành công!', 'type' => 'success'];
                if ($user['role'] == 2) {
                    header('Location: ' . _WEB_ROOT_ . '/admin/');
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
            } else {
                $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Sai tài khoản hoặc mật khẩu!', 'type' => 'error'];
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function handle_register()
    {
        if (isset($_POST)) {
            $hashed_pwd = password_hash(trim($_POST['register_pwd']), PASSWORD_DEFAULT);
            $this->UserModel->__sets([trim($_POST['register_name']), trim($_POST['register_email']), $hashed_pwd]);
            $check_register = $this->UserModel->insert_register();
            if ($check_register > 0) {
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Tạo tài khoản thành công!', 'type' => 'success'];
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function purchase()
    {
        $user_id = $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            $this->render_error(403);
            exit;
        }
        $status = $_GET['status'] ?? 0;
        //Lấy dữ liệu đơn hàng theo mã khách hàng
        $this->OrderModel->__set('user_id', $user_id);
        $this->OrderModel->__set('status', $status);
        $data_order_by_user_id = $this->OrderModel->get_order_by_user_id_and_status();
        $this->data['sub_content']['data_order_by_user_id'] = $data_order_by_user_id;
        $this->data['sub_content']['user_id'] = $_SESSION['user']['id'];
        $this->data['title_page'] = 'Tài Khoản';
        $this->data['content'] = 'auth/purchase';
        $this->render('layouts/main', $this->data);
    }
    public function cancel_order($order_id)
    {
        if (!$order_id) {
            $this->render_error(404);
            exit;
        }
        $this->OrderModel->__sets(['status' => 5, 'id' => $order_id]);
        $this->OrderModel->update_order();
        $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Hủy đơn hàng thành công!', 'type' => 'success'];
        header('Location: ' . _WEB_ROOT_ . '/user/purchase');
    }
    public function confirm_order_success($order_id)
    {
        if (!$order_id) {
            $this->render_error(404);
            exit;
        }
        //Cập nhật bảng orders
        $this->OrderModel->__sets(['status' => 6, 'id' => $order_id]);
        $this->OrderModel->update_order();

        //Cập nhật bảng payment
        $this->PaymentModel->__sets(['Đã thanh toán', $order_id]);
        $this->PaymentModel->confirm_update_payment_success();
        $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xác nhận đơn hàng thành công!', 'type' => 'success'];
        header('Location: ' . _WEB_ROOT_ . '/user/purchase');
    }
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: ' . _WEB_ROOT_ . '/');
    }
}