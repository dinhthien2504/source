<?php
session_start();
$link = str_replace('\\', '/', __DIR__);
define('_DIR_ROOT', $link);

// Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}
$web_root .= str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
define('_WEB_ROOT_', $web_root);
spl_autoload_register(function ($class): void {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (!file_exists(($path))) {
        exit('Autoload Error -' . $path . ' File Not Found');
    }
    require_once $path;
});

$app = new app\core\App;