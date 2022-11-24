<!--SETHO RAMOHAPI 1817997-->
<!--This is the php file for the Skhaftini index page-->
<!DOCTYPE html>
<html>
	<head>
		<title>SKHAFTINI ADMINISTRATION</title>
		<link rel="stylesheet" href="adminindex.css" />
	</head>
	
	<body>
		
		
		<section  id="index">
		<h1 id="logo"><img src="skaftini png-13.png"></h1>
		<h2 id="heading">SKHAFTINI ADMINISTRATION</h2>
		<form action="adminprocess.php" method="POST" id="frame">
		<table>
		<tr><td><label style="color:maroon;">ADMIN ID</label></td>
		<td ><input type="text" required name="adminid"></td></tr>
		<tr><td><label style="color:maroon;">PASSWORD</label></td>
		<td><input  type="password" required name="pass"></td></td>
		<tr><td colspan="2"><input type="submit" value="LOGIN" class="button" name="submit" style="color:maroon; background-color:gold;"></td></tr>
		<tr><td  colspan="2"><button class="button"><a href="forgot.html" class="link" style="color:maroon;">FORGOT PASSWORD</a></button></td></tr>
		</table>
		</form>
		</section>
</html>