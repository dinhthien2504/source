<?php
class Site extends Controller{
    public $data = [];
    public function about() {
        $this->data['sub_content']['info'] = 'Dữ liệu lấy từ model';
        $this->data['page_title'] = 'Trang Giới Thiệu';
        $this->data['content'] = 'sites/about';
        $this->render('layouts/client_layout', $this->data);
    }
    public function contact () {
        $this->data['sub_content']['info'] = 'Dữ liệu lấy từ model';
        $this->data['page_title'] = 'Trang Liên Hệ';
        $this->data['content'] = 'sites/contact';
        $this->render('layouts/client_layout', $this->data);
    }
}