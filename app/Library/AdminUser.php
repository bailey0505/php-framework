<?php

/** 
* Contact Class
* @package NextGen Media - Admin  
* @version Revision: 1.0
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

    public function VerifyPassword(){

    }

    public function Login($password){
        if($this->IsLoaded() && password_verify($password, $this->password)){
            $userLevelVariables = $this->DATABASE->row("SELECT * FROM " . $this->settingsTable . ' WHERE Id_user_level_settings=:Id_user_level_settings', array("Id_user_level_settings"=>$this->auth_level));
            
            $_SESSION['authenticated'] = true; 
            $_SESSION['user_Id'] = $this->IsLoaded();
            $_SESSION['username'] = $this->username;
            $_SESSION['name'] = $this->first_name . ' ' . $this->last_name;
            $_SESSION['title'] = $this->title;
            $_SESSION['user_folder'] = $userLevelVariables['folder'];
            $_SESSION['auth_text'] = $userLevelVariables['display_name'];
            return true;
        }
        return false;
    }

}