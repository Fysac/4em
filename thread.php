<?php
function get_formatted_time($timestamp){
	if (time() - $timestamp < 120){
		return "Just now";
	}
	elseif (time() - $timestamp < 3600){
		return floor((time() - $timestamp) / 60)." minutes ago";
	}
	elseif (date("d m Y") == date("d m Y", $timestamp)){
		return "Today ".date("h:i a", $timestamp);
	}
	elseif (date("d m Y", strtotime("-1 day")) == date("d m Y", $timestamp)){
		return "Yesterday ".date("h:i a", $timestamp);
	}
	else{
		return date("M d, Y h:i a", $timestamp);
	}
}

require_once("inc/mysql.php");
require_once("inc/session.php");
require_once("inc/user.php");

$thread_id = strip_tags(mysql_real_escape_string($_GET["id"]));

$get_thread = mysql_fetch_array(mysql_query("SELECT title, body, author, timestamp FROM threads WHERE id = '$thread_id';"));
$thread_title = $get_thread["title"];
$op_body = $get_thread["body"];
$op_author = $get_thread["author"];
$op_posted = get_formatted_time($get_thread["timestamp"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>4em | "<?php echo $thread_title."\"" ?></title>
	</head>
	<body>
		<?php include "inc/header.php"; ?>
		<div id="container">
			<?php echo "<h1>$thread_title</h1>"?>

			<table id="thread">
				<?php
				$user_info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username = '$op_author';"));
				
				echo 
	            "<tr id=\"post\">
					<td id=\"userPicture\">
						<img class=\"userPicture\" width=\"48\" height=\"48\" src=\"".get_profile_pic($op_author)."\"/>
					</td>
					<td id=\"message\">
						<a href=\"/user.php?name=".$op_author."\" class=\"userLink\">".$op_author."</a> 
						<span id=\"smgrey\">".$op_posted."</span>	
						<div id=\"messageBody\">
						<pre>".$op_body."</pre>
						</div>
						<br>
					</td>			
				</tr>";
				
				// Increment views
				mysql_query("UPDATE threads SET views = views + 1 WHERE id = '$thread_id';");
				
				$get_replies = mysql_query("SELECT * FROM replies WHERE thread = '$thread_id';");
				while ($reply = mysql_fetch_array($get_replies)){
					$reply_title = $reply["title"];
					$reply_body = $reply["body"];
					$reply_author = $reply["author"];
					$reply_posted = get_formatted_time($reply["timestamp"]);
					
					echo 
			        "<tr id=\"post\">
						<td id=\"userPicture\">
							<img class=\"userPicture\" width=\"48\" height=\"48\" src=\"".get_profile_pic($reply_author)."\"/>
						</td>
						<td id=\"message\">
							<a href=\"/user.php?name=".$reply_author."\" class=\"userLink\">".$reply_author."</a> 
							<span id=\"smgrey\">".$reply_posted."</span>	
							<div id=\"messageBody\">
							<pre>".$reply_body."</pre>
							</div>
							<br>
						</td>			
					</tr>";
				}	
				?>
			</table>	
				
			<?php
			if (!logged_in()){
				exit("<h2>You must be signed in to post here.</h2>");
			}
			?>
			<form action="reply.php" method="post">
				<?php
				$thread_array = mysql_fetch_array(mysql_query("SELECT * FROM threads WHERE id = '$thread_id'"));
				$title = "re: ".$thread_array["title"];
				?>
				
				<input type="hidden" value="<?php echo $thread_id; ?>" name="thread_id">
				<br/>
				<input type="text" name="title" value="<?php echo $title; ?>"> 
				<br/><br/>
				<textarea cols="110" rows="15" name="body" placeholder="Reply"></textarea>
				<br/><br/>
				<input type="submit" value="Post Reply">
			</form>
		</div>
	</body>
</html>
