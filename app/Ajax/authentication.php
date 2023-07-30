<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("ROOT", realpath($_SERVER['DOCUMENT_ROOT']) . '/');

require(ROOT . 'configuration.php');
require(ROOT . 'app/Library/App.php');
require(ROOT . 'app/Modules/database/Db.class.php');
require(ROOT . 'app/Modules/database/easyCRUD/easyCRUD.class.php');

require(ROOT . 'app/Library/AdminUser.php');

$result = array(
    'result' => false,
    'message' => 'No action passed'
);

if(!empty($_POST['action'])){
    $action = $_POST['action'];

    if($action == 'login'){

        $ADMIN = new AdminUser();
        $userSearch = $ADMIN->search(array("username"=>$_POST['username']));

        if(!empty($userSearch)){
            $ADMIN = new AdminUser($userSearch[0]['Id_admin_users']);
            
            $loginResult = $ADMIN->login($_POST['password']);

            if($loginResult === true){
                $result['result'] = true;
                $result['message'] = 'user logged in successfully';
            }else{
                $result['result'] = false;
                $result['message'] = 'Incorrect Username or Password';
            }
        }else{
            $result['result'] = false;
            $result['message'] = 'Incorrect Username or Password';
        }
    }else{  
        $result['result'] = false;
        $result['message'] = 'Action not recognized';
    }
}

echo json_encode($result);


