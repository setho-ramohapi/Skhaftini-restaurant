<?php
session_start();
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

if ($stmt->num_rows > 0) {
$stmt->bind_result($password, $name, $phone,$type, $status);
$stmt->fetch();
if ($_POST['pass'] === $password ) {
if ( $status == 'ACTIVE') {
session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['name'] = $name;
$_SESSION['id'] = $phone;
if ($type === 'CLIENT') {
header('Location: home.php');

} elseif ($type === 'RESTAURANT') {
header('Location: home1.php');

}
} else {

echo '<script type="text/javascript"> alert("YOU ARE BLOCKED, CONTACT SKHAFTINI FOR MORE INFO"); window.location = "index.php";</script>';

}
} else {

echo '<script type="text/javascript"> alert("PASSWORD INCORRECT"); window.location = "index.php";</script>';

}
} else {
echo '<script> alert("PHONE_NUMBER INCORRECT");  window.location = "index.php";</script>';

}


$stmt->close();
}
?>
