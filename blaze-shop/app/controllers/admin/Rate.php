<?php
class Rate extends Controller
{
    public $data = [];
    public $rate_model;


    public function __construct()
    {
        $this->rate_model = $this->model('RateModel');
    }


    public function index()
    {
        $listRate = $this->rate_model->getRateByPro();
        $this->data['sub_content']['rateData'] = $listRate;
        $this->data['page_title'] = 'BLAZE-Admin - Đánh Giá';
        $this->data['content'] = 'admin/rates/index';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function detail($id)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $this->deleteRate();
        }

        $this->rate_model->setProduct_id($id);
        $namePro = $this->rate_model->getProductNameById($this->rate_model);
        $this->rate_model->setProduct_id($id);
        $listRate = $this->rate_model->getCommentsWithImagesByProductId($this->rate_model);
        $this->data['sub_content']['rateData'] = $listRate;
        $this->data['productName'] = $namePro;
        $this->data['page_title'] = 'BLAZE-Admin - Đánh Giá';
        $this->data['content'] = 'admin/rates/detail';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function deleteRate()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
        // Lấy idDelete từ POST
        $idDelete = $_POST['idDelete'];
        echo 'ID DELETE: ' . $idDelete; // In ra để kiểm tra

        // Xóa bình luận và ảnh
        $this->rate_model->setId($idDelete);
        $result = $this->rate_model->deleteCommentAndImages($this->rate_model);

        if ($result) {
            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
        } else {
            $_SESSION['messger'] = ['title' => 'Lỗi', 'mess' => 'Không thể xóa bình luận!', 'type' => 'error'];
        }

        // Chuyển hướng lại trang chi tiết
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo 'Không có idDelete trong POST!';
        die();
    }
}

}
