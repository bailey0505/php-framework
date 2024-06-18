<?php

$app = App::GetSiteProfileVariables();


if(empty($_GET['p']) || $_GET['p1'] == 'index'){
    if(!App::IsAuthenticated() && $app['public'] === false){
        App::Redirect("/login");
    }
    $pageNeeded = 'index';
}else if($_GET['p'] == 'login'){
    if(App::IsAuthenticated()){
        App::Redirect("/admin/dashboard");
    }
    $pageNeeded = 'login';
}else if($_GET['p'] == 'reset-password'){
    if(!empty($_GET['token'])){
        $ADMIN = new AdminUser();
        $adminSearch = $ADMIN->search(array("reset_token"=>$_GET['token']));
        
        if(!empty($adminSearch) && $adminSearch[0]['reset_password'] == 1){
            $pageVars['user'] = $adminSearch[0];
        }else{
            App::QueueMessage("Your reset token has expired", "error");
        }
    }
    $pageNeeded = 'reset-password';
    $skipUserLevelDirectory = true;
}else if($_GET['p'] == 'profile' && App::IsAuthenticated()){
    $ADMIN = new AdminUser($_SESSION['user_Id']);
        
    if($ADMIN->IsLoaded()){
        $skipUserLevelDirectory = true;
        $pageVars['user'] = $ADMIN->variables;
        $pageNeeded = 'profile';
    }else{
        App::Redirect('/');
    }
}else if(!App::IsAuthenticated() && $app['public'] === false){
    App::Redirect('/login');
}