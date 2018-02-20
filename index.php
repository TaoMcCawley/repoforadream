<?php
/**
 * Created by PhpStorm.
 * User: Adrian Smith and James McPherson
 * Date: 2/6/18
 * Time: 10:01 AM
 */

require_once 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$f3 = Base::instance();

$f3->set('DEBUG', 3);

$f3->route('GET|POST /', function($f3){
    $f3->set('title', 'Keyboard - Login');

    if(isset($_POST['signupsubmit'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $user = new User($username, $password, $name, $email);
        $dbh = new UserDB($f3);

        if($password !== $_POST['retype']) {
            $user->addError('retype', ' * Password entries must match.');
        }
        if (!$dbh->exists($user)){
            $dbh->signup($user);
            $_SESSION['user'] = $user;
            $f3->reroute('login');
        }else{
            if($dbh->checkEmail($user)) {
                $user->addError('duplicateEmail', 'An account with that email already exists.');
            }
            if($dbh->checkUsername($user)){
                $user->addError('duplicateUsername', 'An account with that username already exists.');
            }
        }


        $f3->set('username', $user->getUsername());
        $f3->set('email', $user->getEmail());
        $f3->set('name', $user->getName());
        $f3->set('errors', $user->getErrors());
    }

    $template = new Template();
    echo $template->render('view/login.html');
});

$f3->route('GET /login', function(){
    $template = new Template();
    echo $template->render('view/header.html');
});

$f3->run();