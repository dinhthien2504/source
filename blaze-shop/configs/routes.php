<?php
// đường dẫn phía client
$routes['default_controller'] = 'home';

$routes['trang-chu'] = 'home';

$routes['san-pham/danh-muc-(\d+)-trang-(\d+)'] = 'product/index/$1/$2';
$routes['san-pham/tim-kiem'] = 'product/index';
$routes['san-pham/ma-san-pham-(\d+)'] = 'product/detail/$1';
$routes['chi-tiet'] = 'product/detail';
$routes['ve-chung-toi'] = 'site/about';
$routes['lien-he'] = 'site/contact';
$routes['yeu-thich'] = 'product/favorPro';

//auth
$routes['tai-khoan'] = 'auth/index';
$routes['trang-ca-nhan'] = 'auth/profile';
$routes['chinh-sua-trang-ca-nhan'] = 'auth/update_profile';
$routes['quen-mat-khau'] = 'auth/forgot';
$routes['trang-xac-minh'] = 'auth/verify';
$routes['dang-xuat'] = 'auth/logout';
$routes['doi-mat-khau'] = 'auth/reset';


//router cart
$routes['gio-hang'] = 'cart';
$routes['dat-hang'] = 'order';
$routes['them-vao-gio'] = 'cart/addcart';

//order 
$routes['lich-su-mua-hang'] = 'order/historyOrder';

//Đường dẫn phía admin

//Danh mục
$routes['admin/danh-muc'] = 'admin/category/index'; //Quản lý sản phẩm: admin\/danh-muc$|admin\/danh-muc-phu$|admin\/san-pham$|admin\/voucher$
$routes['admin/danh-muc-phu'] = 'admin/category/subCategory';
//Sản phẩm
$routes['admin/san-pham'] = 'admin/product/index';
//Tài khoản
$routes['admin/khach-hang'] = 'admin/user/client'; //Quản lý thành viên: admin\/khach-hang$|admin\/nhan-vien$
$routes['admin/nhan-vien'] = 'admin/user/staff'; //Quyền quản trị: admin\/phan-quyen$|admin\/chinh-sua-quyen$
$routes['admin/phan-quyen'] = 'admin/user/privilege';
$routes['admin/chinh-sua-quyen'] = 'admin/user/addPrivilege';
//Đơn hàng
$routes['admin/don-hang'] = 'admin/order/index'; //Quản lý đơn hàng: admin\/don-hang$
//Đánh giá
$routes['admin/danh-gia'] = 'admin/rate/index';
$routes['admin/danh-gia/chi-tiet/(\d+)'] = 'admin/rate/detail/$1';  //Quản lý marketing: admin\/danh-gia$
//Giảm giá
