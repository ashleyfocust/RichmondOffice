<?php
session_start();
//date_default_timezone_set('UTC');
date_default_timezone_set('Europe/London');
function clean($string) {
	$string = str_replace(' ', '-', $string);
	// Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-\/]/', '', $string);
	// Removes special chars.
}


function clearlocks()
	{
	require ("config.php");
	//global $DBH;
	$sql = "delete FROM tblRecordLocks where userid = '".$_SESSION['username']."';";
	$stmt=$DBH->prepare($sql);
	$stmt->execute();
	}


if ($_SESSION['usertype'] == 'nurse') {
	header('location:login.php?flag=x');
}

if (!isset($_SESSION['loggedin']) or $_SESSION['username'] == "Guest") {
	header('location:index1.php?flag=x');
}

foreach ($_GET as $key => $value) {
	if (strlen($value) > 50) {
		header('location:badget.html');
		//echo "Bad Get";
	}

	$_GET[$key] = clean($value);
}

clearlocks();

?>

