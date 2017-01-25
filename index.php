<?php
	session_start();

	$link = mysqli_connect('localhost', 'root', 'Zoltan77', 'secret_diary');

	if (mysqli_connect_error()) {
		die('Connection failed!');
	}

	$email = mysqli_real_escape_string($link, $_POST['email']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$hash = password_hash($password, PASSWORD_DEFAULT);

	// Run registration code
	if (isset($_POST['regBtn'])) {

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

					$query = "INSERT INTO `users` (`email`, `password`) VALUES('".$email."', '".$hash."')";

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

		if (array_key_exists('email', $_POST) || array_key_exists('password', $_POST)) {

			if (empty($_POST['email'])) {

				$emailErr = "Email can't be empty";

			} else if (empty($_POST['password'])) {

				$pwErr = "Password can't be empty";

			} else {

				$query = "SELECT `*` FROM `users` WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) > 0) {

					while ($row = mysqli_fetch_array($result)) {
						$dbPassword = $row['password'];
					}

					if (password_verify($password, $dbPassword)) {

						if (isset($_POST['checkbox'])) {
							setcookie('loggedIn', '', time() + 60 * 60 * 24 * 365);
						}

						$_SESSION['email'] = $email;
						$_SESSION['loggedIn'] = true;
						header('Location: diary.php');

					} else {
						echo "That email doesn't exist or the password is incorrect!";
					}

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
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Secret Diary</title>

</head>
<body>
	<div class="container-fluid" id="mainPage">
		<div class="" id="mainContent">

			<h1>Secret Diary</h1>
			<p><strong>Store your thoughts permanently and securely.</strong></p>
			<div class="container col-sm-8 offset-sm-3" >

				<div class="alert alert-danger col-sm-10">
					<p><strong>There we</strong></p>
					<?php echo $message, $emailErr, $pwErr; ?>
				</div>
				<!-- Sign up form -->
				<form class="" id="registerForm" action="" method="post">
					<div class="form-group row">
						<div class="col-sm-10">
							<p>Interested? Sign up now.</p>
							<input type="email" class="form-control" name="email" value="<?php if(isset($_POST['regBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" value="" placeholder="Password">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
							<div class="form-check">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" name="checkbox"> Remember Me!
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
							<input type="submit" class="btn btn-primary" name="regBtn" value="Sign Up!">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-10">
							<a href="#" id="loginLink">Log In</a>
						</div>
					</div>

				</form>

				<!-- Log in form -->
				<form class="hidden" id="loginForm" action="" method="post">
					<p>Already have an account? Log in below.</p>
					<input type="email" name="email" value="<?php if(isset($_POST['logBtn'])){if(empty($password)){echo $email;}}?>" placeholder="Your email">
					<input type="password" name="password" value="" placeholder="Password">
					<input type="checkbox" name="checkbox">
					<input type="submit" name="logBtn" value="Log In!">
					<a href="#" id="registerLink">Register</a>
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
