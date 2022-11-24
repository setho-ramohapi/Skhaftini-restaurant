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
$stmt = $con->prepare('SELECT NAME FROM admin WHERE ADMIN_ID = ?');
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
<title>SKHAFTINI ADMIN</title>
<link rel="stylesheet" href="skhaftini.css" />
</head>

<body>
<header>
<nav>
<img src="skaftini png-13.png" alt="logo" width="200px" height="135px" />
<nav>
<a href="profile3.php">Profile</a>
<a href="users.php">All Users</a>
<a href="addadmin.html">Add admin</a>
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
<h1>ALL CONCERNS</h1>
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
