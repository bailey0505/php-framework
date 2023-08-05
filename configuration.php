<?php

/**
 * Configuration file for framework - this should be included at the top of ALL backend files
 * @author Bailey Rotellini <baileyrotellini1998@gmail.com>
 */

//Define our root of project
define("ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) . "/");

//This debugging setting controls every debug setting in the framework
define("DEBUG", true);

//Define if we are allowed to send emails
define("SEND_EMAILS", true);

//Loaction defines
define('CONTROLLERS', ROOT . 'app/Controllers/');


//Define our auth levels
define("ADMIN", 0);
define("MANAGER", 10);
