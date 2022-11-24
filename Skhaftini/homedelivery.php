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
$type = $_SESSION['type'];
$nameofmeal = $_SESSION['nameofmeal'];
$id = $_SESSION['id'];
$code =	$_SESSION['code'];
$nameofr =	$_SESSION['nameofr'];
$price = $_SESSION['$price'];
$image1 =	$_SESSION['$image1'];
$description =	$_SESSION['$description'];
$date =	$_SESSION['$date'];
$stmt = $con->prepare('SELECT IMAGE,VILLAGE,PHONE_NUMBER FROM user_registration JOIN user_address on user_address.HOUSE_NUMBER =
user_registration.HOUSE_NUMBER AND PHONE_NUMBER = ?');
echo mysqli_error($con);
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($image,$village,$phone);
$stmt->fetch();

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
</a> <a href="profile.php">Profile </a>
<a href="logout.php">Logout</a>
<a href="home.php">Home</a>
<form action="search.php" method="get">
<input type="text" placeholder="search meal" required name="search"/>
<input type="submit" value="search" name="submit" />
</form>
</nav>

</nav>
</header>
<section id='restaurantsection'>
<?php

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$stmt = $con->prepare("SELECT NAME, PRICE , user_address.VILLAGE from user_registration,user_address,meal WHERE user_address.HOUSE_NUMBER = 
user_registration.HOUSE_NUMBER and meal.MEAL_CODE = $code and user_registration.PHONE_NUMBER = meal.PHONE_NUMBER and user_registration.PHONE_NUMBER <> ? ");

echo mysqli_error($con);
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name,$price, $vil);
$stmt->fetch();


function getDistance($addressFrom, $addressTo, $unit = '' ){
$apiKey = 'AIzaSyAqMZRxJi4eIZUZd-LK4ljxTUrszuBMeTg';
$formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
$formattedAddrTo     = str_replace(' ', '+', $addressTo);
$geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
$outputFrom = json_decode($geocodeFrom);
if(!empty($outputFrom->error_message)){
return $outputFrom->error_message;
}
$geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
$outputTo = json_decode($geocodeTo);
if(!empty($outputTo->error_message)){
return $outputTo->error_message;
}
$latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
$longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
$latitudeTo        = $outputTo->results[0]->geometry->location->lat;
$longitudeTo    = $outputTo->results[0]->geometry->location->lng;
$pi80 = M_PI / 180;
$latitudeFrom *= $pi80;
$longitudeFrom *= $pi80;
$latitudeTo *= $pi80;
$longitudeTo *= $pi80;

$r = 6372.797;

$dlat = $latitudeTo - $latitudeFrom;
$dlon = $longitudeTo - $longitudeFrom;

$a = sin($dlat / 2) * sin($dlat / 2 ) + cos($latitudeFrom) * cos($latitudeTo) * sin($dlon / 2) * sin($dlon / 2);
$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

$km = $r * $c + 3;

return $km;
}

$distance = getDistance($village,$vil);


if ($distance >= 10) {

$query="SELECT PRICE FROM meal WHERE MEAL_CODE = $code";
$result = $con->query($query);


if (!$result) die(mysqli_error($con));

$rows = $result->num_rows;


$row = $result->fetch_array(MYSQLI_ASSOC);

$d = $distance - 10000;

$oldprice = htmlspecialchars($row['PRICE']);
$addition = $d * 5 /100;

$newprice = $oldprice + $addition;

$_SESSION['newprice'] = $newprice;
echo "Due to the distance from $vil and $village being more than 10km apart and the meal price being $price";
echo "<br>";
echo "You will be charged M"; echo round($newprice,0);
echo "<br>";
echo "ARE YOU SATISFIED WITH THE CHARGE?";
echo '
<form method="post" action="orderprocess.php">
<input type="radio" value="YES" name="ANS" required>YES
<input type="radio" value="NO" name="ANS" required>NO
<input type="submit" value="SUBMIT" name="submit" >
</form>
';

} elseif ($distance <= 10) {
echo "<img src='uploaded1/".$image."' height='150px' width='150px'>";
echo '<br>';
echo '<h1>You have ordered</h1>';
echo '<br>';

echo 'NAME_OF_MEAL: '   . $nameofmeal   . '<br>';   
echo 'PRICE: M'   . $price   . '<br>'; 
echo 'DESCRIPTION: '   . $description   . '<br>'; 
echo 'FROM:' . $nameofr ;
echo '<br>';
echo "<img src='uploaded/".$image1."' width='450px' height='300px'>";
echo '<a href="home.php"></i>Go back home</a>';
}



?>


</section>

</section>

<aside id="restaurantaside">
<?php
$selectquery= "SELECT count(*) from order_t where order_t.PHONE_NUMBER = $phone";
$result = $con->query($selectquery);
$count = mysqli_fetch_array($result);
$rows = $count[0];
if ($rows <= 5 ) {
echo 'Hey '. $_SESSION['name'] . ' you have ordered '. '<br>';
echo '<p id="count">'.$rows . ' time(s)'. '</p>'.'<br>';
echo 'Check out more menus from various restaurants, there\'s something for everyone.';
}else {
echo 'Hey '.$_SESSION['name'] . ' you have ordered '. '<br>';
echo '<p id="count">'.$rows . ' times'. '</p>'.'<br>';
echo 'Restaurants know your name now!';
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