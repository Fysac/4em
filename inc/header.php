<div id="header">		
	<a href="/">Home | </a>
		<?php
			if (!logged_in()){
				echo "<b>guest</b> | <a href=\"/join.php\">Join</a> | <a href=\"/login.php\">Login</a>";
			}
			else {
				echo "<a href=\"user.php?name=".$_SESSION["username"]."\">".$_SESSION["username"]."'s Profile</a> 
					| <a href=\"/settings.php\">Settings</a> | <a href=\"/logout.php\">Logout</a>";
			}
		?>
</div>
<hr/>
