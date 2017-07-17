<?php

$app = \System\App::getInstance();   //get instance App Class

//add routes
$app->route->add('home' , 'home/home');
$app->route->add('about-us/:text' , 'home/about-us@about');
$app->route->add('login' , 'login/login@index');
$app->route->add('login/submit' , 'login/login@submit' , 'post');
$app->route->add('logout/:id' , 'login/login@logout' , 'post');
$app->route->add('notfound' , 'error/notfound' , 'post');
