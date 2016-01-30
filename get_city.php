<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["stateId"])) {
	$query ="SELECT * FROM city WHERE stateId = '" . $_POST["stateId"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select City</option>
<?php
	foreach($results as $city) {
?>
	<option value="<?php echo $city["cityId"]; ?>"><?php 
		echo $city["cityName"]; ?></option>
<?php
	}
}
?>