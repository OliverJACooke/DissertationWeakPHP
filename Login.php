<?php
session_start();
$connection = mysql_connect("localhost","usr_weak",'%Pa55w0rd') or die("Could Not Connect");

mysql_select_db("WeakDB") or die("Couldnt find DB");

if(isset($_POST['submit'])) {
		$username		= $_POST['username'];
		$password 		= $_POST['password'];
		$error			= "";
		
		if ($username == "")
		{
			$error = "You must enter a Username";
		}
		else if ($password == "")
		{
			$error = "You must enter a Password";
		}
		else {
			$sql = "SELECT userID FROM tblUser WHERE username='".$username."' && password='".$password."'";
			
			$sql_query = mysql_query($sql) or die(mysql_error());
			$value = mysql_fetch_row($sql_query);
			$result = $value[0];
			
			if($value) {
				$_SESSION["LoggedIn"] = $result;
				header("Location: ../Weak/Members/Home.php");
			} else {
				$error = "Incorrect Username or Password" ;
			}
		}
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="StyleSheet.css">
	</head>
	
	<body>
		<!-- Form Container -->
		<form action="Login.php" method="post">
			<div class=loginForm>
				<div class=formRow>
					<h1>Login</h1>
				</div>
				<div class=formRow>
					<div class=rowLeft>
						<h2>Username</h2>
					</div>
					<div class=rowRight>
						<input type="text" name="username" id="username"/> <!--<<<< Username Input Area -->
					</div>
				</div>
				<div class=formRow>
					<div class=rowLeft>
						<h2>Password</h2>
					</div>
					<div class=rowRight>
						<input type="password" name="password" id="password"/> <!--<<<< Password Input Area -->
					</div>
				</div>
				<div class=formRow>
					<div class=rowLeft>
						<input type="submit" name="submit" value="Login"/> <!--<<<< Submit Button Area -->
					</div>
					<div class=rowRight>
						<label id="lbl_Valid" style="color:red;"><?php echo $error?></label>			<!--<<<< Validation Output Area  ERROR OUTPUT -->
					</div>
				</div>
			</div>
		</form>
		<div class="formRow">
			<a href="Registration.php">Click Here to Register</a>
		</div>
		<!-- Form Container End -->
	</body>
</html>
