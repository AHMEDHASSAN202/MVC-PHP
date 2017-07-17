<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 3:38 PM
 */

namespace System;


class Config
{

    /**
     * Get Value From Config File
     * Using: System/Config::get($value);
     *
     * @param $value
     * @return bool|mixed
     */
    public static function get($value)
    {
        if ($value) {

            $config = $GLOBALS['config'];   //get configuration from super global $GLOBALS

            /**
             * if $value = database/name  (string)
             *
             * EXPLODE
             * $keys = [0] => database , [1] => name  (array)
             *
             */
            $keys = explode('/' , $value);

            foreach ($keys as $key) {

                if (isset($config[$key])) {

                    $config = $config[$key];

                }
            }

            return $config;
        }

        return false;
    }

    /**
     * Set Errors
     *
     * @return mixed
     */
    public static function statusErrors()
    {
        $status = self::get('error/reporting') ?: 'on';

        switch (strtolower($status)) {
            case 'off':
                error_reporting(0);
            break;
            case 'on':
                error_reporting(1);
            break;
        }

    }

    /**
     * Check Version PHP
     *
     * @return void
     */
    public static function phpCheckVersion()
    {
        $leastVersion = self::get('php_version/least_version');

        if (version_compare(PHP_VERSION , $leastVersion , '<')) {

            die("<h2 style='color: red'>PHP Version Must be Upper Than $leastVersion</h2>");

        }

    }



}