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
$stmt->bind_result($image1,$phone);
$stmt->fetch();
$stmt->close();
?>

<html>
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
<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
<a href="restaurants.php"><i class="fas fa-sign-out-alt"></i>Restaurants</a>
<a href="feedback.php">Feedback</a>
<form action="search.php" method="get" autocomplete="off">
<input type="text" placeholder="SEARCH FOR MEAL" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>


</nav>
</header>

<section id='restaurantsection'>
<?php echo "<img src='uploaded1/".$image1." ' width='150px' height='135px' >";?>

<hr>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$rphone = mysqli_real_escape_string($con, $_POST['rphone']);
$feedback = mysqli_real_escape_string($con, $_POST['feedback']);
$insert_query = "INSERT INTO feedback (CPHONE_NUMBER,RPHONE_NUMBER,FEEDBACK) 
VALUES ('$phone','$rphone','$feedback')";
mysqli_query($con, $insert_query);
echo 'YOUR FEEDBACK WAS RECIEVED';
}


?>

</section>

<aside id="restaurantaside">

<?php
$selectquery= "SELECT count(*) from order_t where order_t.PHONE_NUMBER = $phone";
$result = $con->query($selectquery);
$count = mysqli_fetch_array($result);
$rows = $count[0];
if ($rows <= 5 ) {

echo 'Hey '. $_SESSION['name'] . ' you have ordered '. '<br>';
echo '<p id="count">'.$rows . ' time(s)'. '</p>'.'<br>';
echo 'Check out more menus from various restaurants, there\'s something for everyone.';
}else {
echo 'Hey '.$_SESSION['name'] . ' you have ordered '. '<br>';
echo '<p id="count">'.$rows . ' times'. '</p>'.'<br>';
echo 'Restaurants know your name now!';
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