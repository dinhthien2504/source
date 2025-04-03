<?php
namespace app\controllers;
use app\controllers\Base;

class Ajax extends Base
{
    public $data;
    private $ProVariantModel, $CategoryModel, $AttriValueModel, $OrderModel, $OrderDetailModel, $CartModel, $ProvinceModel, $DistrictModel, $WardModel, $UserModel;
    public function __construct()
    {
        $this->ProVariantModel = $this->model('ProVariantModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->AttriValueModel = $this->model('AttriValueModel');
        $this->CartModel = $this->model('CartModel');
        $this->OrderModel = $this->model('OrderModel');
        $this->OrderDetailModel = $this->model('OrderDetailModel');
        $this->ProvinceModel = $this->model('ProvinceModel');
        $this->DistrictModel = $this->model('DistrictModel');
        $this->WardModel = $this->model('WardModel');
        $this->UserModel = $this->model('UserModel');
    }
    //Các hàm trang sản phẩm
    public function get_size()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->ProVariantModel->__set('pro_id', $_POST['pro_id']);
            $this->ProVariantModel->__set('cor_id', $_POST['cor_id']);
            $data = $this->ProVariantModel->get_size_by_cor_id();
            if (!empty($data)) {
                $out_put = '';
                foreach ($data as $item) {
                    if ($item['quantity'] > 0) {
                        $out_put .= '<button onclick="get_quantity(this, \'.size\', \'' . $item['pro_id'] . '\', \'' . $item['cor_id'] . '\', \'' . $item['size_id'] . '\')"
                        class="size ">' . $item['name'] . '</button>';
                    } else {
                        $out_put .= '<button onclick="get_quantity(this, \'.size\', \'' . $item['pro_id'] . '\', \'' . $item['cor_id'] . '\', \'' . $item['size_id'] . '\')"
                        class="size custom-disabled-quantity">' . $item['name'] . '</button>';
                    }
                }
                echo $out_put;
            }
        }
    }
    public function get_quantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->ProVariantModel->__set('pro_id', $_POST['pro_id']);
            if (isset($_POST['cor_id']) && isset($_POST['size_id'])) {
                $this->ProVariantModel->__set('cor_id', $_POST['cor_id']);
                $this->ProVariantModel->__set('size_id', $_POST['size_id']);
            }
            if (isset($_POST['cor_id']) && !isset($_POST['size_id'])) {
                $this->ProVariantModel->__set('cor_id', $_POST['cor_id']);
            }
            if (isset($_POST['size_id']) && !isset($_POST['cor_id'])) {
                $this->ProVariantModel->__set('size_id', $_POST['size_id']);
            }
            $data = $this->ProVariantModel->get_quantity();
            echo json_encode($data);
        }
    }

    //cart
    public function update_quantity_cart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
            $this->CartModel->__sets(['quantity_new' => $_POST['quantity'], 'id' => $_POST['cart_id']]);
            $check = $this->CartModel->update_cart();
            if ($check > 0) {
                echo 1;
            }
        }
    }

    // order
    public function get_province()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = $this->ProvinceModel->get_all_province();
            if (!empty($data)) {
                $out_put = '';
                foreach ($data as $province) {
                    $out_put .= '<li onclick="get_district_province_id(\'' . $province['id'] . '\', \'' . $province['name'] . '\')">' . $province['name'] . '</li>';
                }
                echo $out_put;
            }
        }
    }
    public function get_district_province_id()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->DistrictModel->__set('province_id', $_POST['province_id']);
            $data = $this->DistrictModel->get_all_district_by_province_id();
            if (!empty($data)) {
                $out_put = '';
                foreach ($data as $district) {
                    $out_put .= '<li onclick="get_ward_district_id(\'' . $district['id'] . '\', \'' . $district['name'] . '\')">' . $district['name'] . '</li>';
                }
                echo $out_put;
            }
        }
    }
    public function get_ward_district_id()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->WardModel->__set('district_id', $_POST['district_id']);
            $data = $this->WardModel->get_all_ward_by_district_id();
            if (!empty($data)) {
                $out_put = '';
                foreach ($data as $ward) {
                    $out_put .= '<li onclick="action_ward(\'' . $ward['name'] . '\')">' . $ward['name'] . '</li>';
                }
                echo $out_put;
            }
        }
    }

    //User
    public function update_address()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'] ?? 0;
            $this->UserModel->__sets([trim($_POST['name']), trim($_POST['phone']), trim($_POST['address']), trim($_POST['address_detail']), $user_id]);
            $check = $this->UserModel->update_order_user();
            if ($check > 0) {
                $_SESSION['user']['name'] = $_POST['name'];
                $_SESSION['user']['phone'] = $_POST['phone'];
                $_SESSION['user']['address'] = $_POST['address'];
                $_SESSION['user']['address_detail'] = $_POST['address_detail'];
                echo $check;
            }
        }
    }
    public function check_email()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->UserModel->__set('email', trim($_POST['email']));
            $check = $this->UserModel->get_user_login();
            if (!empty($check)) {
                echo 1;
            }
        }
    }
    public function get_order_detail_by_id()
    {
        $status = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            3 => 'Đang giao',
            4 => 'Đã giao',
            5 => 'Đã hủy',
            6 => 'Hoàn thành',
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->OrderModel->__set('id', $id);
            $this->OrderDetailModel->__set('order_id', $id);
            //Lấy thông tin người đặt hàng
            $order = $this->OrderModel->get_order_by_id();
            //Lấy thông tin sản phẩm đơn Hàng
            $order_detais = $this->OrderDetailModel->get_order_detail_by_order_id();
            if (!empty($order) && !empty($order_detais)) {
                $output = '
                <div class="row">
                    <div class="col-sm-6 fs-17">
                        <p>Trạng thái: <span class="fw-bold">' . $status[$order['status']] . '</span></p>';
                foreach ($order_detais as $Dorder) {
                    $output .= '<div v-for="Dorder in dataDorderByOrderId" class="box-pros d-flex my-3">
                            <img src="' . _WEB_ROOT_ . '/public/assets/img/pro/' . $Dorder['url_image'] . '" alt="lỗi" width="70px" height="70px">
                            <div class="mx-3">
                                <a onclick="handle__url_link(this, \'' . _WEB_ROOT_ . '\', \'' . addslashes($Dorder['name']) . '\', \'i' . $Dorder['pro_id'] . '\')" class="text-decoration-none text-black my-0 cursor-pointer">
                                    ' . $Dorder['name'] . '
                                </a>
                                <p class="my-1 text-danger">Giá: ' . number_format($Dorder['price']) . ' đ<span> x ' . $Dorder['quantity'] . '</span></p>
                                <p class="my-1 text-danger"><span>Phân loại: ' . $Dorder['name_variant'] . '</span></p>';
                    if ($order['status'] == 6 && $Dorder['is_reviewed'] == 0) {
                        $output .= '<button onclick="show_add_rating(\'' . $Dorder['id'] . '\')" class="custom_btn_rating">Đánh giá</button>';
                    } else if ($order['status'] == 6 && $Dorder['is_reviewed'] == 1) {
                        $output .= '<button class="custom_btn_rating_warning">Đã đánh giá</button>';
                    }
                    $output .= '</div>
                            <hr class="text-black">
                        </div>';
                }

                $output .= '</div>
                    <div class="col-sm-6 my-3 fs-17">
                        <p>Trạng thái thanh toán: <span class="fw-bold">' . $order['status_payment'] . '</span></p>
                        <p>Khách hàng: <span class="fw-bold">' . $order['name'] . '</span></p>
                        <p>Số điện thoại: <span class="fw-bold">' . $order['phone'] . '</span></p>
                        <p>Địa chỉ giao hàng: <span class="fw-bold">' . $order['address'] . ', ' . $order['address_detail'] . '</span>
                        </p>
                        <p>Thời gian: <span class="fw-bold">' . $order['by_date'] . '</span></p>
                        <p>Phí vận chuyển: <span class="fw-bold">Miễn ship</span></p>
                        <p>Thanh toán: <span class="fw-bold">' . $order['order_info'] . '</span></p>
                        <p>Tổng tiền: <span class="text-danger fw-bold">' . number_format($order['total']) . ' đ</span></p>
                    </div>
                </div>
                ';
                echo $output;
            }
        }
    }

    //Rate
    public function show_add_rating()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Dorder_id'])) {
            $this->OrderDetailModel->__set('id', $_POST['Dorder_id']);
            $data = $this->OrderDetailModel->get_order_detail_by_id();
            if ($data) {
                echo '<img src="' . _WEB_ROOT_ . '/public/assets/img/pro/' . $data['url_image'] . '" style="width: 80px;"alt="' . $data['name'] . '">
                <div>
                    <p class="m-0 fs-17">' . $data['name'] . '</p>
                    <p class="m-0 fs-17">Phân loại: ' . $data['name_variant'] . '</p>
                </div>  
                <input type="hidden" name="pro_id" value="' . $data['pro_id'] . '">
                <input type="hidden" name="Dorder_id" value="' . $_POST['Dorder_id'] . '">
                <input type="hidden" name="name_variant" value="' . $data['name_variant'] . '">';
            }
        }

    }
    //Các hàm trang thêm sản phẩm admin
    public function get_cate_chirld_by_parent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->CategoryModel->__set('parent_id', $_POST['parent_id']);
            $data = $this->CategoryModel->get_all_cate_by_parent_id();
            if (!empty($data)) {
                $out_put = '';
                foreach ($data as $cate) {
                    $out_put .= '<li onclick="action_cate_chirld(this, ' . $cate['id'] . ', \'' . $cate['name'] . '\')">
                                <div class="d-flex align-items-center justify-content-between">
                                    ' . $cate['name'] . '
                                    <i class="ph ph-caret-right"></i>
                                </div>
                            </li>';
                }
                echo $out_put;
            }
        }
    }
    public function get_attri_val_by_attri_id()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->AttriValueModel->__set('attri_id', $_POST['attri_id']);
            $data = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            if (!empty($data)) {
                $out_put = '<option value="">Chọn</option>';
                foreach ($data as $attri_val) {
                    $out_put .= '<option data-type="' . $attri_val['id'] . '" value="' . $attri_val['id'] . '">' . $attri_val['name'] . '</option>';
                }
                echo $out_put;
            }
        }
    }
    public function get_attri_val_select_2()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->AttriValueModel->__set('attri_id', 2);
            $data = $this->AttriValueModel->get_all_attri_val_by_attri_id();
            if (!empty($data)) {
                $__out_put = '
                 <div class="row g-2 container__option">
                    <div class="col-2">
                        <p class="fs-15">Phân loại 2</p>
                    </div>
                    <div class="col-10">
                        <div class="d-flex align-items-center justify-content-between">
                        <select class="custom-form__select w-50 main-select" id="check_show_option2">
                            <option value="2">Size</option>
                        </select>
                        <button type="button" onclick="del_select__2()" class="btn text-secondary fs-5"><i class="fa-solid fa-delete-left"></i></button>
                        </div>
                    </div>
                    <div class="col-2">
                        <p class="fs-15">Tùy chọn</p>
                    </div>
                    <div class="col-10">
                        <div class="row g-2 select-group">
                            <div class="col-6 select-template">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <select name="pro_two_option[]" class="custom-form__select w-100 option-select show_select show_option_select2">
                                        <option value="">Chọn</option>';
                foreach ($data as $attri_val) {
                    $__out_put .= '<option value="' . $attri_val['id'] . '">' . $attri_val['name'] . '</option>';
                }
                $__out_put .= '</select>
                                                    <div class="text-secondary del_option" style="cursor: pointer;">
                                                        <i class="ph ph-trash-simple"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';
                echo $__out_put;
            }
        }
    }

    //Các hàm xử lý danh mục admin
    public function get_cate_by_cate_id()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->CategoryModel->__set('id', $_POST['cate_id']);
            $data = $this->CategoryModel->get_one_cate_by_id();
            if (!empty($data)) {
                $data_cate_parent = $this->CategoryModel->get_all_cate_parent_edit();
                $url_main = 'https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png';
                $url_img = ($data['url_image'] == null) ? $url_main : '' . _WEB_ROOT_ . '/public/assets/img/cate/' . $data['url_image'];
                $output = '';
                $output .= '<div class="mb-3">
                    <label class="fs-15" for="name_cate">Tên danh mục <span class="star">*</span></label>
                    <input type="text" class="form-control fs-15" value="' . $data['name'] . '" id="name_cate_edit" name="name_cate">
                    </div>                                                                  
                    <div class="mb-3">  
                        <label class="fs-15" for="parent_id">Danh mục cha</label>
                        <select class="form-select fs-15" id="parent_id" name="parent_id">  
                            <option value="0">None</option>';
                foreach ($data_cate_parent as $cate) {
                    $selected = ($data['parent'] == $cate['id']) ? 'selected' : '';
                    $output .= '<option value="' . $cate['id'] . '" ' . $selected . '>' . $cate['name'] . '</option>';
                }
                $output .= '</select>
                    </div>
                    <div class="mb-3">
                        <label class="fs-15" for="img_cate">Hình ảnh</label>
                        <div onclick="action_input(this)"
                            class="custom-content__box--img--basic custom--flex__column">
                            <input type="hidden" name="cate_id" value="' . $data['id'] . '">
                            <input type="hidden" name="parent_old" value="' . $data['parent'] . '">
                            <p class="m-0 fs-12 text-center">Chọn ảnh</p>
                            <input type="file" hidden name="img_cate" class="input_file" onchange="handle_img__cor_change(this)">
                            <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary w-100">
                                <img src="' . $url_img . '" class="w-50 h-50" alt="hinh-anh">
                            </div>
                        </div>
                    </div>';
                echo $output;
            }
        }
    }

    //Các hàm xử lý thành viên Admin
    public function get_user_by_id()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->UserModel->__set('id', $_POST['id']);
            $data = $this->UserModel->get_user_by_id();
            if (!empty($data)) {
                $output = '<div class="text-center">
                    <h3 class="fs-2 fw-normal">Chỉnh Sửa Thành Viên</h3>
                </div>
                <div class="flex-column">
                    <label>Tên </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5z"></path>
                        <path d="M12 14c-4.4 0-8 3.6-8 8h16c0-4.4-3.6-8-8-8z"></path>
                    </svg>
                    <input placeholder="Nhập tên" id="name_edit" value="' . $data['name'] . '" name="name_edit" class="input" type="text" />
                </div>
                <div class="flex-column">
                    <label>Email </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                        <g data-name="Layer 3" id="Layer_3">
                            <path
                                d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
                            </path>
                        </g>
                    </svg>
                    <input disabled placeholder="Nhập email" value="' . $data['email'] . '" id="email_edit" name="email_edit" class="input" type="text" />
                </div>

                <div class="flex-column">
                    <label>Mật Khẩu </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                        <path
                            d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
                        </path>
                        <path
                            d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
                        </path>
                    </svg>
                    <input disabled placeholder="Nhập mật khẩu" value="' . $data['password'] . '" id="pwd_edit" name="pwd_edit" class="input" type="password" />
                </div>
                <div class="flex-column">
                    <label>Vai trò </label>
                </div>
                <div class="mb-3">
                    <select name="role_edit" class="custom-form-select">
                        <option ' . ($data['role'] == 0 ? 'selected' : '') . ' value="0">Khách hàng</option>
                        <option ' . ($data['role'] == 2 ? 'selected' : '') . ' value="2">Quản trị</option>
                    </select>
                </div>
                <input type="hidden" name="id_edit" value="' . $data['id'] . '">
                <button type="submit" id="submit_new_user" class="button-submit">Cập Nhật</button>';
                echo $output;
            }
        }
    }

    //Các hàm xử lý đơn hàng Admin
    public function update_status_order()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $this->OrderModel->__sets(['status' => $status, 'id' => $id]);
            $check_update = $this->OrderModel->update_order();
            echo $check_update;
            if ($check_update) {
                echo '1';
            }
        }
    }
    public function get_order_detail()
    {
        $status = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            3 => 'Đang giao',
            4 => 'Đã giao',
            5 => 'Đã hủy',
            6 => 'Hoàn thành',
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->OrderModel->__set('id', $id);
            $this->OrderDetailModel->__set('order_id', $id);
            //Lấy thông tin người đặt hàng
            $order = $this->OrderModel->get_order_by_id();
            //Lấy thông tin sản phẩm đơn Hàng
            $order_detais = $this->OrderDetailModel->get_order_detail_by_order_id();
            if (!empty($order) && !empty($order_detais)) {
                $output = '
                <div class="row">
                    <div class="col-sm-6">
                        <p>Trạng thái: <span class="fw-bold">' . $status[$order['status']] . '</span></p>';
                foreach ($order_detais as $Dorder) {
                    $output .= '<div v-for="Dorder in dataDorderByOrderId" class="box-pros d-flex my-3">
                            <img src="' . _WEB_ROOT_ . '/public/assets/img/pro/' . $Dorder['url_image'] . '" alt="lỗi" width="70px" height="70px">
                            <div class="mx-3">
                                <p class="my-0">' . $Dorder['name'] . '</p>
                                <p class="my-1 text-danger">Giá: ' . number_format($Dorder['price']) . ' đ<span> x ' . $Dorder['quantity'] . '</span></p>
                                <p class="my-1 text-danger"><span>Phân loại: ' . $Dorder['name_variant'] . '</span></p>
                            </div>
                            <hr class="text-black">
                        </div>';
                }

                $output .= '</div>
                    <div class="col-sm-6 my-3">
                        <p>Trạng thái thanh toán: <span class="fw-bold">' . $order['status_payment'] . '</span></p>
                        <p>Khách hàng: <span class="fw-bold">' . $order['name'] . '</span></p>
                        <p>Số điện thoại: <span class="fw-bold">' . $order['phone'] . '</span></p>
                        <p>Địa chỉ giao hàng: <span class="fw-bold">' . $order['address'] . ', ' . $order['address_detail'] . '</span>
                        </p>
                        <p>Thời gian: <span class="fw-bold">' . $order['by_date'] . '</span></p>
                        <p>Phí vận chuyển: <span class="fw-bold">Miễn ship</span></p>
                        <p>Thanh toán: <span class="fw-bold">' . $order['order_info'] . '</span></p>
                        <p>Tổng tiền: <span class="text-danger fw-bold">' . number_format($order['total']) . ' đ</span></p>
                    </div>
                </div>
                ';
                echo $output;
            }
        }
    }
}


