<?php
// show error reporting

ini_set("display_errors", "on");

error_reporting(E_ALL);


	//rounds

	$css = 'layout/css/';
	$js = 'layout/js/';
	$temp = 'includes/temp/';
	$lang = 'includes/lang/';
	$func = 'includes/func/';
	$up = '../';
	$admin = '../admin/';
	
	// session variable

	$user = "";
  if (isset($_SESSION['user'])) {
		  $user = $_SESSION['user'];
	}

	// include important scripts
	include $up . "connect.php";
	include $lang . "en.php";
	include $func . "function.php";
	include $funcAdmin = $admin . $func . "function.php";
	include $temp . "headernav.php";


?>
