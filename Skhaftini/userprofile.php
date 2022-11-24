.<?php
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
$stmt = $con->prepare('SELECT PHONE_NUMBER, IMAGE FROM user_registration WHERE PHONE_NUMBER = ?');
$usersphone = $_POST['phone'];
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($phone,$image);
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


<section id='restaurantsection'>
<h1>SELECTED USER PROFILE:</h1>
<hr>
<?php
$query  = "SELECT * FROM user_registration join user_address on user_registration.HOUSE_NUMBER = user_address.house_NUMBER WHERE user_registration.PHONE_NUMBER  = '$usersphone'";  
$result = $con->query($query);
if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'NAME OF USER: '   . htmlspecialchars($row['NAME'])   . '<br>'; 
echo 'VILLAGE: '   . htmlspecialchars($row['VILLAGE'])   . '<br>'; 
echo 'PHONE NUMBER: '  . htmlspecialchars($row['PHONE_NUMBER'])   . '<br>'; 
echo 'EMAIL: '   . htmlspecialchars($row['EMAIL'])   . '<br>'; 
echo 'HOUSE NUMBER: '   . htmlspecialchars($row['HOUSE_NUMBER'])   . '<br>'; 
echo 'CITY: '   . htmlspecialchars($row['CITY'])   . '<br>'; 
echo 'DISTRICT: '   . htmlspecialchars($row['DISTRICT'])   . '<br>'; 
echo 'TYPE OF USER: '   . htmlspecialchars($row['TYPE_OF_USER'])   . '<br>'; 
echo 'STATUS: '   . htmlspecialchars($row['STATUS'])   . '<br>'; 
echo 'DATE ACCOUNT CREATED: '   . htmlspecialchars($row['DATE_ACCOUNT_CREATED'])   . '<br>'; 
echo 'PICTURE'.'<br>';
echo "<img src='uploaded1/".$row['IMAGE']."' width='400' height='229'>";
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

echo '<hr>';
}

?>

</h2>
</section>

<aside id="restaurantaside">

<?php echo "Today is " . date("Y/m/d") . " <br> "; echo "Time " . date("h:i:sa"); ?>


</aside>

</body>
</html>
