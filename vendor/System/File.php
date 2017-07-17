<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/7/2017
 * Time: 1:04 AM
 */

namespace System;


class File
{
    /**
     * Stored Main directory
     *
     * @var
     */
    private $dir;

    /**
     * Directory Separator
     *
     * @const
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * File constructor
     *
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Generate Path
     *
     * @param $path
     * @return mixed
     */
    public function to($path = null)
    {
        return str_replace(['/' , '\\'] , self::DS , $this->dir . self::DS . $path);
    }

    /**
     * Full Path vendor Folder
     *
     * @param $path
     * @return mixed
     */
    public function toVendor($path)
    {
        return $this->to('vendor'. self::DS .$path);
    }

    /**
     * Full Path public Folder
     *
     * @param $path
     * @return mixed
     */
    public function toPublic($path)
    {
        return $this->to('public'. self::DS .$path);
    }

    /**
     * Full Path app Folder
     *
     * @param $path
     * @return mixed
     */
    public function toApp($path)
    {
        return $this->to('app'. self::DS .$path);
    }

    /**
     * Check File Exists
     *
     * @param $file
     * @return bool
     */
    public function exists($file)
    {
        return file_exists($file . '.php');
    }

    public function required($file)
    {
        return require_once $file . '.php';
    }
}