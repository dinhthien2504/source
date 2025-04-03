<?php
class Voucher extends Controller
{
    public $data = [];
    public $voucher_model;

    public function __construct()
    {
        $this->voucher_model = $this->model('VoucherModel');
    }

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codeAdd'])) {
            $this->addVoucher();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $this->deleteVoucher();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idShow'])) {
            $this->showEditModal();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUpdate'])) {
            $this->updateVoucher();
        }


        $voucher = $this->voucher_model->getAllVoucher();
        $this->data['sub_content']['dataVoucher'] = $voucher;
        $this->data['page_title'] = 'BLAZE-Admin - Voucher';
        $this->data['content'] = 'admin/vouchers/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    private function addVoucher()
    {
        $code = $_POST['codeAdd'];
        $discount = $_POST['discountAdd'];
        $max = $_POST['maxAdd'];
        $exp = $_POST['expAdd'];

        if (!$code || !$discount || !$max || !$exp) {

            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->voucher_model->setCode($code);
            $this->voucher_model->setDiscount($discount);
            $this->voucher_model->setMaxDis($max);
            $this->voucher_model->setExpiration($exp);
            $this->voucher_model->addVoucher($this->voucher_model);
            // Reload lại trang hiện tại
            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    private function deleteVoucher()
    {
        $this->voucher_model->setId($_POST['idDelete']);
        $this->voucher_model->deleteVoucher($this->voucher_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    }

    public function showEditModal()
    {

        $this->voucher_model->setId($_POST['idShow']); // Lấy ID danh mục
        $voucherShow = $this->voucher_model->getOneVoucher($this->voucher_model); // Lấy thông tin danh mục
        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($voucherShow) {
            echo json_encode($voucherShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy voucher']);
        }
    }

    private function updateVoucher()
    {
        $id = $_POST['idUpdate'];
        $code = $_POST['codeUpdate'];
        $discount = $_POST['discountUpdate'];
        $max = $_POST['maxUpdate'];
        $exp = $_POST['expUpdate'];

        if (!$code || !$discount || !$max || !$exp) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->voucher_model->setId($id);
            $this->voucher_model->setCode($code);
            $this->voucher_model->setDiscount($discount);
            $this->voucher_model->setMaxDis($max);
            $this->voucher_model->setExpiration($exp);
            $this->voucher_model->updateVoucher($this->voucher_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}
