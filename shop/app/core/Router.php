<?php
namespace app\core;

class Router
{
    private $routes = [];
    //Tạo đường dẫn
    public function create(string $path, array $params)
    {
        $regex_path = preg_replace('/\{(.+?)\}/', '([^/]+)', $path);
        $regex_path = str_replace('/', '\/', $regex_path);
        $this->routes[] = [
            'regex_path' => $regex_path,
            'params' => $params
        ];
    }
    //Xử lý đường dẫn
    public function dispatch($path)
    {
        foreach ($this->routes as $route) {
            if (preg_match("/^{$route['regex_path']}$/", $path, $matches)) {
                unset($matches[0]);
                [$__controller, $__action] = $route['params'];
                //Kiểm tra class có tồn tại không
                if (!class_exists($__controller)) {
                    exit('Class không tồn tại!');
                }
                $__controller = new $__controller;
                //Kiểm tra phương thức có tồn tại trong class hay không
                if (!method_exists($__controller, $__action)) {
                    exit('Phương thức không tồn tại!');
                }
                return call_user_func_array([$__controller, $__action], $matches);
            }
        }
        require_once 'app/errors/404.php';
        exit;
    }
}