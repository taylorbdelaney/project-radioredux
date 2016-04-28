<?php
	include('dbconn.php');
	
	$dbc = connect_to_db();
	
	$action = "";
	
	if (isset($_POST['login'])) {
	
		$action = 'login';
		
		$userEmail = $_POST['email'];
		$userPassword = $_POST['pass'];
	
		$validEmail = checkEmail($userEmail, $dbc, $action);
	
		if ($validEmail = TRUE) {
			$validPass = checkPass($userPassword, $dbc, $userEmail);
		
			if ($validPass = TRUE) {
				$userq = "SELECT * FROM users WHERE email = '$userEmail'";
				$result = perform_query($dbc, $userq);
			
				if ($result->num_rows == 0) {
					die("Bad query $sql");
				}
				$user_data = array();
				while ($obj = mysqli_fetch_object($result)) {
					$user_data[] = $obj;
				}
				$jsonUser = json_encode($user_data);
			
				header('Location: ../index.php');
			}
		}
	}
	
	if (isset($_POST['submitReg'])) {
	
		$action = 'register';
		
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$emailReg = $_POST['emailReg'];
		$passReg = $_POST['passwordReg'];
		
		$newEmail = checkEmail($emailReg, $dbc, $action);
		if ($newEmail == TRUE) {
			$insert = "INSERT INTO users (registration_date, first_name, last_name, email, password) VALUES (NOW(), '$firstName', '$lastName', '$emailReg', SHA1('$passReg'))";
			
			if ($dbc->query($insert) === TRUE) {
				header('Location: ../index.php');
			} else {
				echo "Error: $insert <br>" . $mysqli->error;
			}
		}
	
	}

	disconnect_from_db( $dbc, $result );
	
	function checkEmail($userEmail, $dbc, $action) {
		$emailq = "SELECT email FROM users WHERE email = '$userEmail'";
		$result = perform_query($dbc, $emailq);
		
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
	function checkPass($userPassword, $dbc, $userEmail) {
		$passq = "SELECT password FROM users WHERE email = '$userEmail' AND password = SHA1('$userPassword')";
		$result = perform_query($dbc, $passq);
		
		if ($result->num_rows !== 1) {
			die("Incorrect password<br><a href='../index.php'>Return to homepage</a>");
		} else {
			return $passwordCheck = TRUE;
		}
	}
?>