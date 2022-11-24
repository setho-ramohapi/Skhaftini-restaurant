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
$stmt = $con->prepare('SELECT IMAGE FROM user_registration WHERE PHONE_NUMBER = ?');
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($image);
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

<img src="skaftini png-13.png" alt="logo" width="200px" height="135px" />
<nav>
<a href="profile.php">Profile </a>
<a href="logout.php">Logout</a>
<a href="home.php">Home</a>
<form action="search.php" method="get">
<input type="text" placeholder="search meal" required name="search"/>
<input type="submit" value="search" name="submit" />
</form>
</nav>

</nav>
</header>


<section id="restaurantsection">

<h1> MENUS </h1>
<h2>

<?php
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
echo "<img src='uploaded/".$row['IMAGE_NAME']."' width='350px' height='200px'>";
echo '<form action="order.php" method="post">
<input type="hidden" value="'.$row['NAME'].'" name="nameofr">
<input type="hidden" value="'.$row['NAME_OF_MEAL'].'" name="nameofmeal">
<input type="hidden" value="'.$row['IMAGE_NAME'].'" name="image1">
<input type="hidden" value="'.$row['PRICE'].'" name="price">
<input type="hidden" value="'.$row['MEAL_CODE'].'" name="mealcode">
<input type="hidden" value="'.$row['DESCRIPTION'].'" name="description">
<input type="hidden" value="'.$_SESSION['id'].'" name="phone"
<table>
<tr><td>CHOOSE DATE FOR PICKUP OR DELIVERY</td>
<td><input type="date" name="date"</td></tr>
<br>
<tr><td >TYPE OF DELIVERY?</td></tr>
<br>
<tr><td><input type="radio" value="PICKUP" name="type" required /> PICKUP</td></tr>
<br>
<tr><td><input type="radio" value="HOME DELIVERY" name="type" required />HOME DELIVERY</td></tr>
<br>
<tr><td><input type="submit" value="ORDER MEAL" name="submit"/></td></tr>
<br>
<br><hr>
</table>
</form>';
}


?>

</h2>

</section>

<aside id="restaurantaside">
<?php
$selectquery= "SELECT count(*) from user_registration where TYPE_OF_USER = 'RESTAURANT'";
$result = $con->query($selectquery);
$count = mysqli_fetch_array($result);
$rows = $count[0];
echo 'There are'. '<br>';
echo '<p id="count">'.$rows . ' restaurants'. '</p>'.'<br>';
echo 'registered with Skhaftini and with every passing day we are becoming a hub of deliciousness!';

?>
<div>
<hr style="border: solid 1px gold">

REPORT A PROBLEM

TERMS & POLICIES

HELP
</div>
<div>
<?php echo "Today is " . date("Y/m/d") . " <br> "; echo "Time " . date("h:i:sa"); ?>

</div>

</aside>

</body>
</html>
