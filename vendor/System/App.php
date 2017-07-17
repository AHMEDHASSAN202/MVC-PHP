<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/7/2017
 * Time: 12:58 AM
 */

namespace System;


class App
{

    /**
     * store instance App
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Container class
     *
     * @var array
     */
    private $container = [];

    /**
     * App Constructor
     *
     * @param File $file
     */
    private function __construct(File $file)
    {
        $this->share('file' , $file);  //share file object in container

        $this->autoload();  //autoload classes

        $this->helper();  //required helper file
    }


    /**
     * Get instance
     *
     * @param File|null $file
     * @return null|App
     */
    public static function getInstance(File $file = null)
    {

        if (is_null(self::$instance)) {

            self::$instance = new self($file);

        }

        return self::$instance;
    }

    /**
     * Run Application
     *
     * @return mixed
     */
    public function run()
    {
        $this->session->start();

        $this->request->prepareUrl();

        $this->routesFile();

        list($controller , $method , $arguments) = $this->route->properRoute();

        $output = $this->load->action($controller , $method , $arguments);

        $this->response->setOutput($output);

        $this->response->send();

    }

    /**
     * Share Class in Container
     *
     * @param $key
     * @param $value
     */
    public function share($key , $value)
    {
        //Check The value IF anonymous function will it call
        if ($value instanceof \Closure) {

            $value = call_user_func($value , $this);

        }

        $this->container[$key] = $value;
    }

    /**
     * Get Class From Container Array
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (! array_key_exists($key , $this->container)) {

            if ($this->isCoreClasses($key)) {

                $this->share($key , $this->createObjectFromCoreClasses($key));

            }else {

                die('this '. $key . ' class not found in container and core classes [App get method]');

            }

        }

        return $this->container[$key];
    }

    /**
     * Main Classes
     *
     * @return array
     */
    private function coreClasses()
    {
        return [
            'request'   => 'System\Request',
            'response'  => 'System\Response',
            'route'     => 'System\Route',
            'load'      => 'System\Loader',
            'url'       => 'System\Url',
            'session'   => 'System\Session',
            'cookie'    => 'System\Cookie',
            'db'        => 'System\Database',
            'validate'  => 'System\Validation',
            'view'      => 'System\View\viewFactory',
            'html'      => 'System\Html'
        ];
    }

    /**
     * Check if Class Exists in Core Classes
     *
     * @param $class
     * @return bool
     */
    private function isCoreClasses($class)
    {
        $classes = $this->coreClasses();

        return array_key_exists($class , $classes);
    }

    /**
     * Create Object From Core Classes
     *
     * @param $class
     * @return mixed
     */
    private function createObjectFromCoreClasses($class)
    {
        $classes = $this->coreClasses();

        $object = new $classes[$class]($this);

        return $object;
    }

    /**
     * autoload Function
     *
     * @return mixed
     */
    public function autoload() {

        spl_autoload_register(function ($class) {

            if (strpos($class , 'app') === 0) {
                $file = $this->file->to($class);
            }else {
                $file = $this->file->toVendor($class);
            }

            if ($this->file->exists($file)) {

                $this->file->required($file);

            }else {

                die($file . ' not found [autoload]');

            }

        });

    }

    /**
     * Required helper File
     *
     * @return mixed
     */
    private function helper()
    {
        $helper = $this->file->toVendor('helpers/helper');

        if (!$this->file->exists($helper)) {
            die('helper file not fount');
        }

        return $this->file->required($helper);
    }

    /**
     * Required routes File
     *
     * @return mixed
     */
    private function routesFile()
    {
        $file = $this->file->toApp('routes');

        if (! $this->file->exists($file)) {
            die('not found routes file');
        }

        $this->file->required($file);
    }

    /**
     * Magic Method get
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->get($name);
    }

}