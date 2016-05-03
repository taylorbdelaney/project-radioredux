	<?php //pull preferences data from db		
		$dbc = @mysqli_connect( "localhost", "russelzb", "RbpGD2MM", "russelzb") or
			die( "Connect failed: couldn't open preferences ". mysqli_connect_error() );

		$query = "select user_id, song_year from preferences";
		$result = mysqli_query($dbc,$query);
		if ( mysqli_num_rows( $result ) == 0 ) {
			die("bad query $query");
		}
		
		$favorites_data = array(); // put the rows as objects in an array
		while ( $obj = mysqli_fetch_object( $result ) ) {
			$favorites_data[] = $obj;
		}
		
		echo json_encode($favorites_data);
		mysqli_close($dbc);
	