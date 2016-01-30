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

$_SESSION['dirty'] = false;

function printTrayItem($dish)
{
	require 'connect.php';

	$dishId = $dish['dishId'];
	//$dishName = $dish['dishName'];
	$dishQuantity=$dish['quantity'];
	$dishPrice = $dish['price'];
	/*$dishImageUrl = $dish['imageUrl'];
	$dishImageWidth = $dish['imageWidth'];
	$dishImageHeight = $dish['imageHeight'];
	$length = strlen($dishName);*/

	$fetchDishName = "select dishName from menu where dishId = " . $dishId . ";";

	$dishName = mysqli_fetch_array(mysqli_query($connection, $fetchDishName))['dishName'];


	echo "<center><u><font id='dishName'>" . $dishName . "</font></u><br />";
	// echo '<br /> imageHeight : ' . $dishImageHeight . 
	// 	', imageWidth : ' . $dishImageWidth;

	/*echo "<br /><img id='dishImage' src='" . $dishImageUrl . "' align='middle' 
	height='" . ($dishImageHeight * 0.70) . "' width='"
	. ($dishImageWidth * 0.70) . "' border='5'></center>";*/

	//printSpaces(20 + (710 - $dishImageWidth) / 7);

	//echo '<br><br><br><br><br>';
	//echo "<br /><br /><input type='number' id='". $dishId ."' name='"
	// . $dishId . "' min='0' step='1' value='0' size='5'>";

	echo "<input type='button' id='dec' onclick='decrementValue(" . $dishId
		. ")' value='-' >";
	echo "<div class='qty'><input type='text' id='" . $dishId . "' name='"
		. $dishId . "' value='" . $dishQuantity . "'></div>";
	echo "<input type='button' id='inc' onclick='incrementValue(" . $dishId
		. ")' value='+' >";
	echo "<label for='" . $dishId . "' id='price'> Price : &#x20b9; "
		. $dishPrice . "</label>";

	// 2 very slightly different Rupee symbols
	// &#x20b9;
	// &#8377;

	echo '<br />_____________________________________________________________'
	. '__________________________________________________________________'
	. '_______<br />';

	return $dishPrice;
}

	require 'connect.php';

	$orderId=$_SESSION['orderId'];
	$fetchOrderedDishes= " select * from dishOrders where orderId='"
		. $orderId . "';";

	// echo 'Orderid : ' . $orderId . '<br />';
	// echo 'fetch : ' . $fetchOrderedDishes;
	$result= mysqli_query($connection, $fetchOrderedDishes);

	$totalPrice = 0;

if ($result->num_rows > 0)
{
	echo "<form action='confirmOrder.php' method='post'>";

	while ($dish = mysqli_fetch_array($result))
		$totalPrice += printTrayItem($dish);

	echo "<input id='confirmOrder2' type='submit' value='Confirm Order'>";
	echo "</form>";
	echo '<label id="totalPrice2">Total Price : &#x20b9;' . $totalPrice . '</label>';
}

?>


<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" href="trayStyles.css" type="text/css">
</head>
