<?php
	session_start();
	setcookie('loggedIn', '', time() - 60*60*24);
	session_destroy();
	header('Location: index.php');
 ?>