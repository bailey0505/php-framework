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
                
                $app = App::GetSiteProfileVaribales();
                $mailResult = $MAILER->Send(array(array("email"=>$ADMIN->username)), $app['site_name'] . '- Reset Password', 'reset-password', $ADMIN->variables);

                if($mailResult === true){
                    $result['result'] = true;
                    $result['message'] = 'If you had an account in our system you will receive an email to reset your password';
                }else{
                    $ADMIN->reset_password = 0;
                    $ADMIN->reset_token = null;
                    $ADMIN->save();

                    $result['result'] = false;
                    $result['message'] = 'Their was an error with sending email to reset password. Please contact support';
                }

            }else{
                $result['result'] = true;
                $result['message'] = 'If you had an account in our system you will receive an email to reset your password';
            }
        }else{
            $result['result'] = false;
            $result['message'] = 'No username passed';
        }
    }else if($action == 'reset-password'){
        $ADMIN = new AdminUser($_POST['Id_admin_users']);

        if($ADMIN->IsLoaded() && $ADMIN->reset_token == $_POST['reset_token']){
            $ADMIN->reset_token = null;
            $ADMIN->reset_password = 0;
            $ADMIN->SetPassword($_POST['password']);

            App::QueueMessage("Password Reset Successfully", "success");

            $result['result'] = true;
            $result['message'] = 'Password reset successfully';
        }else{
            $result['result'] = false;
            $result['message'] = 'Could not reset password. Please contact support';
        }
    }else{
        $result['result'] = false;
        $result['message'] = 'Action not recognized';
    }
}


echo json_encode($result);