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
     * Private Variable to hold our app settings
     * 
     */
    private $app;

    /**
   * Construct Function for our class
   * @return null
   */
	public function __construct() {
		require_once(ROOT . 'app/Modules/php-mailer/vendor/autoload.php');
        require_once(ROOT . 'app/Modules/twig/vendor/autoload.php');

        $loader = new \Twig\Loader\FilesystemLoader(ROOT . 'public/mail/');
        $this->TWIG = new \Twig\Environment($loader, [
            'debug' => DEBUG
        ]);
        $this->MAILER = new PHPMailer();

        $this->app = App::GetSiteProfileVaribales();
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


    /*
        $mail = new PHPMailer;
        $mail->isSMTP(); 
        $mail->SMTPDebug = 0; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls'; 
        $mail->SMTPAuth = true;
        $mail->Username = $settings['username'];
        $mail->Password = $settings['password'];
        $mail->setFrom($settings['username'], "Alyssa Michelle Videography");
        $mail->addAddress('alyssamvideo@gmail.com', "Alyssa Boyd");
        $mail->Subject = 'New Inquiry';
        $mail->IsHTML(true);
        $mail->msgHTML($html);

    */

    /**
     * Function for sending email
     * @param array $addresses the emails to send to
     * @param string $subject the subject of the email
     * @param string $template the email template 
     * @param array $data the data for the email 
     * @param string $replyTo the reply to email
     * @return boolean
     */
    public function Send($addresses, $subject, $template, $data = false, $replyTo = false){
        if(empty(SEND_EMAILS)){
            return true;
        }
        
        $settings = parse_ini_file(ROOT . 'settings/mail.ini.php');

        $this->MAILER->isSMTP(); 
        $this->MAILER->Host = $settings['Host'];
        $this->MAILER->Port = $settings['Port'];
        $this->MAILER->SMTPSecure = $settings['SmtpSecure']; 
        $this->MAILER->SMTPAuth = true;
        $this->MAILER->Username = $settings['Username'];
        $this->MAILER->Password = $settings['Password'];
        $this->MAILER->setFrom($settings['Username']);
        $this->MAILER->IsHTML(true);

        $this->AddAddresses($addresses);
        $this->MAILER->Subject = $subject;

        if(!empty($replyTo)){
            $this->MAILER->addReplyTo($replyTo);
        }

        $header = $this->GetHeader();
        $footer = $this->GetFooter();
        $email = $this->TWIG->render($template . '.html', array('data'=> $data, 'header'=>$header, 'footer'=>$footer, 'globals'=>$GLOBALS, 'app'=>$this->app));
        $this->MAILER->Body = $email;

        if(!$this->MAILER->send()){
            //echo "<pre>";
            //print_r($this->MAILER);
            //print_r($this->MAILER->ErrorInfo);
            return false;
        }
        return true;
    }

    /**
     * Function for getting the header for email
     * @return html
     */
    private function GetHeader(){
        return $this->TWIG->render('partials/header.html', array('globals' => $GLOBALS, 'app'=>$this->app));
    }

    /**
     * Function for getting the footer for email
     * @return html
     */
    private function GetFooter(){
        return $this->TWIG->render('partials/footer.html', array('globals' => $GLOBALS, 'app'=>$this->app));
    }

}