<!DOCTYPE>
<html>
<head>
<link href="orderHistoryStyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	 <form action="placeOrder.php">
		    <input type="submit" id="home" value="Home">
		</form>

 <form action ="changePassword.php" method="post">
  <input type="submit" id="changePassword" value="Change Password">
 </form>
	   
		<form action="logout.php">
		    <input type="submit" id="logout" value="Logout">
		</form>
</body>
</html>

<?php

session_start();

require 'connect.php';

$userName = $_SESSION['userName'];

//$userName = 'test';
$fetchOrderHistory = "select * from orderHistory where userName = '" . $userName
	. "' order by orderDate desc;";

//echo $fetchOrderHistory . '<br />';

$result = mysqli_query($connection, $fetchOrderHistory);

//var_dump($result);

//echo '<br />';

if ($result->num_rows > 0)
{
	echo '<div id="orderHistory"><h1>Your order history : </h1>';

	$previousOrderId = "xxxxxx";

	while ($order = mysqli_fetch_array($result))
	{
		$orderId = $order['orderId'];
		$totalPrice = $order['totalPrice'];

		//$orderId = '000000';
		$fetchDishOrderHistory = "select * from dishOrderHistory where orderId = '"
			. $orderId . "' order by dishId";

		$dishOrder = mysqli_query($connection, $fetchDishOrderHistory);

		if ($dishOrder->num_rows > 0)
		{
			$orderDate = $order['orderDate'];
			echo "<br /><b>Order Id : </b>" . $orderId . "<br /><b>Ordered On : </b>" . $orderDate
				. "<br /><b>Dishes Ordered :</b>";

			while ($dish = mysqli_fetch_array($dishOrder))
			{
				$dishId = $dish['dishId'];
				$dishQuantity = $dish['quantity'];

				$fetchDishName = "select dishName from menu where dishId = "
					. $dishId . ";";

				$dishName = mysqli_fetch_array(mysqli_query($connection, $fetchDishName))['dishName'];

				echo "<br />Ordered Dish : " . $dishName . "&nbsp;&nbsp;&nbsp;&nbsp;Quantity : "
					. $dishQuantity;
			}

			echo '<br /><b>Total Price : </b>' . $order['totalPrice'];
			echo '<br />';
		}

		//printOrderedDish($dishId, $dishQuantity);
	}

	echo '</div>';
}
else
	echo '<center id="noHistory">Sorry! You have never ordered before :(</center>';

?>
