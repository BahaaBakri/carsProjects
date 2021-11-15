<?php

	function lang( $keyword ) {
		static $langarray = array(
			// navbar
			// brand
			"hom" => "Home",
			// nav
			"cat" => "Categories",
			"ite" => "Items",
			"mem" => "Members",
			"sta" => "Statistics",
			"log" => "Logs",
			// content of dropdown in the right
			"pro" => "Edit profile",
			"set" => "Setting",
			"out" => "Log out",
			"del" => "Delete profile",
			"com" => "Comments"
		);
	return $langarray[$keyword];
	}

?>
