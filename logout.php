<?php 
    require_once './function/utils.php';

    //Unset all sessions
    $_SESSION = array();

    //destroy sessiosn
    session_destroy();

    //redirect to login page
    header('Location: login.php')


?>