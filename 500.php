<?php

//Define our root path for ease of use through controllers and here
define("ROOT", realpath($_SERVER['DOCUMENT_ROOT']) . '/');

require(ROOT . 'app/Library/App.php');
require(ROOT . 'app/Modules/twig/vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader(ROOT . 'public/views/');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

echo $twig->render('pages/500.html');