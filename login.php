<?php
require_once("inc/session.php");
require_once("inc/user.php");

if (isset($_POST["username"]) && isset($_POST["password"])){
	$username = mysql_real_escape_string($_POST["username"]);
	$password = $_POST['password'];

	if (empty($username) || !user_exists($username)){
		exit("Bad login");
	}
	
	$expected_hash = mysql_fetch_array(mysql_query("SELECT hash FROM users WHERE username = '$username';"))["hash"];
	
	if (!password_verify($password, $expected_hash)){
		exit("Bad login");
	}
	
	$get_user_data = mysql_query("SELECT id, username, joined FROM users WHERE username = '$username';");
	$user_data = mysql_fetch_array($get_user_data);
	
	validate_user($user_data);
	header("Location: /");
}
?>

<html>
	<head>
		<title>4em | Login</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	</head>
	<body>
		<?php include 'inc/header.php'; ?>
		<div class='container'>
			<form action="login.php" method="post">
				<h2>Login to 4em</h2>

				<p><input type="text" name="username" placeholder="Username" maxlength="25"></p>
				<p><input type="password" name="password" placeholder="Password"></p>
				
				<input type="submit" value="Login"/>
            </form>
		</div>
	</body>
</html>
