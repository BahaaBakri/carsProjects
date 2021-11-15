<?php 
	function lang ($keyword) {
		static $langarray = array(
			"Home" => "الرئيسية",
			"Works" => "الأعمال",
			"About" => "من نحن"
		
		);
		return $langarray[$keyword];
	}

?>