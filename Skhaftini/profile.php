<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: index.php');
exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'skhaftini';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT EMAIL,NAME,user_address.HOUSE_NUMBER,PHONE_NUMBER,IMAGE,CREDIT_CARD,CHARGE,VILLAGE FROM user_registration join user_address on
user_address.HOUSE_NUMBER = user_registration.HOUSE_NUMBER and PHONE_NUMBER = ?');
echo mysqli_error($con);
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($email,$name,$houseno,$phone,$image,$card,$charge,$village);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>SKHAFTINI</title>
<link rel="stylesheet" href="skhaftini.css" />
</head>

<body>
<header>
<nav>
<a href="home.php"><img src="skaftini png-13.png" alt="logo" width="200px" height="135px" /></a>
<nav>
<a href="logout.php">Logout</a>
<a href="home.php">Home</a>
<a href="restaurants.php">Restaurants</a>
<form action="search.php" method="get">
<input type="text" placeholder="search meal" name="search"/>
<input type="submit" value="search" name="submit" />
</form>
</nav>
</nav>
</header>	
<section id="restaurantsection">
<h2>
<p><?php echo "<img src='uploaded1/".$image." ' width='200px' height='135px'>";?></p>
<form action="updateprofile.php" method="post" enctype="multipart/form-data" id="meal">
<input type="hidden" value="'.$phone.'" name="phone" id="pass" /></li>
<input type="submit" value="Update profile" name="submit" id="order"/>
</form>
Username: <?php echo $_SESSION['name']?> 
<br>
Phone number: <?php echo $_SESSION['id']?>
<br>
Email: <?php echo $email?>
<br>
Village: <?php echo $village?>
<br>
House number: <?php echo $houseno?>	
<br>
Credit card number: <?php echo $card?>
<br>
Outstanding charge to be paid: <?php echo $charge?>
</h2>					
</section>
<aside id="restaurantaside">
</aside>
</body>
</html>