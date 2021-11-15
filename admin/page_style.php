<?php


	session_start();

	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session

		$pagetitle = "Members";
		include "ini.php";
		$do = "";

		if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "mange";
		}

		if ($do === "mange") {
      // Mange page code
    } elseif ($do === "add") {
      // Add page code
    } elseif ($do === "insert") {
      // Insert page code
    } elseif ($do === "edit") {
      // Edit page code
    } elseif ($do === "update") {
      // Update page code
    } elseif ($do === "delete") {
      // Delete page code
    } elseif ($do === "deleteaccess") {
      // deleteaccess page code.
    } else {

    		// show Error alert [Error 404]

    			$msg = "<div class='alert alert-danger text-center'>Sorry, We couldn't find this page Error 404, Find a solution <a href='https://www.ionos.com/digitalguide/websites/website-creation/what-does-the-404-not-found-error-mean/' target='_blank'>here</a></div>";
    			redirect($msg, NULL, 15);

     } }
    else {
    // when open the script direct

    	header('location: index.php');
    	exit;
    }
    	include $temp . "footer.php";
    ?>
