<?php

/** 
* Admin User Class Class
* @author Bailey Rotellini <baileyrotellini1998@gmail.com>
* @access public  
*/


class AdminUser Extends Crud {
    /**
	* protected variable to set table for class
	* @access protected
	*/
	protected $table = 'admin_users';
	/**
	* protected variable to set Id column for our class
	* @access protected
	*/
	protected $pk  = 'Id_admin_users';

    /**
	* Variable to hold our setting table
	* @access protected
	*/
	protected $settingsTable  = 'user_level_settings';


    /**
   * Construct Function for our class
   * @param int $Id primary key to load
   * @return null
   */
	public function __construct($Id = false) {
		parent::__construct($Id);
	}

    /**
     * Function for setting password on user
     * @param $password the password
     * @return null
     */
    public function SetPassword($password){
        if($this->IsLoaded()){
            $this->password = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost"=>12));
            $this->update();
        }
        return false;
    }

    /**
     * Function to login to platform 
     * @param string $password the generic text password string
     * @return boolean
     */
    public function Login($password){
        if($this->IsLoaded() && password_verify($password, $this->password)){
            $userLevelVariables = $this->DATABASE->row("SELECT * FROM " . $this->settingsTable . ' WHERE Id_user_level_settings=:Id_user_level_settings', array("Id_user_level_settings"=>$this->auth_level));
            
            $_SESSION['authenticated'] = true; 
            $_SESSION['user_Id'] = $this->IsLoaded();
            $_SESSION['username'] = $this->username;
            $_SESSION['name'] = $this->first_name . ' ' . $this->last_name;
            $_SESSION['title'] = $this->title;
            $_SESSION['auth_level'] = $this->auth_level;
            $_SESSION['user_folder'] = $userLevelVariables['folder'];
            $_SESSION['auth_text'] = $userLevelVariables['display_name'];
            
            return true;
        }
        return false;
    }

    /**
     * Static function to generate random reset token
     * @param int $length the length you want the reset token. Default 128
     * @return string
     */
    public static function GenerateResetToken($length = 128){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}