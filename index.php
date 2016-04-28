<?php
	include('include/dbconn.php');
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Radio Redux</title>

	<link rel="stylesheet" type="text/css" href="css/redux_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src='scripts/radioredux.js'></script>
	
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
				
				<input type="submit" name="submitYear" value="SUBMIT" />
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
<?php
	// returns the spotify track url
	function getTrackURL($trackname) {
		$trackname = urlencode($trackname);
		$ch = curl_init();

		// set url 
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=".$trackname."&type=track");
		
		//return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		// $output contains the output string 
		$output = curl_exec($ch);

		// close curl resource to free up system resources 
		curl_close($ch);
		
		$data = json_decode($output);
		
		$trackURL = $data -> tracks -> items[0] -> href;
		$url = preg_match('"https://api.spotify.com/v1/tracks/[A-Za-z0-9]+"', $trackURL, $matches);
		
		return $matches[0];
	}
	
	// getTrackID gets track ID from url (like output from getTrackURL)
	function getTrackID($url) {
		$term = "tracks/";
		$startDex = strpos($url, $term);
		return substr($url, $startDex + strlen($term));
	}
	
	// embedit takes a year (for playlist name) and an array of track ID's
	// echos onto the page
	function embedit($year, $tidarr) {
		$src = "https://embed.spotify.com/?uri=spotify:trackset:".$year.":";
		foreach ($tidarr as $thisone) {
			$src .= ($thisone.",");
		}
		
		echo '<iframe id="player" width="640" height="720" src="'.$src.'&view=coverart" frameborder="0" allowtransparency="true"></iframe>';
	}
	
	// call example: getSongsAPI(2010);
	// returns array of song ID's
	// NOTE: this version gets the ID's from the Spotify API
	function getSongsAPI($year) {
		$dbc = connect_to_db();
		$query = 'select title from radio_redux_test where year = '.$year;
		$res = perform_query($dbc, $query);
		$out = array();
		while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
			$out[] = getTrackID(getTrackURL($row['title']));
		}
		disconnect_from_db_simple($dbc);
		
		shuffle($out);
		return $out;
	}
	
	
	// call example: getSongsDB(2010);
	// returns array of song ID's
	// NOTE: this version gets the ID's from the database
	function getSongsDB($year) {
		$dbc = connect_to_db();
		$query = 'select trackID from radio_redux_test where year = '.$year;
		$res = perform_query($dbc, $query);
		$out = array();
		while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
			if ($row['trackID'] != '') {
				$out[] = $row['trackID'];
			}
		}
		disconnect_from_db_simple($dbc);
		
		shuffle($out);
		return $out;
	}
	
	
	function displayform() {
		echo '<form method="get">Year: <input type="text" name="year"/><br><input type="submit" value="SUBMIT"/>';
	}
	
	// DON'T TOUCH THIS
	function updateDBwithTrackIDs() {
		$dbc = connect_to_db();
		foreach (range(1960, 2015) as $year) {
			$query = 'select title from radio_redux_test where year = '.$year;
			$res = perform_query($dbc, $query);
			while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
				$id = getTrackID(getTrackURL($row['title']));
				$query = "update radio_redux_test set trackID = '".$id."' where title = \"".$row['title']."\" and year = ".$year;
				perform_query($dbc, $query);
			}
		}
		disconnect_from_db_simple($dbc);
	}


















