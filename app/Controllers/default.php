<?php


if(empty($_GET['p1']) || $_GET['p1'] == 'index'){
    $pageNeeded = 'login';
}else if($_GET['p0'] == 'login'){
    $pageNeeded = 'login';
}else if($_GET['p0'] == 'reset-password'){

}