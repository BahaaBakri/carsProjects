<?php 
	
	

	//rounds

	$css = 'layout/css/';
	$js = 'layout/js/';
	$temp = 'includes/temp/';
	$lang = 'includes/lang/';
	$func = 'includes/func/';
	$up = '../';
	// include important scripts
	include $up . "connect.php";
	include $lang . "en.php";
	include $func . "function.php";
	include $temp . "header.php";


	// add navbar if the page doesn't has $nonavbar variable
	/*
	if (!isset($nonavbar)) {
		include $temp . "navbar.php";
	}
	*/
?>