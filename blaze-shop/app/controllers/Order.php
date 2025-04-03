<?php

use PHPMailer\PHPMailer\POP3;

class Order extends Controller
{
    public $data = [];
    public $order_model;
    public $order_detail_model;
    public $payment_model;
    public $product_model;
    public $cart_detail_model;
    public $voucher_model;
    public $size_detail_model;

    public function __construct()
    {
        $this->order_model = $this->model('OrderModel');
        $this->order_detail_model = $this->model('OrderDetailModel');
        $this->payment_model = $this->model('PaymentModel');
        $this->product_model = $this->model('ProductModel');
        $this->cart_detail_model = $this->model('CartDetailModel');
        $this->voucher_model = $this->model('VoucherModel');
        $this->size_detail_model = $this->model('SizeDetailModel');
    }
    public function index()
    {
        $user_id = $_SESSION['user']['id'] ?? "";
        if (!$user_id) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Vui lòng đăng nhập để đặt hàng!', 'type' => 'error'];
            header("Location:" . _WEB_ROOT_ . "/tai-khoan");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : ""; //from detail
            $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : ""; //from detail
            $quantity_detail = isset($_POST['quantity_detail']) ? $_POST['quantity_detail'] : ""; //from detail
            $all_id = isset($_POST['all_id']) ? $_POST['all_id'] : ""; // from cart

            if ($pro_id && $selected_size && $quantity_detail) {
                $this->product_model->setId($pro_id);
                $prod = $this->product_model->getOnePro($this->product_model);
                $prod['size'] = $selected_size;
                $size_mapping = [
                    1 => "S",
                    2 => "M",
                    3 => "L",
                    4 => "XL",
                    5 => "XXL",
                ];
                $prod['size_name'] = $size_mapping[$prod['size']] ?? "Unknown";

                $prod['quantity'] = $quantity_detail;
                $pros = [$prod];
            } elseif ($all_id) {
                $all_id_array = explode(",", $all_id);
                $all_id_array = array_filter($all_id_array);
                $this->cart_detail_model->setId($all_id_array);
                $pros = $this->cart_detail_model->getDcartForOrder($this->cart_detail_model);
            }
        }
        $this->data['sub_content']['pros'] = $pros;

        $this->data['page_title'] = "Đặt hàng";
        $this->data['content'] = "cart/order";
        $this->render("layouts/client_layout", $this->data);
    }
    public function createOrder()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['voucher_id'])) {
                $voucher = str_replace(" ", "", $_POST['voucher_id']);
                $this->voucher_model->setCode($voucher);
                $isVoucher = $this->voucher_model->checkVoucher($this->voucher_model); // kiem tra voucher co dung hay k
            }

            $this->order_model->setUserId($_POST['user_id']);
            $this->order_model->setPhone($_POST['phone']);
            $this->order_model->setAddress($_POST['address']);
            $this->order_model->setVoucherId($voucher);

            $code_oder = $this->order_model->generateCoderOrder();
            $this->order_model->setCodeOrder($code_oder);

            $this->order_model->setNote($_POST['note']);
            $this->order_model->setTotal($_POST['total']);

            if ($isVoucher) {
                $order_id = $this->order_model->addOrder($this->order_model);
            } else {
                $order_id = $this->order_model->addOrderNoVoucher($this->order_model);
            }
            // xử lý order_detail
            if ($order_id) {
                $data_order_detail = [];
                $pro_ids = explode(".", $_POST['pro_ids']);
                $sizes = explode(".", $_POST['sizes']);
                $quantities = explode(".", $_POST['quantities']);
                $prices = explode(".", $_POST['prices']);
                $Dcart_id = explode(".", $_POST['Dcart_id']) ?? "";
                $flag_Dcart = false;
                foreach ($pro_ids as $key => $pro) {
                    if ($Dcart_id) {
                        $data_order_detail[] = [
                            'pro_id' => $pro,
                            'size' => $sizes[$key],
                            'quantity' => $quantities[$key],
                            'price' => $prices[$key],
                            'Dcart_id' => $Dcart_id[$key]
                        ];
                        $flag_Dcart = true;
                    } else {
                        $data_order_detail[] = [
                            'pro_id' => $pro,
                            'size' => $sizes[$key],
                            'quantity' => $quantities[$key],
                            'price' => $prices[$key]
                        ];
                    }

                }

                $order_detail_id = "";
                $this->order_detail_model->setOrder_id($order_id);
                foreach ($data_order_detail as $data) {
                    $this->order_detail_model->setProduct_id($data['pro_id']);
                    $this->order_detail_model->setSize($data['size']);
                    $this->order_detail_model->setQuantity($data['quantity']);
                    $this->order_detail_model->setPrice($data['price']);

                    $order_detail_id .= "," . $this->order_detail_model->addOrderDetail($this->order_detail_model); //HANDLE ORDER_DETAIL

                    //update so luong san pham
                    // $this->product_model->setSales($data['quantity']);
                    // $this->product_model->setId($data['pro_id']);
                    // $this->product_model->updateSalePro($this->product_model);

                    $this->size_detail_model->setQuantity($data['quantity']);
                    $this->size_detail_model->setProId($data['pro_id']);
                    $this->size_detail_model->setSizeId($data['size']);
                    $this->size_detail_model->updateQuantitySize($this->size_detail_model);

                    if ($flag_Dcart == true) {
                        $this->cart_detail_model->setId($data['Dcart_id']);
                        $this->cart_detail_model->delCartDetail($this->cart_detail_model); //DEL CART_DETAIL AFTER ADD ORDER_DETAIL
                    }

                }
                $order_detail_id = array_filter(explode(',', ltrim($order_detail_id, ',')));
                $this->order_detail_model->setId($order_detail_id);
                $data_order = $this->order_detail_model->getD_orderForSendMail($this->order_detail_model);
                $this->sendOrderMail($_SESSION['user']['email'], $_SESSION['user']['name'], $code_oder, $_POST['total'], $data_order);
                $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đặt hàng thành công', 'type' => 'success'];


            }

        }
        header("Location:" . _WEB_ROOT_ . "/cart");

    }

    public function sendOrderMail($recipient, $name_rep, $orderCode, $total, $orderDetails = [])
    {

        require_once '' . _DIR_ROOT . '/mail/mailer.php';
        $mail = new Mailer();
        $orderDetail = '';
        foreach ($orderDetails as $data) {
            $orderDetail .= '
            <tr>
                <td>' . htmlspecialchars($data['name'] ?? '') . '</td>    
                <td>' . htmlspecialchars($data['size'] ?? '') . '</td>
                <td>' . htmlspecialchars($data['quantity'] ?? '') . '</td>
                <td>' . htmlspecialchars($data['price'] ?? '') . '</td>
            </tr>';
        }

        $mail->sendOrder($recipient, $name_rep, $orderCode, $total, $orderDetail);
    }

    public function historyOrder()
    {
        $idUser = $_SESSION['user']['id'] ?? null;
        $this->order_model->setUserId($idUser);
        $order = $this->order_model->getAllOrderByIdUser($this->order_model);
        $this->data['sub_content']['order'] = $order;
        $status = [
            0 => 'Đã huỷ',
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            3 => 'Đang giao',
            4 => 'Đã giao'
        ];
        $this->data['sub_content']['status'] = $status;

        $this->data['page_title'] = "Đơn hàng";
        $this->data['content'] = "cart/order_history";
        $this->render("layouts/client_layout", $this->data);
    }

    public function showDorderByOrder()
    {

        if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
            $this->order_detail_model->setOrder_id($_POST['order_id']);
            $Dorder = $this->order_detail_model->getDorder($this->order_detail_model);
            $size = [
                1 => "S",
                2 => "M",
                3 => "L",
                4 => "XL",
                5 => "XXL"
            ];
            $output = '';
            foreach ($Dorder as $Dor) {
                $output .= '
                    <div class="pro-item-order">    

                        <div class="pro-order">
                            <div class="pro-img-order">
                            <img src="' . _WEB_ROOT_ . '/public/assets/img/' . $Dor['img'] . '" style="width: 100px;"alt="' . $Dor['name'] . '">
                            </div>
                            <div class="pro-info-order" >
                                <p class="item-title-order">Tên : ' . $Dor['name'] . '</p>
                                <p class="item-price-order">Giá : ' . number_format($Dor['price']) . 'đ</p>
                                <p class="item-quantity-order">Số lượng : ' . $Dor['quantity'] . '</p>
                                <p class="item-size-order">Size : ' . $size[$Dor['size']] . '</p>
                            </div>
                        </div>';
                if ($_POST['order_status'] == 4) {
                    if ($Dor['is_reviewed'] == 0) {
                        $output .= '
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="button" class="btn btn-success btn-sm reviewOrder button-show-rate" data-dorderid="'.$Dor['id'].'" data-productid="' . $Dor['product_id'] . '">Đánh giá</button>
                                </div>';
                    } else {
                        $output .= '<div class="d-flex justify-content-end mt-2">
                                    <button type="button" class="btn btn-warning btn-sm reviewOrder">Đã đánh giá</button>
                                </div>';
                    }
                }
                $output .= '</div>
                ';
            }
            if ($_POST['order_status'] == 1) {
                $output .= '
                <button class="btn btn-danger cancelOrder" data-id="${item.id}" data-order-id="'.$Dor['order_id'].'" >Hủy đơn</button>
                ';
            }
            echo $output;
        }

    }
    public function updateQuantity(){
        
        if(isset($_POST['plusQuantity'])){
            
        }elseif(isset($_POST['minusQuantity'])){

        }
        $this->size_detail_model->updateQuantity($this->size_detail_model);
    }
    
    public function showRate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['Dorder_id'])) {
            $this->product_model->setId($_POST['product_id']);
            $dataPro = $this->product_model->getOnePro($this->product_model);
            $this->order_detail_model->setProduct_id($_POST['product_id']);
            $Dorder_id = $_POST['Dorder_id'];
            $size = $this->order_detail_model->getSizeRate($this->order_detail_model);
            $sizes = [
                1 => "S",
                2 => "M",
                3 => "L",
                4 => "XL",
                5 => "XXL"
            ];
            if ($dataPro) {
                echo '<img src="' . _WEB_ROOT_ . '/public/assets/img/' . $dataPro['img'] . '" style="width: 80px;"alt="' . $dataPro['name'] . '">
                <div>
                    <p class="m-0">' . $dataPro['name'] . '</p>
                    <p class="m-0">Size: ' . $sizes[$size['size']] . '</p>
                </div>  
                <input type="hidden" name="pro_id" value="' . $dataPro['id'] . '">
                <input type="hidden" name="Dorder_id" value="' . $Dorder_id . '">
                <input type="hidden" name="name_size" value="' . $sizes[$size['size']] . '">';
            } else {
                echo 'Không tìm thấy sản phẩm có id: ' . $_POST['product_id'];
            }
        }
    }

    public function showOrderById(){
        $status = [
            0 => 'Đã huỷ',
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            3 => 'Đang giao',
            4 => 'Đã giao'
        ];
        $this->order_model->setUserId($_SESSION['user']['id']);
        $this->order_model->setStatus($_POST['status']);
        $orders = $this->order_model->getOrderByIdUserStatus($this->order_model);
        if(!$orders){
            echo '<p class="text-danger text-center fw-bold">Chưa có đơn nào</p>';
        }
        foreach($orders as $order){
            echo '
            <div class="pro-item-order">
                    <div class="status-time-order">
                        <p class="status-order">Trạng thái: <span class="wait-apply">'. $status[$order['status']] .'</span>
                        </p>
                        <p class="time-order">Thời gian: <span class="time-pro-order">'. $order['by_date'] .'</span> </p>
                    </div>
                    <p>Mã vận đơn: <span class="item-price-order">'. $order['code_order'] .'</span></p>
                    <p class="total-order">Tổng thanh toán: <span
                            style="color: #088178; font-weight: bold;">'. number_format($order['total']) .'đ</span></p>
                    <button class="details-button-order button-show-Dord" data-toggle="modal" data-target="#watchAllDord"
                        data-id="'. $order['id'] .'" data-orderstatus="'. $order['status'] .'">Xem chi tiết</button>
                </div>
            ';
        }
    }

    public function cancelOrder(){
        $this->order_model->setId($_POST['orderId']);
        $this->order_model->cancelOrder($this->order_model);
        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Huỷ đơn thành công!', 'type' => 'success'];
        exit();
    }
}