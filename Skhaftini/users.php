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
<title>SKHAFTINI ADMIN</title>
<link rel="stylesheet" href="skhaftini.css" />
</head>

<body>
<header>
<nav>
<img src="skaftini png-13.png" alt="logo" width="200px" height="135px" />
<nav>
<a href="home2.php">Home</a>
<a href="profile3.php">Profile</a>
<a href="users.php">Users</a>
<a href="adminlogout.php">Logout</a>
<form action="searchuser.php" method="get">
<input type="text" placeholder="SEARCH USER" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>
</nav>
</header>

<section id="restaurantsection">
<h2>All users: </h2>
<?php

$selectquery ="SELECT * FROM user_registration";
$result = $con->query($selectquery);
if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo '<br>';
echo 'Username: ' . htmlspecialchars($row['NAME'])  . '<a/>'. '<br>';  
echo '<br>';
echo 'TYPE OF User: '   . htmlspecialchars($row['TYPE_OF_USER'])  . '<br>';
echo '<br>';
echo 'Credit card: '   .htmlspecialchars($row['CREDIT_CARD'])  . '<br>';
echo '<br>';
echo "<img src='uploaded1/".$row['IMAGE']."' width='400' height='229'>";
echo '<br>';
echo '
<form action="userprofile.php" method="post">
<input type="hidden" value="'.$row['PHONE_NUMBER'].'" name="phone">
<input type="submit" value="VIEW PROFILE" name="submit" />
</form>';
echo '
<form action="block.php" method="post">
<input type="hidden" value="'.$row['PHONE_NUMBER'].'" name="phone">
<input type="submit" value="BLOCK USER" name="submit" />
</form>';
echo '
<form action="unblock.php" method="post">
<input type="hidden" value="'.$row['PHONE_NUMBER'].'" name="phone">
<input type="submit" value="UNBLOCK USER" name="submit" />
</form>';

}
?>

</section>

<aside id="restaurantaside">

<?php echo "Today is " . date("Y/m/d") . " <br> "; echo "Time " . date("h:i:sa"); ?>


</aside>

</body>
</html>