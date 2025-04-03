<?php
namespace app\controllers;
use app\views\Viewer;
abstract class Base extends Viewer
{
    protected static function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] == 2;
    }
    protected function model($model)
    {
        $class_model = 'app\\models\\' . $model;
        if (class_exists($class_model)) {
            return new $class_model();
        }
        return false;
    }
    protected function create_pagination_url($page)
    {
        $url_current = $_SERVER['REQUEST_URI'];

        // Tách phần URL và query string
        $url_parts = parse_url($url_current);
        parse_str($url_parts['query'] ?? '', $query);

        // Cập nhật tham số page
        $query['page'] = $page;

        // Xây dựng lại URL
        $new_query = http_build_query($query);
        $base_url = $url_parts['path'];

        return $base_url . '?' . $new_query;
    }
    protected function handle_url_page($total_page, $current_page)
    {
        $links = '';
        $dots = false;
        //Nút prev
        $links .= '<li class="pagination-item">' . $this->handle_prev_page($current_page) . '</li>';
        // Nút "Đầu"
        if ($current_page > 3) {
            $url = $this->create_pagination_url(1);
            $links .= '<li class="pagination-item">
                            <a href="' . $url . '" class="pagination-item__link">1</a>
                       </li>';
        }

        // Các trang số
        for ($i = 1; $i <= $total_page; $i++) {
            $is_active = $i == $current_page ? 'pagination-item--active' : '';

            // Hiển thị trang trong khoảng gần current_page
            if ($i >= $current_page - 2 && $i <= $current_page + 2) {
                $dots = false;
                $url = $this->create_pagination_url($i);
                $links .= '<li class="pagination-item ' . $is_active . '">
                                <a href="' . $url . '" class="pagination-item__link">' . $i . '</a>
                           </li>';
            } else {

                if (!$dots) {
                    $links .= '<li class="pagination-item">
                                <i class="pagination-item__link-icon fas fa-ellipsis-h"></i>
                               </li>';
                    $dots = true;
                }
            }
        }

        // Nút "Cuối"
        if ($current_page < $total_page - 3) {
            $url = $this->create_pagination_url($total_page);
            $links .= '<li class="pagination-item">
                            <a href="' . $url . '" class="pagination-item__link">' . $total_page . '</a>
                       </li>';
        }
        //Nút next
        $links .= '<li class="pagination-item">' . $this->handle_next_page($current_page, $total_page) . '</li>';
        return $links;
    }
    protected function handle_next_page($current_page, $total_page)
    {
        $link_next = '';
        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            $url = $this->create_pagination_url($next_page);

            // In ra HTML của nút Next
            $link_next .= '<a href="' . $url . '" class="category-filter__page-btn">
                                <i class="category-filter__page-icon fa-solid fa-chevron-right"></i>
                            </a>';
        } else {
            // Nếu không thể Next, hiển thị nút bị disable
            $link_next .= '<a class="category-filter__page-btn disable">
                    <i class="category-filter__page-icon fa-solid fa-chevron-right"></i>
                </a>';
        }
        return $link_next;
    }
    protected function handle_prev_page($current_page)
    {
        $link_prev = '';
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $url = $this->create_pagination_url($prev_page);

            // In ra HTML của nút Prev
            $link_prev .= '<a href="' . $url . '" class="category-filter__page-btn">
                                <i class="category-filter__page-icon fa-solid fa-chevron-left"></i>
                            </a>';
        } else {
            // Nếu không thể Prev, hiển thị nút bị disable
            $link_prev .= '<a class="category-filter__page-btn disable">
                                <i class="category-filter__page-icon fa-solid fa-chevron-left"></i>
                            </a>';
        }
        return $link_prev;
    }
    protected function render_error($name = 404)
    {
        $file_path = 'app/errors/' . $name . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}