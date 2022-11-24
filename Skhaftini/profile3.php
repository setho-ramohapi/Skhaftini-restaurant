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
$stmt = $con->prepare('SELECT EMAIL, NAME FROM admin WHERE ADMIN_ID = ?');
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($email,$name);
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

<p>ADMIN_ID:<?=$_SESSION['id']?></p>

<p>EMAIL:<?=$email?></p>


</section>
<aside id="restaurantaside">

<?php echo "Today is " . date("Y/m/d") . " <br> "; echo "Time " . date("h:i:sa"); ?>


</aside>

</body>
</html>