<html>
	<head>
		<title>4em | Settings</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<link rel="stylesheet" type="text/css" href="../stylesheet.css"/>
		<?php
		require_once("inc/session.php");
		require_once("inc/user.php");
		?>
	</head>
	<body>
		<?php
		require_once("inc/header.php");
		if (!logged_in()){
			echo "<h2><a href=\"/login\">Login</a> or <a href=\"/join\">join</a> to change your settings.</h2>";
			exit();
		}
		?>
		<h2>Settings</h2>
		
		<p><b>Username:</b> <?php echo $_SESSION["username"]; ?></p>

		<form action="change_username.php" method="post">
			<input type="text" name="new" placeholder="New username"/>
			<input type="submit" value="Change"/> 
		</form>
		
		<p><b>Joined:</b> <?php echo get_date_joined($_SESSION["username"]) ?></p>
		
		<form action="change_password.php" method="post">
			<b>Change password:</b><br>
			<input type="password" placeholder="Current password" name="current">
			<br/><br/>
			<input type="password" placeholder="New password" name="new">
			<br/>
			<input type="password" placeholder="Confirm new password" name="confirm">
			<br/>
			<input type="submit" value="Change"> 
		</form>
		<hr>
		
		<b>Profile picture:</b>
		<br/><br/>
		<?php echo "<img width=48 height=48 src=".get_profile_pic($_SESSION["username"])."></img>"; ?>
		<br/>
		<form action="change_avatar.php" method="post" enctype="multipart/form-data">
			<b>New picture:</b> <input type="file" name="file" id="file"><br>
			<input type="hidden" name="MAX_FILE_SIZE" value="20000">
			<input type="submit" value="Upload"> 
			JPG, PNG, and GIF formats are allowed. File size must be under 20 kB. For best results, upload a square image.
		</form>
		<hr>
	</body>
</html>
