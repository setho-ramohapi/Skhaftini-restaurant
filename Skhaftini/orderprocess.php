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

<h1>Skhaftini</h1>
<nav>
<a href="profile.php"><?php echo "<img src='uploaded1/".$image." '>";?></a> <a href="profile.php"><i class="fas fa-user-circle"></i>Profile </a>
<a href="logout.php">Logout</a>
<a href="home.php">Home</a>
<a href="restaurants.php">Restaurants</a>
<form action="search.php" method="get">
<input type="text" placeholder="search meal" required name="search"/>
<input type="submit" value="search" name="submit" />
</form>
</nav>

</nav>
</header>


<section>


<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'skhaftini';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

$ans = mysqli_real_escape_string($con, $_POST['ANS']);
$type = $_SESSION['type'];
$name = $_SESSION['name'];
$id = $_SESSION['id'];
$code =	$_SESSION['code'];
$nameofr =	$_SESSION['nameofr'];
$price = $_SESSION['newprice'];
$image1 =	$_SESSION['$image1'];
$description =	$_SESSION['$description'];
$date =	$_SESSION['$date'];


if ($_POST['ANS'] == 'YES') {


$insert_query = "INSERT INTO order_t (PHONE_NUMBER,MEAL_CODE,TYPE_OF_DELIVERY,DATE_FOR_DELIVERY_OR_PICKUP,PRICE) VALUES 
('$id','$code','$type','$date','$price')";

mysqli_query($con, $insert_query);


echo "your order was made";
echo '<h1>'. $_SESSION['name'] . 'YOU HAVE ORDERED:' .  '</h1>';


echo 'NAME_OF_MEAL: '   . $name   . '<br>';   
echo 'PRICE: '   . $price   . '<br>'; 
echo 'DESCRIPTION: '   . $description   . '<br>'; 
echo '<h1>'. 'FROM:'. $nameofr . '</h1>';
echo "<img src='uploaded/".$image1."'>";
echo '<br><br>';




}
elseif ($_POST['ANS'] == 'NO') {
echo 'order cancelled';

}
}

?>

</section>

<footer>

</footer>

</body>
</html>