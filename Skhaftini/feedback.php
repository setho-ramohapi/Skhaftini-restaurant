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
<img src="skaftini png-13.png" alt="logo" width="200px" height="135px" />
<nav>
<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
<a href="restaurants.php"><i class="fas fa-sign-out-alt"></i>Restaurants</a>
<a href="feedback.php"><i class="fas fa-sign-out-alt">Feedback</i></a>
<form action="search.php" method="get" autocomplete="off">
<input type="text" placeholder="SEARCH FOR MEAL" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>
</header>
<section id="restaurantsection">
<h2>Give feedback to restaurant </h2>
<?php

$selectquery ="SELECT * FROM user_registration WHERE TYPE_OF_USER='RESTAURANT'";
$result = $con->query($selectquery);
if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo '<br>';
echo 'Restaurant: ' . htmlspecialchars($row['NAME']). '<br>';
echo '<br>';
echo "<img src='uploaded1/".$row['IMAGE']."' width='400' height='229'>";
echo '<br>';
echo '</form>
<form action="feedbackprocess.php" method="post">
<input type="hidden" value="'.$phone.'" name="phone">
<input type="hidden" value="'.$row['PHONE_NUMBER'].'" name="rphone">
<textarea placeholder="FEEDBACK" style="width:200px; height:100px;" name="feedback"></textarea>
<input type="submit" value="SUBMIT FEEDBACK" name="submit" />
</form>';

}
?>

</section>

<aside id="restaurantaside">
</aside>

</body>
</html>