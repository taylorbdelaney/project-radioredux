<?php
session_start();
include("include/dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Admin Page</title>
	<link rel="icon" type="image/png" href="img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="css/redux_style.css">
</head>
<body>
<div id="top">
</div>
<div id="main">
<a href="http://cscilab.bc.edu/~delanetc/radioRedux"><img class="center" src="img/banner.png" alt="Radio Redux"></a>
<div id="tablecontent">
<?php
	showTable();
	if (isset($_POST['sendem'])) {
		sendemail();
	}
?>
<br>
<a id="gohomeb" href="index.php"><button type="button" id="hbut">Home</button></a>
<button type="button" id="emsend">Send Email</button>
<form id="emform" method="post">
	<input id="hinput" type="hidden" name="sendem"/>
</form>
</div>
<br>
</div>
<div id="bottom"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="scripts/adminpage.js"></script>
</body>
</html>
<?php
	function showTable() {
		$dbc = connect_to_db();
		$query = "select * from users";
		$result = perform_query($dbc, $query);
		
		echo "<table id=\"admntable\"><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Favorites</th><th>Reg. Date</th></tr>";
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		while ($row != null) {
			$id = $row['id'];
			$fname = $row['first_name'];
			$lname = $row['last_name'];
			$email = $row['email'];
			$regdate = $row['registration_date'];
			
			$queryp = "select song_year from preferences where user_id = ".$id;
			$resultp = perform_query($dbc, $queryp);
			$rowp = mysqli_fetch_array($resultp, MYSQLI_ASSOC);
			$pyrs = "";
			while ($rowp != null) {
				$pyrs .= ($rowp['song_year'] . ", ");
				$rowp = mysqli_fetch_array($resultp, MYSQLI_ASSOC);
			}
			
			if (strlen($pyrs > 0)) {
				$pyrs = substr($pyrs,0,strlen($pyrs)-2);
			}
			echo "<tr><td>$id</td><td>$fname</td><td>$lname</td><td>$email</td><td>$pyrs</td><td>$regdate</td></tr>";
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		echo "</table>";
	}
	
	function sendemail() {
		$dbc = connect_to_db();
		$query = "select distinct user_id from preferences";
		$result = perform_query($dbc, $query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		while ($row != null) {
			$usr = $row['user_id'];
			$query2 = "select u.first_name as fn, u.email as em, p.song_year as song_year from preferences as p, users as u where p.user_id = ".$usr." and u.id = ".$usr." order by rand() limit 1";
			$res2 = perform_query($dbc, $query2);
			$row2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);
			$yr = $row2['song_year'];
			$fname = $row2['fn'];
			$eml = $row2['em'];

			$mess = "<style type=\"text/css\">div {background-color:#FEDD6C; border: 50px solid #544741; font-family:\"Trebuchet MS\", Helvetica, sans-serif; font-size: 20px;} p {padding: 20px;}</style><div id=\"outer\"><div><p><br>Hi ".$fname.",<br><br>\r\nThis is RadioRedux reminding you how much you miss listening to the radio in ".$yr.".<br><br><a href=\"http://cscilab.bc.edu/~delanetc/radioRedux/index.php?year=".$yr."\">Click here</a> to relive ".$yr.".<br><br></p></div>";
			$headers = "From: communications@radioredux.com" . "\r\n" . "Reply-To: secorj@bc.edu" . "\r\n" . "Content-Type: text/html" . "\r\n";
			mail($eml, "Your RadioReux Year", $mess, $headers);
			
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		echo "<span id=\"donemessage\">Emails sent to users!</span>";
	}