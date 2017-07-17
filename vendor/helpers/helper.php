<?php

/**
 * Show data
 *
 * @param $var
 */
if (! function_exists('pre')) {

    function pre($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

}

/**
 * Show data and exist
 *
 * @param $var
 */
if (! function_exists('pred')) {

    function pred($var) {
        pre($var);
        exit();
    }

}

/**
 * Escape Html tags
 *
 * @param $value
 */
if (! function_exists('escape_tags_html')) {

    function escape_tags_html($value) {
        return htmlspecialchars($value , ENT_QUOTES , 'UTF-8');
    }
}

/**
 * Strip All Tags [html - xml - php]
 *
 * @return clean value
 */
if (! function_exists('cleanInput')) {

    function cleanInput($value) {
        $value = trim($value);
        return strip_tags($value);
    }
}

/**
 * Generate Full Path For The Given Path In Public directory
 *
 * @param $path
 */
if (! function_exists('assets')) {

    function assets($path) {
        $app = \System\App::getInstance();
        return $app->url->url('public/' . $path);
    }

}

/**
 * Generate Url
 *
 * @param $url
 */
if (! function_exists('url')) {

    function url($url) {
        $app = \System\App::getInstance();
        return $app->url->url($url);
    }

}