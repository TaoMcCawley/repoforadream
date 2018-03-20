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

$f3->route('GET|POST /', function ($f3) {
    $f3->set('title', 'Keyboard - Sign Up');

    if (isset($_POST['signupsubmit'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $newUser = new NewUser($username, $password, $name, $email);
        $dbh = new UserDB($f3);

        if ($password !== $_POST['retype']) {
            $newUser->addError('retype', ' * Password entries must match.');
        }
        if ($dbh->signup($newUser)) {
            $f3->reroute('/login');
        } else {
            if ($dbh->emailExists($newUser)) {
                $newUser->addError('duplicateEmail', 'An account with that email already exists.');
            }
            if ($dbh->usernameExists($newUser)) {
                $newUser->addError('duplicateUsername', 'An account with that username already exists.');
            }

            $_SESSION['user'] = $newUser;
        }

        $f3->set('username', $newUser->getUsername());
        $f3->set('email', $newUser->getEmail());
        $f3->set('name', $newUser->getName());
        $f3->set('errors', $newUser->getErrors());
    }

    $template = new Template();
    echo $template->render('view/signup.html');
});

$f3->route('GET|POST /login', function ($f3) {
    $title = "Keyboard - Login";
    $f3->set("title", $title);

    if (isset($_POST['loginsubmit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $dbh = new UserDB($f3);

        $user = $dbh->login($username, $password);

        if ($user != null) {
            $user->setSongs($dbh->loadSongs($user));
            $_SESSION['user'] = $user;
            $f3->reroute("/keyboard");
        }
        $f3->set("username", $username);
    }

    $template = new Template();
    echo $template->render('view/login.html');
});

$f3->route('GET|POST /keyboard', function ($f3) {
    $title = 'Keyboard';
    $f3->set('title', $title);
    $displayedOctaves = 2;
    $songs = array();

    if (!isset($_SESSION{'user'})) {
        $firstOctave = array(
            'q' => 'C',
            '2' => 'C#',
            'w' => 'D',
            '3' => 'D#',
            'e' => 'E',
            'r' => 'F',
            '5' => 'F#',
            't' => 'G',
            '6' => 'G#',
            'y' => 'A',
            '7' => 'A#',
            'u' => 'B'
        );
        $secondOctave = array(
            'i' => 'C',
            '9' => 'C#',
            'o' => 'D',
            '0' => 'D#',
            'p' => 'E',
            'z' => 'F',
            's' => 'F#',
            'x' => 'G',
            'd' => 'G#',
            'c' => 'A',
            'f' => 'A#',
            'v' => 'B'
        );
        $loggedIn = "false";
    } else {
        $user = $_SESSION['user'];
        $allOctaves = $user->getMapping();
        $firstOctave = $allOctaves[0];
        $secondOctave = $allOctaves[1];
        $loggedIn = "true";
        $songs = $user->getSongs();
    }

    $defaultOctave = 4;

    $f3->set('octaves', $displayedOctaves);
    $f3->set('firstOctave', $firstOctave);
    $f3->set('secondOctave', $secondOctave);
    $f3->set('currentOctave', $defaultOctave);
    $f3->set('songs', $songs);
    $f3->set('loggedIn', $loggedIn);

    $template = new Template();
    echo $template->render('view/mainBoard.html');
});

$f3->route('POST /savesong', function ($f3) {
    $songContent = $_POST['song'];
    $name = $_POST['name'];

    $dbh = new UserDB($f3);

    $user = $_SESSION['user'];

    $song = $dbh->saveSong($user, $name, $songContent);
    $user->addSong($song);

    echo $name.":".$songContent;
});

$f3->route('GET /logout', function($f3){
    session_destroy();
    $f3->reroute("/login");
});

$f3->run();