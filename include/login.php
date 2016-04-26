<?php

	$db = 'delanetc';
	$mysqli = new mysqli('Localhost', 'delanetc', 'lo0per1293', $db);
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
	}
	
	$userEmail = $_POST['email'];
	$userPassword = $_POST['pass'];
	
	$validEmail = checkEmail($userEmail, $mysqli);
	
	if ($validEmail = TRUE) {
		$validPass = checkPass($userPassword, $userEmail, $mysqli);
		
		if ($validPass = TRUE) {
			$userq = "SELECT * FROM users WHERE email = '$userEmail'";
			$result = $mysqli->query($userq);
			
			if ($result->num_rows == 0) {
				die("Bad query $sql");
			}
			$user_data = array();
			while ($obj = mysqli_fetch_object($result)) {
				$user_data[] = $obj;
			}
			$jsonUser = json_encode($user_data);
			
			header('Location: http://cscilab.bc.edu/~delanetc/radioRedux/index.html');
		}
	}



	$mysqli->close();
	
	function checkEmail($userEmail, $mysqli) {
		$emailq = "SELECT email FROM users WHERE email = '$userEmail'";
		$result = $mysqli->query($emailq);
		
		if ($result->num_rows !== 1) {
			die("This email address does not exist in our user database");
		} else {
			return $emailCheck = TRUE;
		}
	}
	function checkPass($userPassword, $userEmail, $mysqli) {
		$passq = "SELECT password FROM users WHERE email = '$userEmail' AND password = SHA1('$userPassword')";
		$result = $mysqli->query($passq);
		
		if ($result->num_rows !== 1) {
			die("Incorrect password");
		} else {
			return $passwordCheck = TRUE;
		}
	}
?>