<?php
session_start();

function validate_user($user_data){
    session_regenerate_id();
    $_SESSION["valid"] = true;
    $_SESSION["username"] = $user_data["username"];
}

function logged_in(){
    return isset($_SESSION["valid"]) && $_SESSION["valid"];
}

function logout(){
    $_SESSION = array();
    session_destroy();
}
?>
