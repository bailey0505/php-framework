<?php

if(empty($_GET['p']) || $_GET['p1'] == 'index'){
    if(!App::IsAuthenticated()){
        App::Redirect("/login");
    }
    $pageNeeded = 'index';
}else if($_GET['p'] == 'login'){
  
    if(App::IsAuthenticated()){
        App::Redirect("/");
    }
    $pageNeeded = 'login';
}else if($_GET['p'] == 'reset-password'){

}else if(!App::IsAuthenticated()){
    App::Redirect('/login');
}