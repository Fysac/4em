<?php
require_once("inc/mysql.php");
require_once("inc/session.php");
require_once("inc/user.php");

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm"])){
	$username = strip_tags(mysql_real_escape_string($_POST["username"]));
	$password = $_POST["password"];
	$confirm = $_POST["confirm"];
	
	if (empty($username)){
		exit("Empty username");
	}
	if (empty($password)){
		exit("Empty password");
	}
	if ($password != $confirm){
		exit("Passwords do not match");
	}
	if (user_exists($username)){
		exit("Username taken");
	}
	
	$time = time();
	$hash = password_hash($password, PASSWORD_DEFAULT);
	
	$create_user = mysql_query("INSERT INTO users (username, hash, joined) VALUES ('$username', '$hash', '$time');");
	
	$get_user_data = mysql_query("SELECT id, username, joined FROM users WHERE username = '$username';");
	$user_data = mysql_fetch_array($get_user_data, MYSQL_ASSOC);
	
	validate_user($user_data);
	header("Location: /");	
}
?>

<html>
	<head>
		<title>4em | Join</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	</head>
	<body>
		<?php include "inc/header.php"; ?>
		<form action="join.php" method="post">
			<h2>Join 4em</h2>
			<p><input type="text" name="username" placeholder="Username" maxlength="25"></p>

			<p><input type="password" name="password" placeholder="Password"></p>
			
			<p><input type="password" name="confirm" placeholder="Confirm password"></p>
			<input type="submit" value="Join" name="submit">
        </form>
	</body>
</html>
