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
$stmt = $con->prepare('SELECT PHONE_NUMBER FROM user_registration WHERE PHONE_NUMBER = ?');
$search = mysqli_real_escape_string($con, $_GET['search']);
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($phone);
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
<a href="adminlogout.php">Logout</a>
<a href="profile3.php">Profile</a>
<a href="users.php">Users</a>
<form action="searchuser.php" method="get">
<input type="text" placeholder="SEARCH USER" name="search"/>
<input type="submit" value="SEARCH" name="submit" />
</form>
</nav>
</nav>
</header>	
<section id='restaurantsection'>
<div>
<h1> FOUND USER</h1>
<h2>
<?php
$query  = "SELECT * FROM user_registration join user_address on user_registration.HOUSE_NUMBER = user_address.HOUSE_NUMBER WHERE NAME REGEXP '$search'";  
$result = $con->query($query);
if (!$result) die(mysqli_error($con));
$rows = $result->num_rows;
if (!empty($rows)) {
for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'Username: '   . htmlspecialchars($row['NAME'])   . '<br>'; 
echo 'Phone: '   . htmlspecialchars($row['PHONE_NUMBER'])   . '<br>'; 
echo 'Village: '   . htmlspecialchars($row['VILLAGE'])   . '<br>'; 
echo "<img src='uploaded1/".$row['IMAGE']."' width='400px' height='200px'>";
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

}} elseif (empty($rows)) {
echo 'No user by that name';
}
?>
</h2>
</div>
</section>


<aside id="restaurantaside">


</aside>

</body>