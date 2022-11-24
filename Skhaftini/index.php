<!--SETHO RAMOHAPI 1817997-->
<!--This is the php file for the Skhaftini index page-->
<!DOCTYPE html>
<html>
	<head>
		<title>SKHAFTINI</title>
		<link rel="stylesheet" href="skhaftini.css" />
	</head>
	
	<body id="indexbody">
		<section id="index">
		<h1>WHAT'S ON THE MENU</h1>
	
		<?php
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'skhaftini';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$query  = "SELECT * FROM user_registration join meal on user_registration.PHONE_NUMBER = meal.PHONE_NUMBER WHERE TYPE_OF_USER = 'RESTAURANT' ORDER BY NAME ASC";  
		$result = $con->query($query);
		if (!$result) die(mysqli_error($con));
		$rows = $result->num_rows;
		for ($j = 0 ; $j < $rows ; ++$j)  {    
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo 'Name of restaurant: '   . htmlspecialchars($row['NAME'])   . '<br>'; 
		echo 'Name of meal: '   . htmlspecialchars($row['NAME_OF_MEAL'])   . '<br>'; 
		echo 'Description: '   . htmlspecialchars($row['DESCRIPTION'])   . '<br>'; 
		echo 'Price of meal: M'   . htmlspecialchars($row['PRICE'])   . '<br>'; 
		echo "<img src='uploaded/".$row['IMAGE_NAME']."' width='500px' height='220px'>";
		echo '<hr>'; }
		?>
	
		</section>
		
		<aside id="indexaside">
		<h1 id="logo"><img src="skaftini png-13.png"></h1>
		<h2 id="heading">Welcome to Skhaftini, the lunchbox portal</h2>
		<form action="process.php" method="POST" id="frame">
		<table>
		<tr><td><label style="color:maroon;">Phone number</label></td>
		<td ><input type="text" required name="phone" id="user"></td></tr>
		<tr><td><label style="color:maroon;">Password</label></td>
		<td><input  type="password" required name="pass" id="pass"></td></td>
		<tr><td colspan="2"><input type="submit" value="LOGIN" class="button" name="submit" style="color:maroon; background-color:gold;"></td></tr>
		<tr><td  colspan="2"><button class="button"><a href="forgot.html" class="link" style="color:maroon;">FORGOT PASSWORD</a></button></td></tr>
		<tr><td  colspan="2"><button class="button"><a href="registration.html" class="link" style="color:maroon;">SIGN UP</a></button></td></tr>
		</table>
		</form>
		<h4 id="heading"> <a href="concerns.html" style="text-decoration: none; color: gold;">Concerns </a> - About Skhaftini - Terms</h2>
		</aside>
</html>