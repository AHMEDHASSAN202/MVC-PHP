<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/7/2017
 * Time: 2:10 AM
 */

namespace System;


class Session
{
    /**
     * App Class
     *
     * @var object
     */
    private $app;

    /**
     * Session Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Start Session
     *
     * @return void
     */
    public function start()
    {
        //used session with only cookies
        ini_set('session.use_only_cookies' , 1);

        //This means that the cookie won't be accessible by scripting languages [such us js]
        ini_set('session.cookie_httponly' , 1);

        if (! session_id()) {

            session_start();
        }
    }

    /**
     * Set Session
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key , $value)  {

        return $_SESSION[$key] = $value;

    }

    /**
     * Get Session
     *
     * @param $key
     * @return mixed
     */
    public function get($key)  {

        return $_SESSION[$key];

    }

    /**
     * Determine if Key exists in Session
     *
     * @param $key
     * @return bool
     */
    public function has($key)  {

        return array_key_exists($_SESSION , $key);

    }

    /**
     * Pull Session
     *
     * @param $key
     * @return mixed
     */
    public function pull($key)  {

        $session = $this->get($key);

        $this->remove($key);

        return $session;
    }

    /**
     * Remove Session
     *
     * @param $key
     */
    public function remove($key)  {

        unset($_SESSION[$key]);

    }

    /**
     * Destroy Session
     *
     * @return void
     */
    public function destroy()  {

        session_destroy();

        unset($_SESSION);

    }

    /**
     * Get All Session
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }

}