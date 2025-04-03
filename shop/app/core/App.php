<?php
namespace app\core;

use app\core\Router;
use app\configs\Routes;
class App
{
    private $router;
    public function __construct()
    {
        $this->router = new Router();
        Routes::setupRoutes($this->router);
        $url = $_SERVER['PATH_INFO'] ?? '/';
        $this->router->dispatch($url);
    }
}