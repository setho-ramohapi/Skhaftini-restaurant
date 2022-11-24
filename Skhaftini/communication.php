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
if (isset($_POST['submit'])) 
{
$phone1 = mysqli_real_escape_string($con, $_POST['phone1']);
$status = mysqli_real_escape_string($con, $_POST['status']);
$phone2 = mysqli_real_escape_string($con, $_POST['phone2']);
$type = mysqli_real_escape_string($con, $_POST['type']);
$orderid = mysqli_real_escape_string($con, $_POST['orderid']);
$requirement = mysqli_real_escape_string($con, $_POST['requirements']);

$insert_query = "INSERT INTO requirement (ORDER_ID,CPHONE_NUMBER,RPHONE_NUMBER,STATUS_OF_ORDER,REQUIREMENTS) VALUES ('$orderid','$phone1','$phone2','$status','$requirement')";

mysqli_query($con, $insert_query);

echo mysqli_error($con);

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
<a href="home1.php"><i class="fas fa-sign-out-alt"></i>Home</a>
<a href="profile1.php"><i class="fas fa-user-circle"></i>Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
<a href="meal.php"><i class="fas fa-sign-out-alt"></i>Meals</a>
<a href="orders.php"><i class="fas fa-sign-out-alt"></i>Orders</a>
</nav>


</nav>
</header>

<section id="restaurantsection">
<h1><?=$_SESSION['name']?>!</h1>


<h2>MEAL REQUIREMENTS ADDED </h2>
<?php
if ($_POST['status'] == 'CANCEL') {
$delete_query = "DELETE FROM order_t WHERE ORDER_ID = '$orderid' AND PHONE_NUMBER = '$phone1'";
mysqli_query($con,$delete_query);
echo 'deleted order';
}
elseif ($_POST['status'] == 'CONFIRM'){	
if ($_POST["type"] == 'HOME DELIVERY')
{
$stmt = $con->prepare("SELECT NAME,user_address.HOUSE_NUMBER,POSTAL_CODE, STREET, CITY, DISTRICT, user_registration.PHONE_NUMBER, IMAGE FROM user_registration, user_address,
order_t WHERE user_registration.HOUSE_NUMBER = user_address.HOUSE_NUMBER AND user_registration.PHONE_NUMBER = order_t.PHONE_NUMBER AND ORDER_ID = ? ");
echo mysqli_error($con);
$stmt->bind_param('i', $orderid);
$stmt->execute();
$stmt->bind_result($name,$housenum,$postalcode,$street,$city,$district,$phone,$image);

while($stmt->fetch()) {
echo "<img src='uploaded1/".$image."'>";
echo 'NAME_OF_CLIENT: '   . $name   . '<br>';  
echo 'HOUSE NUMBER: '   . $housenum   . '<br>';
echo 'POSTAL_CODE: '   . $postalcode   . '<br>'; 
echo 'STREET: '   . $street   . '<br>';
echo 'CITY: '   . $city   . '<br>';
echo 'DISTRICT: '   . $district  . '<br>';
echo 'PHONE_NUMBER: '   . $phone   . '<br>';
}
} elseif ($_POST["type"] == 'PICKUP') {
echo 'They\'ll pick it up';

}

}

}

?>

</section>

<aside id="restaurantaside">

<?php
$selectquery= "SELECT count(*) from order_t join meal where meal.MEAL_CODE = order_t.MEAL_CODE and meal.PHONE_NUMBER ='$phone2'";
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