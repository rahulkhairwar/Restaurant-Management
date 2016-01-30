<?php
class DBController {
	private $host = '127.0.0.1';
	private $user = "root";
	private $password = "rahul1234";
	private $database = "restaurant";
	private $connection;

// 	$host = '127.0.0.1';
// $mysqlUserName = 'root';
// $mysqlPassword = 'rahul1234';
// $database = 'restaurant';
	
	function __construct()
	{
		// $conn = $this->connectDB();
		// if(!empty($conn)) {
		// 	$this->selectDB($conn);
		// }

		$this->connectDB();
	}
	
	function connectDB() {
		// $conn = mysqli_connect($this->host,$this->user,$this->password);
		// return $conn;
		$host = '127.0.0.1';
		$mysqlUserName = 'root';
		$mysqlPassword = 'rahul1234';
		$database = 'restaurant';
		$connection = mysqli_connect($host, $mysqlUserName, $mysqlPassword, $database);

		$this->host = $host;
		$this->user = $mysqlUserName;
		$this->password = $mysqlPassword;
		$this->database = $database;
		$this->connection = $connection;
		//$connection = mysqli_connect($this->host, $this->user,$this->password,$this->database);

		return $connection;
	}
	
	// function selectDB($conn) {
	// 	mysql_select_db($this->database,$conn);
	// }
	
	function runQuery($query) {
		$result = mysqli_query($this->connection, $query);

		//var_dump($this->connection);
		//echo '<br /><br />';
		//echo $this->connection . '<br />';
		//echo $query . '<br />';
		//var_dump($result);

		while($row = mysqli_fetch_array($result))
		{
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->connection, $query);
		$rowcount = $result->num_rows;
		return $rowcount;	
	}
}

?>
