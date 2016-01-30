<?php

session_start();
//echo '<br />secTime : ' . $_SESSION['secondTime'] . ', canSignUp : ' . $_SESSION['canSignUp'] . '<br />';

if (isset($_SESSION['firstName']))
{
	echo '<br />firstName is set! as ' . $_SESSION['firstName'] . '<br />';
	echo '<br /> and userName is : ' . $_SESSION['userName'];

	//$_SESSION['firstName'] = 'rahul';
	//$_SESSION['userName'] = $_SESSION['userName'];

	header('Location: placeOrder.php') && exit();
}

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sign Up</title>

	<link type="text/css" rel="stylesheet" href="signUpStyles.css">
</head>

<body background="static/images/signUpBackground.jpg">
	<section class="body">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" 
			enctype="multipart/form-data">

		<h1 class="title">Sign Up</h1>
		<label></label>
      	<input name="firstName" required="required" placeholder="First Name">
     	<label></label>
      	<input name="lastName" required="required" placeholder="Last Name">
		<label></label>
	    <input name="userName" required="required" placeholder="Username"> 
	    <label></label>
	    <input name="password" type="password" required="required" 
	    	placeholder="Password">
        <label></label>
        <input name="confirmPassword" type="password" required="required" 
           	placeholder="Confirm Password">
		<label></label>		    	    		    
		<input type="hidden" name="secondTime" value="true">
		<input type="hidden" name="canSignUp" value="false">
		         
	    <input id="signUp" name="signUp" type="submit" value="Sign Up">
	        
	</form>

	<form action="index.php">
	    <input id="login" name="login" type="submit" value="Log In">
	</form>
    </section>
</body>

<?php

if (isset($_POST['secondTime']) && $_POST['secondTime'] == true)
{
	require 'connect.php';
	require 'functions.php';
	$getUsers = 'select * from users';

	$userExists = doesUserNameExist($_POST['userName']);

	//require 'functions.php';

	if ($userExists)
	{
		echo '<font id="userNameTaken">Username is already taken!</font>';
		echo '<script language="javascript">';
		echo 'document.body.style.backgroundImage =
			"url(\'static/images/signUpBackground.jpg\')";';
		echo '</script>';
	}
	else
	{
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];

		if ($password != $confirmPassword)
		{
			echo '<font id="userNameTaken">Passwords do not match!</font>';
			echo '<script language="javascript">';
			echo 'document.body.style.backgroundImage =
				"url(\'static/images/signUpBackground.jpg\')";';
			echo '</script>';
		}
		else
		{
			require 'connect.php';

			$addNewUser = 'insert into users values(\'' . $_POST['userName'] . '\', \'' 
				. $password . '\', \'' . $_POST['firstName'] . '\', \''
				. $_POST['lastName'] . '\', null, null, null, null);';

			$result = mysqli_query($connection, $addNewUser);

			// echo '<font id="signedUp" size="6" color="white">Successfully signed up!
			// 	 Now you can login and order your meal! Enjoy! :D</font>';

			$_SESSION['signedUp'] = true;

			header('Location: index.php') && exit();
		}
	}
}

?>