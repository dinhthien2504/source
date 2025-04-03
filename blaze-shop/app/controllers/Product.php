<?php
class Product extends Controller
{

    public $data = [];
    public $product_model;
    public $category_model;
    public $subcategory_model;
    public $rate_model;
    public $size_detail_model;
    public function __construct()
    {
        $this->product_model = $this->model('ProductModel');
        $this->category_model = $this->model('CategoryModel');
        $this->subcategory_model = $this->model('SubCategoryModel');
        $this->rate_model = $this->model('RateModel');
        $this->size_detail_model = $this->model('SizeDetailModel');
    }
    public function index($idSubCate = '', $page = 1)
    {
        $dataPro = [];
        $item_per_page = 6;

        $this->product_model->setSubCategory_id($idSubCate);
        $idSubCate = $idSubCate ?: 1;
        if (isset($_POST['submitFilter']) && $_POST['submitFilter'] !== '') {
            $filter = trim($_POST['submitFilter']);
            $method = 'price';
            $this->data['sub_content']['filter'] = $filter;
        } else {
            $filter = 'DESC';
            $method = 'id';
        }
        if (isset($_POST['submitSearch'])) {
            if ($_POST['submitSearch'] != '') {
                $search = trim($_POST['submitSearch']);
            } else {
                $search = trim($_POST['kyw']);
            }
            $dataPro = $this->product_model->getAllPro('id', 8, $this->product_model, $search);
        } else {
            $dataPro = $this->product_model->getAllPro($method, $item_per_page, $this->product_model, null, $page, $filter);
            $countProByIdCate = $this->product_model->countProByIdSubCate($this->product_model);
            $total_page = ceil($countProByIdCate['total'] / $item_per_page);
            $this->data['sub_content']['totalPage'] = $total_page;
            $this->show_page($idSubCate, 'san-pham/danh-muc-', $total_page, $page);
            $this->data['sub_content']['pagination'] = ob_get_clean();
        }
        $dataCategory = $this->category_model->getAllCateClient();
        $dataSubCategory = $this->subcategory_model->getAllSubCateClient();
        $this->data['sub_content']['idSubCate'] = $idSubCate;
        $this->data['sub_content']['dataCategory'] = $dataCategory;
        $this->data['sub_content']['dataSubCategory'] = $dataSubCategory;
        $this->data['sub_content']['dataPro'] = $dataPro;
        $this->data['page_title'] = 'Danh sách sản phẩm';
        $this->data['content'] = 'products/index';
        $this->render('layouts/client_layout', $this->data);
    }
    public function detail($id)
    {
        $filterRate = $_POST['submitFilterRate'] ?? "";
        $this->rate_model->setRating($filterRate);

        $this->product_model->setId($id);
        $proDetail = $this->product_model->getOnePro($this->product_model);
        $this->product_model->setSubCategory_id($proDetail['subcategory_id']);
        $proImages = $this->product_model->getImgByIdPro($this->product_model);
        $proRelate = $this->product_model->getAllProRalate($this->product_model);
        $sizes = $this->product_model->getSize($this->product_model);
        $this->rate_model->setProduct_id($id);
        $dataRate = $this->rate_model->getRateByIdProAndIdUser($this->rate_model);
        $dataAvgRate = $this->rate_model->getAvgRate($this->rate_model);
        //count rate
        $count = [];
        $count[] = $this->rate_model->countRate($this->rate_model, 1);
        $count[] = $this->rate_model->countRate($this->rate_model, 2);
        $count[] = $this->rate_model->countRate($this->rate_model, 3);
        $count[] = $this->rate_model->countRate($this->rate_model, 4);
        $count[] = $this->rate_model->countRate($this->rate_model, 5);

        $this->data['sub_content']['proDetail'] = $proDetail;
        $this->data['sub_content']['proRelate'] = $proRelate;
        $this->data['sub_content']['proImages'] = $proImages;
        $this->data['sub_content']['dataRate'] = $dataRate;
        $this->data['sub_content']['dataAvgRate'] = $dataAvgRate;
        $this->data['sub_content']['countRate'] = $count;
        $this->data['sub_content']['sizes'] = $sizes;
        $this->data['sub_content']['pro_id'] = $id;
        $this->data['page_title'] = 'Chi tiết sản phẩm';
        $this->data['content'] = 'products/detail';
        $this->render('layouts/client_layout', $this->data);
    }
    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $search = trim($_POST['search']);
            $dataSearch = $this->product_model->getAllPro('id', 3, $this->product_model, $search);
            foreach ($dataSearch as $pro) {
                echo '<div class="col-lg-4 col-md-6 col-12"> 
                    <div class="card rounded-4" >
                    <div class="card-body d-flex flex-column gap-2">
                        <a class="text-decoration-none text-secondary" href="' . _WEB_ROOT_ . '/san-pham/ma-san-pham-' . $pro['id'] . '">
                            <img style="height: 200px; object-fit: cover;" src="' . _WEB_ROOT_ . '/public/assets/img/' . $pro['img'] . '" class="card-img-top rounded-4" alt="...">
                        </a>
                        <p class="card-title m-0 p-0 fw-semibold">' . $pro['name'] . '</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="price fw-bold">' . number_format($pro['price'] - ($pro['price'] * $pro['discount_percent'] / 100)) . 'đ</span>
                            <a href="#" id="shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>
                    </div>
                </div>';
            }
        }
    }
    public function show_page($idSubCate, $act, $total_page, $current_page)
    {
        $actCurrent = $idSubCate > 0 ? $act . $idSubCate : $act;
        if ($current_page > 2) {
            echo '<li class="page-item"><a class="page-link text-brand" href="' . _WEB_ROOT_ . '/' . $actCurrent . '-trang-1">First</a></li>';
        }
        for ($num = 1; $num <= $total_page; $num++) {
            if ($num != $current_page) {
                if ($num > $current_page - 2 && $num < $current_page + 2) {
                    echo '<li class="page-item"><a class="page-link text-brand" href="' . _WEB_ROOT_ . '/' . $actCurrent . '-trang-' . $num . '">' . $num . '</a></li>';
                }
            } else {
                echo '<li class="page-item"><a class="page-link bg-active-page">' . $num . '</a></li>';
            }
        }
        if ($current_page < $total_page - 2) {
            echo '<li class="page-item"><a class="page-link text-brand" href="' . _WEB_ROOT_ . '/' . $actCurrent . '-trang-' . $total_page . '">Last</a></li>';
        }
    }

    public function favorPro()
    {
        if (!isset($_SESSION['favor'])) {
            $_SESSION['favor'];
        }
        if (isset($_POST['pro-to-love'])) {
            $this->product_model->setId($_POST['pro-to-love']);
            $favor = $this->product_model->getFavor($this->product_model);


            if (!isset($_SESSION['favor'][$favor['id']])) {
                $_SESSION['favor'][$favor['id']] = [
                    'id' => $favor['id'],
                    'name' => $favor['name'],
                    'img' => $favor['img']
                ];
                $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm vào yêu thích thành công', 'type' => 'success'];
            } else {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Sản phẩm đã tồn tại', 'type' => 'error'];
            }
        }

        header("Location: " . _WEB_ROOT_ . "/trang-chu");
        exit;

    }

    public function getQuantityFromDsize()
    {
        $this->size_detail_model->setProId($_POST['proId']);
        $this->size_detail_model->setSizeId($_POST['sizeId']);
        $quantity = $this->size_detail_model->getQuantityByTwoId($this->size_detail_model);
        echo $quantity['quantity'];
    }
}