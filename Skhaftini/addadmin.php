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
$adminid = mysqli_real_escape_string($con, $_POST['adminid']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$surname = mysqli_real_escape_string($con, $_POST['surname']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$nationalid = mysqli_real_escape_string($con, $_POST['nationalid']);
$pass1 = mysqli_real_escape_string($con, $_POST['pass1']);
$pass2 = mysqli_real_escape_string($con, $_POST['pass2']);

$insert_query = "INSERT INTO admin (ADMIN_ID,EMAIL,NAME,SURNAME,PHONE_NUMBER,PASSWORD,NATIONAL_ID) 
VALUES ('$adminid','$email','$name','$surname','$phone','$pass1','$nationalid')";
mysqli_query($con, $insert_query);
echo mysqli_error($con);

if ($pass1 !== $pass2) {
echo '<script type="text/javascript"> alert("PASSWORDS do not match"); window.location = "addadmin.php";</script>';
} else {
	echo "success";
}
}


?>