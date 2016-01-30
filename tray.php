<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" href="trayStyles.css" type="text/css">
<script src="javascriptFunctions.js" type="text/javascript"></script>
</head>
<body>
	<form action="placeOrder.php" method="get">
		<input id="home" type="submit" value="Home">
	</form>

	<form action="logout.php" method="get">
		<input id="logout" type="submit" value="Logout">
	</form>
</html>

<?php 

session_start();

require 'functions.php';

$_SESSION['dirty'] = false;

if (!isset($_POST['secondTime']))
	$_POST['secondTime'] = false;

if ($_POST['secondTime'] == false)
	fetchTray();

?>

<?php

require 'connect.php';
//require 'functions.php';

if ($_POST['secondTime'] == true)
{
	echo '<script language="javascript">';
	echo 'alert("The changes have been saved to your tray")';
	echo '</script>';

	$deleteDishOrders = "delete from dishOrders where orderId = '"
		. $_SESSION['orderId'] . "';";

	mysqli_query($connection, $deleteDishOrders);

	addOrdersToDb2($_POST);

	fetchTray();
}

?>

