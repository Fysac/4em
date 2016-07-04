<?php
require_once("config.php");

mysql_connect($DATABASE_HOST, $DATABASE_ADMIN, $DATABASE_PASSWORD);
mysql_select_db($DATABASE);
?>
