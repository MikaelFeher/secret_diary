<?php
	session_start();

	require 'db_connect.php';

	if(array_key_exists('id', $_COOKIE)) {
		$_SESSION['id'] = $_COOKIE['id'];
	}

	if (!array_key_exists('id', $_SESSION)) {
		header('Location: index.php');
	}

	$email = $_SESSION['email'];

	$query = mysqli_query($link, "SELECT * FROM `users` WHERE email = '$email'");

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

		<a href="index.php?logout=1" id="logoutBtn" class="btn btn-outline-success">Log Out</a>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-outline-warning btn-md" data-toggle="modal" data-target="#exampleModal" id="instructions">
			Instructions
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><strong>Instructions</strong></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>This is your personal diary/journal - It's all saved as you type and will be available for you at any time.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Got it!</button>
					</div>
				</div>
			</div>
		</div>

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
			$('#myModal').modal(options)
		});
	</script>
</body>
</html>
