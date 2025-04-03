<?php
namespace app\views;

abstract class Viewer {

    public function render($view, $data = []) {
        if(!file_exists('app/views/'.$view.'.php')) {
            throw new \Exception("View not found: ". $view);
        }
        extract($data);
        require_once 'app/views/'. $view. '.php';
    }
}