<?php

session_start();

if (!isset($_SESSION['firstName']))
	header('Location: index.php') && exit();

//var_dump($_POST);

$_SESSION['dirty'] = true;

if (!isset($_POST['secondTime']))
	$_POST['secondTime'] = false;

?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="settingsStyles.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<form action="" method="post" class="dark-matter">
	    <h1 id="heading">Change your password here :</h1>
	    <label>
	        <!-- <span>Old Password:</span> -->
	        <input id="currentPassword" type="password" name="currentPassword"
	        	placeholder="Current Password" required/>
	    </label>
	    
	    <label>
	        <!-- <span>New Password:</span> -->
	        <input id="newPassword" type="password" name="newPassword"
	        	placeholder="New Password" required/>
	    </label>
	    
	    <label>
	        <!-- <span>Confirm New Password:</span> -->
	        <input id="confirmNewPassword" type="password" name="confirmNewPassword"
	        	placeholder="Confirm New Password" required/>
	    </label>
	    	<input type="hidden" name="secondTime" value="true">

	    <label>
	        <span>&nbsp;</span> 
	        <input id="changePassword" type="submit" class="button"
	        	value="Change Password" /> 
	    </label>
	</form>

<!-- 	    <form action="placeOrder.php">
	    	<input type="submit" id="home" value="Home">
	    </form> -->

	    <form action="placeOrder.php">
		    <input type="submit" id="home" value="Home">
		</form>

		<form action="logout.php">
		    <input type="submit" id="logout" value="Logout">
		</form>

</body>
</html>

<?php

require 'connect.php';

if ($_POST['secondTime'] == true)
{
	// echo '<br />hi';
	//   echo '<script language="javascript">';
 //  echo 'alert("secondTime is TRUE")';
 //  echo '</script>';

	$userName = $_SESSION['userName'];
	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
	$confirmNewPassword = $_POST['confirmNewPassword'];

	$fetchCurrentPassword = "select password from users where userName = '"
		. $userName . "';";

	$result = mysqli_query($connection, $fetchCurrentPassword);

	if ($result->num_rows > 0)
	{
		$password = mysqli_fetch_array($result)['password'];

		if ($password == $currentPassword)
		{
			if ($newPassword != $confirmNewPassword)
				echo "<font id='errorMessage'>New passwords entered
					don't match</font>";
			else if ($newPassword == $currentPassword)
				echo "<font id='errorMessage'>You need to provide a
					new password</font>";
			else
			{
				$changePassword = "update users set password = '" . $newPassword
					. "' where userName = '" . $userName . "';";

				mysqli_query($connection, $changePassword);

				echo "<font id='errorMessage'>Your password has been
					changed</font>";
			}
		}
		else
			echo "<font id='errorMessage'>Entered current password
				is incorrect</font>";
	}
}

// newPasswordsDontMatch samePasswordEntered passwordChanged incorrectCurrentPassword
