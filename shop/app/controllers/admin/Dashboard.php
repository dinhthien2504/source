<?php
namespace app\controllers\admin;
use app\controllers\Base;
use DateTime;
class Dashboard extends Base
{
    public $data;
    private $CategoryModel, $ProductModel, $OrderModel;
    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->render_error("403");
            exit();
        }
        $this->CategoryModel = $this->model('CategoryModel');
        $this->ProductModel = $this->model('ProductModel');
        $this->OrderModel = $this->model('OrderModel');
    }
    public function index()
    {
        $this->data['title_page'] = 'Dashboard';
        //Lấy tổng danh mục
        $total_cate = $this->CategoryModel->total();
        $this->data['sub_content']['total_cate'] = $total_cate;
        //Lấy tổng sản Phẩm
        $total_pro = $this->ProductModel->total();
        $this->data['sub_content']['total_pro'] = $total_pro;
        //Lấy tổng đơn hàng
        $total_order = $this->OrderModel->total();
        $this->data['sub_content']['total_order'] = $total_order;
        //Lấy tổng đơn hàng mới
        $this->OrderModel->__set('status', 1);
        $total_order_new = $this->OrderModel->total_order_by_status();
        $this->data['sub_content']['total_order_new'] = $total_order_new;
        //Lấy dữ liệu sơ đồ chart
        $data_chart = $this->ProductModel->get_pro_by_cate_dashboard();
        $this->data['sub_content']['data_chart'] = $data_chart;

        //Lấy dữ liệu biểu đồ
        $revenue = $this->OrderModel->get_revenue();
        // echo '<pre>';
        // var_dump($revenue);
        if (!empty($revenue)) {
            $months = [];
            // Sử dụng DateTime để tính toán 12 tháng gần nhất
            $currentDate = new DateTime(); // Ngày hiện tại
            $currentDate->modify('first day of this month'); // Đặt ngày thành đầu tháng hiện tại
            // Tạo mảng chứa tất cả các tháng trong 12 tháng gần nhất
            for ($i = 11; $i >= 0; $i--) {
                // Tính toán tháng dựa trên DateTime
                $month = clone $currentDate; // Clone đối tượng DateTime để tránh thay đổi gốc
                $month->modify("-$i month"); // Trừ $i tháng

                // Chuyển đổi thành định dạng 'Y-m'
                $monthStr = $month->format('Y-m');

                // Gán giá trị ban đầu là 0
                $months[$monthStr] = 0;
            }

            foreach ($revenue as $item) {
                if (isset($months[$item['month']])) {
                    $months[$item['month']] = (int) $item['monthly_total'];
                }
            }
            $months_js = array_keys($months);
            $totals_js = array_values($months);
            $this->data['sub_content']['months_js'] = $months_js;
            $this->data['sub_content']['totals_js'] = $totals_js;
        }

        $this->data['content'] = 'admin/dashboard';
        $this->render('layouts/main_admin', $this->data);
    }

}