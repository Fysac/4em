<!DOCTYPE html>
<html>
	<head>
		<title>4em | New Post</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<?php
		require_once("inc/session.php");
		require_once("inc/user.php");
		?>
	</head>
	
	<body>
		<?php
			if (logged_in() && isset($_POST["title"]) && isset($_POST["body"])){
				$username = $_SESSION["username"];
				$time = time();
				
				$title = strip_tags(mysql_real_escape_string($_POST["title"]));
				$body = strip_tags(mysql_real_escape_string($_POST["body"]), "<a><b><i>");
				
				if (empty($title)){
					exit("Invalid title");
				}
				if (empty($body)){
					exit("Invalid message body");
				}
				
				mysql_query("INSERT INTO threads VALUES(NULL, '$title', '$body', '$username', 0, 0, '$time', '$username', '$time')");
				
				header("Location: /");
			}
					
			include "inc/header.php";
			
			if (logged_in()){
				echo 
				"<h1>New Post</h1>
				<form action=\"post.php\" method=\"POST\">
					<input type=\"text\" name=\"title\" placeholder=\"Title\"><br><br>

					<textarea cols=\"110\" rows=\"15\" name=\"body\" placeholder=\"Message body\"></textarea>
					<br/><br/>
					<input type=\"submit\" value=\"Post\">
				</form>";
			}
			else {
				echo "<h2><a href=\"/login.php\">Login</a> or <a href=\"/join.php\">join</a> to make a new post.</h2>";
			}
		?>
	</body>
</html>
