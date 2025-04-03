<?php
// $path = $_SERVER['DOCUMENT_ROOT'];
$link = str_replace('\\', '/', __DIR__);
define('_DIR_ROOT', $link);
// Xử lý http root

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}
$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
$web_root .= $folder;
define('_WEB_ROOT_', $web_root);

require_once 'configs/routes.php'; // load routes config
require_once 'configs/configs.php';
require_once 'configs/database.php';
require_once 'core/Route.php'; // load Route class
require_once 'app/App.php';
require_once 'core/Controller.php'; // Load base controller
require_once 'core/Model.php'; // Load base model

