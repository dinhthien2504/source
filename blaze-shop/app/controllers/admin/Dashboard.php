<?php
class Dashboard extends Controller{
    public $data =[];
    public $subCategory_model;
    public $product_model;
    public $order_model;
    public $rate_model;
    public function __construct(){
        $this->subCategory_model = $this->model('SubCategoryModel');
        $this->product_model = $this->model('ProductModel');
        $this->order_model = $this->model('OrderModel');
        $this->rate_model = $this->model('RateModel');
    }
    public function index () {
        $chart = $this->product_model->getProByCateDashboard();
        $countCate = $this->subCategory_model->countCateAndSubCate();
        $countPro = $this->product_model->countPro();
        $countOrder = $this->order_model->countOrder();
        $countRate = $this->rate_model->countRateAdmin();
        $revenue = $this->order_model->getRevenue();
        if (isset($revenue)) {
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
                    $months[$item['month']] = (int)$item['monthly_total'];
                }
            }
            $months_js = array_keys($months); 
            $totals_js = array_values($months);
        }
        $this->data['sub_content']['chart'] = $chart;
        $this->data['sub_content']['countCate'] = $countCate;
        $this->data['sub_content']['countPro'] = $countPro;
        $this->data['sub_content']['countOrder'] = $countOrder;
        $this->data['sub_content']['countRate'] = $countRate;
        $this->data['sub_content']['months_js'] = $months_js;
        $this->data['sub_content']['totals_js'] = $totals_js;
        $this->data['sub_content']['info'] = 'Dữ liệu lấy từ model';
        $this->data['page_title'] = 'BLAZE-Admin - Dashboard';
        $this->data['content'] = 'admin/index';
        $this->render('layouts/admin_layout', $this->data);
    }
}