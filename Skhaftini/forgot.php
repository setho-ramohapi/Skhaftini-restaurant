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
if ( mysqli_connect_errno() ) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($stmt = $con->prepare('SELECT PASSWORD, NAME, PHONE_NUMBER, TYPE_OF_USER, STATUS FROM user_registration WHERE PHONE_NUMBER = ?')) {
$userid = $_POST['phone'];
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($password, $name, $phone,$type, $status);
$stmt->fetch();
if ($_POST['phone'] == $phone) {
if ( $status == 'ACTIVE') {

header('LOCATION:questions.html');
} else {
echo '<script type="text/javascript"> alert("YOUR ACCOUNT IS BLOCKED"); window.location = "index.php";</script>';
}
} 
else 
{
echo '<script> alert("PHONE_NUMBER INCORRECT");  window.location = "index.php";</script>';

}

}
?>
