<?php
	session_start();
	if (!isset($_SESSION['loggedIn'])) {
		header('Location: index.php');
	}
	print_r($_SESSION);
	echo $_COOKIE['loggedIn'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Secret Diary</title>
</head>
<body>
	<a href="logout.php">Log Out</a>
	<h1>You are logged in!</h1>

	<!-- Setup diary -->





</body>
</html>
