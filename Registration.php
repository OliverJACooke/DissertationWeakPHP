<?php
	session_start();
	$connection = mysql_connect("localhost","usr_weak",'%Pa55w0rd') or die("Could Not Connect");

mysql_select_db("WeakDB") or die("Couldnt find DB");

	if(isset($_POST['submit'])) {
		$firstName		= $_POST['firstName'];
		$lastName 		= $_POST['lastName'];
		$dob			= $_POST['dob'];
		$eMail 			= $_POST['eMail'];
		$username		= $_POST['username'];
		$password 		= $_POST['password'];
		$rePassword		= $_POST['rePassword'];
		$error 			= "";
		
		$sql = "SELECT username FROM tblUser WHERE username='".$username."'";
		$sql_query = mysql_query($sql, $connection) or die(mysql_error());
		$value = mysql_fetch_assoc($sql_query);
		$dbUsername = $value['username'];
	
		if($dbUsername != null)
		{
			$error = "Username already in use";
		}
		else if ($username == "")
		{
			$error = "You must enter a Username";
		}
		else if ($password == "")
		{
			$error = "You must enter a Password";
		}
		else if ($rePassword == "")
		{
			$error = "You must enter the Password again";
		}
		else if ($firstName == "")
		{
			$error = "You must enter a First Name";
		}
		else if ($lastName == "")
		{
			$error = "You must enter a Last Name";
		}
		else if ($dob == "")
		{
			$error = "You must enter a Date of Birth";
		}
		else if ($eMail == "")
		{
			$error = "You must enter a E-Mail";
		}
		else if ($password != $rePassword)
		{
			$error = "Your passwords must match";
		}
		else {
			$sql = "INSERT INTO tblUser 
						(username,
						password,
						firstName,
						lastName,
						DOB,
						eMail)
					VALUES (
						'$username', 
						'$password', 
						'$firstName',
						'$lastName', 
						'$dob', 
						'$eMail')";
			
			$sql_query = mysql_query($sql) or die(mysql_error());
			
			header("Location: ../Weak/Login.php");
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="StyleSheet.css">
	</head>
	
	<body>
		
		<form action="Registration.php" method="post">  <!--<<<< Form Begins -->
			<div class="registrationForm">
				<div class="formRow">
					<h1>Registration</h1>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>First Name</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="firstName" id="firstName"/> <!--<<<< First Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Second Name</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="lastName" id="lastName"/> <!--<<<< Second Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Date of Birth</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="dob" id="dob"/> <!--<<<< Date of Birth Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>E-Mail Address</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="eMail" id="eMail"/> <!--<<<< E-Mail Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Username</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="username" id="username"/> <!--<<<< Username Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Password</h2>
					</div>
					<div class="rowRight">
						<input type="password" name="password" id="password"/> <!--<<<< Password Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Password Repeat</h2>
					</div>
					<div class="rowRight">
						<input type="password" name="rePassword" id="rePassword"/> <!--<<<< Password Repeat Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<input type="submit" name="submit" value="Submit"/> <!--<<<< Submit Button Area -->
					</div>
					<div class="rowRight">
						<label id="lbl_Valid"><?php echo $error?> </label><!--<<<< Validation Output Area -->
					</div>
				</div>
			</div>
		</form>  <!--<<<< Form Ends -->
	</body>
</html>
