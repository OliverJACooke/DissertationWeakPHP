<?php
session_start();
$userID = $_SESSION["LoggedIn"];

$connection = mysql_connect("localhost","usr_weak",'%Pa55w0rd') or die("Could Not Connect");

mysql_select_db("WeakDB") or die("Couldnt find DB");
	
if($userID == null) {
	header("Location: ../Login.php") ;
}
else 
{
	// ------ Username Display ------
	$sqlUser = "SELECT username FROM tblUser WHERE userID='".$userID."'";
			
	$sql_query = mysql_query($sqlUser) or die(mysql_error());
	$value = mysql_fetch_assoc($sql_query);
	$username = $value['username'];
	// ------ Username Display ------	
	
	if(isset($_POST['search'])) {
		$sUsername = $_POST["searchUsername"];
		
		$sqlSearch = "	SELECT userID, username, firstName, lastName, DOB, eMail, admin 
						FROM tblUser WHERE username 
						LIKE '%".$sUsername."%'";
		
		$sqlSearchQuery = mysql_query($sqlSearch);
		$selectUser = mysql_fetch_assoc($sqlSearchQuery);
		
		if ($selectUser)
		{
			$firstNameSearch 	= $selectUser['firstName'];
			$lastNameSearch 	= $selectUser['lastName'];
			$DOBSearch 			= $selectUser['DOB'];
			$eMailSearch 		= $selectUser['eMail'];
			$adminSearch 		= $selectUser['admin'];
			
			$_SESSION['userIDSearch'] = $selectUser['userID'];
			$_SESSION['usernameSearch'] = $selectUser['username'];
		}
		else
		{
			$error = "No User Found";
		}
	}
	if(isset($_POST['submit'])) {
		$UserID			= $_SESSION['userIDSearch'];
		$firstName		= $_POST['firstName'];
		$lastName 		= $_POST['lastName'];
		$dob			= $_POST['dob'];
		$eMail 			= $_POST['eMail'];
		$chkAdmin 		= $_POST['admin'];
		
		if ($firstName == "")
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
		else {
			$sql = "UPDATE tblUser 
					SET 
						firstName='".$firstNameSearch."',
						lastName='".$lastNameSearch."',
						DOB='".$DOBSearch."',
						eMail='".$eMailSearch."', 
						admin='".$admin."'
					WHERE userID = '".$searchUserID."'";
			
			$sql_query = mysql_query($sql);
		}
		$_SESSION['userIDSearch'] = '';
		$_SESSION['usernameSearch'] = '';
	}
	
	if(isset($_POST['delete'])) {
		$searchUserID = $_SESSION['userIDSearch'];
		
		$sql = "DELETE FROM tblUser WHERE userID = '".$searchUserID."'";
		
		$sql_query = mysql_query($sql) or die(mysql_error());
	}
}
	
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../StyleSheet.css">
	</head>
<body>
		<div class="container">
			<h1>Welcome <?php echo $username?></h1>
			<div class=linksRow>
				<div class="link">
					<a href="../Members/Home.php">Home</a>
				</div>
				<div class="link">
					<a href="../Members/PostMessage.php">Post Message</a>
				</div>
				<div class="link">
					<a href="../Admin/Admin.php">Admin</a>
				</div>
                <div class="link">
                    <a href="../Logout.php">Logout</a>
                </div>
			</div>
			
			<!--<<<< Form Begins -->
			<form action="Admin.php" method="post">
				<div class="formRow">
					<h1>User Admin</h1>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>User Search</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="searchUsername" id="searchUsername"/> <!--<<<< First Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<input type="submit" name="search" value="Search"/> <!--<<<< Submit Button Area -->
					</div>
					<div class="rowRight">
						<label id="lbl_Valid"><?php echo $errorSearch?> </label><!--<<<< Validation Output Area -->
					</div>
				</div>
			</form>
			<form action="Admin.php" method="post"> 
				
				<div class="formRow">
					<div class="rowLeft">
						<h2>UserID</h2>
					</div>
					<div class="rowRight">
						<label id="userID"><?php echo $_SESSION['userIDSearch'];?></label> <!--<<<< First Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Username</h2>
					</div>
					<div class="rowRight">
						<label id="username"><?php echo $_SESSION['usernameSearch'];?></label><!--<<<< Username Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>First Name</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="firstName" id="firstName" value="<?php echo $firstNameSearch;?>"> <!--<<<< First Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Second Name</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="lastName" id="lastName" value="<?php echo $lastNameSearch;?>"/> <!--<<<< Second Name Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Date of Birth</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="dob" id="dob" value="<?php echo $DOBSearch;?>"/> <!--<<<< Date of Birth Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>E-Mail Address</h2>
					</div>
					<div class="rowRight">
						<input type="text" name="eMail" id="eMail" value="<?php echo $eMailSearch;?>"/> <!--<<<< E-Mail Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<h2>Admin</h2>
					</div>
					<div class="rowRight">
						<input type="checkbox" name="admin" id="admin"  <?php echo ($adminSearch==1 ? 'checked' : '');?>/> <!--<<<< Password Repeat Input Area -->
					</div>
				</div>
				<div class="formRow">
					<div class="rowLeft">
						<input type="submit" name="submit" value="Submit"/> <!--<<<< Submit Button Area -->
						<input type="submit" name="delete" value="Delete"/>
					</div>
					<div class="rowRight">
						<label id="lbl_Valid"><?php echo $error?> </label><!--<<<< Validation Output Area -->
					</div>
				</div>
			</form>  <!--<<<< Form Ends -->
			
		</div>
	</body>
</html>
