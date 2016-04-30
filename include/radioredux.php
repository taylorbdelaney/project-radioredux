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
			if ($row['trackID2'] != '') {
				$out[] = $row['trackID2'];
			}
		}
		disconnect_from_db_simple($dbc);
		
		shuffle($out);
		return $out;
	}
	
	// call example: getAllDB(2010);
	// returns array of db entries
	function getAllDB($year) {
		$dbc = connect_to_db();
		$query = 'select * from radio_redux_test where year = '.$year;
		$res = perform_query($dbc, $query);
		$out = array();
		while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
			$out[] = $row;
		}
		disconnect_from_db_simple($dbc);
		
		shuffle($out);
		return $out;
	}
	
	// calling getSongsFromRes(getAllDB(2010)) is equivalent to calling getSongsDB(2010)
	function getSongsFromRes($dbarray) {
		$out = array();
		foreach ($dbarray as $row) {
			if ($row['trackID2'] != '') {
				$out[] = $row['trackID2'];
			}
		}
		return $out;
	}
	
	
	function displayform() {
		echo '<form method="get">Year: <input type="text" name="year"/><br><input type="submit" value="SUBMIT"/>';
	}
	
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
	
	function showPlaylist($lst) {
		echo "<br><br><div class=\"tableholder\" id=\"tbh\"><table id=\"tb\"><tr><th>Title</th><th>Artist</th><th>Rank</th></tr>";
		foreach ($lst as $val) {
			echo "<tr><td>".$val['title']."</td><td>".$val['artist']."</td><td class=\"ranking\">".$val['rank']."</td></tr>";
		}
		echo "</table></div><br><br>";
	}
	
	
	function updateDBwithTrackIDs2() {
		$dbc = connect_to_db();
		//foreach (range(1960, 2015) as $year) {
		foreach (range(2001, 2015) as $year) {
			$query = 'select title from radio_redux_test where year = '.$year;
			$res = perform_query($dbc, $query);
			while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
				$id = getTrackID(getTrackURL2($row['title'], $row['artist']));
				$query = "update radio_redux_test set trackID2 = '".$id."' where title = \"".$row['title']."\" and year = ".$year;
				perform_query($dbc, $query);
			}
		}
		disconnect_from_db_simple($dbc);
		echo "done up to ".$year;
	}


	// returns the spotify track url
	function getTrackURL2($trackname, $artist) {
		$trackname = urlencode($trackname);
		$ch = curl_init();

		// set url 
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=".$trackname."%20".$artist."&type=track");
		
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