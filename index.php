<?php

require_once("inc/mysql.php");
require_once("inc/session.php");
require_once("inc/user.php");

$currentPage = $_SERVER["PHP_SELF"];

/* Remember, index value is for the SQL query's sake (using LIMIT). The actual
   index (human-understandable) is $index + 1 */
if (isset($_GET['page']) && $_GET['page'] != 1){
	$page = $_GET['page'];
	$index = ($page * 20) - 20;
}
else{
	$page = 1;
	$index = 0;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>4em</title>
	</head>
	<body>
		<?php include "inc/header.php"; ?>
		<h1>Welcome to 4em</h1>
 
		<div id="content">
			<form action="post.php">
				<input type="submit" value="New Post">
			</form>
			<br/>

			<form action="index.php" method="GET">
				<input type="text" name="filter" placeholder="title">
				<input type="submit" value="Search">
			</form>
			<br/>
			
			<table id="discussion" border='1' rules='rows'>
				<tr class='d1' id='head'>
					<td><b>Title</td>
					<td><b>Author</td>
					<td><b>Replies</td>
					<td><b>Views</td>
					<td><b>Last Message</td>
                    <td></td>
				</tr>

			<?php
			/* Check to filter keywords */
			if (isset($_GET['filter'])){
				$_GET['filter'] = mysql_real_escape_string($_GET['filter']);
				$sql = mysql_query("SELECT * FROM threads WHERE title LIKE '%$_GET[filter]%' ORDER BY last_timestamp DESC LIMIT $index, 20");
			}
			else {
				$sql = mysql_query("SELECT * FROM threads ORDER BY last_timestamp DESC LIMIT $index, 20");
			}
			
			if (!$sql){
				exit("There are no threads to show.");
			}
			
			/* Table row color starts as even */
			$class = "even";
			
			while ($r = mysql_fetch_array($sql)){
				/* Check if last message was made within a certain time frame */
				if (time() - $r["last_timestamp"] < 120){
					$last_timestamp = "Just now";
				}
				elseif (time() - $r["last_timestamp"] < 3600){
					$last_timestamp = floor((time() - $r["last_timestamp"]) / 60)." minutes ago";
				}
				elseif (date('d m Y') == date('d m Y', $r['last_timestamp'])){
					$last_timestamp = "Today ".date("h:i a", $r["last_timestamp"]);
				}
				elseif (date('d m Y', strtotime('-1 day')) == date('d m Y', $r['last_timestamp'])){
					$last_timestamp = "Yesterday ".date("h:i a", $r["last_timestamp"]);
				}
				else{
					$last_timestamp = date("M d, Y h:i a ", $r["last_timestamp"]);
				}
				
				/* Truncate title, add '...' if more than 40 chars */
				$title = substr($r['title'], 0, 40);
				if (strlen($r['title']) > 40){
					$title .= "...";
				}
				
				/* Alternate row shading */
				if ($class == "even"){
					$class = "odd";
				}
				else{
					$class = "even";
				}
				/* Dynamically update rows of table */
				echo 
				"<tr class=$class>
				<td><a href='thread.php?id=$r[id]'>$title</a></td>  
				<td><img class=userPicture width=16 height=16 src=".get_profile_pic($r["author"])."> </img><a href=user.php?name=".$r['author'].">$r[author]</a></td>
				<td>$r[replies]</td>
				<td>$r[views]</td>
				<td class='last_timestamp'>$last_timestamp by</td><td class='last_author'><img class=userPicture width=16 height=16 src=".get_profile_pic($r["last_author"])."> </img><a href=user.php?name=".$r['last_author'].">$r[last_author]</a></div></td>
				</tr>";
			}
			?>
			</table>
			<div class='pagination'>		
				<?php
					if (isset($_GET['filter'])){
						/* Get query without 1-20 limit */
						$num_threads =  mysql_num_rows(mysql_query("SELECT * FROM threads WHERE title LIKE '%$_GET[filter]%' ORDER BY last_timestamp DESC"));
						$num_pages = ceil($num_threads / 20);
						
						echo "<b>".($index + 1)."-".($index + mysql_num_rows($sql))."</b> of <b>".$num_threads."</b>";
						if ($num_pages != 1){
							echo "<br>";
							echo "<a href=".$currentPage."?page=1&filter=".$_GET['filter'].">First</a> | ";
							if ($page == 1){
								echo "< Prev | ";
							}
							else{
								echo "<a href=".$currentPage."?page=".($page - 1)."&filter=".$_GET['filter'].">< Prev</a> | ";
							}
							if ($page == $num_pages){
								echo "Next > | ";
							}
							else{
								echo "<a href=".$currentPage."?page=".($page + 1)."&filter=".$_GET['filter'].">Next ></a> | ";
							}
							echo "<a href=".$currentPage."?page=".$num_pages."&filter=".$_GET['filter'].">Last</a>";
						}		
					}
					else {			
						/* Get query without 1-20 limit */
						$num_threads = mysql_num_rows(mysql_query("SELECT * FROM threads"));
						$num_pages = ceil($num_threads / 20);
						
						echo "<b>".($index + 1)."-".($index + mysql_num_rows($sql))."</b> of <b>".$num_threads."</b>";
						if ($num_pages != 1){
							echo "<br>";
							echo "<a href=".$currentPage."?page=1>First</a> | ";
							if ($page == 1){
								echo "< Prev | ";
							}
							else{
								echo "<a href=".$currentPage."?page=".($page - 1).">< Prev</a> | ";
							}
							if ($page == $num_pages){
								echo "Next > | ";
							}
							else{
								echo "<a href=".$currentPage."?page=".($page + 1).">Next ></a> | ";
							}
							echo "<a href=".$currentPage."?page=".$num_pages.">Last</a>";
						}	
					}
				?>
			</div>
		</div>
	</body>
</html>
