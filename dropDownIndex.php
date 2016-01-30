<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$query ="SELECT * FROM state;";
$results = $db_handle->runQuery($query);
?>
<html>
<head>
<TITLE>jQuery Dependent DropDown List - Countries and States</TITLE>
<head>
<style>
body{width:610px;}
.frmDronpDown {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}
.demoInputBox {padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;}
.row{padding-bottom:15px;}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function getCity(val)
{
	$.ajax({
	type: "POST",
	url: "get_city.php",
	data:'stateId='+val,
	success: function(data){
		$("#city-list").html(data);
	}
	});
}

function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>
</head>
<body>
<div class="frmDronpDown">
<div class="row">
<label>State:</label><br/>
<select name="state" id="state-list" class="demoInputBox" onChange="getCity(this.value);">
<option value="">Select State</option>
<?php
foreach($results as $state) {
?>
<option value="<?php echo $state["stateId"]; ?>"><?php echo $state["stateName"]; ?>
</option>
<?php
}
?>
</select>
</div>
<div class="row">
<label>City:</label><br/>
<select name="city" id="city-list" class="demoInputBox">
<option value="">Select City</option>
</select>
</div>
</div>
</body>
</html>