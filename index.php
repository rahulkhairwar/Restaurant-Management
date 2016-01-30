<?php
session_start();

//require 'functions.php';
// echo 'echoing secTime : ' . $_POST['secondTime'];
// var_dump($_POST);
// echo '<br />';
// var_dump($_SESSION);

if (!isset($_POST['secondTime']))
	$_POST['secondTime'] = 'false';

//echo 'secTime : ' . $_POST['secondTime'];
//echo '<br />uN : ' . $_POST['userName'];

if (isset($_SESSION['firstName']))
	header('Location: placeOrder.php') && exit();

if (isset($_SESSION['signedUp']) && $_SESSION['signedUp'] == true)
{
	echo '<script language="javascript">';
	echo 'alert("Successfully signed up! Now you can login and order your meal Enjoy :D")';
	echo '</script>';

	$_SESSION['signedUp'] = false;
}

?>

<html>
<head>
	<!-- <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico"> -->
	<link rel="shortcut icon" href="static/images/favicon.ico" type="image/x-icon" />
	<title>Restaurant</title>
	<link rel="stylesheet" href="indexStyles.css">
</head>

<body>

	<h1 id="welcome">Welcome to Tuscana Online Restaurant</h1>
	<br><br><br><br><br>
	<form class="form" method="post">
		<div class="relative1"><input type="text" name="userName"
			placeholder="Username" required></div>
			<div class="relative1"><input type="password" name="password"
				placeholder="Password" required></div>
			<div class="relative1"><input type="hidden" name="secondTime"
				value="true"></div>
	    <div class="relative1"><input type="submit" value="Login"></div>
	 </form>
	 
	 <form action="signUp.php" class="form">
	 	<div class="relative"><input type="submit" value="Sign Up"></div>
	</form>
	
</body>
</html>

<?php

if ($_POST['secondTime'] == 'true')
{
	require 'functions.php';

	$userExists = doesUserExist($_POST['userName'], $_POST['password']);
	//echo $userExists;

	if ($userExists)
		header('Location: placeOrder.php') && exit();
	else
	{
		echo '<font size="5" id="invalidCredentials">Incorrect 
			username and password combination</font>';
		echo '<script language="javascript">';
		echo 'document.body.style.backgroundImage =
			"url(\'static/images/loginBackground.png\')";';
		echo '</script>';
}

	// echo '<font size="5" color="orange">Incorrect </div>
}

?>
