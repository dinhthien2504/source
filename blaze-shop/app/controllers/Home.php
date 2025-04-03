<?php
class Home extends Controller
{

    public $product_model;
    public $data = [];

    public function __construct()
    {
        $this->product_model = $this->model('ProductModel');
    }

    public function index()
    {
        $proNew = $this->product_model->getAllPro('id', 4, $this->product_model);
        $proSales = $this->product_model->getAllPro('sales', 8, $this->product_model);
        $this->data['page_title'] = 'Trang chủ';
        $this->data['content'] = 'home/index';
        $this->data['sub_content']['proNew'] = $proNew;
        $this->data['sub_content']['proSales'] = $proSales;
        $this->render('layouts/client_layout', $this->data);
    }
}
