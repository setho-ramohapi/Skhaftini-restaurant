
<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'skhaftini';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$stmt = $con->prepare('SELECT IMAGE, PHONE_NUMBER FROM user_registration WHERE PHONE_NUMBER = ?');
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($image,$phone);
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
<a href="profile1.php"><i class="fas fa-user-circle"></i>Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
<a href="meal.php"><i class="fas fa-sign-out-alt"></i>Meals</a>
<a href="orders.php"><i class="fas fa-sign-out-alt"></i>Orders</a>
<a href="receievedfeedbacks.php">Feedback</a>
</nav>


</nav>
</header>

<section id='restaurantsection'>
<?php echo "<img src='uploaded1/".$image." ' width='150px' height='135px' >";?>
<h1>Your new orders:</h1>

<?php 
if (mysqli_connect_errno()) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT NAME,NAME_OF_MEAL,order_t.PHONE_NUMBER, order_t.PRICE, DESCRIPTION, IMAGE_NAME,DATE_AND_TIME_ORDER_MADE FROM order_t,user_registration, meal 
WHERE order_t.PHONE_NUMBER = user_registration.PHONE_NUMBER AND order_t.MEAL_CODE = meal.MEAL_CODE AND meal.PHONE_NUMBER in 
(SELECT meal.PHONE_NUMBER FROM meal JOIN order_t ON meal.MEAL_CODE = order_t.MEAL_CODE WHERE meal.PHONE_NUMBER = ? )');
echo mysqli_error($con);

$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($name,$namemeal,$phone2,$price,$description,$image,$date);

while($stmt->fetch()) {
echo 'NAME OF CLIENT: '   . $name   . '<br>';  
echo 'NAME OF MEAL: '   . $namemeal   . '<br>';
echo 'PRICE: M'   . $price   . '<br>'; 
echo 'DESCRIPTION: '   . $description   . '<br>';
echo 'ON: '   . $date   . '<br>';
echo "<img src='uploaded/".$image."' width='300px' height='250px'>";
echo '<br><br>';

}

?>
</section>

<aside id="restaurantaside">

<?php
$selectquery= "SELECT count(*) from order_t join meal where meal.MEAL_CODE = order_t.MEAL_CODE and meal.PHONE_NUMBER ='$phone'";
$result = $con->query($selectquery);
$count = mysqli_fetch_array($result);
$rows = $count[0];
if ($rows <= 5 ) {

echo 'Hey '. $_SESSION['name'] . ' '. '<br>';
echo '<p id="count">'.$rows . ' meal(s) in total have been ordered from you'. '</p>'.'<br>';
echo 'Add more meals to attract more customers';
}else {
echo 'Hey '. $_SESSION['name'] . ' '. '<br>';
echo '<p id="count">'.$rows . ' meals in total have been ordered from you'. '</p>'.'<br>';
echo 'Add more meals to attract more customers';
}
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
