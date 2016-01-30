<?php

class Dish
{
	private $dishId;
	private $dishName;
	private $dishQuantity;
	private $dishPrice;

	function __construct($dishId, $dishName, $dishQuantity, $dishPrice)
	{
		// $conn = $this->connectDB();
		// if(!empty($conn)) {
		// 	$this->selectDB($conn);
		// }

		//$this->connectDB();

		$this->setDishId($dishId);
		$this->setDishName($dishName);
		$this->setDishQuantity($dishQuantity);
		$this->setDishPrice($dishPrice);
	}

	function setDishId($dishId)
	{
		//echo 'setting dishId to ' . $dishId . '<br />';
		$this->dishId = $dishId;

		//echo 'set dishId to ' . $this->dishId . '<br />';
	}

	function setDishName($dishName)
	{
		$this->dishName = $dishName;
	}

	function setDishQuantity($dishQuantity)
	{
		$this->dishQuantity = $dishQuantity;
	}

	function setDishPrice($dishPrice)
	{
		$this->dishPrice = $dishPrice;
	}

	function getDishId()
	{
		return $this->dishId;
	}

	function getDishName()
	{
		return $this->dishName;
	}

	function getDishQuantity()
	{
		return $this->dishQuantity;
	}

	function getDishPrice()
	{
		return $this->dishPrice;
	}

	function toString()
	{
		return "dishId : " . $this->getDishId() . ", dishName : "
			. $this->getDishName() . ", dishQuantity : "
			. $this->getDishQuantity() . ", dishPrice : "
			. $this->getDishPrice();
	}

}