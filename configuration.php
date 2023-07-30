<?php

define("INSTALL_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) . "/");


//Loaction defines
define('CONTROLLERS', ROOT . 'app/Controllers/');


//Define our auth levels
define("ADMIN", 0);
define("MANAGER", 10);