<?php

session_start();

if (!isset($_SESSION['firstName']))
	header('Location: index.php') && exit();

//var_dump($_SESSION);

if (isset($_SESSION['orderPlaced']) && $_SESSION['orderPlaced'] == true)
{
  echo '<script language="javascript">';
  echo 'alert("Your order has been placed successfully! :D")';
  echo '</script>';

  $_SESSION['orderPlaced'] = false;
  $_SESSION['dirty'] = false;
}

if (isset($_SESSION['orderCancelled']) && $_SESSION['orderCancelled'] == true)
{
  echo '<script language="javascript">';
  echo 'alert("Your order has been cancelled")';
  echo '</script>';

  $_SESSION['orderCancelled'] = false;
}

$userName = $_SESSION['userName'];
$firstName = $_SESSION['firstName'];

echo '<font size=\'10\' color=\'white\'>Welcome, ' . $firstName . '</font><br />';
// echo 'your generated order id is : ' . $_SESSION['orderId'] . '<br />';

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="static/images/favicon.ico" type="image/x-icon" />
  <title>Place Your Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="javascriptFunctions.js"></script>

  <link type="text/css" rel="stylesheet" href="placeOrderStyles.css">
</head>
<body>

  <input type="button" onclick="location.href='settings.php';" value="Settings" 
    id="settings"/> 
  <button id="starters" onclick="changeBackground('starters')" type="button" 
    class="startersButton">Starters</button>
  <button id="mainCourse" onclick="changeBackground('mainCourse')" type="button"
    class="mainCourseAndDessertsButtons">Main Course</button>
  <button id="desserts" onclick="changeBackground('desserts')" type="button"
    class="mainCourseAndDessertsButtons">Desserts</button>

    <iframe id='menu' src="fetchStarters.php"></iframe>

  <form action="logout.php">
    <input type="submit" id="logout" value="Logout">
  </form>
   <input type="button" onclick="location.href='orderHistory.php';" value="Settings"
    id="settings"/>
     <input type="button" onclick="location.href='tray.php';" value="Tray"
    id="tray"/>


</body>
</html>
