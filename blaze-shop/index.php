<?php
error_reporting(E_ALL); // Hiển thị tất cả lỗi
ini_set('display_errors', 1); // Bật hiển thị lỗi
session_start();
ob_start();
require_once 'bootstrap.php';
$app = new App();