<?php
class Route
{

    function handleRoute($url)
    {
        global $routes;
        unset($routes['default_controller']);

        $url = trim($url, '/');

        $handle_url = $url;
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match("#" . $key . "#is", $url)) {
                    $handle_url = preg_replace("#" . $key . "#is", $value, $url);
                }
            }
        }
        return $handle_url;
    }


}