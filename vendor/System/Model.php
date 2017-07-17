<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 2:27 AM
 */

namespace System;

abstract class Model
{
    /**
     * Application Class
     *
     * @var object
     */
    protected $app;

    /**
     * Model Constructor
     *
     * @param \System\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }




}