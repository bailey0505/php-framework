<?php

/**
 * Class for essential app functions 
 * @author Bailey Rotellini <baileyrotellini1998@gmail.com>
 */

class App {

    public function __construct(){}

    /**
     * Return variables associated with site profile
     * @return array
     */
    public static function GetSiteProfileVaribales(){
        return array(
            'site_name' => "PHP Framework",
            'page_title_base' => "PHP Framework",
            'show_search' => false,
            "show_mega_menu" => false,
            "show_resources" => false,
            "show_notifications" => false,
            "show_messages" => false,
            "show_language" => false,
            "show_maximize" => true
        );
    }

    /**
     * Function for getting menu items dependant on user level
     * @retun array
     */
    public static function GetMenu(){

    }

    /**
     * Function for redirecting to new page
     * @param string $location Where you want to redirect to 
     * @return null
     */
    public static function Redirect($location){
        header("Location: " . $location);
        exit();
    }

    /**
     * Check to see if a user is currently logged in
     * @return boolean
     */
    public static function IsAuthenticated(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if($_SESSION['authenticated'] === true && !empty($_SESSION['user_Id'])) {
            return true;
        }
        return false;
    }

    /**
     * Check if a user can access a restricted area
     * @param int $auth the auth you need to access area
     * @return boolean
     */
    public static function UserCanAccessPage($auth){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if($_SESSION['authenticated'] === true && $_SESSION['auth_level'] <= $auth){
            return true;
        }
        return false;
    }
}