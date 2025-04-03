<?php
namespace app\configs;

use app\core\Router as Router;
//User
use app\controllers\Page;
use app\controllers\Product;
use app\controllers\Ajax;
use app\controllers\User;
use app\controllers\Cart;
use app\controllers\Rate;

//Admin
use app\controllers\admin\Dashboard;
use app\controllers\admin\Product as ProductAdmin;
use app\controllers\admin\Category as CategoryAdmin;
use app\controllers\admin\User as UserAdmin;
use app\controllers\admin\Order as OrderAdmin;
class Routes
{
    public static function setupRoutes(Router $router): void
    {
        //Home
        $router->create(path: '/', params: [Page::class, 'index']);
        //Product
        $router->create(path: '/.+-cat{/+d}-cid{/+d}', params: [Product::class, 'list']);
        $router->create(path: '/search', params: [Product::class, 'search']);
        $router->create(path: '/.+-i{/+d}', params: [Product::class, 'detail']);

        //Auth 
        $router->create(path: '/handle_login', params: [User::class, 'handle_login']);
        $router->create(path: '/handle_register', params: [User::class, 'handle_register']);
        $router->create(path: '/logout', params: [User::class, 'logout']);
        $router->create(path: '/user/purchase', params: [User::class, 'purchase']);
        $router->create(path: '/user/cancel_order-{/+d}', params: [User::class, 'cancel_order']);
        $router->create(path: '/user/confirm-order-success-{/+d}', params: [User::class, 'confirm_order_success']);

        //Rate
        $router->create(path: '/create-rating', params: [Rate::class, 'create_rating']);
        //Cart
        $router->create(path: '/cart', params: [Cart::class, 'cart']);
        $router->create(path: '/save_cart', params: [Cart::class, 'save_cart']);
        $router->create(path: '/handle_del/{/+d}', params: [Cart::class, 'handle_del']);
        $router->create(path: '/handle-cart', params: [Cart::class, 'handle_cart']);
        $router->create(path: '/handle_checkout', params: [Cart::class, 'handle_checkout']);
        $router->create(path: '/handle-payment', params: [Cart::class, 'handle_payment']);
        $router->create(path: '/order-success', params: [Cart::class, 'order_success']);

        // Ajax
        $router->create(path: '/get_size', params: [Ajax::class, 'get_size']);
        $router->create(path: '/get_quantity', params: [Ajax::class, 'get_quantity']);
        $router->create(path: '/check_email', params: [Ajax::class, 'check_email']);
        $router->create(path: '/update_quantity_cart', params: [Ajax::class, 'update_quantity_cart']);
        $router->create(path: '/get_province', params: [Ajax::class, 'get_province']);
        $router->create(path: '/get_district_province_id', params: [Ajax::class, 'get_district_province_id']);
        $router->create(path: '/get_ward_district_id', params: [Ajax::class, 'get_ward_district_id']);
        $router->create(path: '/update_address', params: [Ajax::class, 'update_address']);
        $router->create(path: '/user/get_order_detail_by_id', params: [Ajax::class, 'get_order_detail_by_id']);
        $router->create(path: '/user/show-add-rating', params: [Ajax::class, 'show_add_rating']);

        //Ajax Admin
        $router->create(path: '/admin/get_attri_val_by_attri_id', params: [Ajax::class, 'get_attri_val_by_attri_id']);
        $router->create(path: '/admin/get_cate_chirld_by_parent', params: [Ajax::class, 'get_cate_chirld_by_parent']);
        $router->create(path: '/admin/get_attri_val_select_2', params: [Ajax::class, 'get_attri_val_select_2']);
        $router->create(path: '/admin/get_cate_by_cate_id', params: [Ajax::class, 'get_cate_by_cate_id']);
        $router->create(path: '/admin/get_user_by_id', params: [Ajax::class, 'get_user_by_id']);
        $router->create(path: '/admin/update_status_order', params: [Ajax::class, 'update_status_order']);
        $router->create(path: '/admin/get_order_detail', params: [Ajax::class, 'get_order_detail']);


        //Admin
        $router->create(path: '/admin/', params: [Dashboard::class, 'index']);
        //Admin product
        $router->create(path: '/admin/products', params: [ProductAdmin::class, 'index']);
        $router->create(path: '/admin/product-new', params: [ProductAdmin::class, 'new']);
        $router->create(path: '/admin/product/handle_new', params: [ProductAdmin::class, 'handle_new']);
        $router->create(path: '/admin/product-edit-{/+d}', params: [ProductAdmin::class, 'edit']);
        $router->create(path: '/admin/product/handle_edit', params: [ProductAdmin::class, 'handle_edit']);
        $router->create(path: '/admin/product/handle-del-{/+d}', params: [ProductAdmin::class, 'handle_del']);
        $router->create(path: '/admin/product/handle_del_groups', params: [ProductAdmin::class, 'handle_del_groups']);

        //Admin category
        $router->create(path: '/admin/categories', params: [CategoryAdmin::class, 'index']);
        $router->create(path: '/admin/category/handle_new', params: [CategoryAdmin::class, 'handle_new']);
        $router->create(path: '/admin/category/handle_edit', params: [CategoryAdmin::class, 'handle_edit']);
        $router->create(path: '/admin/category/handle-del-{/+d}', params: [CategoryAdmin::class, 'handle_del']);
        $router->create(path: '/admin/category/handle_del_groups', params: [CategoryAdmin::class, 'handle_del_groups']);

        //Admin User
        $router->create(path: '/admin/users', params: [UserAdmin::class, 'index']);
        $router->create(path: '/admin/user-new', params: [UserAdmin::class, 'new']);
        $router->create(path: '/admin/user/handle-new', params: [UserAdmin::class, 'handle_new']);
        $router->create(path: '/admin/user/handle-edit', params: [UserAdmin::class, 'handle_edit']);
        $router->create(path: '/admin/user/handle_del-{/+d}', params: [UserAdmin::class, 'handle_del']);
        $router->create(path: '/admin/user/handle-del-groups', params: [UserAdmin::class, 'handle_del_groups']);

        //Admin Order
        $router->create(path: '/admin/orders', params: [OrderAdmin::class, 'index']);
        $router->create(path: '/admin/order/handle_update_groups', params: [OrderAdmin::class, 'handle_update_groups']);
    }
}