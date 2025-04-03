<?php
namespace app\controllers;
class Rate extends Base
{
    public array $data = [];
    private $RateImageModel;
    private $RateModel;
    private $OrderDetailModel;
    public function __construct()
    {
        $this->RateImageModel = $this->model('RateImageModel');
        $this->RateModel = $this->model('RateModel');
        $this->OrderDetailModel = $this->model('OrderDetailModel');
    }
    public function create_rating()
    {
        if (isset($_POST['submit_create_rating'])) {
            $imgs = $_FILES['img'] ?? null;
            //Xử lý thêm đánh giá
            $this->handle_post_data(data_post: $_POST);
            $rate_id = $this->RateModel->insert_rate();
            if ($rate_id) {
                $this->OrderDetailModel->__sets(['is_reviewed' => 1, 'id' => $_POST['Dorder_id']]);
                $this->OrderDetailModel->update_status_rate();

                //Xử lý Ảnh
                if (!empty($imgs['name'][0])) {
                    $this->handle_upload_img_rate($imgs, $rate_id);
                }
                $_SESSION['messager'] = ['title' => 'Thông báo!', 'mess' => 'Cảm ơn bạn đã đánh giá!', 'type' => 'success'];
            } else {
                $_SESSION['messager'] = ['title' => 'Thông báo!', 'mess' => 'Đánh giá thất bại!', 'type' => 'error'];
            }
            header('Location: ' . _WEB_ROOT_ . '/user/purchase?status=6');
        }
    }
    private function handle_post_data($data_post)
    {
        $this->RateModel->__sets([
            'user_id' => $data_post['user_id'],
            'pro_id' => $data_post['pro_id'],
            'review_text' => $data_post['review_text'],
            'rating' => $data_post['rating'],
            'name_variant' => $data_post['name_variant'],
        ]);
    }
    private function handle_upload_img_rate($files, $rate_id)
    {
        $target_dir = dirname(__DIR__, 2) . "/public/assets/img/rate/";
        foreach ($files['name'] as $index => $file) {
            if (empty($file))
                continue;
            $this->RateImageModel->__sets(['rate_id' => $rate_id, 'url_image' => $file]);
            $this->RateImageModel->insert_img_rate();

            $tmp_name = $files['tmp_name'][$index];
            $address_img = $target_dir . $file;
            move_uploaded_file($tmp_name, $address_img);
        }
    }
}