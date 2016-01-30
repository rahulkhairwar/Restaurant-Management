<?php

session_start();

if (!isset($_SESSION['firstName']))
	header('Location: index.php') && exit();

require 'functions.php';

if (isset($_SESSION['dirty']) && $_SESSION['dirty'] == true)
{
	$_SESSION['dirty'] = false;
	$result = 0;
}
else
	$result = addOrdersToDb2($_POST);

//var_dump($_POST);

?>

<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="addToTrayStyles.css">

</head>

<body>
	<?php

	echo '<center><font size="12">';

	if ($result == -1)
		echo 'You need to select at least 1 dish to proceed :(';
	else
	{
		echo 'The selected dishes have been added to your tray! :D<br /><br />';
		echo 'You can add more dishes to your tray, or can proceed with
			your order : <br />';

		echo "<input type='button' id='proceed' value='Proceed'
			onclick='parent.window.location.href=\"editOrder.php\";'>";

		echo '</font></center>';
		// echo '<form action="confirmOrder.php" method="post">';
		// echo "<input type='submit' id='confirmOrder' value='Confirm'></center>";
		// echo '</form>';
	}

	?>

</body>
</html>
