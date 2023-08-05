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
            'email'=>'baileyrotellini1998@gmail.com',
            'theme' => 'dark',
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
     * Function for getting auth level text
     * @return string|false
     */
    public static function GetAuthLevelText(){
        return (!empty($_SESSION['user_folder']) ? $_SESSION['user_folder'] : false);
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

    /**
     * Function for queing a message to display
     * @param string $message The message
     * @param string $type The type of message(error, success, info etc.)
     * @return null
     */
    public static function QueueMessage($message, $type){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION['messages'])){
            $_SESSION['messages'] = array();
        }
        $_SESSION['messages'][] = array(
            'message' => $message,
            'type' => $type
        );
    }
    
    /**
     * Function to compile messages array
     * @return array|null
     */
    public static function CompileMessages(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(!empty($_SESSION['messages'])){
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        }
    }

    /***************  Menu Defines - Do not code anything else beyond this point  ******************/

    /**
     * Function for getting menu items dependant on user level
     * @return array
     */
    public static function GetMenu(){
        $text = App::GetAuthLevelText();

        if(!empty($text)){
            if($text == 'admin'){
                return App::GetAdminMenu();
            }else{
                return false;
            }
        }
        return false;
    }

    /**
     * Get Admin menu items
     * @return array
     */
    public static function GetAdminMenu(){
        return array(
            'main' => array(
                array(
                    'name'=> 'Page Example',
                    'link'=> '/page',
                    'icon' => 'book'
                ),
                array(
                    'name'=> 'Page Example 2',
                    'link'=> '#',
                    'icon' => 'monitor',
                    'list_name' => 'example-page-2',
                    'sub_items' => array(
                        array(
                            'name'=>'SubItem 1',
                            'link'=> '/page2/sub-item'
                        )
                    )
                ),
            ),
            'footer'=>false
        );
    }

}