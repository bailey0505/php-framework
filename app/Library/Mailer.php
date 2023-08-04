<?php 

/**
 * Mailer Class from Framework
 * @author Bailey Rotellini <baileyrotellini1998@gmail.com>
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    /**
     * Private variables to hold our PHP mailer
     */
    private $MAILER;

    /**
     * Prviate variable to hold our twig
     */
    private $TWIG;
    
    /**
   * Construct Function for our class
   * @return null
   */
	public function __construct() {
		require_once(ROOT . 'app/Modules/php-mailer/vendor/autoload.php');
        require_once(ROOT . 'app/Modules/twig/vendor/autoload.php');

        $this->MAILER = new PHPMailer();

        $loader = new \Twig\Loader\FilesystemLoader(ROOT . 'public/mail/');
        $this->TWIG = new \Twig\Environment($loader, [
            'debug' => DEBUG
        ]);
	}

}