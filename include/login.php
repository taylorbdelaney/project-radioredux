<?php
	session_start();
	
	include('dbconn.php');
	
	$dbc = connect_to_db();
	
	if (isset($_POST['login'])) {
		
		$userEmail = $_POST['email'];
		$userPassword = $_POST['pass'];
	
		$validEmail = checkEmail($userEmail, $dbc);
	
		if ($validEmail = TRUE) {
			$validPass = checkPass($userPassword, $dbc, $userEmail);
		
			if ($validPass = TRUE) {
				$userq = "SELECT * FROM users WHERE email = '$userEmail'";
				$result = perform_query($dbc, $userq);
			
				if ($result->num_rows == 0) {
					die("Bad query $sql");
				}
				$user_data = array();
				while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
					$user_data[] = $row['id'];
				}
				
				$_SESSION['user'] = $user_data[0];
			
				header('Location: ../index.php');
			}
		}
	}

	disconnect_from_db( $dbc, $result );
	
	function checkEmail($userEmail, $dbc) {
		$emailq = "SELECT email FROM users WHERE email = '$userEmail'";
		$result = perform_query($dbc, $emailq);
		
		if ($result->num_rows !== 1) {
			die("This email address does not exist in our user database");
		} else {
			return $emailCheck = TRUE;
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