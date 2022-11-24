 <?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'skhaftini';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$type = mysqli_real_escape_string($con, $_POST['type']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
$house = mysqli_real_escape_string($con, $_POST['housenumber']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$street = mysqli_real_escape_string($con, $_POST['street']);
$city = mysqli_real_escape_string($con, $_POST['city']);
$district = mysqli_real_escape_string($con, $_POST['district']);
$village = mysqli_real_escape_string($con, $_POST['village']);
$card = mysqli_real_escape_string($con, $_POST['card']);
$pass1 = mysqli_real_escape_string($con, $_POST['pass1']);
$pass2 = mysqli_real_escape_string($con, $_POST['pass2']);
$insert_query1 = "INSERT INTO user_address (HOUSE_NUMBER,POSTAL_CODE,CITY,STREET,DISTRICT,VILLAGE) 
VALUES ('$house','$postal_code','$city','$street','$district','$village')";
mysqli_query($con, $insert_query1);

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
$allowed = array("jpg" => "image/jpg","jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
$filename = $_FILES["image"]["name"];
$filetype = $_FILES["image"]["type"];
$filesize = $_FILES["image"]["size"];
$folder = 'uploaded1/';
$tempname = $_FILES["image"]["tmp_name"];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if (!array_key_exists($ext, $allowed)) die ("Error: format is wrong");

if (in_array($filetype,$allowed)) {
move_uploaded_file($tempname,$folder.$filename);
$insert_query = "INSERT INTO user_registration (EMAIL,NAME,HOUSE_NUMBER,PHONE_NUMBER,PASSWORD,TYPE_OF_USER,IMAGE,STATUS,CREDIT_CARD,CHARGE) 
VALUES ('$email','$name','$house','$phone','$pass1','$type','$filename','ACTIVE','$card',0)";
mysqli_query($con, $insert_query);
}}
else {
	echo "Error: ". $_FILES["image"]["error"];
}
if ($_POST['pass1'] === $_POST['pass2']) {
if ($_POST['type'] == 'RESTAURANT') {
session_start();
if ( mysqli_connect_errno() ) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($stmt = $con->prepare('SELECT PASSWORD, NAME, PHONE_NUMBER FROM user_registration WHERE PHONE_NUMBER = ?')) {
$userid = $_POST['phone'];
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
$stmt->bind_result($password, $name, $phone);
$stmt->fetch();
if ($_POST['pass1'] === $password) {
session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['name'] = $name;
$_SESSION['id'] = $phone;
header('Location: home1.php');
}
}
}
}
elseif ($_POST['type'] == 'CLIENT'){
echo 'client';
session_start();

if ( mysqli_connect_errno() ) 
{
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($stmt = $con->prepare('SELECT PASSWORD, NAME, PHONE_NUMBER FROM user_registration WHERE PHONE_NUMBER = ?')) {
$userid = $_POST['phone'];
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
$stmt->bind_result($password, $name, $phone);
$stmt->fetch();
if ($_POST['pass1'] === $password) {
session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['name'] = $name;
$_SESSION['id'] = $phone;
header('Location: home.php');
}
}
}
}
} else
{
echo '<script type="text/javascript"> alert("PASSWORDS do not match"); window.location = "registration.php";</script>';
}
}

?>