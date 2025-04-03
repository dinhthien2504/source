<?php
namespace app\controllers;
class Page extends Base
{
    public array $data = [];
    private $product_model, $category_model;
    public function __construct()
    {
        $this->product_model = $this->model('ProductModel');
        $this->category_model = $this->model('CategoryModel');
    }
    public function index()
    {
        //Danh mục cha
        $data_cates_parent = $this->category_model->get_all_parent();
        $this->data['sub_content']['cates_parent'] = $data_cates_parent;

        //Sản phẩm mới
        $data_pros_new = $this->product_model->get_all_home();
        $this->data['sub_content']['pros_new'] = $data_pros_new;

        //Sản phẩm bán chạy
        $data_pros_best_sellers = $this->product_model->get_all_home("sell");
        $this->data['sub_content']['pros_best_sellers'] = $data_pros_best_sellers;

        $this->data['title_page'] = 'Trang Chủ';
        $this->data['content'] = 'pages/home';
        $this->render('layouts/main', $this->data);
    }

    public function about()
    {
        echo 'Trang về chúng tôi';
    }
}