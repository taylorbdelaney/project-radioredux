<?php
	include('include/dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Radio Redux</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<?php
	if (isset($_GET['year'])) {
		error_reporting(E_ERROR);
		$yr = $_GET['year'];
		$toPlay = getSongs(intval($yr));
		embedit($yr,$toPlay);
	}
	else {
		displayform();
	}
?>
</body>
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
		
		echo '<iframe src="'.$src.'" frameborder="0" allowtransparency="true"></iframe>';
	}
	
	// call example: getSongs(2010);
	// returns array of song ID's
	function getSongs($year) {
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
	
	function displayform() {
		echo '<form method="get">Year: <input type="text" name="year"/><br><input type="submit" value="SUBMIT"/>';
	}