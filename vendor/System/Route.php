<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/9/2017
 * Time: 2:47 AM
 */

namespace System;


class Route
{

    /**
     * Application Object
     *
     * @var $app
     */
    private $app;

    /**
     * Container Routes
     *
     * @var array
     */
    private $containerRoutes = [];

    /**
     * Route Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Add URL To Container
     *
     * @param $url
     * @param $action
     * @param string $requestMethod
     * @return array
     */
    public function add($url , $action , $requestMethod = 'GET')
    {
        return $this->containerRoutes[] = [
            'url'           => $url,
            'pattern'       => $this->getPattern($url),
            'action'        => $this->getAction($action),
            'requestMethod' => strtoupper($requestMethod)
        ];
    }

    /**
     * Get Pattern URL
     *
     * @param $url
     * @return string
     */
    private function getPattern($url)
    {
        $url = str_replace('\\'  , '/' , $url);

        $pattern = '#^';
        $pattern .= str_replace([':text' , ':id'] , ['([a-zA-Z0-9-]+)' , '(\d+)'] , $url);
        $pattern .= '$#';

        return $pattern;
    }

    /**
     * Get Action
     *
     * @param $action
     * @return mixed|string
     */
    private function getAction($action)
    {
        $action = str_replace('/' , '\\' , $action);

        return strpos($action , '@') !== false ? $action : $action . '@index';
    }


    public function properRoute()
    {
        foreach ($this->containerRoutes as $key => $route) {

            if ($this->isMatchCurrentRoute($route['pattern']) && $this->isMatchCurrentRequestMethod($route['requestMethod']))
            {
                $action = explode('@' , $route['action']);

                //get controller
                $controller = $action[0];

                //get method
                $method = $action[1];

                //get arguments from current URL
                $arguments = $this->getArgumentsFromCurrentUrl($route['pattern']);

                return [$controller , $method , $arguments];
            }

        }

        //$this->app->url->redirect('notFound');
        exit('not found this page [route]');

    }

    /**
     * Check if Route is Matching Current URL
     *
     * @param $pattern
     * @return int
     */
    private function isMatchCurrentRoute($pattern)
    {
        return preg_match($pattern , $this->app->request->url());
    }

    /**
     * Check if Request Method Route is Matching Current Request Method
     *
     * @param $requestMethod
     * @return bool
     */
    private function isMatchCurrentRequestMethod($requestMethod)
    {
        return $requestMethod !== $this->app->request->requestMethod() ? false : true;
    }

    /**
     * Get Arguments From Current URL
     *
     * @param $pattern
     * @return mixed
     */
    private function getArgumentsFromCurrentUrl($pattern)
    {
        preg_match($pattern , $this->app->request->url() , $arguments);

        array_shift($arguments);

        return $arguments;
    }

    /**
     * Get All Routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->containerRoutes;
    }
}