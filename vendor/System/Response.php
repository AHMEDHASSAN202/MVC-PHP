<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/11/2017
 * Time: 1:00 AM
 */

namespace System;


class Response
{

    /**
     * Application Class
     *
     * @var App
     */
    private $app;

    /**
     * Content View
     *
     * @var
     */
    private $content = '';

    /**
     * Headers
     *
     * @var array
     */
    private $headers = [];

    /**
     * Response Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Set Content output
     *
     * @param $content
     */
    public function setOutput($content)
    {
        $this->content = $content;
    }

    /**
     * Send Content
     *
     * @return void
     */
    private function sendOutput()
    {
        echo $this->content;
    }

    /**
     * Set headers
     *
     * @param $key
     * @param $value
     */
    public function setHeader($key , $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Send headers
     *
     * @return void
     */
    private function sendHeader()
    {
        foreach ($this->headers as $key => $value) {

            header($key . ': ' . $value);

        }
    }

    /**
     * Send Content and Headers
     *
     * @return void
     */
    public function send()
    {
        $this->sendOutput();

        $this->sendHeader();
    }

}