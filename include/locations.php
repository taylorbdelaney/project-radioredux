<?php
ini_set('max_execution_time', 0);
include('dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Radio Redux LocScraping</title>
	<link rel="icon" type="image/png" href="../img/favicon.png"/>
</head>
<body>
<?php
	//getall();
	echo "Uncomment the function call to run it";
?>
</body>
</html>
<?php

function getall() {
	$dbc = connect_to_db();
	$query = 'select distinct artist from radio_redux_test;';
	
	$cities = array('Aarhus', 'Aberdeen', 'Adelaide', 'Ajax', 'Akron', 'Albany', 'Albuquerque', 'Alexandria', 'Amsterdam', 'Anaheim', 'Ankara', 'Ann-Arbor', 'Annapolis', 'Asheville', 'Athens', 'Atlanta', 'Austin', 'Australia', 'Bakersfield', 'Baltimore', 'Bangkok', 'Bangor', 'Barcelona', 'Basildon', 'Baton-Rouge', 'Beirut', 'Belfast', 'Belgium', 'Belgrade', 'Bellingham', 'Bergen', 'Berkeley', 'Berlin', 'Birmingham', 'Blackpool', 'Bloomington', 'Boston', 'Boulder', 'Bournemouth', 'Bradford', 'Brampton', 'Bratislava', 'Brighton', 'Brisbane', 'Bristol', 'Brixton', 'Brooklyn', 'Brussels', 'Bucharest', 'Budapest', 'Buffalo', 'Burlington', 'Burlington-Ontario', 'Cairo', 'Calgary', 'California', 'Cambridge', 'Canada', 'Canberra', 'Cape-Town', 'Caracas', 'Cardiff', 'Champaign', 'Chapel-Hill', 'Charlotte', 'Charlottesville', 'Chattanooga', 'Chelmsford', 'Chester', 'Chicago', 'Christchurch', 'Cincinnati', 'City-of-Halifax', 'Claremont', 'Cleveland', 'Colchester', 'Cologne', 'Columbus', 'Compton', 'Copenhagen', 'Cork', 'Cornwall', 'Corpus-Christi', 'Coventry', 'Croydon', 'Dallas', 'Dayton', 'Denton', 'Denver', 'Derby', 'Derry', 'Des-Moines', 'Detroit', 'Dublin', 'Dundee', 'Dunedin', 'Edinburgh', 'Edmonton', 'El-Paso', 'England', 'Espoo', 'Essex', 'Estonia', 'Eugene', 'Fayetteville', 'Finland', 'Fort-Lauderdale', 'Fort-Wayne', 'Fort-Worth', 'France', 'Frankfurt', 'Fresno', 'Fukuoka', 'Gainesville', 'Geneva', 'Germany', 'Ghent', 'Glasgow', 'Gold-Coast', 'Gothenburg', 'Granada', 'Grand-Rapids', 'Greece', 'Greensboro', 'Greenwich-Village', 'Guadalajara', 'Guelph-Ontario', 'Halmstad', 'Hamburg', 'Hamilton', 'Hanover', 'Harlem', 'Havana', 'Helsingborg', 'Helsinki', 'Hermosa-Beach', 'Hertfordshire', 'Hobart', 'Hokkaido', 'Hollywood', 'Houston', 'Huntington-Beach', 'Indianapolis', 'Ipswich', 'Istanbul', 'Italy', 'Jacksonville', 'Jamaica', 'Japan', 'Jersey-City', 'Johannesburg-Gauteng', 'Kansas-City', 'Karachi', 'Kelowna', 'Kent', 'Kharkiv', 'Kiev', 'Kingston', 'Kingston-Upon-Hull', 'Kitchener', 'Knoxville', 'Kolkata', 'Kristiansand', 'Kuala-Lumpur', 'Kuopio', 'Kyoto', 'Lahore', 'Las-Vegas', 'Leeds', 'Leicester', 'Lincoln', 'Lisbon', 'Little-Rock', 'Liverpool', 'Lodi', 'London', 'Long-Beach', 'Long-Island', 'Los-Angeles', 'Louisville', 'Lubbock', 'Naples', 'Nashville', 'Netherlands', 'New-Brunswick', 'New-Haven', 'New-Jersey', 'New-Orleans', 'New-York', 'New-Zealand', 'Newcastle', 'Newcastle-Upon-Tyne', 'Newport', 'Newport-Beach', 'Norfolk', 'Northampton', 'Northern-Ireland', 'Norway', 'Norwich', 'Nottingham', 'Novi-Sad', 'Oakland', 'Okinawa-Prefecture', 'Oklahoma-City', 'Oldham', 'Olympia', 'Omaha', 'Ontario', 'Orange-County', 'Orlando', 'Osaka', 'Oslo', 'Ottawa', 'Oulu', 'Oxford', 'Oxnard', 'Paisley', 'Palm-Desert', 'Paris', 'Pasadena', 'Pensacola', 'Peoria', 'Perth', 'Peterborough', 'Philadelphia', 'Phoenix', 'Pittsburgh', 'Pomona', 'Pontypridd', 'Portland', 'Porto-Alegre', 'Portsmouth', 'Prague', 'Princeton', 'Providence', 'Puerto-Rico', 'Punjab', 'Quebec-City', 'Queens', 'Queensbridge-Queens', 'Quezon-City', 'Madrid', 'Malibu', 'Manchester', 'Marseille', 'Melbourne', 'Memphis', 'Mexico', 'Mexico-City', 'Miami', 'Milan', 'Milwaukee', 'Minneapolis', 'Minneapolis-St-Paul', 'Mississauga', 'Moncton', 'Monterrey', 'Montreal', 'Moscow', 'Mumbai', 'Munich', 'Manila', 'Raleigh', 'Reading', 'Redondo-Beach', 'Regina', 'Republic-of-Macedonia', 'Reykjavik', 'Richmond', 'Riga', 'Riverside', 'Rochester', 'Rome', 'Rotterdam', 'Sacramento', 'Salford', 'Salt-Lake-City', 'San-Antonio', 'San-Diego', 'San-Francisco', 'San-Francisco-Bay-Area', 'San-Jose', 'San-Pedro', 'Santa-Barbara', 'Santa-Cruz', 'Santa-Monica', 'Santa-Rosa', 'Santurce-San-Juan-Puerto-Rico', 'Sarajevo', 'Savannah', 'Seattle', 'Seoul', 'Sheffield', 'Slovenia', 'South-Gate', 'South-Korea', 'Southampton', 'Southend-on-Sea', 'Springfield', 'St-Albans', 'St-Catharines', 'St-Louis', 'Staten-Island', 'Stavanger', 'Stockholm', 'Stockport', 'Stourbridge', 'Stuttgart', 'Sunderland', 'Surrey', 'Swansea', 'Sweden', 'Swindon', 'Sydney', 'Syracuse', 'Tacoma', 'Tallahassee', 'Tallinn', 'Tampa', 'Tampere', 'Tel-Aviv', 'Tempe', 'The-Bronx', 'Thessaloniki', 'Tokyo', 'Toledo', 'Topeka', 'Toronto', 'Torrance', 'Trinidad-and-Tobago', 'Trondheim', 'Tucson', 'Tulsa', 'Turin', 'Turku', 'Ukraine', 'United-Kingdom', 'Uppsala', 'Utrecht', 'Vacaville', 'Vallejo', 'Vancouver', 'Venice', 'Victoria', 'Vienna', 'Virginia-Beach', 'Wakefield', 'Wales', 'Washington-D-C', 'Watford', 'Wellington', 'Wigan', 'Windsor-Ontario', 'Winnipeg', 'Winston-Salem', 'Wirral-Peninsula', 'Wolverhampton', 'Worcester', 'Yokohama', 'Yonkers', 'York', 'Yorkshire', 'Youngstown', 'Zagreb', 'Zaragoza');
	
	// start city for loop here
	foreach ($cities as $city) {
		$city = strtolower($city);
		$res = perform_query($dbc, $query);
		$html = file_get_contents('http://www.ranker.com/list/'.$city.'-bands-and-musical-artists-from-here/reference');
		$page = 1;
		while ($html !== false) {
			while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
				$artist = $row['artist'];
				$artist = str_replace("'", "\'", $artist);
				$pattern = '|<span class="inlineBlock oNode robotoC" itemprop="name"> '.$artist.'<\/span>|';
				if (preg_match($pattern, $html) == 1) {
					$upquery = 'update radio_redux_test set city=\''.$city.'\' where artist=\''.$artist.'\'';
					perform_query($dbc, $upquery);
					echo $city."_p".$page.": ".$artist."<br>";
				}
			}
			$page++;
			$html = file_get_contents('http://www.ranker.com/list/'.$city.'-bands-and-musical-artists-from-here/reference?page='.$page);
			$res = perform_query($dbc, $query);
		}
		echo "<br><br>";
	}
	disconnect_from_db_simple($dbc);
}

function checkit() {
	$html = file_get_contents('http://www.ranker.com/list/canada-bands-and-musical-artists-from-here/reference');
	$i = 0;
	while ($html !== false) {
		echo $i."<br>";
		$i++;
		$html = file_get_contents('http://www.ranker.com/list/canada-bands-and-musical-artists-from-here/reference?page='.$i);
	}
	
	echo "<br><br>done";
	/*
	$artist = 'Alexisonfire';
	$pattern = '|<span class="inlineBlock oNode robotoC" itemprop="name"> '.$artist.'<\/span>|';
	echo preg_match($pattern, $html);
	*/

}