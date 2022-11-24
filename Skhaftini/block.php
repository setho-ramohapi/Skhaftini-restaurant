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
<a href="profile3.php">Profile</a>
<a href="users.php">Users</a>
<form action="searchuser.php" method="get">
<input type="text" placeholder="SEARCH USER" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>
</nav>
</header>
<section id="restaurantsection">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$phone = mysqli_real_escape_string($con, $_POST['phone']);

$update_query="UPDATE user_registration SET STATUS = 'BLOCKED' WHERE PHONE_NUMBER = '$phone'";
$result = $con->query($update_query);
echo 'USER HAS BEEN BLOCKED';

}
?>

</section>

<aside id="restaurantaside">


</aside>

</body>

</html>
