<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/11/2017
 * Time: 12:18 AM
 */

namespace System\View;


use System\App;

class viewFactory
{

    /**
     * Application object
     *
     * @var App
     */
    private $app;

    /**
     * viewFactory Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Render View
     *
     * @param $view
     * @param array $data
     * @return view
     */
    public function render($view , $data = [])
    {
        return new view($this->app , $view , $data);
    }

}