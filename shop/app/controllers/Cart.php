<?php
namespace app\controllers;

use app\controllers\Base;
use app\mail\Mailer;
class Cart extends Base
{
    public $data = [];
    private $cart_model;
    private $pro_variant_model;
    private $province_model;
    private $order_model;
    private $order_detail_model;
    private $mail;
    private $PaymentModel;
    private $PaymentMethodModel;
    public function __construct()
    {
        $this->cart_model = $this->model('CartModel');
        $this->pro_variant_model = $this->model('ProVariantModel');
        $this->province_model = $this->model('ProvinceModel');
        $this->order_model = $this->model('OrderModel');
        $this->order_detail_model = $this->model('OrderDetailModel');
        $this->PaymentModel = $this->model('PaymentModel');
        $this->PaymentMethodModel = $this->model('PaymentMethodModel');
        $this->mail = new Mailer();
    }

    public function cart()
    {
        $user_id = $_SESSION['user']['id'] ?? 0;
        $this->cart_model->__set('user_id', $user_id);

        $data_cart_user_id = $this->cart_model->get_all_cart_by_user_id();
        $this->data['title_page'] = 'Giỏ Hàng';
        $this->data['sub_content']['data_carts'] = $data_cart_user_id;
        $this->data['content'] = 'carts/cart';
        $this->render('layouts/main', $this->data);
    }
    public function save_cart()
    {
        if (isset($_POST['submit_save_cart'])) {
            $this->cart_model->__sets([
                'user_id' => trim($_POST['user_id']),
                'pro_variant_id' => trim($_POST['pro_variant_id']),
                'quantity' => trim($_POST['pro_quantity']),
            ]);
            //Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            $check_isset_cart = $this->cart_model->check_cart();
            if ($check_isset_cart) {
                //Lấy số lượng trong kho 
                $this->pro_variant_model->__set('id', $_POST['pro_variant_id']);
                $quantity_stock = $this->pro_variant_model->get_quantity_by_id();
                //Kiểm tra số lường trong kho có đủ để thêm vào giỏ hàng hay không
                $total_quantity = $check_isset_cart['quantity'] + $_POST['pro_quantity'];
                if ($total_quantity <= $quantity_stock['quantity']) {
                    $this->cart_model->__sets(['id' => $check_isset_cart['id'], 'quantity_new' => $total_quantity]);
                    $this->cart_model->update_cart();
                    $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Đã cập nhật lại số lượng sản phẩm!', 'type' => 'success'];
                } else {
                    $_SESSION['messager'] = ['title' => 'Lỗi!', 'mess' => 'Tổng lượng hàng trong kho không đủ để thêm vào giỏ hàng của bạn!', 'type' => 'error'];
                }
            } else {
                $this->cart_model->insert_cart();
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Sản phẩm đã được thêm vào giỏ hàng!', 'type' => 'success'];
            }
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }

    public function handle_del($id)
    {
        if ($id) {
            $id_handle = is_array($id) ? $id : [$id];
            $this->cart_model->__sets($id_handle);
            $this->cart_model->delete_cart();
            $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Xóa sản phẩm thành công!', 'type' => 'success'];
            header('Location: ' . _WEB_ROOT_ . '/cart');
        }
    }

    public function handle_cart()
    {
        if (isset($_POST['pro_check__cart'])) {
            $data_check = $_POST['pro_check__cart'] ?? [];
        }
        //Xử lý xóa danh sách giỏ hàng
        if (isset($_POST['submit_handle__del'])) {
            if (!empty($data_check)) {
                $this->handle_del($data_check);
                header('Location: ' . _WEB_ROOT_ . '/cart');
            }
        }
        //Xử lý thanh toán danh sách sản phẩm
        if (isset($_POST['submit_handle__buy'])) {
            $this->checkout($_POST['pro_check__cart']);
        }
    }
    public function checkout($id)
    {
        //Dữ liệu sản phẩm lấy từ giỏ hàng để thanh toán
        $id = $id ?? 0;
        $this->cart_model->__sets($id);
        $data_cart_id = $this->cart_model->get_all_cart_by_cart_id();
        $this->data['sub_content']['data_carts'] = $data_cart_id;
        //Dữ liệu Tỉnh/Thành Phố
        $data_province = $this->province_model->get_all_province();
        $this->data['sub_content']['data_province'] = $data_province;
        //Lấy dữ liệu tất cả phương thức thanh Toán\
        $data_payment_method = $this->PaymentMethodModel->get_all_payment_method();
        $this->data['sub_content']['data_payment_method'] = $data_payment_method;
        $this->data['title_page'] = 'Thanh Toán';
        $this->data['content'] = 'carts/checkout';
        $this->render('layouts/main', $this->data);
    }
    public function handle_checkout()
    {
        if (isset($_POST['submit__checkout'])) {
            //Lưu thông tin vào session để chút xử lý
            $_SESSION['carts'] = $_POST;
            // Xử lý dữ liệu đơn hàng
            $payment = $_POST['payment'] ?? 1;
            if ($payment == 2) {
                // Nếu là MoMo QR
                $this->handle_payment_momoQR($_POST['total']);
                exit();
            } else if ($payment == 3) {
                // Nếu là MoMo ATM
                $this->handle_payment_momoATM($_POST['total']);
                exit();
            }
            //Tạo đơn hàng ngay lập tức nếu là thanh toán khi nhận hàng
            $order_id = $this->handleSaveOrder($_POST);
            $data_payment = [
                'amount' => $_POST['total'],
                'orderInfo' => 'Thanh toán khi nhận hàng',
                'resultCode' => 100,
            ];
            $this->handle_payment_data($data_payment, $_POST['payment'], $order_id);
            header('Location: ' . _WEB_ROOT_ . '/order-success');
        }
    }
    private function handleSaveOrder($dataPost)
    {
        $this->handle_order_data($dataPost);
        $order_id = $this->order_model->insert_order();
        if ($order_id) {
            // Xử lý dữ liệu chi tiết đơn hàng
            $order_details = $this->handle_order_detail__data($dataPost, $order_id);
            // Chèn danh sách chi tiết đơn hàng vào cơ sở dữ liệu
            $this->order_detail_model->__sets($order_details);
            if ($this->order_detail_model->insert_order_detail()) {
                $cart_ids = [];
                foreach ($dataPost['cart_id'] as $cart_id) {
                    $cart_ids[] = $cart_id;
                }
                $this->handle_del($cart_ids);
                $_SESSION['messager'] = ['title' => 'Thành công!', 'mess' => 'Tạo đơn hàng thành công!', 'type' => 'success'];
                //Thực hiện thao tác gửi mail
                $this->sendMailOrder($order_id);
            } else {
                echo 'Lỗi khi thêm chi tiết đơn hàng.<br>';
            }
        }
        return $order_id;
    }
    private function handle_order_data($data_post)
    {
        $code_order = 'S' . date("YmdHis");
        $this->order_model->__sets([
            $data_post['user_id'] ?? 0,
            $data_post['voucher_id'] ?? null,
            $data_post['staff_id'] ?? null,
            $code_order,
            $data_post['total'] ?? 0
        ]);
    }
    private function handle_order_detail__data($data_post, $order_id)
    {
        if (isset($data_post['pro_id']) && is_array($data_post['pro_id'])) {
            $order_details = [];
            foreach ($data_post['pro_id'] as $index => $pro_id) {
                $order_details[] = [
                    $pro_id,
                    $data_post['pro_variant_id'][$index],
                    $order_id,
                    $data_post['name_variant'][$index] ?? null,
                    $data_post['quantity'][$index] ?? 0,
                    $data_post['price'][$index] ?? 0
                ];
            }
        }

        return $order_details;
    }
    private function sendMailOrder($order_id)
    {
        //Lấy thông tin đơn hàng vừa đặt
        $this->order_detail_model->__set('order_id', $order_id);
        $data_Dorder = $this->order_detail_model->get_order_detail_by_order_id();
        //Lấy mã đơn hàng vừa đặt
        $this->order_model->__set('id', $order_id);
        $data_order = $this->order_model->get_order_by_id();
        $email = $_SESSION['user']['email'] ?? null;
        $name = $_SESSION['user']['name'] ?? null;
        $subject = 'Thong bao dat hang';
        $body = "Xin chào " . $name . "<br>";
        $body .= "Đơn hàng #" . $data_order['code_order'] . " của bạn sẽ được chuẩn bị và giao trong thời gian sớm nhất<br>";
        $body .= '<div style="
                height: auto;
                padding: 10px;
                margin: 10px;
                background-color: #eee;">
                    <h1 style="color: #0051ffe8; text-align: center; font-size: 27px;">Đặt Hàng Thành Công</h1>
                    <div style="padding: 0 20px;
                    background-color: #fff;" class="sendmail_row">
                        <div style="display: grid;
                        grid-template-columns: auto 1fr;
                        align-items: center;
                        grid-column-gap: 10px;" class="name_madh">
                            <p style="color: #444444;
                            font: 100;" class="title_madh">Mã Đơn Hàng: <span style="color: #444444;
                            font-weight: bold;">#' . $data_order['code_order'] . '</span></p>
                        </div>
                        <div>
                            <h2 style="font-weight: bold;">Bạn vừa mua:</h2>
                            <div style="display: grid;
                            grid-template-columns: auto 1fr;
                            align-items: center;" class="products_item_">';

        foreach ($data_Dorder as $item) {
            $body .= '<div style="display: grid;
                        grid-template-columns: auto 1fr;
                        grid-column-gap: 10px;" class="name">
                        <p style="color: #444444;">' . $item['name'] . '</p>
                        <p style="color: #444444;">Giá: <span style="font-weight: bold;">' . number_format($item['price']) . ' đ</span></p>
                        <p style="color: #444444; font-weight: bold; font-style: italic;" class="quantity_name">Phân loại: ' . $item['name_variant'] . ' x ' . $item['quantity'] . '</p>
                    </div>';
        }

        $body .= '</div>
                            <div class="sendmail_total">
                                <div style="display: grid;
                                grid-template-columns: auto 1fr;
                                grid-column-gap: 10px;
                                align-items: center;" class="item_total">
                                    <h4>Giá trị đơn hàng:</h4>
                                    <p>' . number_format($data_order['total']) . ' đ</p>
                                </div>
                                <div style="display: grid;
                                grid-template-columns: auto 1fr;
                                grid-column-gap: 10px;
                                align-items: center;" class="item_total">
                                    <h4>Phí vận chuyển:</h4>
                                    <p>0 VND</p>
                                </div>
                                <div style="display: grid;
                                grid-template-columns: auto 1fr;
                                grid-column-gap: 10px;
                                align-items: center;" class="item_total">
                                    <h4>Tổng cộng:</h4>
                                    <p style="color: #0051ffe8;
                                    font-size: 20px;
                                    font-weight: bold;" class="price_total">' . number_format($data_order['total']) . ' đ</p>
                                </div>
                                <div style="display: grid;
                                grid-template-columns: auto 1fr;
                                grid-column-gap: 10px;
                                align-items: center;" class="item_total">
                                    <h4>Phương thức thanh toán:</h4>
                                    <p>Thanh toán khi nhận hàng (COD)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Cảm ơn bạn đã đặt hàng tại: <span style="color: #0051ffe8;
                    font-weight: bold;
                    font-size: 24px;" class="sendMail_logo"><a href="">Shop</a></span></p>
                </div>';
        $this->mail->sendMail($email, $name, $subject, $body);
    }
    public function handle_payment()
    {
        if (isset($_GET)) {
            $data_post = $_SESSION['carts'];
            //Xử lý xong thì xóa giỏ hàng trong session
            unset($_SESSION['carts']);
            //Xử lý các chức năng khác

            if ($_GET['resultCode'] == 0) {
                //Giao dịch thành công, xử lý thêm tất cả dữ liệu đơn hàng và thông tin thanh toán vào db

                //Thêm đơn hàng và đơn hàng chi tiết
                $order_id = $this->handleSaveOrder($data_post);
                //Thêm thông tin phương thức thanh toán
                $this->handle_payment_data($_GET, $data_post['payment'], $order_id);
                header("Location: " . _WEB_ROOT_ . "/order-success");
            } else {
                $_SESSION['messager'] = ['title' => 'Cảnh báo!', 'mess' => 'Đơn hàng của bạn thanh toán thất bại!', 'type' => 'error'];
                header("Location: " . _WEB_ROOT_ . "/cart");
            }
        }
    }
    private function handle_payment_data($data_get, $payment, $order_id)
    {
        $this->PaymentModel->__sets([
            'order_id' => $order_id,
            'request_id' => $order_id,
            'amount' => $data_get['amount'],
            'order_info' => $data_get['orderInfo'],
            'trans_id' => $data_get['transId'] ?? null,
            'result_code' => $data_get['resultCode'],
            'message' => $data_get['message'] ?? null,
            'payment_method_id' => $payment,
            'response_time' => $data_get['responseTime'] ?? time(),
            'signature' => $data_get['signature'] ?? NULL,
            'status' => $payment > 1 ? 'Đã thanh toán' : 'Chưa thanh toán',
        ]);
        $this->PaymentModel->insertPayment();
    }
    public function order_success()
    {
        $this->data['title_page'] = 'Tạo đơn hàng thành công';
        $this->data['content'] = 'carts/order_success';
        $this->data['sub_content'] = [];
        $this->render('layouts/main', $this->data);
    }
    //Xử lý thanh toán momo QR
    private function handle_payment_momoQR($amount)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán qua MoMo QR";
        $orderId = time() . "";
        $redirectUrl = _WEB_ROOT_ . "/handle-payment";
        $ipnUrl = "http://localhost/shop/handle_checkout";
        $extraData = "";
        $requestId = time() . "";
        $requestType = "captureWallet";

        // Chuỗi cần ký (thứ tự chính xác)
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        // echo '<pre>';
        // var_dump($jsonResult);
        // exit;

        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']); // Chuyển hướng người dùng đến MoMo
        } else {
            echo "Lỗi khi tạo thanh toán: " . json_encode($jsonResult);
        }
    }
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Tăng timeout lên 10 giây
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);

        if ($result === false) {
            die('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

    //Xử lý thanh toán momo ATM
    private function handle_payment_momoATM($amount)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';

        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo ATM";
        $orderId = time() . "";
        $redirectUrl = _WEB_ROOT_ . "/handle-payment";
        $ipnUrl = "http://localhost/shop/handle_checkout";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']); // Chuyển hướng người dùng đến MoMo
        } else {
            echo "Lỗi khi tạo thanh toán: " . json_encode($jsonResult);
        }
    }
}

