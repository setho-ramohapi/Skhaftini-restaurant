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
<a href="home1.php">Home</a>
<a href="profile1.php">Profile</a>
<a href="logout.php">Logout</a>
<a href="meal.php">Meals</a>
<a href="orders.php">Orders</a>
</nav>
</nav>
</header>

<section id="restaurantsection">
<h1><?=$_SESSION['name']?>!</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$code = mysqli_real_escape_string($con, $_POST['mealcode']);
$imageofmeal = mysqli_real_escape_string($con, $_POST['imageofmeal']);

$update_query="UPDATE meal SET DESCRIPTION = '$description', NAME_OF_MEAL = '$name', PRICE = '$price' WHERE MEAL_CODE = '$code'";
$result = $con->query($update_query);
echo 'YOUR MEAL HAS BEEN UPDATED';
echo '<br>';
echo 'NAME_OF_MEAL: '   . $name   . '<br>';   
echo 'DESCRIPTION: '   . $description   . '<br>'; 
echo 'PRICE: '   . $price   . '<br>'; 
echo "<img src='uploaded/".$imageofmeal."' width='400' height='229'>";

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
