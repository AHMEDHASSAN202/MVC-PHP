<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/10/2017
 * Time: 1:33 AM
 */

namespace app\Controllers\home;
use System\Controller;


class homeController extends Controller
{

    public function index()
    {
        $data['title'] = 'home';

        return $this->app->view->render('home/home' , $data);
    }
}