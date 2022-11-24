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
if ($stmt = $con->prepare('SELECT PASSWORD, ADMIN_ID, SURNAME FROM admin WHERE ADMIN_ID = ?')) {
$adminid = $_POST['adminid'];
$stmt->bind_param('i', $adminid);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
$stmt->bind_result($password, $name, $surname);
$stmt->fetch();
if ($_POST['pass'] === $password) {

if ($adminid == $name) {
session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['id'] = $adminid;
header('location:home2.php');
} else {
	echo '<script> alert("ADMIN_ID INCORRECT");  window.location = "adminindex.php";</script>';
}

} else {
	echo '<script> alert("PASSWORD INCORRECT");  window.location = "adminindex.php";</script>';
}
}
$stmt->close();
}
?>
