<?php
include('dbconn.php');
$out = array();
if (isset($_GET['year'])) {
	$year = $_GET['year'];
	$dbc = connect_to_db();
	$query = 'select * from radio_redux_test where year = '.$year;
	$res = perform_query($dbc, $query);
	while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		array_push($out, $row);
	}
}
echo json_encode($out);