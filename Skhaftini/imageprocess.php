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
<a href="home1.php">Home</a>
<a href="profile1.php">Profile</a>
<a href="logout.php">Logout</a>
<a href="meal.php">Meals</a>
<a href="orders.php">Orders</a>
</nav>


</nav>
</header>

<section id='restaurantsection'>
<h1><?=$_SESSION['name']?>!</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$price = mysqli_real_escape_string($con, $_POST['price']);

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
$allowed = array("jpg" => "image/jpg","jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
$filename = $_FILES["image"]["name"];
$filetype = $_FILES["image"]["type"];
$filesize = $_FILES["image"]["size"];
$folder = 'uploaded/';
$tempname = $_FILES["image"]["tmp_name"];

$ext = pathinfo($filename, PATHINFO_EXTENSION);
if (!array_key_exists($ext, $allowed)) die ("Error: format is wrong");

if (in_array($filetype,$allowed)) {

move_uploaded_file($tempname,$folder.$filename);
$insert_query = "INSERT INTO meal (PHONE_NUMBER,DESCRIPTION,NAME_OF_MEAL,PRICE,IMAGE_NAME) VALUES ('$phone','$description','$name','$price','$filename')";
mysqli_query($con, $insert_query); 
$query  = "SELECT * FROM meal WHERE PHONE_NUMBER = '$phone' ORDER BY MEAL_CODE DESC LIMIT 1";  
$result = $con->query($query);

if (!$result) die("Fatal Error");

$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'MEAL_CODE: '   . htmlspecialchars($row['MEAL_CODE'])   . '<br>';    
echo 'DESCRIPTION: ' . htmlspecialchars($row['DESCRIPTION']) . '<br>';    
echo 'NAME_OF_MEAL: '  . htmlspecialchars($row['NAME_OF_MEAL'])     . '<br>';   
echo 'PRICE: '     . htmlspecialchars($row['PRICE'])     . '<br>';
echo "<br><img src='$folder/$filename' width='300px' height='200px'>"; 
} 
}else {
echo "Error: there was a problem";
}
}
else {
echo "Error: ". $_FILES["image"]["error"];
}


?>

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
