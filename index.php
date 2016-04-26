<?php
	include('radioredux.php');
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Radio Redux</title>

	<link rel="stylesheet" type="text/css" href="css/redux_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	
</head>

<body>

	<div id="top">
		<form id="loginForm" name="loginForm" action="include/login.php" method="post">
			<input type="email" id="email" name="email" placeholder="Email Address" />
			<input type="password" id="pass" name="pass" placeholder="Password" />
			<input type="submit" id="login" name="login" value="LOGIN" />
			<br><a href="account/register.html" target="_self">Don't have a Radio Redux account? <u>Sign Up</u>.</a>
		</form>
		
	</div>
	
	<div id="main">
		<img class="center" src="img/banner.png" alt="Radio Redux">
		
		<div id="musicContainer" class="center">
			<form id="yearForm" name="yearForm" method="get">
				<!-- Note: add in loop / db json link for years... also is dropdown the best way to do this? -->
				<select name="year">
					<option value="1991">1991</option>
					<option value="1992">1992</option>
					<option value="1993">1993</option>
					<option value="1994">1994</option>
					<option value="1995">1995</option>
				</select>
			</form>
			
			<?php
				if (isset($_GET['year'])) {
					error_reporting(E_ERROR);
					$yr = $_GET['year'];
					$toPlay = getSongsDB(intval($yr));
					embedit($yr,$toPlay);
				}
				else {
					//displayform();
				}
			?>
			
		</div>
		<div id="controls">
			<div class="controls_middle">
				<div class="prevbutton">
					<img src="img/btn_left.png" alt="Previous song button">
				</div>
				<div class="playbutton">
					<img src="img/btn_play.png" alt="Play button">
				</div>
				<div class="nextbutton">
					<img src="img/btn_right.png" alt="Next song button">
				</div>
			</div>
		</div>
		<div id="controlsBottom" class="center">
		</div>
	
	</div>
	
	<div id="bottom">
	
	</div>


</body>

<script>
	$(document).ready(function() {
	
		/* Error msg if user doesn't fill in username or password */
		$("#login").click(function() {
			$(".error").hide();
			var hasError = false;
			var userEmail = $("#email").val();
			var userPassword = $("#pass").val();
			
			if ( userEmail == "" || userPassword == "" ) {
				$("#top").after("<span class='error'>** Please fill out login form completely **</span>");
				hasError = true;
			}
			
			if (hasError == true) {return false};
		});
	
	});


</script>

</html>


















