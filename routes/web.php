<?php 

/**
 * Web Router File For the Framework. All requests start here as well as end here
 * @author Bailey Rotellini <baileyrotellini1998@gmail.com>
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Define our root path for ease of use through controllers and here
define("ROOT", realpath($_SERVER['DOCUMENT_ROOT']) . '/');

//Load in our composer module
require(ROOT . 'configuration.php');
require(ROOT . 'app/Library/App.php');
require(ROOT . 'app/Modules/database/Db.class.php');
require(ROOT . 'app/Modules/database/easyCRUD/easyCRUD.class.php');
require(ROOT . 'app/Modules/twig/vendor/autoload.php');
require(ROOT . 'app/Library/AdminUser.php');


$loader = new \Twig\Loader\FilesystemLoader(ROOT . 'public/views/');
$twig = new \Twig\Environment($loader, [
    'debug' => DEBUG
]);

$pageVars = array();
$base = array();
$base['page_title'] = 'PHP Framework';
$base['site_profile'] = App::GetSiteProfileVaribales();
$base['menu'] = App::GetMenu(); 

$directoryForUsage = $_SESSION['user_folder'];

$skipUserLevelDirectory = false;
$controller = CONTROLLERS . 'default.php';

$controllerFindAttempt = CONTROLLERS;
if(!empty($directoryForUsage)){
    $controllerFindAttempt .= $directoryForUsage . "/";
}
if(!empty($_GET['p'])){
    $controllerFindAttempt .= $_GET['p'];
}
$controllerFindAttempt .= '.php';

if(file_exists(CONTROLLERS . $directoryForUsage . '/' . $_GET['p'] . '.php')){
    $controller = CONTROLLERS . $directoryForUsage . '/' . $_GET['p'] . '.php';
}

include($controller);

$messages = App::CompileMessages();

$twig->addGlobal('data', $pageVars);
$twig->addGlobal('messages', $messages);
$twig->addGlobal('base', $base);
$twig->addGlobal('globals', $GLOBALS);
$twig->addGlobal('session', $_SESSION);

$pageNeeded = ($skipUserLevelDirectory === false ? 'pages/' . $directoryForUsage . '/' . $pageNeeded . '.html' : 'pages/' . $pageNeeded . '.html');

try {
    echo $twig->render($pageNeeded);
} catch (Exception $e) {
    echo $twig->render('pages/404.html', array('error'=> $e));
}