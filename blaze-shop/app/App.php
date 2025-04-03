<?php
class App
{
    private $__controller, $__action, $__params, $__routes, $__privile;
    function __construct()
    {

        global $routes;

        $this->__routes = new Route();
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];
        $this->handlerUrl();
    }

    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    public function handlerUrl()
    {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);
        $urlArray = array_filter(explode('/', $url));
        $urlArray = array_values($urlArray);
        $urlCheck = "";
        $isAdmin = false; // cắm cờ
        if (!empty($urlArray)) {
            if (strtolower($urlArray[0]) == 'admin') {
                require_once 'models/PrivilegeModel.php';
                $this->__privile = new PrivilegeModel();
                $checkPrivilege = $this->__privile->checkPrivilege();
                if (!$checkPrivilege) {
                    $this->loadError('403');
                    exit();//Dừng lại mọi hoạt động
                } else {
                    $isAdmin = true;
                    unset($urlArray[0]); // Xóa 'admin' khỏi mảng URL
                    $urlArray = array_values($urlArray); // Đặt lại chỉ mục
                }
            }
            // xử lý controller
            if (!empty($urlArray[0])) {
                $this->__controller = ucfirst($urlArray[0]);
            }

            // Tạo đường dẫn controller
            $controllerPath = $isAdmin ? 'app/controllers/admin/' . $this->__controller . '.php' : 'app/controllers/' . $this->__controller . '.php';
            if (file_exists($controllerPath)) {
                require_once $controllerPath;

                // kiểm tra class controller có tồn tại không
                if (class_exists($this->__controller)) {
                    $this->__controller = new $this->__controller();
                    unset($urlArray[0]);
                } else {
                    $this->loadError();
                    return;
                }
            } else {
                $this->loadError();
                return;
            }
        } else {
            header("Location: " . _WEB_ROOT_ . "/trang-chu");
        }
        // xử lý action
        if (!empty($urlArray[1])) {
            $this->__action = $urlArray[1];
            unset($urlArray[1]);
        }

        // kiểm tra sự tồn tại của phương thức
        if (!method_exists($this->__controller, $this->__action)) {
            $this->loadError();
            return;
        }

        // xử lý params
        $this->__params = array_values($urlArray);
        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }

    public function loadError($name = '404')
    {
        require_once 'errors/' . $name . '.php';
    }
}
