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
<a href="home2.php">Home</a>
<a href="profile3.php">Profile</a>
<a href="users.php">All Users</a>
<a href="adminlogout.php">Logout</a>
<a href="concernreceived.php">Concerns Received</a>
<form action="searchuser.php" method="get">
<input type="text" placeholder="SEARCH USER" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>
</nav>
</header>
<section id="restaurantsection">
<h2>Received concerns </h2>
<hr>
<?php

$selectquery ="SELECT * FROM concern";
$result = $con->query($selectquery);
if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo '<br>';
echo 'SENDER: ' . htmlspecialchars($row['EMAIL']). '<br>';
echo 'CONCERN: ' . htmlspecialchars($row['CONCERN']). '<br>';
echo '<hr>';
echo '<br>';

}
?>

</section>

<aside id="restaurantaside">

<?php echo "Today is " . date("Y/m/d") . " <br> "; echo "Time " . date("h:i:sa"); ?>


</aside>

</body>
</html>