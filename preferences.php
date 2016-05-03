<?php
$dbc = @mysqli_connect( "localhost", "russelzb", "RbpGD2MM", "russelzb") or
			die( "Connect failed: couldn't open bobc ". mysqli_connect_error() );

	$year = $_POST["year"];
	$id   = $_POST["id"];

	$query = "INSERT INTO preferences (user_id, song_year) VALUES (\"$id\",\"$year\")";
	
	$result = mysqli_query($dbc,$query);
	echo json_encode($result);
	mysqli_close($dbc);