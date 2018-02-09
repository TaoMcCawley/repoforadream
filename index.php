<?php
/**
 * Created by PhpStorm.
 * User: Adrian Smith and James McPherson
 * Date: 2/6/18
 * Time: 10:01 AM
 */

require_once 'vendor/autoload.php';

$f3 = Base::instance();

$f3->set('DEBUG', 3);

$f3->route('GET /', function($f3){
    $template = new Template();
    echo $template->render('view/login.html');
});

$f3->run();