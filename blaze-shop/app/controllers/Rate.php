<?php 
class Rate extends Controller {
    public $data = [];
    private $rate_model;
    private $rateImage_model;
    private $order_detail_model;
    public function __construct(){
        $this->rate_model = $this->model("RateModel");
        $this->rateImage_model = $this->model("RateImageModel");
        $this->order_detail_model = $this->model("OrderDetailModel");
    }
    public function addRate(){
        if(isset($_POST['submitRate'])){
            $idUser = $_POST['user_id'] ?: 1;
            $idPro = $_POST['pro_id'] ?: 1;
            $review = $_POST['review'] ?: '';
            $name_size = $_POST['name_size'] ?: '';
            $rating = $_POST['rating'] ?:1;
            $Dorder_id = $_POST['Dorder_id'] ?: null;
            
            $this->rate_model->setUser_id($idUser);
            $this->rate_model->setProduct_id($idPro);
            $this->rate_model->setReview_text($review);
            $this->rate_model->setName_size($name_size);
            $this->rate_model->setRating($rating);
    
            $lastIdRate = $this->rate_model->insertRate($this->rate_model);
    
            if($lastIdRate){
                $this->order_detail_model->setId($Dorder_id);
                $this->order_detail_model->setIs_reviewed(1);
                $this->order_detail_model->updateRate($this->order_detail_model);
                if (isset($_FILES['img']) && count($_FILES['img']) > 0) {
                    $files = $_FILES['img'];  
                    foreach($files['name'] as $index => $file){
                        if($file != ""){
                            if (in_array($files['type'][$index], ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'])) {
                                $this->rateImage_model->setRate_id($lastIdRate);
                                $tmpName = $files['tmp_name'][$index];
                                $target_dir = dirname(__DIR__, 2) . "/public/assets/img/";
                                $addressImg = $target_dir . $file;
    
                                $this->rateImage_model->setImg($file);
                                $this->rateImage_model->insertImg($this->rateImage_model);
                                
                                if (move_uploaded_file($tmpName, $addressImg)) {
                                   $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm ảnh thành công!', 'type' => 'success'];
                                    header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
                                } else {
                                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Có lỗi khi tải ảnh lên!', 'type' => 'error'];
                                    header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
                                }
                            } else {
                                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'File không phải dạng ảnh!', 'type' => 'error'];
                                header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
                            }
                        }
                    }
                    $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đánh giá của bạn đã được gửi!', 'type' => 'success'];
                    header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
                    exit();
                } else {
                    $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đánh giá của bạn đã được gửi!', 'type' => 'success'];
                    header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
                }
            } else {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Không tìm thấy đánh giá!', 'type' => 'error'];
                header("Location: "._WEB_ROOT_."/san-pham/ma-san-pham-".$idPro."");
            }
        }
    }
    
}