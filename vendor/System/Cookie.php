<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/8/2017
 * Time: 5:46 AM
 */

namespace System;


class Cookie
{
    /**
     * App Class
     *
     * @var object
     */
    private $app;

    /**
     * cookie Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Set Cookie
     *
     * @param $key
     * @param $value
     * @param $expire [expiration with day]
     * @return mixed
     */
    public function set($key , $value , $expire = NULL)  {

        if (is_null($expire)) {

            $expire = Config::get('cookie/default_expire');

        }

        $expire = $expire == -1 ? -1 : time() + (86400 * $expire);

        return setcookie($key , $value , $expire , '/' , '' , false , true);

    }

    /**
     * Get Cookie
     *
     * @param $key
     * @return mixed
     */
    public function get($key)  {

        return $_COOKIE[$key];

    }

    /**
     * Determine if Key exists in Cookie
     *
     * @param $key
     * @return bool
     */
    public function has($key)  {

        return array_key_exists($_COOKIE, $key);

    }

    /**
     * Remove Cookie
     *
     * @param $key
     * @return mixed
     */
    public function remove($key)  {

        return $this->set($key , null , -1);

    }

    /**
     * Destroy Cookie
     *
     * @return void
     */
    public function destroy()  {

        foreach ($_COOKIE as $key => $value) {

            $this->set($key , null , -1);

        }

        unset($_COOKIE);

    }

    /**
     * Get All Cookie
     *
     * @return array
     */
    public function all()
    {
        return $_COOKIE;
    }

}