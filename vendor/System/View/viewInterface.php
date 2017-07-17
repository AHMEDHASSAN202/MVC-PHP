<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/11/2017
 * Time: 12:22 AM
 */

namespace System\View;


interface viewInterface
{

    /**
     * Get The View Output
     *
     * @return string
     */
    public function getOutput();

    /**
     * Convert The View Object to String
     *
     * @return string
     */
    public function __toString();



}