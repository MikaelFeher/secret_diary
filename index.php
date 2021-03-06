<?php
	session_start();

	require 'db_connect.php';

	$errors = $message = '';

	if(array_key_exists('logout', $_GET)) {
		session_destroy();
		setcookie('id', '', time() - 60*60);
		$_COOKIE['id'] = '';

	} else if (array_key_exists('id', $_SESSION) || array_key_exists('id', $_COOKIE)){
		header('Location: diary.php');
	}

	unset($_GET['logout']);

	if($_POST){
		$email = mysqli_real_escape_string($link, $_POST['email']);
		$password = mysqli_real_escape_string($link, $_POST['password']);
		$hash = password_hash($password, PASSWORD_DEFAULT);

		// Registration code
		if (isset($_POST['regBtn'])) {

			if (empty($_POST['email'])) {

				$errors .= "Email can't be empty";

			} else if (empty($_POST['password'])) {

				$errors .= "Password can't be empty<br>";

			} else {

				$query = "SELECT `id` FROM `users` WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) > 0) {

					$errors .= 'That email already exists<br>';

				} else {

					$query = "INSERT INTO `users` (`email`, `password`) VALUES('".$email."', '".$hash."')";

					if (mysqli_query($link, $query)) {

						$_SESSION['id'] = mysqli_insert_id($link);


						if ($_POST['checkbox'] = 1) {
							setcookie('id', mysqli_insert_id($link), time() + 60 * 60 * 24 * 365);
						}

						header('Location: diary.php');

					} else {

						$errors .= 'Oops, something went wrong! Try again...<br>'.$link->error;
					}
				}
			}

		// Login code
		} else if (isset($_POST['logBtn'])) {

			if (empty($_POST['email'])) {

				$errors .= "Email can't be empty<br>";

			} else if (empty($_POST['password'])) {

				$errors .= "Password can't be empty<br>";

			} else {

				$query = "SELECT * FROM `users` WHERE email = '$email'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) > 0) {

					while ($row = mysqli_fetch_array($result)) {
						$dbPassword = $row['password'];
						$id = $row['id'];
					}

					if (!password_verify($password, $dbPassword)) {
						die("That email doesn't exist or the password is incorrect!");
					}

					$_SESSION['email'] = $email;

					if ($_POST['checkbox'] = 2) {
						setcookie('id', mysqli_insert_id($link), time() + 60 * 60 * 24 * 365);
					}

					header('Location: diary.php');


					// } else {
					// 	$errors .= "That email doesn't exist or the password is incorrect!<br>";

				} else {
					$errors .= "That email doesn't exist or the password is incorrect!<br>";
				}
			}
		}
		if (!empty($errors)) {
			$message = '<div class="row"><div class="alert alert-danger col-sm-8 offset-sm-2"><strong>There were error(s) in your form:</strong><br>'.$errors.'</div></div>';
		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Secret Diary</title>

</head>
<body>
	<div class="container-fluid" id="mainPage">
		<div class="" >
			<div class="container col-sm-10 offset-sm-1 col-lg-4 offset-lg-4" id="mainContent">
				<div class="row">
					<div class="col-sm-10 offset-sm-1">
						<h1>Secret Diary</h1>
						<p><strong>Store your thoughts permanently and securely.</strong></p>
					</div>
				</div>
					<?php if ($message) {echo $message;} ?>

				<!-- Sign up form -->
				<form class="" id="registerForm" action="" method="post">
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<p>Interested? Sign up now.</p>
							<input type="email" class="form-control" name="email" value="<?php if(isset($_POST['regBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<input type="password" class="form-control" name="password" value="" placeholder="Password">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<div class="form-check">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" name="checkbox" value=1> Remember Me!
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<input type="submit" class="btn btn-primary" name="regBtn" value="Sign Up!">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<a href="#" id="loginLink">Log In</a> <span>//</span>
							<a href="mailto:mikael.feher@gmail.com?Subject=Secret%20Diary" target="_top">Feedback</a>
						</div>
					</div>
				</form>

				<!-- Log in form -->
				<form class="hidden" id="loginForm" action="" method="post">
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<p>Already have an account? Log in below.</p>
							<input class="form-control" type="email" name="email" value="<?php if(isset($_POST['logBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<input class="form-control" type="password" name="password" value="" placeholder="Password">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<div class="form-check">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" name="checkbox" value=2> Remember Me!
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<input class="btn btn-primary" type="submit" name="logBtn" value="Log In!">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10 offset-sm-1">
							<a href="#" id="registerLink">Register</a> <span>//</span> <a href="mailto:mikael.feher@gmail.com?Subject=Secret%20Diary" target="_top">Feedback</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- Bootstrap and jQuery -->
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('form a').click(function () {
				$('#loginForm').toggleClass('hidden');
				$('#registerForm').toggleClass('hidden');

				return false;
			})
		});

	</script>

</body>
</html>
