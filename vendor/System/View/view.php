<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/11/2017
 * Time: 12:24 AM
 */

namespace System\View;


use System\App;

class view implements viewInterface
{

    /**
     * Application object
     *
     * @var App
     */
    private $app;

    /**
     * View File
     *
     * @var string
     */
    private $view;

    /**
     * Store Passed Data to The View
     *
     * @var array
     */
    private $data = [];

    /**
     * Main View
     *
     * @var string
     */
    private $output;

    /**
     * view Constructor
     *
     * @param App $app
     * @param $view
     * @param array $data
     */
    public function __construct(App $app , $view , $data = [])
    {

        $this->app = $app;

        $this->view = $this->prepareView($view);

        $this->data = $data;

    }

    /**
     * Prepare View Path
     *
     * @param $view
     * @return string
     */
    private function prepareView($view)
    {
        $view = $this->app->file->toApp(sprintf('Views/%s' , $view));

        if (!$this->app->file->exists($view)) {

            die(sprintf('not found %s view [view class]' , $view));

        }

        return $view . '.php';
    }

    /**
     * Get Output and Passes data
     *
     * @return string
     */
    public function getOutput(){

        if (is_null($this->output)) {

            ob_start();

            extract($this->data);

            require $this->view;

            $this->output = ob_get_clean();

            return $this->output;
        }
    }

    /**
     * Magic Method __toString
     * called when echo object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getOutput();
    }

}