<?php

	$db = 'delanetc';
	$mysqli = new mysqli('Localhost', 'delanetc', 'lo0per1293', $db);
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
	}
	
	$action = "";
	
	if (isset($_POST['login'])) {
	
		$action = 'login';
		
		$userEmail = $_POST['email'];
		$userPassword = $_POST['pass'];
	
		$validEmail = checkEmail($userEmail, $mysqli, $action);
	
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
	}
	
	if (isset($_POST['submitReg'])) {
	
		$action = 'register';
		
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$emailReg = $_POST['emailReg'];
		$passReg = $_POST['passwordReg'];
		
		$newEmail = checkEmail($emailReg, $mysqli, $action);
		if ($newEmail == TRUE) {
			$insert = "INSERT INTO users (registration_date, first_name, last_name, email, password) VALUES (NOW(), '$firstName', '$lastName', '$emailReg', SHA1('$passReg'))";
			
			if ($mysqli->query($insert) === TRUE) {
				header('Location: ../index.html');
			} else {
				echo "Error: $insert <br>" . $mysqli->error;
			}
		}
	
	}



	$mysqli->close();
	
	function checkEmail($userEmail, $mysqli, $action) {
		$emailq = "SELECT email FROM users WHERE email = '$userEmail'";
		$result = $mysqli->query($emailq);
		
		if ($action == 'login') {
			if ($result->num_rows !== 1) {
				die("This email address does not exist in our user database");
			} else {
				return $emailCheck = TRUE;
			}
		} else if ($action == 'register') {
			if ($result->num_rows !== 0) {
				die("This email address already exists in our database. <a href='../account/register.html'>Click here</a> to return to registration.");
			} else {
				return $emailCheck = TRUE;
			}
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