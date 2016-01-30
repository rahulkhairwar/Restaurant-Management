<?php

session_start();

if (isset($_SESSION))
{
	/**
	 * Only destroying the session, and not deleting the created
	 * orderId(unless nothing has been ordered), so that the
	 * history can be saved in the database, and after a certain
	 * period of time all history (probably upto a few months ago)
	 * can be deleted by the admin and then the same orderId can be used 
	 * again.
	 */

	require 'connect.php';

	$orderId = $_SESSION['orderId'];
	$fetchOrderedDishesByUser = "select * from dishOrders where orderId = '"
		. $orderId . "';";
	$result = mysqli_query($connection, $fetchOrderedDishesByUser);
	$fetchOrderDetails = "select * from orders where orderId = '"
		. $orderId . "';";

	$orderDetails = mysqli_fetch_array(
		mysqli_query($connection, $fetchOrderDetails));

	//echo '<br /><br /> Delivery Address : ';
	//echo ($orderDetails['deliveryAddress'] == '');

	if (($orderDetails['deliveryAddress'] == '') == 1)
	{
		$deleteOrderedDishes = "delete from dishOrders where orderId = '"
			. $orderId . "';";
		mysqli_query($connection, $deleteOrderedDishes);

		$deleteOrderId = "delete from orders where orderId = '"
			. $orderId . "';";
		mysqli_query($connection, $deleteOrderId);
	}

	session_destroy();
	header('Location: index.php') && exit();
}

?>
