<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/7/2017
 * Time: 2:59 AM
 */

namespace System;


class Request
{
    /**
     * Application Object
     *
     * @var object
     */
    private $app;

    /**
     * Main URL
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Current Url
     *
     * @var string
     */
    private $url;

    /**
     * Container Uploaded Files
     *
     * @var array
     */
    private $files = [];

    /**
     * Request Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Prepare Url
     *
     * @return mixed
     */
    public function prepareUrl()
    {
        //set base url
        $this->baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];

        $request = filter_var($_SERVER['REQUEST_URI'] , FILTER_SANITIZE_URL);

        if (strpos($request , '?')) {
            list($request , $blaString) = explode('?' , $request);
        }

        //set current url [request]
        $this->url = trim($request , '/');

        if ($this->url == '') {

            $this->url = 'home';

        }

    }

    /**
     * Get Base URL
     *
     * @return string
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Get Current URL
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Get Value From $_GET array
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Get Value From $_POST array
     *
     * @param $key
     * @return null
     */
    public function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Set Post
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setPost($key , $value)
    {
        return $_POST[$key] = $value;
    }

    /**
     * Get Value From $_SERVER array
     *
     * @param $key
     * @return null
     */
    public function server($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
    }

    /**
     * Get Request Method
     *
     * @return string
     */
    public function requestMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Returns the complete URL of the current page
     * (not reliable because not all user-agents support it)
     *
     * @return mixed
     */
    public function referer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    /**
     * Uploaded File Function
     *
     * @param $name
     * @return object
     */
    public function file($name)
    {
        if (!isset($this->files[$name])) {

            $obj = new UploadedFile($this->app , $name);

            $this->files[$name] = $obj;

        }

        return $this->files[$name];
    }
}