<?php
require_once("inc/mysql.php");

function get_date_joined($username){
	$joined = mysql_fetch_array(mysql_query("SELECT joined from users WHERE username = '$username'"))["joined"];
	return date("M d, Y h:i a", $joined);
}

function get_profile_pic($username){
    return file_exists("image/user/".$username.".jpg") ? "/image/user/".$username.".jpg" : "/image/guest.png";
}

function user_exists($username){
	$check_username = mysql_query("SELECT username from users WHERE username = '$username'");
	return mysql_num_rows($check_username) > 0;
}
?>
