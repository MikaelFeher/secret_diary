<?php
	session_start();

	$link = mysqli_connect('localhost', 'root', 'Zoltan77', 'secret_diary');

	if (mysqli_connect_error()) {
		die('Connection failed!');
	}

	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);

	// Run registration code
	if (isset($_POST['regBtn'])) {
		echo "Registration";

		if (array_key_exists('email', $_POST) || array_key_exists('password', $_POST)) {

			if (empty($_POST['email'])) {

				$emailErr = "Email can't be empty";

			} else if (empty($_POST['password'])) {

				$pwErr = "Password can't be empty";

			} else {

				$query = "SELECT `id` FROM `users` WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) > 0) {

					$emailErr = 'That email already exists';

				} else {

					$query = "INSERT INTO `users` (`email`, `password`) VALUES('".$email."', '".$password."')";

					if (mysqli_query($link, $query)) {
						$message = 'Signed up successfully!';
						if (isset($_POST['checkbox'])) {
							setcookie('loggedIn', '', time() + 60 * 60 * 24 * 365);
						}
						$_SESSION['email'] = $email;
						$_SESSION['loggedIn'] = true;
						header('Location: diary.php');


					} else {

						$message = 'Oops, something went wrong! Try again...<br>'.$link->error;

					}
				}
			}

		}
	} else if (isset($_POST['logBtn'])) {
		echo "Log in";

		if (array_key_exists('email', $_POST) || array_key_exists('password', $_POST)) {


			if (empty($_POST['email'])) {

				$emailErr = "Email can't be empty";

			} else if (empty($_POST['password'])) {

				$pwErr = "Password can't be empty";

			} else {

				$query = "SELECT `id` FROM `users` WHERE email = '".$email."' AND password = '".$password."'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) > 0) {

					if (isset($_POST['checkbox'])) {
						setcookie('loggedIn', '', time() + 60 * 60 * 24 * 365);

					}
					$_SESSION['email'] = $email;
					$_SESSION['loggedIn'] = true;
					header('Location: diary.php');

					// print_r $result;

				} else {
					echo "That email doesn't exist or the password is incorrect!";
				}

			}

		}

	}

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
	<div class="">
		<?php echo $message, $emailErr, $pwErr; ?>
	</div>
	<!-- Sign up form -->
	<form class="" action="" method="post">
		<input type="email" name="email" value="<?php if(isset($_POST['regBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
		<input type="password" name="password" value="" placeholder="Password">
		<input type="checkbox" name="checkbox">
		<input type="submit" name="regBtn" value="Sign Up!">
	</form>
	
	<!-- Log in form -->
	<form class="" action="" method="post">
		<input type="email" name="email" value="<?php if(isset($_POST['logBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
		<input type="password" name="password" value="" placeholder="Password">
		<input type="checkbox" name="checkbox">
		<input type="submit" name="logBtn" value="Log In!">
	</form>


	<!-- Setup Bootstrap -->
	<!-- Setup jQuery -->
	
</body>
</html>
