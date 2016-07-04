<?php
require_once("inc/session.php");
require_once("inc/user.php");

$current = mysql_real_escape_string($_SESSION["username"]);
$username = strip_tags(mysql_real_escape_string($_POST["new"]));

if (empty($username)){
	exit("Empty username");
}
if (user_exists($username)){
	exit("Username taken");
}

mysql_query("UPDATE users SET username = '$username' WHERE username = '$current';");
mysql_query("UPDATE threads SET author = '$username' WHERE author = '$current';");
mysql_query("UPDATE threads SET last_author = '$username' WHERE last_author = '$current';");
mysql_query("UPDATE replies SET author = '$username' WHERE author = '$current';");

rename("image/user/".$current.".jpg", "image/user/".$username.".jpg");

$user_data = mysql_fetch_array(mysql_query("SELECT id, username, joined FROM users WHERE username = '$username';"));
validate_user($user_data);
header("Location: settings.php");
?>

