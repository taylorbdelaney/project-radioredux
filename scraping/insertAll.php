<?php // note that this is not a complete page.	
	$dbc = @mysqli_connect( "localhost", "russelzb", "RbpGD2MM", "russelzb") or
			die( "Connect failed: couldn't open bobc ". mysqli_connect_error() );

	//get variables variables
	$
	
	//dump data into db
	$query = "INSERT INTO radio_redux_test (insertion_date, entered_by, name, category, address, latitude, longitude, phone, url, stars, price_range, comment) VALUES (now(), \"$entered_by\", \"$name\",\"$category\",\"$address\",\"$latitude\",\"$longitude\", \"$phone\", \"$url\", \"$rating\", \"$price\", \"$comments\")";
	//$query = "INSERT INTO bestofbc (insertion_date, entered_by, name, category, url, stars, price_range, comment) VALUES (now(), \"$entered_by\", \"$name\",\"$category\", \"$url\", \"$rating\", \"$price", \"$comments\")";

	//$query = "INSERT INTO bestofbc (name) VALUES (\"whataboutthisname\")";
	//$query = "INSERT INTO bestofbc (price_range) VALUES (\"$price\")";
	$result = mysqli_query($dbc,$query);
	echo json_encode($result);
	mysqli_close($dbc);

	/*
	if ( mysqli_num_rows( $result ) == 0 ) {
		die("bad query $query");
	}
	$attraction_data = array();	// put the rows as objects in an array
	while ( $obj = mysqli_fetch_object( $result ) ) {
		$attraction_data[] = $obj;
	}
	echo json_encode($attraction_data);

	mysqli_close($dbc);

		$result = perform_query($dbc,$query);
		disconnect_from_db($dbc,$result);	

	$data = array();
	$errors = array();
	if(empty($_POST['name'])){
		$errors['name'] = "Name req.";
	}
	if(!empty($errors)){
		$data['success'] = false;
		$data['errors'] = $errors;
	}
	else{
		$data['success'] = true;
		$data['message'] = "success";
	}
	
	echo json_encode($data);
	/*
	
	$name = $_POST['name'];
	$city = $_POST['city'];
	$data_from_post = array('dataName' => $name, 'dataCity' => $city);*/
	//echo json_encode($data_from_post);
