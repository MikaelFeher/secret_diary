<?php
	session_start();
	require 'db_connect.php';
	setcookie('loggedIn', '', time() - 60*60*24);
	session_destroy();
	header('Location: index.php');
 ?>
