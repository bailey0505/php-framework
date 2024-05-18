<?php

if(App::UserCanAccessPage(ADMIN)){
    $pageNeeded = 'articles/articles-landing';
    $base['page_title'] = 'Articles';
}else{
    App::redirect('/login');
}