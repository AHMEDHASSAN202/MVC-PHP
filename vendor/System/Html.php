<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/11/2017
 * Time: 2:28 AM
 */

namespace System;


class Html
{

    /**
     * Application Class
     *
     * @var object
     */
    private $app;

    /**
     * Title page
     *
     * @var string
     */
    private $title;

    /**
     * Description page
     *
     * @var string
     */
    private $description;

    /**
     * Keywords page
     *
     * @var string
     */
    private $keywords;

    /**
     * Html Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Set Title
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = trim($title);
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Description
     *
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = trim($description);
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Keywords
     *
     * @param $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = trim($keywords);
    }

    /**
     * Get Keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

}