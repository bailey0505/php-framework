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
require(ROOT . 'app/Library/Mailer.php');

$result = array(
    'result' => false,
    'message' => 'No action passed'
);

if(!empty($_POST['action'])){
    $action = $_POST['action'];

    if($action == 'request-reset-password'){
        if(!empty($_POST['username'])){
            $ADMIN = new AdminUser();
            $userSearch = $ADMIN->search(array("username"=>$_POST['username']));

            if(!empty($userSearch)){
                $ADMIN = new AdminUser($userSearch[0]['Id_admin_users']);
                $ADMIN->reset_password = 1;
                $ADMIN->reset_token = AdminUser::GenerateResetToken();
                $ADMIN->update();

                $MAILER = new Mailer(DEBUG);

                echo "<pre>";
                var_dump($ADMIN);
                die();

            }else{
                $result['result'] = true;
                $result['message'] = 'If you had an account in our system you will receive an email to reset your password';
            }
        }else{
            $result['result'] = false;
            $result['message'] = 'No username passed';
        }
    }else{
        $result['result'] = false;
        $result['message'] = 'Action not recognized';
    }
}


echo json_encode($result);