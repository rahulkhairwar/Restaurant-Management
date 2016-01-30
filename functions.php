
<?php

function doesUserNameExist($userName)
{
	require 'connect.php';

	$getUsers = 'select userName from users';
	$result = mysqli_query($connection, $getUsers);

	if ($result->num_rows > 0)
	{
		while ($user = mysqli_fetch_array($result))
		{
			if ($user['userName'] == $userName)
				return true;
		}
	}

	return false;
}

function doesUserExist($userName, $password)
{
	require 'connect.php';

	$getUsers = 'select userName, password, firstName from users';
	$result = mysqli_query($connection, $getUsers);

	if ($result->num_rows > 0)
	{
		while ($user = mysqli_fetch_array($result))
		{
			if ($user['userName'] == $userName && $user['password'] == $password)
			{
				//echo 'setting session userName variable as : ' . $userName;
				$_SESSION['userName'] = $userName;
				$_SESSION['firstName'] = $user['firstName'];
				$_SESSION['orderId'] = createOrderId();

				addOrderIdToDb($_SESSION['orderId'], $userName);

				return true;
			}
		}
	}

	return false;
}

function addOrderIdToDb($orderId, $userName)
{
	require 'connect.php';

	$addOrderId = "insert into orders values('" . $_SESSION['orderId']
		. "', null, null, null, '" . $userName . "');";

	//echo 'addOrderId : ' . $addOrderId . '<br />';
	mysqli_query($connection, $addOrderId);
}

function createOrderId()
{
	require 'connect.php';

	$getOrderIds = 'select orderId from orders';
	$result = mysqli_query($connection, $getOrderIds);
	$isUnique = false;

	while (!$isUnique)
	{
		$try = rand(0, 1);

		if ($try == 0)
			$char1 = chr(rand(65, 90));
		else
			$char1 = chr(rand(97, 122));

		$try = rand(0, 1);

		if ($try == 0)
			$char2 = chr(rand(65, 90));
		else
			$char2 = chr(rand(97, 122));

		//echo 'char1 : ' . $char1 . ', char2 : ' . $char2;

		$dig1 = chr(rand(48, 57));
		$dig2 = chr(rand(48, 57));
		$dig3 = chr(rand(48, 57));
		$dig4 = chr(rand(48, 57));
		$dig5 = chr(rand(48, 57));
		$dig6 = chr(rand(48, 57));

		$orderId = $char1 . $char2 . $dig1 . $dig2 . $dig3 . $dig4 . $dig5 . $dig6;

		if (isOrderIdUnique($orderId, $result))
			$isUnique = true;
	}

	return $orderId;
}

function isOrderIdUnique($createdId, $allOrderIds)
{
	while ($orderId = mysqli_fetch_array($allOrderIds))
	{
		if ($orderId['orderId'] == $createdId)
			return false;
	}

	return true;
}

/**
 *	Not used yet. Not sure if I can
 */
function fetchCoursePage($courseType)
{
	require 'connect.php';

	$fetchStarters = "select * from menu where dishType = '" . $courseType . "'";
	//echo '<br />' . $fetchStarters . '<br />';
	$result = mysqli_query($connection, $fetchStarters);

	$numberOfRows = $result->num_rows;

	echo '<form action=\'confirmOrder.php\' method=\'post\'>';

	//echo '<blockquote>This text would be indented</blockquote>';

	//echo '<blockquote>';
	//echo '<br /> <button >hello</button>';


	// for printDish()
	require 'functions.php';

	while ($numberOfRows > 0)
	{
		$dish = mysqli_fetch_array($result);
	
		printDish($dish);
		$numberOfRows--;

		echo '<br>';

		//printDish($dish['dishName']);
	}

	echo '<input type=\'submit\' value=\'Confirm Order\'>';
	echo '</form>';
	//echo '</blockquote>';

}

// 	// 2 very slightly different Rupee symbols
// 	// &#x20b9;
// 	// &#8377;

function printDish2($dish, $dishType)
{
	$dishId = $dish['dishId'];
	$dishName = $dish['dishName'];
	$dishPrice = $dish['price'];
	$dishImageUrl = $dish['imageUrl'];
	$dishImageWidth = $dish['imageWidth'];
	$dishImageHeight = $dish['imageHeight'];
	$length = strlen($dishName);

	echo "<center><u><font id='dishName'>" . $dishName . "</font></u><br />";
	// echo '<br /> imageHeight : ' . $dishImageHeight . 
	// 	', imageWidth : ' . $dishImageWidth;

	echo "<br /><img id='dishImage' src='" . $dishImageUrl . "' align='middle' height='" 
	. ($dishImageHeight * 0.70) . "' width='" . ($dishImageWidth * 0.70) . "'></center>";

	//printSpaces(20 + (710 - $dishImageWidth) / 7);

	echo "<br /><br /><input type='number' id='dishQuantity' name='" . $dishId . "' min='0'
		step='1' value='0' size='5'>";
	//echo "<br /<br /><input type='number' name='" . $dishId . "' value='" . $dishQuantity . "' min='0' step='1' size"
	//printTab(1);
	echo "<label for='" . $dishId . "'>Price (for 1) : &#x20b9; " . $dishPrice . "</label>";
	

	// 2 very slightly different Rupee symbols
	// &#x20b9;
	// &#8377;

	echo '<br />_____________________________________________________________'
		. '__________________________________________________________________'
		. '_______<br />';
}
// 	echo '<br />_____________________________________________________________'
// 		. '__________________________________________________________________'
// 		. '_______<br />';
// }

function printDish3($dish, $dishType)
{
	$dishId = $dish['dishId'];
	$dishName = $dish['dishName'];
	$dishPrice = $dish['price'];
	$dishImageUrl = $dish['imageUrl'];
	$dishImageWidth = $dish['imageWidth'];
	$dishImageHeight = $dish['imageHeight'];
	$length = strlen($dishName);

	echo "<center><u><font id='dishName'>" . $dishName . "</font></u><br />";
	// echo '<br /> imageHeight : ' . $dishImageHeight . 
	// 	', imageWidth : ' . $dishImageWidth;

	echo "<br /><img id='dishImage' src='" . $dishImageUrl . "' align='middle' 
		height='" . ($dishImageHeight * 0.70) . "' width='"
		. ($dishImageWidth * 0.70) . "' border='5'></center>";

	//printSpaces(20 + (710 - $dishImageWidth) / 7);

	//echo '<br><br><br><br><br>';
	//echo "<br /><br /><input type='number' id='". $dishId ."' name='"
	// . $dishId . "' min='0' step='1' value='0' size='5'>";
	
	echo "<input type='button' id='dec' onclick='decrementValue(" . $dishId . ")' value='-' >";
	echo "<div class='qty'><input type='text' id='" . $dishId . "' name='" . $dishId . "' value='0'></div>";
    echo "<input type='button' id='inc' onclick='incrementValue(" . $dishId . ")' value='+' >";
	echo "<label for='" . $dishId . "' id='price'> Price (for 1) : &#x20b9; " . $dishPrice . "</label>";
	
	// 2 very slightly different Rupee symbols
	// &#x20b9;
	// &#8377;

	echo '<br />_____________________________________________________________'
		. '__________________________________________________________________'
		. '_______<br />';
}


function addOrdersToDb($allDishes)
{
	require 'connect.php';

	$orderId = $_SESSION['orderId'];
	$size = sizeof($allDishes);
	//$dishType = // you can know from the url which redirected you here

	//echo 'the size of the array is : ' . $size . '<br />';

	$countOfDishes = 0;

	foreach($allDishes as $dishId => $dishQuantity)
	{
	    $dishId = str_replace('_', ' ', $dishId);

	    // echo 'dishId : ' . $dishId . ', dishQuantity : ' . $dishQuantity . 
	    // 	', price per plate : ' . $dishPrice . '<br />';

	    if ($dishQuantity > 0)
	    {
	    	$countOfDishes++;
	    	$dishPrice = mysqli_fetch_array(fetchMenu($dishId))['price'];
	    	$insertDish = "insert into dishOrders values('" . $orderId . "', " 
	    		. $dishId . ", " . $dishQuantity . ", " . ($dishQuantity * $dishPrice)
	    		. ");";

			//echo $insertDish . '<br />';

			mysqli_query($connection, $insertDish);
	    }
	}

	if ($countOfDishes == 0)
		return -1;
	else
		return 0;
}

function addOrdersToDb2($allDishes)
{
	require 'connect.php';

	$orderId = $_SESSION['orderId'];
	$size = sizeof($allDishes);
	//$dishType = // you can know from the url which redirected you here

	//echo 'the size of the array is : ' . $size . '<br />';

	$countOfDishes = 0;

	foreach($allDishes as $dishId => $dishQuantity)
	{
		//echo 'dishId : ' . $dishId . '<br />';
	    $dishId = str_replace('_', ' ', $dishId);

	    // echo 'dishId : ' . $dishId . ', dishQuantity : ' . $dishQuantity . 
	    // 	', price per plate : ' . $dishPrice . '<br />';

	    if ($dishQuantity > 0)
	    {
	    	$countOfDishes++;

			$fetchOrderedDishes = "select * from dishOrders where orderId = '"
				. $orderId . "' and dishId = " . $dishId . ";";

			$result = mysqli_query($connection, $fetchOrderedDishes);

			if ($result->num_rows > 0)
			{
				$quantity = mysqli_fetch_array($result)['quantity'];

				$updateQuantity = "update dishOrders set quantity = "
					. ($quantity + $dishQuantity) . " where orderId = '"
					. $orderId . "' and dishId = " . $dishId . ";";

				mysqli_query($connection, $updateQuantity);

				//echo 'Dish quantity updated!!';
			}
			else
			{
				$dishPrice = mysqli_fetch_array(fetchMenu($dishId))['price'];
				$insertDish = "insert into dishOrders values('" . $orderId . "', " 
					. $dishId . ", " . $dishQuantity . ", " . ($dishQuantity * $dishPrice)
					. ");";

				//echo $insertDish . '<br />';

				mysqli_query($connection, $insertDish);

				//echo 'Dish quantity added!!';
			}
	    }
	}

	if ($countOfDishes == 0)
		return -1;
	else
		return 0;
}

function fetchMenu($dishId)
{
	require 'connect.php';

	$getMenu = "select * from menu where dishId = " . $dishId . ";";
	$result = mysqli_query($connection, $getMenu);

	return $result;
}

function printSpaces($numberOfTimes)
{	
	for ($i = 0; $i < $numberOfTimes; $i++)
		echo '&nbsp;';
}

function printTab($numberOfTimes)
{
	$tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	for ($i = 0; $i < $numberOfTimes; $i++)
		echo $tab;
}

function printTrayItem($dish)
{
	require 'connect.php';

	$dishId = $dish['dishId'];
	$dishQuantity=$dish['quantity'];
	$dishPrice = $dish['price'];

	$fetchDishName = "select dishName from menu where dishId = " . $dishId . ";";

	$dishName = mysqli_fetch_array(mysqli_query($connection, $fetchDishName))['dishName'];


	echo "<center><u><font id='dishName'>" . $dishName . "</font></u><br />";
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

function fetchTray()
{
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
		echo "<form method='post'>";

		while ($dish = mysqli_fetch_array($result))
			$totalPrice += printTrayItem($dish);

		echo "<input id='saveChanges' type='submit' value='Save Changes'>";
		echo "<input type='hidden' name='secondTime' value='true'>";
		echo "</form>";
		echo "<label id='totalPrice'>Total Price : &#x20b9;". $totalPrice
			. "</label>";
		echo "<input type='button' onclick='location.href=\"confirmOrder.php\";'
			value='Confirm Order' id='confirmOrder'/>";
	}
	else
		echo '<center id="emptyTray"><br />Sorry, there are no dishes in your tray currently</center>';
}

?>
