<?php

session_start();

if (!isset($_SESSION['firstName']))
	header('Location: index.php') && exit();

$_SESSION['dirty'] = false;

if (!isset($_POST['secondTime']))
	$_POST['secondTime'] = false;

require_once("dbcontroller.php");
$db_handle = new DBController();
$query ="SELECT * FROM state;";
$results = $db_handle->runQuery($query);

?>

<!DOCTYPE html>
<html>
<head>

	<script src="https://code.jquery.com/jquery-2.1.1.min.js" 
		type="text/javascript">
	</script>

	<script>

		function getCity(val)
		{
			$.ajax({
				type: "POST",
				url: "get_city.php",
				data:'stateId='+val,
				success: function(data)
				{
					$("#city-list").html(data);
				}
			});
		}

		function selectCountry(val)
		{
			$("#search-box").val(val);
			$("#suggesstion-box").hide();
		}

	</script>

	<link rel="stylesheet" href="confirmOrderStyles.css" type="text/css">
</head>

<body>
	<label id="heading">&nbsp;Enter the address where you want
		the food to be delivered</label>
	<br /><br /><br /><br />
	<form method="post">
	<div class="frmDronpDown">
	<div class="row">
	<label id="stateLabel">State : </label>
	<select name="state" id="state-list" class="demoInputBox" 
		onChange="getCity(this.value);" required>
	<option value="">Select State</option>
	<?php
	foreach($results as $state)
	{
	?>
	<option value="<?php echo $state["stateId"]; ?>"><?php echo $state["stateName"]; ?>
	</option>
	<?php
	}
	?>
	</select>
	</div>
	<div class="row">
	<label id="cityLabel">City:</label>
	<select name="city" id="city-list" class="demoInputBox" required>
	<option value="">Select City</option>
	</select>

	</div>
	<div>
		<label id='streetLabel'>Street : </label><input type="text" id="street"
			name="street" placeholder="Street" required><br /><br />
		<label id='buildingLabel'>Building : </label><input type="text" 
			id="building" name="building" placeholder="Building" required>
		<br /><br />
		<label id='flatNoLabel'>Flat No. : </label><input type="text"
		id="flatNo" name="flatNo" placeholder="Flat No. (if exists)"><br />
		<label id='phoneNumberLabel'>Phone Number : </label><input type="text"
			id="phoneNumber" name="phoneNumber" placeholder="Phone Number"
			required><br />
		<input type="hidden" id="secondTime" name="secondTime" value="true">
			<br />
		<input type="submit" class="confirmOrder" id="confirmOrder" 
			value="Confirm Order">
	</div>
	</form>

	<form method="post">
		<input type="hidden" id="secondTime" name="secondTime" value="true">
		<input type="hidden" id="orderCancelled" name="orderCancelled" value="true">
		<input type="submit" class="cancelOrder" id="cancelOrder"
			value="Cancel Order">
	</form>

</body>
</html>

<?php

echo '<br /><br /><br /><br />';

require 'connect.php';

if ($_POST['secondTime'] == true)
{
	if (isset($_POST['orderCancelled']) && $_POST['orderCancelled'] == true)
	{
		$deleteDishOrders = "delete from dishOrders where orderId = '"
		. $_SESSION['orderId'] . "';";

		mysqli_query($connection, $deleteDishOrders);

		$_SESSION['orderCancelled'] = true;
	
		header('Location: placeOrder.php') && exit();
	}
	else
	{
		$stateId = $_POST['state'];
		$cityId = $_POST['city'];

		$fetchState = "select stateName from state where stateId = '" . $stateId . "'";
		$fetchCity = "select cityName from city where cityId = '" . $cityId . "'";
		$state = mysqli_fetch_array(mysqli_query($connection, $fetchState))['stateName'];
		$city = mysqli_fetch_array(mysqli_query($connection, $fetchCity))['cityName'];

		$street = $_POST['street'];
		$building = $_POST['building'];
		$flatNo = $_POST['flatNo'];
		$phoneNumber = $_POST['phoneNumber'];

		$address = $flatNo . ", " . $building . ", " . $street . ", " . $city . ", "
			. $state;

		$length = strlen($address);
		$quotePositions;
		$count = 0;

		for ($i = 0; $i < $length; $i++)
		{
			$char = substr($address, $i, 1);

			if ($char == '\'')
				$quotePositions[$count++] = $i;
		}

		$deliveryAddress = "";
		$upto = -1;

		for ($i = 0; $i < $count; $i++)
		{
			$deliveryAddress .= substr($address, $upto + 1, $quotePositions[$i] -
				($upto + 1));

			$upto = $quotePositions[$i];
		}

		if ($upto < $length - 1)
			$deliveryAddress .= substr($address, $upto + 1, ($length - 1 - $upto));

		/**
		 * generate new orderId -- done!!
		 * delete all tuples with the old orderId from dishOrders -- done!!
		 * add address value to orders -- done!!
		 * add the order details to the orderHistory table
		 */
		
		$userName = $_SESSION['userName'];
		$orderId = $_SESSION['orderId'];
		$totalPrice = $_SESSION['totalPrice'];
		$addOrderToOrderHistory = "insert into orderHistory values('"
			. $orderId . "', " . $totalPrice . ", sysdate(), '"
			. $userName . "', '" . $deliveryAddress . "');";

		echo 'addOrderToOrderHistory : ' . $addOrderToOrderHistory . '<br />';

		mysqli_query($connection, $addOrderToOrderHistory);

		$fetchOrderedDishes = "select * from dishOrders where orderId = '"
			. $orderId . "';";
		$allOrderedDishes = mysqli_query($connection, $fetchOrderedDishes);

		if ($allOrderedDishes->num_rows > 0)
		{
			while ($orderedDish = mysqli_fetch_array($allOrderedDishes))
			{
				$dishId = $orderedDish['dishId'];
				$dishQuantity = $orderedDish['quantity'];
				$dishPrice = $orderedDish['price'];

				$insertIntoDishOrderHistory = "insert into dishOrderHistory
					values ('" . $orderId . "', " . $dishId . ", "
					. $dishQuantity . ", " . $dishPrice . ");";

				mysqli_query($connection, $insertIntoDishOrderHistory);
			}
		}

		$deleteDishOrders = "delete from dishOrders where orderId = '"
			. $orderId . "';";

		mysqli_query($connection, $deleteDishOrders);

		$deleteOrderId = "delete from orders where orderId = '"
			. $orderId . "';";

		mysqli_query($connection, $deleteOrderId);

		require 'functions.php';

		$_SESSION['orderId'] = createOrderId();

		addOrderIdToDb($_SESSION['orderId'], $_SESSION['userName']);

		$_SESSION['orderPlaced'] = true;
		
		header('Location: placeOrder.php') && exit();
	}
}
else
{
	$orderId = $_SESSION['orderId'];
	$fetchOrderedDishes = "select * from dishOrders where orderId = '" . $orderId
		. "';";

	$result = mysqli_query($connection, $fetchOrderedDishes);

	if ($result->num_rows > 0)
	{
		$totalPrice = 0.0;

		while ($orderedDish = mysqli_fetch_array($result))
			$totalPrice += $orderedDish['price'];

		$_SESSION['totalPrice'] = $totalPrice;

		echo '<label id="totalPrice">Order Total : &#x20b9; ' . $totalPrice . '</label>';
	}
}

?>
