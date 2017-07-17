<?php

namespace app\Controllers\login;

use \System\Controller;

class loginController extends Controller
{
    public function index()
    {
        $data['title'] = 'login';
        $data['action'] = $this->app->url->url('login/submit');

        return $this->app->view->render('login/login' , $data);
    }

    public function submit()
    {
        /*$this->app->validate->required('username')->username('username');
        $this->app->validate->required('password')->password('password');
        $this->app->validate->requiredFile('image')->isImage('image');
        $this->app->validate->required('email')->email('email');*/
        $this->app->validate->unique('first_name' , ['users' , 'first_name']);

        if ($this->validate->passes()) {
            echo 'success';
        }else {
            pre($this->validate->getErrors());
        }
    }


}