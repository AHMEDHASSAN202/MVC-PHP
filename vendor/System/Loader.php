<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 1:12 AM
 */

namespace System;


class Loader
{

    /**
     * Application Class
     *
     * @var object
     */
    private $app;

    /**
     * Container Controllers
     *
     * Note : array Container Controllers is associative array
     * key    >>>>>> The Class for example : app\Controllers\HomeController
     * Value  >>>>>> The Object From This Class
     *
     * @var array
     */
    private $containerControllers = [];

    /**
     * Container Models
     *
     * Note : array Container Models is associative array
     * key    >>>>>> The Class for example : app\Models\HomeModel
     * Value  >>>>>> The Object From This Class
     *
     * @var array
     */
    private $containerModels = [];

    /**
     * Loader Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Get Controller And Run Method
     *
     * @param $controller
     * @param $method
     * @param array $arguments
     * @return mixed
     */
    public function action($controller , $method , $arguments = [])
    {
        $controller = $this->controller($controller);

        if (! method_exists($controller , $method)) {

            die($method .' Method not exists in class [Loader action]');
        }

        return call_user_func_array([$controller , $method] , $arguments);
    }

    /**
     * Controller
     *
     * @param $controller
     * @return mixed
     */
    public function controller($controller)
    {
        $controller = $this->generateControllerName($controller);

        if (!$this->isExists($this->containerControllers , $controller)) {

            $this->addController($controller);

        }

        return $this->containerControllers[$controller];
    }

    /**
     * Generate Controller Name
     *
     * @param $controller
     * @return mixed|string
     */
    private function generateControllerName($controller)
    {
        $controller = sprintf('app\\Controllers\\%s%s' , $controller , 'Controller');

        $controller = str_replace('/' , '\\' , $controller);

        return $controller;
    }

    /**
     * Check If key Exists in array
     *
     * @param $array
     * @param $key
     * @return bool
     */
    private function isExists($array , $key)
    {
        return array_key_exists($key , $array);
    }

    /**
     * Add Controller Into Container Controllers
     *
     * @param $controller
     */
    private function addController($controller)
    {
        $object = new $controller($this->app);

        $this->containerControllers[$controller] = $object;
    }

    /**
     * Model
     *
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        $model = $this->generateModelName($model);

        if (!$this->isExists($this->containerModels , $model)) {

            $this->addModel($model);

        }

        return $this->containerModels[$model];
    }

    /**
     * Generate Model Name
     *
     * @param $model
     * @return mixed|string
     */
    private function generateModelName($model)
    {
        $model = sprintf('app\\Models\\%s%s' , $model , 'Model');

        $model = str_replace('/' , '\\' , $model);

        return $model;
    }

    /**
     * Add Model Into Models Container
     *
     * @param $model
     */
    private function addModel($model)
    {
        $object = new $model($this->app);

        $this->containerModels[$model] = $object;
    }
}