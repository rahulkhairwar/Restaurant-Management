<!DOCTYPE html>
<html>
<head>
	<script src="javascriptFunctions.js"></script>
	<link rel="stylesheet" href="fetchPagesStyles.css" type="text/css">
</head>
<!-- <body background="static/images/fetchMainCourseBackground.jpg"> -->
<body>

	<script type="text/javascript">
        changeBackground('mainCourse');
    </script>

<!-- <button id="b1" onclick="ChangeTopMostBG()">sdsd</button>
<button id="sd" onclick="rd()">sdsdsd</button> -->

<!--  bgcolor='#082b4f' -->
</body>
</html>

<?php

require 'connect.php';

$fetchMainCourse = "select * from menu where dishType = 'mainCourse'";
$result = mysqli_query($connection, $fetchMainCourse);

$numberOfRows = $result->num_rows;

echo "<form action='addToTray.php' method='post'>";
//echo "<input type='hidden' name='secondTime' value='true'>";

// for printDish()
require 'functions.php';

while ($numberOfRows > 0)
{
	$dish = mysqli_fetch_array($result);
	
	printDish3($dish, 'mainCourse');
	$numberOfRows--;

	echo '<br>';
}

/**
 * the form is submitted to addToTray which adds the order dishes(with 
 * their quantities) to the database with a unique order id(created 
 * when the user logs in. 
 */
echo "<input type='submit' id='addToTray' value='Add to Tray'>";
echo '</form>';
//echo '</blockquote>';

?>
