<?php
require_once("inc/mysql.php");
require_once("inc/session.php");

if (logged_in()){
    $username = $_SESSION["username"];
    $thread_id = strip_tags(mysql_real_escape_string($_POST["thread_id"]));
    $title = strip_tags(mysql_real_escape_string($_POST["title"]));
	$body = strip_tags(mysql_real_escape_string($_POST["body"]), "<a><b><i>");
	
	if (empty($title)){
		exit("Invalid title");
	}
	if (empty($body)){
		exit("Invalid message body");
	}

	$time = time();

	/* Add info to replies table */
	mysql_query("INSERT INTO replies VALUES(NULL, '$thread_id', '$title', '$body', '$username', '$time');");

	/* Increment number of replies in thread table */
	mysql_query("UPDATE threads SET replies = replies + 1 WHERE id = '$thread_id';");

	/* Store last message info in database */
	mysql_query("UPDATE threads SET last_author = '$username' WHERE id = '$thread_id';");
	mysql_query("UPDATE threads SET last_timestamp = '$time' WHERE id = '$thread_id';");

	header("Location: thread.php?id=".$thread_id);
}
?>
