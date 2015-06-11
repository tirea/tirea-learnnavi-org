<?php
	require('_login.php');
	system("/home/tirea/bin/runas");
	header("Location: http://".$_SERVER["HTTP_HOST"]."/posts");
?>

