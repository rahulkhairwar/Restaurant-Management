<?php
//session_start();

$host = '127.0.0.1';
$mysqlUserName = 'root';
$mysqlPassword = 'rahul1234';
$database = 'restaurant';

//$_GLOBAL['databaseConnection'] = mysqli_connect($host, $userName, $password, $database);
$connection = mysqli_connect($host, $mysqlUserName, $mysqlPassword, $database);

/*echo 'The connection object : ';
print_r($connection);
echo '<br />';*/

if (!$connection)
{
	$_SESSION['errorType'] = 'database';

	//session_destroy();

	header('Location: error.php') && exit();

	//echo 'global connection variable isn\'t getting created! -_-';

}

?>
