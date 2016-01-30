<?php
session_start();

if ($_SESSION['errorType'] == 'database')
	echo 'Could not connect to database. Please try again later.';
else
	echo 'Some error occured. Please try again later.';