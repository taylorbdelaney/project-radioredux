<?php
session_start();
include('include/dbconn.php');
include('include/radioredux.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Radio Redux – Homepage</title>
	
	<link rel="icon" type="image/png" href="img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="css/redux_style.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>

<body>
	<div id="top">
		<?php
			if(isset($_SESSION['user']) == "") {
				echo "<div id='showLogin'>";
				showLogin();
				echo "</div>";
			} else if (isset($_SESSION['user'])!== "") {
				echo "<div id='showUser'>";
				userInfo();
				echo "</div>";
				//this bit may be unnecessary
				$id = $_SESSION["user"]["id"];
				echo "<p id='userid2' style='visibility: hidden'> $id </p>";
			}
		?>
	</div>
	<div id="main">
		<a href="http://cscilab.bc.edu/~delanetc/radioRedux"><img class="center" src="img/banner.png" alt="Radio Redux"></a>
		
		<div id="musicContainer" class="center">
			<div id="statement">
				<span id="state1">Have you ever thought,</span>
				<span id="state2">"Gee, I'd love to listen to the radio like it were 2003?"</span>
				<span id="state3"><b>No? Good.</b><br>because 2004 is when the real magic happens.</span>
			</div>
		</div>
		<div id="controls">
			<div id="problem">
				<span class="prob1">THE PROBLEM:</span>
				<span>Many humans on this earth are dissatisfied with their present state of living and enjoy reminiscing
				about their younger years, when everything was simpler, easier, happier, better.<br><br>We utilize social media
				for visual nostalgia triggers, and we've even set aside a day of the week for "throwbacks," yet our <span class="prob1"> SONIC
				NOSTALGIA</span> lacks a customizable and centralized source wherein we can escape the hell of the present
				and keep on living in the past.</span>
			</div>
	</div>
		<div id="controlsBottom" class="center">
			<div id="solution">
				<span class="sol1">THE SOLUTION:</span>
				<span>Go ahead, pick a year.</span>
				<form id="yearForm" name="yearForm" method="get">

					<select name="year" id="yrselect">
						<?php
							echo "<option value=\"na\">Year</option>";
							//$favorites_array = getFavorites();
							//echo "<option value=\"\">Favorites</option>";
							$randyear = rand(1960, 2015);
							echo "<option value=\"$randyear\">Random</option>";
							foreach (range(2015, 1960) as $thisyear) {
								$pickit = ($_GET['year']==$thisyear) ? "selected" : "";
								echo "<option value=\"$thisyear\" $pickit>$thisyear</option>";
							}
						?>
					</select>
				</form>
			</div>
		</div>
	<div id="bottom">
	</div>

</body>

<script>
	$(document).ready(function() {
		$("#loadPreferences").click(function() {
			//fill favorites array
			//alert("loading preferences...");
			var current_user = parseInt($('#userid2').text());				//gets current user of session
			$('#yrselect').empty(); 								//empty current select to fill with pref's.
			//alert("current user: " + current_user);
			//alert("select empty?");
			$.getJSON("selectFavorites.php", function (data) {  //for each song_year in pref db table...
				$.each(data, function (i, attr) {
					var user_id = attr.user_id;
					var song_year = attr.song_year;
					if(user_id == current_user){
						//make new option with user_id and song_year
						var option = $('<option></option>').attr("value", song_year).text(song_year);
						$('#yrselect').append(option);
					}
					//append to table unused user_id's and years for testing purposes
					/*else{
						$("#fav_table").append("<tr><td>" + user_id + 
							"</td><td>" + song_year +
							"</td></tr>");	
					}*/

					

				});
			}).done(function(data){ 
				//alert("loading favorites finished");
			});
		});

		// Error msg if user doesn't fill in username or password
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
		
		//Redirect
		$("#yrselect").change(function() {
			if ($("#yrselect").val() != "na") {
				var year = $("#yrselect").val();
				var url = "http://cscilab.bc.edu/~delanetc/radioRedux/landing.php?year=" + year;
				$(location).attr('href', url);
			}
		});

		//insert user_id and year into user's preferences
		$("#preferences").click(function() {
			var showLogin = document.getElementById("showLogin");
			if(showLogin){ // if loginForm exists, we are not logged in. Therefore show error
				alert("You must log in before modifying your preferences");
			}
			else{
				console.log("You are successfully logged in");
				//get year
				var yearElement = document.getElementById("yrselect");
				var yearStr 	= yearElement.options[yearElement.selectedIndex].text;
				var id = document.getElementById("userid1");
				var idStr = id.innerHTML;
				var formData = {
					'year' : yearStr,
					'id'   : idStr
				};
				$.ajax({
						type 	: 'POST',
						url		: 'preferences.php',
						data	: formData,
						dataType: 'json',
								encode :true
					}).done(function(data){ //cleanup form (by hiding?)
								//alert("all done");
							});
					event.preventDefault();
			}
		});
			
	});


</script>

</html>
<?php

	// returns logged in user information
	function showLogin() {
		
		echo "<form id='loginForm' name='loginForm' action='include/login.php' method='post'>";
		echo "<input type='email' id='email' name='email' placeholder='Email Address' />";
		echo "<input type='password' id='pass' name='pass' placeholder='Password' />";
		echo "<input type='submit' id='login' name='login' value='LOGIN' />";
		echo "<br>Don't have a Radio Redux account? <a href='account/register.php' target='_self'><u>Sign Up</u>.</a>";
		echo "</form>";
	}
	
	function userInfo() {
		
		$id = $_SESSION['user']['id'];
		$firstName = $_SESSION['user']['first_name'];
		$lastName = $_SESSION['user']['last_name'];
		$fullName = $firstName . " " . $lastName;
		
		echo "<span>" . $fullName . "</span>";
		echo "<form name='logoutUser' id='logoutUser' action='account/logout.php' method='get'>";
		echo "<input type='submit' name='logout' value='Logout' />";
		echo "</form>";
		
		// for admins
		if (in_array($id, array(4,7,11))) {
			echo "<a href=\"admin.php\"><button id=\"admnp\" type=\"button\">Admin Page</button></a>";
		}
		
		//for preferences insertion later on
		echo "<p id='userid1' style='visibility: hidden'> $id </p>";
	}
	
?>