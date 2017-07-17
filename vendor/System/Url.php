<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 1:04 AM
 */

namespace System;


class Url
{

    /**
     * Application Class
     *
     * @var object
     */
    private $app;

    /**
     * Url Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Set Full URL
     *
     * @param $link
     * @return string
     */
    public function url($link)
    {
        return trim($this->app->request->baseUrl() . '/' .$link);
    }

    /**
     * Redirect URL
     *
     * @param $location
     */
    public function redirect($location)
    {
        header('Location: ' . $location);
        exit();
    }
}