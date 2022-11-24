<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: login.php');
exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT EMAIL,NAME,SURNAME, TYPE_OF_USER FROM user_registration = ?');
echo mysqli_error($conn);
$user = $_SESSION['id'];
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($email,$name,$surname,$type);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>ARIELLE E-LEARNING</title>
<link rel="stylesheet" href="ARFA.css"/>
</head>

<body>
<header>
<nav>
<a href="student-home.php"><img src="logo1197c37250c3468907d3cfdb5fca91f6f.png" alt="logo" width="200px" height="100px" /></a>
<a href="logout.php" style="float:left;">Logout</a>
</nav>
</header>	
<aside>
<li><a href="student-profile.php">Profile</a><li/>
<li><a href="courses.php"></i>Programs</a><li/>
<li><a href="student-assignments.php">Assignments</a><li/>
<li><a href="assignments.php">Discussion Forums</a><li/>
<li><a href="sessions.php">Sessions</a><li/>
</aside>

<section id="restaurantsection">
<h2>
<p><?php echo "<img src='uploaded1/".$image." ' width='200px' height='135px'>";?></p>
<form action="updateprofile.php" method="post" enctype="multipart/form-data" id="meal">
<input type="hidden" value="'.$phone.'" name="phone" id="pass" /></li>
<input type="submit" value="Update profile" name="submit" id="order"/>
</form>
<?php echo $type?>
<br>
First Name: <?php echo $_SESSION['name']?> 
<br>
Surname: <?php echo $_SESSION['id']?>
<br>
Email: <?php echo $email?>
<br>
</h2>					
</section>
<aside id="restaurantaside">
</aside>
</body>
</html>