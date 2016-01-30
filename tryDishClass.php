<?php

require_once 'Dish.php';

$dish[0] = new Dish(1, "dish one", 5, 100.0);
$dish[1] = new Dish(2, "dish two", 10, 200.0);
$dish[2] = new Dish(3, "dish three", 15, 300.0);
$dish[3] = new Dish(4, "dish four", 20, 400.0);

echo 'Will print details of all dishes :<br />';

for ($i = 0; $i < 4; $i++)
	echo $dish[$i]->toString() . '<br />';

?>
