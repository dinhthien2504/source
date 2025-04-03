<?php
namespace app\controllers\admin;
use app\controllers\Base;
class Order extends Base
{
    public $data = [];
    private $OrderModel;
    public static $item_page = 10;
    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->render_error("403");
            exit();
        }
        $this->OrderModel = $this->model('OrderModel');
    }
    public function index()
    {
        //Đặt số lượng phần tử cho trang
        $this->OrderModel->__set('item_page', self::$item_page);

        //Lấy trang hiện tại nếu có
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->OrderModel->__set('current_page', $current_page);

        //Lấy từ khóa theo mã đơn hàng
        $code = isset($_GET['code']) ? trim($_GET['code']) : null;
        $this->OrderModel->__set('code', $code);

        //Lấy trạng thái đơn hàng
        $status = isset($_GET['status']) ? $_GET['status'] : 0;
        $this->OrderModel->__set('status', $status);

        //Lấy tổng thành viên để tính số trang
        $total_order_handle_page = $this->OrderModel->total_order_handle_page();
        $total_page = ceil($total_order_handle_page['total'] / self::$item_page);
        //Xử lý đường dẫn cho phân trang
        if ($total_page > 1) {
            $links = $this->handle_url_page($total_page, $current_page);
            $this->data['sub_content']['links'] = $links;
        }
        //Lấy thông tin đơn hàng
        $orders = $this->OrderModel->get_order_admin();
        //Lấy tổng số đơn hàng
        $total = $this->OrderModel->total();
        $this->data['sub_content']['total_order'] = $total;
        $this->data['title_page'] = 'Quản Lý Đơn Hàng';
        $this->data['content'] = 'admin/orders/index';
        $this->data['sub_content']['orders'] = $orders;
        $this->render('layouts/main_admin', $this->data);
    }
    public function handle_update_groups()
    {
        $groups = isset($_POST['order_groups']) ? $_POST['order_groups'] : [];
        $status = isset($_POST['status_current']) ? $_POST['status_current'] : false;
        if (!empty($groups) && $status) {
            //Xử lý nếu có đơn muốn duyệt
            $this->OrderModel->__sets(['status' => $status + 1, 'groups' => $groups]);
            $check_update = $this->OrderModel->update_order_groups();
            if ($check_update > 0) {
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Duyệt danh sách đơn hàng thành công!', 'type' => 'success'];
            }
        } else {
            $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Không có đơn nào được chọn!', 'type' => 'warning'];
        }
        header('Location: ' . _WEB_ROOT_ . '/admin/orders?status=' . $status);
    }
}