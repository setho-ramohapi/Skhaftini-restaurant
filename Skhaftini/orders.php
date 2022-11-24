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
$stmt = $con->prepare('SELECT IMAGE,PHONE_NUMBER FROM user_registration WHERE PHONE_NUMBER = ?');
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($imageu,$phone);
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
<a href="profile1.php"><Profile</a>
<a href="logout.php">Logout</a>
<a href="meal.php">Meals</a>
</nav>
</nav>
</header>

<section id='restaurantsection'>
<h1><?=$_SESSION['name']?>! All orders:</h1>
<?php
$stmt = $con->prepare('SELECT NAME,NAME_OF_MEAL, order_t.PHONE_NUMBER,order_t.PRICE, DESCRIPTION, IMAGE_NAME, TYPE_OF_DELIVERY, order_t.PHONE_NUMBER, ORDER_ID FROM order_t,user_registration, meal 
WHERE order_t.PHONE_NUMBER = user_registration.PHONE_NUMBER AND order_t.MEAL_CODE = meal.MEAL_CODE AND meal.PHONE_NUMBER in 
(SELECT meal.PHONE_NUMBER FROM meal JOIN order_t ON meal.MEAL_CODE = order_t.MEAL_CODE WHERE meal.PHONE_NUMBER = ? )');
echo mysqli_error($con);
// In this case we can use the account ID to get the account info.
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($name,$namemeal,$phone2,$price,$description,$image,$type,$phone1,$orderid);

while($stmt->fetch()) {
echo 'NAME_OF_CLIENT: '   . $name   . '<br>';  
echo 'CALL CLIENT: '   . $phone2  . '<br>';
echo 'NAME_OF_MEAL: '   . $namemeal   . '<br>';
echo 'PRICE: M'   . $price   . '<br>'; 
echo 'DESCRIPTION: '   . $description   . '<br>';
echo 'TYPE OF DELIVERY: '   . $type   . '<br>';
echo "<img src='uploaded/".$image."' width='400' height='229'>";

echo '<form action="communication.php" method="post" id="frame">
<table>
<tr><td><input type="hidden" value="'.$orderid.'" name="orderid"</td><tr>
<tr><td><input type="hidden" value="'.$phone1.'" name="phone1"</td></tr>
<tr><td> <input type="hidden" value="'.$type.'" name="type"</td></tr>
<tr><td> <input type="hidden" value="'.$_SESSION['id'].'" name="phone2"</td></tr>
<tr><td>REQUIREMENTS FOR ORDER</td>
<td><textarea values="ENTER REQUIREMENTS" required name="requirements"></textarea> </td></tr>

<tr><td>CANCEL</td>
<td><input type="radio" value="CANCEL" name="status" required /></td></tr>
<tr><td>CONFIRM</td>
<td><input type="radio" value="CONFIRM" name="status" required /></td></tr>

<td><input type="submit" value="SUBMIT" name="submit"/></td></tr>
</table>
</form>';
echo '<hr>';
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
