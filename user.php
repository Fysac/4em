<?php
require_once("inc/session.php");
require_once("inc/user.php");
$username = strip_tags(mysql_real_escape_string($_GET["name"]));
if (!user_exists($username)){
	exit("No such user");
}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<title>4em | <?php echo $username ?>'s Profile</title>
	</head>
	<body>
		<?php 
		include "inc/header.php";
		echo "<h2>User profile of $username</h2>";
		?>
	</body>
</html>

