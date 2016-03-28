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
	$userID = $_SESSION["LoggedIn"];
	$sql = "SELECT username FROM tblUser WHERE userID='".$userID."'";
			
	$sql_query = mysql_query($sql, $connection) or die(mysql_error());
	$value = mysql_fetch_assoc($sql_query);
	$username = $value['username'];

	if(isset($_POST['submit'])) {
		$chkPrivate		= $_POST['private'];
		$submitUsername	= $_POST['username'];
		$message 		= $_POST['message'];
		
		$sqlSelect = "SELECT username FROM tblUser WHERE username='".$submitUsername."'";
		$sql_query = mysql_query($sqlSelect);
		$value = mysql_fetch_assoc($sql_query);
		$dbUsername = $value['username'];
		
		if ($chkPrivate == on && $dbUsername == "")
		{
			$error = "User does not exist";
		}
		else if ($message == "")
		{
			$error = "You must enter a message";
		}
		else 
		{
			if ($chkPrivate == "on")
			{
				$privateBool = 1;
			} 
			else
			{
				$privateBool = 0;
			}
			
			$sqlInsert = "INSERT INTO tblMessage (userID,messageBody,messageType,username)
			VALUES ('$userID', '$message', '$privateBool','$submitUsername')";
			
			$sql_query = mysql_query($sqlInsert);
			
			header("Location: ../Members/Home.php");
		}
	}
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../StyleSheet.css">
	</head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
		$(document).ready(function () {
			$('#formRowHidden').hide();
			$('#private').change(function () {
			if (!this.checked) {
				//  ^
			$('#username').val('');
				$('#formRowHidden').hide();
			}
			else 
			{
				$('#formRowHidden').show();
			}
			});
		});
	</script>
	
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
			<form action="PostMessage.php" method="post"> 
				<div class=formRow>
					<h3>Post a Message</h3>
				</div>
				<div class=formRow>
					<div class=rowLeft>
						<h4>Private Message?</h4>
					</div>
					<div class=rowRight>
						<input type="checkbox" name="private" id="private"/> <!--<<<< Private Message Checkbox  -->
					</div>
				</div>
				<div class="formRowHidden" id="formRowHidden">
					<div class=rowLeft>
						<h4>Username</h4>
					</div>
					<div class=rowRight>
						<input type="text" name="username" id="username"/> <!--<<<< Private Message Checkbox  -->
					</div>
				</div>
				<?php ?>
				<div class=formRow>
					<div class=rowLeft>
						<h4>Message</h4>
					</div>
					<div class=rowRight>
						<textarea rows=2 cols=50 name="message" id="message"/></textarea> <!--<<<< Message Input Textarea -->
					</div>
				</div>
				<div class=formRow>
					<div class=rowLeft>
						<input type="submit" name="submit" value="Submit"/> <!--<<<< Submit Button -->
					</div>
					<div class=rowRight>
						<label id="lbl_Valid"><?php echo $error?> </label><!--<<<< Validation Output Area -->
					</div>
				</div>
			</form>  <!--<<<< Form Ends -->
			
		</div>
	</body>
</html>
