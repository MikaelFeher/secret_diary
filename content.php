<?php
	session_start();
	if (!isset($_SESSION['loggedIn'])) {
		header('Location: index.php');
	}

	require 'db_connect.php';

	$content = mysqli_real_escape_string($link, $_POST['content']);

	$email = $_SESSION['email'];

	$query = "UPDATE `users` SET `content` = '".$content."' WHERE `email` = '".$email."'";
	$result = mysqli_query($link, $query);

	if(!$result) {
		die('something went wrong');
	}

?>
