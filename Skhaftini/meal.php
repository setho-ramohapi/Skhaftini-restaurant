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
$stmt = $con->prepare('SELECT PHONE_NUMBER, IMAGE FROM user_registration WHERE PHONE_NUMBER = ?');

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
<title>MEAL</title>
<link rel="stylesheet" href="skhaftini.css" />
</head>

<body>
<header>
<nav>

<img src="skaftini png-13.png" alt="logo" width="200px" height="135px" />
<nav>
<a href="home1.php">Home</a>
<a href="profile1.php">Profile</a>
<a href="logout.php">Logout</a>
<a href="orders.php">Orders</a>
</nav>
</nav>
</header>

<section id='restaurantsection'>
<h1>
<form action="imageprocess.php" method="POST" enctype="multipart/form-data" id="frame">
WHAT'S NEW ON THE MENU?
<hr>
<table>
<tr><td><input type="hidden" value=<?=$phone?> name="phone" id="pass" /></td></tr>
<tr><td><label>DESCRIPTION</label></td>
<td><textarea placeholder="What is in this dish?" value="'.$row['DESCRIPTION'].'" required name="description" style="width:200px; height: 150px"></textarea></td></tr>
<tr><td><label>NAME OF MEAL</label></td>
<td><input type="text" required name="name" id="pass"></td></tr>
<tr><td><label>PRICE</label></td>
<td><input type="number" required name="price" id="pass"></td></tr>
<tr><td><label>IMAGE OF MEAL</label></td>
<td><input type="file" required name="image" id="pass"></td></tr>
<tr><td><input type="submit" value="ADD TO MENU" id="btn" name="submit"></td></tr>
</table>
</form>
<hr>

YOUR CURRENT MENU:</h1>
<?php
$query  = "SELECT * FROM user_registration join meal on user_registration.PHONE_NUMBER = meal.PHONE_NUMBER WHERE meal.PHONE_NUMBER  = '$user'";  
$result = $con->query($query);
if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)  {    
$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'Name of meal: '   . htmlspecialchars($row['NAME_OF_MEAL'])   . '<br>'; 
echo 'Description: '   . htmlspecialchars($row['DESCRIPTION'])   . '<br>'; 
echo 'Price of meal: M'   . htmlspecialchars($row['PRICE'])   . '<br>'; 
echo '<h1>UPDATE MEAL:</h1>';
echo 'Current meal picture'.'<br>';
echo "<a href='s.php'>"."<img src='uploaded/".$row['IMAGE_NAME']."' width='400' height='229'>"."</a>";
echo '<form action="update.php" method="post">
<input type="hidden" value="'.$row['MEAL_CODE'].'" name="mealcode">
<input type="hidden" value="'.$row['PHONE_NUMBER'].'" name="phone" id="pass" />
<input type="hidden" value="'.$row['IMAGE_NAME'].'" name="imageofmeal">
<br>
<label>CURRENT DESCRIPTION</label>
<textarea values="'.$row['DESCRIPTION'].'" required name="description">'.$row['DESCRIPTION'].'</textarea>
<br>
<label>CURRENT NAME OF MEAL</label>
<input type="text"  value="'.$row['NAME_OF_MEAL'].'" required name="name">
<br>
<label>CURRENT PRICE</label>
<input type="number" value="'.$row['PRICE'].'"  required name="price">
<br>
<input type="submit" value="UPDATE MEAL" name="submit">
<br>
</form>
<form action="delete.php" method="post">
<input type="hidden" value="'.$row['MEAL_CODE'].'" name="mealcode">
<input type="submit" value="REMOVE MEAL" name="submit" />
</form>';
echo '<hr>';
}

?>

</h2>
</section>

<aside id="restaurantaside">

<?php
$selectquery= "SELECT count(*) from order_t join meal where meal.MEAL_CODE = order_t.MEAL_CODE and meal.PHONE_NUMBER ='$phone'";
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
