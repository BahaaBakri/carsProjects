<?php

// logout page must be in indepentent page
session_start();
unset($_SESSION["user"]);
unset($_SESSION["uid"]);
header("location: index.php");
?>