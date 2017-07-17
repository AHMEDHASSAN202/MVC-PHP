<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 2:19 AM
 */

namespace System;


abstract class Controller
{
    /**
     * Application Class
     *
     * @var object
     */
    protected $app;

    /**
     * Controller Constructor
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /*
     * Encode The given value to json
     *
     * @param mixed
     * @return string
     */
    protected function json($data)
    {
        return json_encode($data);
    }

    /**
     * Get Element Direct From Container Class
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->app->get($name);
    }


}