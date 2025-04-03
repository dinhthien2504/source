<?php
class Order extends Controller
{
    public $data = [];
    public $order_model;
    public $size_detail_model;
    public $order_detail_model;

    public function __construct()
    {
        $this->order_model = $this->model('OrderModel');
        $this->size_detail_model = $this->model('SizeDetailModel');
        $this->order_detail_model = $this->model('OrderDetailModel');
    }

    public function index()
    {
        $this->order_model->setStatus(1);
        $this->data['sub_content']['orders'] = $this->order_model->getOrderByStatus($this->order_model);
        $status = [
            ['id' => 0, 'name' => 'Đã huỷ'],
            ['id' => 1, 'name' => 'Chờ xác nhận'],
            ['id' => 2, 'name' => 'Đã xác nhận'],
            ['id' => 3, 'name' => 'Đang giao'],
            ['id' => 4, 'name' => 'Đã giao'],
        ];
        $this->data['sub_content']['status'] = $status;
        $this->data['page_title'] = 'BLAZE-Admin - Đơn Hàng';
        $this->data['content'] = 'admin/orders/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function updateOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->order_model->setStatus($_POST['status']);
            $this->order_model->setStaffId($_SESSION['user']['id']);
            $this->order_model->setId($_POST['id']);
            if ($_POST['status'] == 1) {
                $this->order_model->updateStatusStaff1($this->order_model);
            } else if ($_POST['status'] == 3) {
                $this->order_model->updateStatus1($this->order_model);
                //update sale

                //update payment
            } else {
                $this->order_model->updateStatus1($this->order_model);
            }
        }
        echo $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật đơn hàng thành công', 'type' => 'success'];
        exit;
    }

    public function getDorderAdmin()
    {
        if (isset($_POST['order_id'])) {
            $this->order_detail_model->setOrder_id($_POST['order_id']);
            $order = $this->order_detail_model->getDorderAdmin($this->order_detail_model);
            $size = [
                1 => 'S',
                2 => 'M',
                3 => 'L',
                4 => 'XL',
                5 => 'XXL',
            ];
            $status = [
                ['id' => 0, 'name' => 'Đã huỷ'],
                ['id' => 1, 'name' => 'Chờ xác nhận'],
                ['id' => 2, 'name' => 'Đã xác nhận'],
                ['id' => 3, 'name' => 'Đang giao'],
                ['id' => 4, 'name' => 'Đã giao'],
            ];

            foreach ($order as $or) {
                $options = '';
                foreach ($status as $stat) {
                    if ($stat['id'] != $or['status'] && $stat['id'] != 0) {
                        $options .= '<option value="' . $stat['id'] . '">' . $stat['name'] . '</option>';
                    }
                }

                echo '
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box-pros d-flex my-3">
                                <img src="' . _WEB_ROOT_ . '/public/assets/img/' . $or['img'] . '" alt="lỗi" width="50px" height="50px">
                                <div class="mx-3">
                                    <p class="my-0">' . $or['name'] . '</p>
                                    <p class="my-1 text-danger">' . $or['price'] . '<span> x ' . $or['quantity'] . '</span> <span> : ' . $size[$or['size']] . '</span></p>
                                </div>
                            </div>
                            <select name="status" id="" style="width: 100%; height: 45px; border-radius: 7px; border: 1px solid gray" class="text-body">
                                <option value="' . $status[$or['status']]['id'] . '">' . $status[$or['status']]['name'] . '</option>
                                ' . $options . '
                            </select>
                            <input type="hidden" name="orderId" id="" value="' . $or['orderId'] . '">

                        </div>
                        <div class="col-sm-6 my-3">
                            <p>Khách hàng: <span>' . $or['user_name'] . '</span></p>
                            <p>Số điện thoại: <span>' . $or['number'] . '</span></p>
                            <p>Địa chỉ giao hàng: <span>' . $or['address'] . '</span></p>
                            <p>Thời gian: <span>' . $or['day_time'] . '</span></p>
                            <p>Phí vận chuyển: <span>Miễn ship</span></p>
                            <p>Thanh toán: <span>Thanh toán khi nhận hàng</span></p>
                            <p>Ghi chú: <span></span></p>
                            <p>Tổng tiền: <span class="text-danger">' . $or['total'] . '</span></p>
                        </div>
                    </div>
                ';
            }
        }
    }
    public function showOrderDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['order_id'])) {
            $this->order_detail_model->setOrder_id($_POST['order_id']);
            $order = $this->order_detail_model->getDorderAdmin($this->order_detail_model);
            $size = [
                1 => 'S',
                2 => 'M',
                3 => 'L',
                4 => 'XL',
                5 => 'XXL',
            ];
            $status = [
                0 => 'Đã huỷ',
                1 => 'Chờ xác nhận',
                2 => 'Đã xác nhận',
                3 => 'Đang giao',
                4 => 'Đã giao',
            ];
            $output = '';
            if (!empty($order)) {
                $output .= '
                <div class="row">
                    <div class="col-sm-6">
                        <p>Trạng thái: <span class="font-weight-bold">' . $status[$order[0]['status']] . '</span></p>';
                foreach ($order as $or) {
                    $output .= '        
                            <div class="box-pros d-flex my-3">
                                <img src="' . _WEB_ROOT_ . '/public/assets/img/' . $or['img'] . '" alt="lỗi" width="50px" height="50px">
                                <div class="mx-3">
                                    <p class="my-0">' . $or['name'] . '</p>
                                    <p class="my-1 text-danger">' . number_format($or['price']) . 'đ' . '<span> x ' . $or['quantity'] . '</span> <span> : ' . $size[$or['size']] . '</span></p>
                                </div>
                            </div>
                            <input type="hidden" name="orderId" id="" value="' . $or['orderId'] . '">
                    ';
                }
                $customerInfo = $order[0];
                $output .= '   
                    </div>
                        <div class="col-sm-6 my-3">
                            <p>Khách hàng: <span class="font-weight-bold">' . $customerInfo['user_name'] . '</span></p>
                            <p>Số điện thoại: <span class="font-weight-bold">' . $customerInfo['number'] . '</span></p>
                            <p>Địa chỉ giao hàng: <span class="font-weight-bold">' . $customerInfo['address'] . '</span></p>
                            <p>Thời gian: <span class="font-weight-bold">' . $customerInfo['day_time'] . '</span></p>
                            <p>Phí vận chuyển: <span class="font-weight-bold">Miễn ship</span></p>
                            <p>Thanh toán: <span class="font-weight-bold">Thanh toán khi nhận hàng</span></p>
                            <p>Ghi chú: <span class="font-weight-bold"></span></p>
                            <p>Tổng tiền: <span class="text-danger font-weight-bold">' . number_format($customerInfo['total']) . ' đ</span></p>
                        </div>
                    </div>
                ';
                echo $output;
            } else {
                echo 'Không tìm thấy id';
            }
        } else {
            echo 'Không tìm thấy id';
        }
    }

    public function showOrderById()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->order_model->setStatus($_POST['status']);
            $orders = $this->order_model->getOrderByStatus($this->order_model);
            $status = [
                0 => 'Đã huỷ',
                1 => 'Chờ xác nhận',
                2 => 'Đã xác nhận',
                3 => 'Đang giao',
                4 => 'Đã giao',
            ];
            // if($_POST['status'] == 4 || $_POST['status'] == 0){  

            foreach ($orders as $order) {
                $disabled = ($order['status'] == 4 || $order['status'] == 0) ? 'disabled' : '';
                echo '<tr>
                            <td class="align-middle">' . $order['code_order'] . '</td>
                            <td class="align-middle">' . $order['name'] . '</td>
                            <td class="align-middle">' . $order['by_date'] . ' đ</td>
                            <td class="align-middle">' . number_format($order['total']) . '</td>
                            <td class="text-primary align-middle fw-bold">' . $status[$order['status']] . '</td>
                            <td class="align-middle">
                                <button data-toggle="modal" 
                                        class="btn btn-outline-warning ml-2 showDetailOrder"
                                        data-target="#showOrderModal" 
                                        data-id="' . $order['id'] . '">
                                    <i class="ri-edit-box-line"></i>
                                </button>
                                <button class="btn btn-outline-success change-status-btn ml-2" 
                                        data-target="#editStatusOrder" 
                                        ' . $disabled . '
                                        data-id="' . $order['id'] . '" data-status = ' . $order['status'] . '  onclick="return confirm(' . "'Duyệt đơn hàng này?'" . ')" >
                                    <i class="ri-refresh-line"></i>
                                </button>
                            </td>
                        </tr>';
            }// end foreach

            // }
        }
    }
}