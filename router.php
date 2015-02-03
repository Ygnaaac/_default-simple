<?php

$content_tpl = '';

if (!isset($_GET['site']))
    $_GET['site'] = 1;

if(isset($_COOKIE['age'])){
     setcookie("age-check", "1", time()+3600);
}

if((!isset($_COOKIE['age-check']) || !$_COOKIE['age-check']) && $_GET['site'] != 2){
    header('Location: kontrola-veku');
    exit();
}


switch ($_GET['site']) {

    case 1: default :
        $content_tpl = 'templates/index.phtml';
        $checker = false;
        break;
    case 2:
        $content_tpl = 'templates/agechecker.phtml';
        $checker = true;
        break;
}

?>