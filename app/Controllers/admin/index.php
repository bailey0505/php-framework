<?php

if(App::UserCanAccessPage(ADMIN)){
    $pageNeeded = 'index';
    $base['page_title'] = 'Dashboard';
}else{
    App::redirect('/login');
}

