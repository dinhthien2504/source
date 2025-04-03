<?php
class Cart extends Controller {
    public $data =[];
    public $cart_model;    
    public $cart_detail_model;

    public function __construct()
    {
        $this->cart_model = $this->model('CartModel');
        $this->cart_detail_model = $this->model('CartDetailModel');
    }
    public function index () {
        // $user_id = $_SESSION['user']['id'];
        // if(!$user_id){
        //     
        // }
        if(isset($_SESSION['user'])){

            $this->cart_model->setUser_id($_SESSION['user']['id']);
            $cart = $this->cart_model->getCart($this->cart_model);

            $this->data['sub_content']['carts'] = $cart;
            
            $this->data['page_title'] = 'Giỏ Hàng';
            $this->data['content'] = 'cart/index';  
            $this->render('layouts/client_layout', $this->data);
        }else{
            $_SESSION['messger'] = ['title'=>'Thất bại', 'mess'=>'Vui lòng đăng nhập để xem giỏ hàng', 'type'=>'error'];
            header("Location:"._WEB_ROOT_."/tai-khoan");
            exit;
        }
        
    }

    public function addCart(){
        $user_id = $_SESSION['user']['id'];
        if(!$user_id){
            $_SESSION['messger'] = ['title'=>'Thất bại', 'mess'=>'Vui lòng đăng nhập để xem giỏ hàng', 'type'=>'error'];
            header("Location:"._WEB_ROOT_."/tai-khoan");
            exit;
        }
        $this->cart_model->setUser_id($user_id);
        $isCart = $this->cart_model->checkCart($this->cart_model);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $selectedSize = isset($_POST['selected_size']) ? $_POST['selected_size'] : null;
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
            $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : 'loi';
            if($isCart){
                $this->cart_detail_model->setProductId($pro_id);
                $this->cart_detail_model->setCartId($isCart[0]['id']);
                $this->cart_detail_model->setQuantity($quantity);
                $this->cart_detail_model->setSize($selectedSize);

                $checkProCart = $this->cart_detail_model->checkProCart($this->cart_detail_model);
                if($checkProCart){ 
                    $flag_update = false;
                    foreach($checkProCart as $pro_cart){
                        if($pro_cart['size'] == $selectedSize){
                            $afterQuan = $quantity + $pro_cart['quantity'];
                            $this->cart_detail_model->setId($pro_cart['id']);
                            $this->cart_detail_model->setQuantity($afterQuan);
                            $this->cart_detail_model->updateQuan($this->cart_detail_model);
                            $flag_update = true;
                            break;
                        }
                        
                    }
                    if(!$flag_update){
                        $this->cart_detail_model->addCartDetail($this->cart_detail_model);
                    }
                }else{
                    $this->cart_detail_model->addCartDetail($this->cart_detail_model);
                }

            }else{
                $this->cart_model->addcart($this->cart_model);
                $isCart = $this->cart_model->checkCart($this->cart_model);
                $this->cart_detail_model->setProductId($pro_id);
                $this->cart_detail_model->setCartId($isCart[0]['id']);
                $this->cart_detail_model->setQuantity($quantity);
                $this->cart_detail_model->setSize($selectedSize);
                $this->cart_detail_model->addCartDetail($this->cart_detail_model);
            }
            header("Location: "._WEB_ROOT_."/gio-hang");
        }
    }

    public function delCart($Dcart_id){
        $this->cart_detail_model->setId($Dcart_id);
        $this->cart_detail_model->delCartDetail($this->cart_detail_model);
        header("Location: "._WEB_ROOT_."/cart");
    }

    public function plusCart($Dcart_id){
        $this->cart_detail_model->setId($Dcart_id);
        $Dcart = $this->cart_detail_model->getDcart($this->cart_detail_model);
        $quanPlus = $Dcart['quantity'] + 1;
        $this->cart_detail_model->setQuantity($quanPlus);
        $this->cart_detail_model->updateQuan($this->cart_detail_model);
        header("Location: "._WEB_ROOT_."/cart");

    }
    public function miniusCart($Dcart_id){
        $this->cart_detail_model->setId($Dcart_id);
        $Dcart = $this->cart_detail_model->getDcart($this->cart_detail_model);
        $quanMinius = $Dcart['quantity'] - 1;
        $this->cart_detail_model->setQuantity($quanMinius);
        $this->cart_detail_model->updateQuan($this->cart_detail_model);
        header("Location: "._WEB_ROOT_."/cart");
    }
}