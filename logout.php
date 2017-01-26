<?php
	session_start();
	if (!isset($_SESSION['loggedIn'])) {
		header('Location: index.php');
	}
	setcookie('loggedIn', '', time() - 60*60*24);
	session_destroy();
	header('Location: index.php');
 ?>
