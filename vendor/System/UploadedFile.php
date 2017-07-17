<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/12/2017
 * Time: 3:14 PM
 */

namespace System;


class UploadedFile
{
    /**
     * Application Class
     *
     * @var $app
     */
    private $app;

    /**
     * Stored Information File
     *
     * @var array
     */
    private $file = [];

    /**
     * File name
     *
     * @var string
     */
    private $name = null;

    /**
     * File extension
     *
     * @var string
     */
    private $extension = null;

    /**
     * File name and extension
     *
     * @var
     */
    private $nameAndExtension = null;

    /**
     * File type
     *
     * @var string
     */
    private $type = null;

    /**
     * Temporary name
     *
     * @var string
     */
    private $temporaryName = null;

    /**
     * Error in Upload File
     *
     * @var
     */
    private $error = null;

    /**
     * Size file
     *
     * @var int
     */
    private $size = null;

    /**
     * Extension Images
     * must be extension lowercase
     *
     * @var array
     */
    private $imageExtension = ['jpg' , 'jpeg' , 'png' , 'giv' , 'webp' , 'gif'];

    //-------------------------\\
    const KB =  1024;
    const MB =  1048576;
    const GB = 1073741824;
    //-------------------------\\


    /**
     * UploadedFile Constructor
     *
     * @param App $app
     * @param $file
     */
    public function __construct(App $app , $file)
    {
        $this->app = $app;

        $this->infoFile($file);
    }

    /**
     * Get Information File and Set All Properties
     *
     * @param $file
     * @return mixed
     */
    private function infoFile($file)
    {
        if (empty($_FILES[$file])) {

            die(sprintf('%s not exists' , $file));

        }

        $file = $_FILES[$file];

        if ($file['error'] !== UPLOAD_ERR_OK) {

            return 'Sorry, there was an error uploading your file.';

        }

        $this->file = $file;

        $info = pathinfo($this->file['name']);

        $this->name = $info['filename'];

        $this->extension = $info['extension'];

        $this->nameAndExtension = $this->file['name'];

        $this->type = $this->file['type'];

        $this->temporaryName = $this->file['tmp_name'];

        $this->error = $this->file['error'];

        $this->size = $this->file['size'];

    }

    /**
     * Determine if file Success Uploaded
     *
     * @return bool
     */
    public function uploaded()
    {
        return !empty($this->file) ? true : false;
    }

    /**
     * Get Name File
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get Extension File
     *
     * @return string
     */
    public function extension()
    {
        return $this->extension;
    }

    /**
     * Get Name And Extension File
     *
     * @return null
     */
    public function nameAndExtension()
    {
        return $this->nameAndExtension;
    }

    /**
     * Get Type File
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get Temporary Name
     *
     * @return string
     */
    public function temporaryName()
    {
        return $this->temporaryName;
    }

    /**
     * Get Error
     *
     * @return null
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Get File Size with megabyte
     *
     * @return float
     */
    public function size()
    {
        return round($this->size / self::MB , 2);
    }

    /**
     * Determine if File Is image
     *
     * @return bool
     */
    public function isImage()
    {
        if (!in_array(strtolower($this->extension) , $this->imageExtension)) {
            return false;
        }

        return true;
    }

    /**
     * Move an Uploaded File to a New Location
     *
     * @param $target
     * @param null $fileName
     * @return bool
     */
    public function moveTo($target , $fileName = null)
    {

        if (!is_dir($target)) {
            if (!mkdir($target , 0777 , true)) {
                die('Failed to create folders...');
            }
        }

        //$name = 80char
        $name = $fileName === null ? sha1(mt_rand()) . sha1(mt_rand()) : $fileName;

        $name .= '.' . $this->extension;

        $fullName = $target . DIRECTORY_SEPARATOR . $name;

        return move_uploaded_file($this->temporaryName , $fullName);
    }

}