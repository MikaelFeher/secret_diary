<?php
	session_start();
	if (!isset($_SESSION['loggedIn'])) {
		header('Location: index.php');
	}

	require 'db_connect.php';

	$email = $_SESSION['email'];

	$query = mysqli_query($link, "SELECT content FROM `users` WHERE email = '$email'");

	while ($row = mysqli_fetch_array($query)) {
			$content = $row['content'];
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
	<div id="header">
		<div id="logo">
			<h1>Secret Diary</h1>
		</div>
		<a href="logout.php" id="logoutBtn" class="btn btn-outline-success">Log Out</a>
	</div>

	<!-- Diary -->
	<div class="container-fluid" id="mainArea">
		<textarea class="col-xs-12" id="contentField" name="content"><?php echo $content; ?></textarea>
	</div>


	<!-- Bootstrap and jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('textarea').on('change keyup paste', function(event) {
				event.preventDefault();
				var textInput = $(this).serialize();

				$.ajax({
					type: "POST",
					url: "content.php",
					data: textInput,
					success: function(status){
						console.log('The Response: ' + status);
					}
				});
			});
		});
	</script>
</body>
</html>
