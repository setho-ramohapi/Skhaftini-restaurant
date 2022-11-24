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
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
$type = mysqli_real_escape_string($con, $_POST['type']);
$code = mysqli_real_escape_string($con, $_POST['mealcode']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$nameofmeal = mysqli_real_escape_string($con, $_POST['nameofmeal']);
$nameofr = mysqli_real_escape_string($con, $_POST['nameofr']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$image1 = mysqli_real_escape_string($con, $_POST['image1']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$date = date('Y-m-d', strtotime($_POST['date']));

if ($_POST['type'] === 'PICKUP') {

$insert_query = "INSERT INTO order_t (PHONE_NUMBER,MEAL_CODE,TYPE_OF_DELIVERY,DATE_FOR_DELIVERY_OR_PICKUP,PRICE) VALUES 
('$phone','$code','$type','$date','$price')";
mysqli_query($con, $insert_query);
$update_query = "UPDATE user_registration SET CHARGE = CHARGE + $price WHERE PHONE_NUMBER = $phone";
mysqli_query($con, $update_query);

echo mysqli_error($con);
} else {
$_SESSION['loggedin'] = TRUE;
$_SESSION['nameofmeal'] = $nameofmeal;
$_SESSION['id'] = $phone;
$_SESSION['type'] = $type;
$_SESSION['code'] = $code;
$_SESSION['nameofr'] = $nameofr;
$_SESSION['$price'] = $price;
$_SESSION['$image1'] = $image1;
$_SESSION['$description'] = $description;
$_SESSION['$date'] = $date;
header('location:homedelivery.php');
}

$stmt = $con->prepare('SELECT IMAGE FROM user_registration WHERE PHONE_NUMBER = ?');
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();
}

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
<a href="profile.php">Profile</a>
<a href="logout.php">Logout</a>
<a href="restaurants.php">Restaurants</a>
<a href="home.php">Home</a>
<form action="search.php" method="get">
<input type="text" placeholder="search meal" name="search"/>
<input type="submit" value="search" name="submit" />
</form>
</nav>



</nav>
</header>

<section id="restaurantsection">
<?php echo "<img src='uploaded1/".$image."' height='150px' width='150px'>";?>
<h1>You have ordered</h1>
<h2>
<?php

echo 'NAME OF MEAL: '   . $nameofmeal   . '<br>';   
echo 'PRICE: M'   . $price   . '<br>'; 
echo 'DESCRIPTION: '   . $description   . '<br>'; 
echo 'FROM:' . $nameofr ;
echo '<br>';
echo "<img src='uploaded/".$image1."' width='450px' height='300px'>";


?>

<br><a href="restaurants.php">Make another order</a><br>
<a href="home.php">Go back home</a>
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
