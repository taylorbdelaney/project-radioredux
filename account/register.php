<?php
session_start();

include_once('../include/dbconn.php');

if (isset($_POST['submitReg'])) {
	
		$dbc = connect_to_db();
		
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$emailReg = $_POST['emailReg'];
		$passReg = $_POST['passwordReg'];
		
		$newEmail = checkEmail($emailReg, $dbc);
		if ($newEmail == TRUE) {
			$insert = "INSERT INTO users (registration_date, first_name, last_name, email, password) VALUES (NOW(), '$firstName', '$lastName', '$emailReg', SHA1('$passReg'))";
			
			if ($dbc->query($insert) === TRUE) {
				header('Location: ../index.php');
			} else {
				echo "Error: $insert <br>" . $dbc->error;
			}
		}
		
		disconnect_from_db( $dbc, $result );
	}
?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Radio Redux – Register for Account</title>
	
	<link rel="icon" type="image/png" href="../img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="../css/redux_style.css">
</head>

<body>

	<div id="top">
	
	</div>
	<div id="main">
		<a href="http://cscilab.bc.edu/~delanetc/radioRedux"><img class="center" src="../img/banner.png" alt="Radio Redux"></a>
		
		<div id="musicContainer" class="center">
			<form name="register" id="register" class="center" method="post">
				<input type="text" class="center" id="first_name" name="first_name" placeholder="First Name" />
				<input type="text" class="center" id="last_name" name="last_name" placeholder="Last Name" />
				<input type="email" class="center" id="emailReg" name="emailReg" placeholder="Email Address" required />
				<input type="password" class="center" id="passwordReg" name="passwordReg" placeholder="Password" required />
				
				<input type="submit" class="center" id="submitReg" name="submitReg" value="REGISTER" />
			
			</form>
		
		</div>
	</div>
	<div id="bottom">
	
	</div>

</body>


</html>
<?php

function checkEmail($userEmail, $dbc) {
		$emailq = "SELECT email FROM users WHERE email = '$userEmail'";
		$result = perform_query($dbc, $emailq);

		if ($result->num_rows !== 0) {
			die("This email address already exists in our database. <a href='../account/register.html'>Click here</a> to return to registration.");
		} else {
				return $emailCheck = TRUE;
		}
	}

?>