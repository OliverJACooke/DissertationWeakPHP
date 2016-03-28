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
	// ------ SQL Connect ------
	$sqlUser = "SELECT username 
				FROM tblUser 
				WHERE userID='".$userID."'";
				
	$sql_query = mysql_query($sqlUser);
	$value = mysql_fetch_assoc($sql_query);
	
	$username = $value['username'];
	// ------ Username Display ------
	
	// ------ Private Display ------
	$messageType = $_POST["publicPrivate"];
	
	if ($messageType == "")
	{
		$messageType = "Public";
	}
		
	if ($messageType == "Public")
	{
		$sqlMessage = "SELECT tblUser.username, tblMessage.messageBody FROM tblMessage INNER JOIN tblUser ON tblMessage.userID = tblUser.userID WHERE tblMessage.messageType = 0 ";
	} else
	{
		$sqlMessage = "SELECT tblUser.username, tblMessage.messageBody FROM tblMessage INNER JOIN tblUser ON tblMessage.userID = tblUser.userID WHERE tblMessage.messageType = 1 && tblMessage.username = '".$username."'";
	}
	
	$result = mysql_query($sqlMessage);
	// ------ Private Display ------
}

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../StyleSheet.css"/>
	</head>
	<script type="text/javascript">
		document.getElementById('publicPrivate').value = "<?php echo $_GET['publicPrivate'];?>";
	</script>
	<body>
		<div class="container">
			<h1>Welcome <?php echo $username?></h1>
			<div class="linksRow">
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
				<form action="Home.php" method="post">
					<div class="link">
						<select name="publicPrivate" id="publicPrivate" onchange='this.form.submit()'>
							<option value="Public" <?php if (isset($messageType) && $messageType=="Public") echo "selected";?>>Public</option>
							<option value="Private"<?php if (isset($messageType) && $messageType=="Private") echo "selected";?>>Private</option>
						</select>
					</div>
				</form>
			</div>
			<div class="messageContainer">
				<table>
					<tr>
						<th style="width:200px;">Name</th>
						<th style="width:600px;">Message</th>
					</tr>
					<?php 
					if (mysql_num_rows($result) > 0) {
						while($row = mysql_fetch_assoc($result)) {
							echo "<tr> <td>" . $row["username"]. "</td><td> " . $row["messageBody"]. "</td></tr>";
						}
					}
					?>
				</table>
			</div>
		</div>	
	</body>
</html>
