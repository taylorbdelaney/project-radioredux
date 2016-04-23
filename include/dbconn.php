<?php

function connect_to_db(){
	$dbc = @mysqli_connect( "localhost", "russelzb", "RbpGD2MM", 'russelzb' ) or
			die( "Connect failed: ". mysqli_connect_error() );
	return $dbc;
}

function disconnect_from_db( $dbc, $result ){
	mysqli_free_result( $result );
	mysqli_close( $dbc );
}

function disconnect_from_db_simple($dbc) {
	mysqli_close($dbc);
}

function perform_query( $dbc, $query ){
	
	//echo "My query is >$query< <br />";
	$result = mysqli_query($dbc, $query) or 
			die( "bad query".mysqli_error( $dbc ) );
	return $result;
}