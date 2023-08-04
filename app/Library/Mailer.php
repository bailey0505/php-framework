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
    private $this->MAILERER;

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

        $settings = parse_ini_file(ROOT . 'settings/mail.ini.php');

        $this->MAILER = new PHPMailer();
        $this->MAILER->isSMTP(); 
        $this->MAILER->Host = $settings['Host'];
        $this->MAILER->Port = $settings['Port'];
        $this->MAILER->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $this->MAILER->SMTPAuth = true;
        $this->MAILER->Username = $settings['Username'];
        $this->MAILER->Password = $settings['Password'];
        $this->MAILER->setFrom($settings['Username']);
        $this->MAILER->IsHTML(true);

        $loader = new \Twig\Loader\FilesystemLoader(ROOT . 'public/mail/');
        $this->TWIG = new \Twig\Environment($loader, [
            'debug' => DEBUG
        ]);
	}

    /**
     * Function for adding emails to emails being sent
     * @param array $addresses  - The email addresses and names of people you want to send to
     * 
     *  addresses array(array('email'=>'email@email.com', 'name'=> 'Jon Doe'))
     * 
     * @return null
     */
    public function AddAddresses($addresses){
        foreach($addresses as $address){
            if(!empty($address['email'])){
                if(!empty($address['name'])){
                    $this->MAILER->addAddress($address['email'], $address['name']);
                }else{
                    $this->MAILER->addAddress($address['email']);
                }
            }
        }
    }

    /**
     * Function for adding bcc
     * @param string $address The email address
     * @return null
     */
    public function AddBcc($address){
        $this->MAILER->addBCC($address);
    }

    /**
     * Function for adding cc to email
     * @param string $address the email address
     * @return null
     */
    public function AddCc($address){
        $this->MAILER->addCC($address);
    }

    /**
     * 
     */
    public function Send($addresses, $template, $data = false){

    }
}