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
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$email = mysqli_real_escape_string($con, $_POST['email']);
$concern = mysqli_real_escape_string($con, $_POST['concern']);
$insert_query = "INSERT INTO concern (EMAIL,CONCERN) 
VALUES ('$email','$concern')";
mysqli_query($con, $insert_query);
header('location:concernsend.html');
}


?>